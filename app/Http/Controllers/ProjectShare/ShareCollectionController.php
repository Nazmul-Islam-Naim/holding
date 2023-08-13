<?php

namespace App\Http\Controllers\ProjectShare;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShareCollection\CreateRequest;
use App\Http\Requests\ShareCollection\UpdateRequest;
use App\Models\BankAccount;
use App\Models\Project;
use App\Models\ProjectShare;
use App\Models\ProjectShareholder;
use App\Models\ShareHolder;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ShareCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= ProjectShare::with(['project', 'shareHolder'])->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('shareCollections.create',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Collection">Collection</a>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('shareCollection.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $data['bankAccounts'] = BankAccount::select('id', 'account_name', 'account_number')->get();
        $data['projectShare'] = ProjectShare::findOrFail($id);
        return view('shareCollection.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, $id)
    {
        try {
            $projectShare = ProjectShare::findOrFail($id);
            $projectShare->decrement('due', $request->amount);

            $projectShare->shareHolder()->decrement('due', $request->amount);
            $projectShare->shareHolder()->increment('collection', $request->amount);

            BankAccount::where('id', $request->bank_account_id)->increment('balance', $request->amount);

            $shareCollection = $projectShare->bill()->create([
                'project_id' => $projectShare->project_id,
                'share_holder_id' => $projectShare->share_holder_id,
                'bank_account_id' => $request->bank_account_id,
                'transaction_type' => TransactionType::getFromName('Receive'),
                'amount' => $request->amount,
                'date' => $request->date,
                'note' => $request->note,
            ]);

            $shareCollection->transaction()->create([
                'bank_account_id' => $request->bank_account_id,
                'transaction_type' => TransactionType::getFromName('Receive'),
                'reason' => 'Bill Collection (p: '. $projectShare->project->title. ' s/h: '. $projectShare->shareHolder->name. ', '. $projectShare->shareHolder->phone. ')',
                'amount' => $request->amount,
                'transaction_date' => $request->date,
                'note' => $request->note,
            ]);
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('shareCollections.index')->with('status_color','success');
        } catch (\Exception $exception) {
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['bankAccounts'] = BankAccount::select('id', 'account_name', 'account_number')->get();
        $data['projectShareholder'] = ProjectShareholder::findOrFail($id);
        return view('shareCollection.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $inpuntdata = $request->except('_method', '_token');
            $projectShareholder = ProjectShareholder::findOrFail($id);

            //reverse
            $projectShareholder->projectShare()->increment('due', $projectShareholder->amount);

            $projectShareholder->shareHolder()->increment('due', $projectShareholder->amount);
            $projectShareholder->shareHolder()->decrement('collection', $projectShareholder->amount);

            $projectShareholder->bankAccount()->decrement('balance', $projectShareholder->amount);

            //update
            $projectShareholder->projectShare()->decrement('due', $request->amount);

            $projectShareholder->shareHolder()->decrement('due', $request->amount);
            $projectShareholder->shareHolder()->increment('collection', $request->amount);

            BankAccount::where('id', $request->bank_account_id)->increment('balance', $request->amount);

            $projectShareholder->update($inpuntdata);

            $projectShareholder->transaction()->update([
                'bank_account_id' => $request->bank_account_id,
                'amount' => $request->amount,
                'transaction_date' => $request->date,
                'note' => $request->note,
            ]);

            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('shareCollections.amendment')->with('status_color','success');
        } catch (\Exception $exception) {
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try{
            $projectShareholder = ProjectShareholder::findOrFail($id);

            //reverse
            $projectShareholder->projectShare()->increment('due', $projectShareholder->amount);

            $projectShareholder->shareHolder()->increment('due', $projectShareholder->amount);
            $projectShareholder->shareHolder()->decrement('collection', $projectShareholder->amount);

            $projectShareholder->bankAccount()->decrement('balance', $projectShareholder->amount);
            $projectShareholder->transaction()->delete();
            $projectShareholder->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('shareCollections.amendment')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function report(Request $request)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function amendment(Request $request)
    {
        if ($request->ajax()) {
            $alldata= ProjectShareholder::with(['projectShare', 'project', 'shareHolder'])
                    ->where('transaction_type', TransactionType::getFromName('Receive')->value)
                    ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('shareCollections.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('shareCollection.amendment');
    }
}
