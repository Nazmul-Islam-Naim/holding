<?php

namespace App\Http\Controllers\ProjectShare;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\DateFilter;
use App\Http\Requests\ShareCollection\CreateRequest;
use App\Http\Requests\ShareCollection\UpdateRequest;
use App\Models\BankAccount;
use App\Models\BillGenerate;
use App\Models\ProjectShare;
use App\Models\ProjectShareholder;
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
            $alldata= ProjectShare::with(['project', 'shareHolder'])->where('due', '>', 0)->get();
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
        $data['billGenerate'] = BillGenerate::findOrFail($id);
        return view('shareCollection.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, $id)
    {
        try {
            $billGenerate = BillGenerate::findOrFail($id);
            $billGenerate->decrement('due', $request->amount);
            $billGenerate->increment('collection', $request->amount);

            $billGenerate->shareHolder()->decrement('due', $request->amount);
            $billGenerate->shareHolder()->increment('collection', $request->amount);

            BankAccount::where('id', $request->bank_account_id)->increment('balance', $request->amount);

            $shareCollection = $billGenerate->projectShareholders()->create([
                'project_id' => $billGenerate->project_id,
                'share_holder_id' => $billGenerate->share_holder_id,
                'bill_type_id' => $billGenerate->bill_type_id,
                'bank_account_id' => $request->bank_account_id,
                'transaction_type' => TransactionType::getFromName('Receive'),
                'amount' => $request->amount,
                'date' => $request->date,
                'note' => $request->note,
            ]);

            $shareCollection->transaction()->create([
                'bank_account_id' => $request->bank_account_id,
                'transaction_type' => TransactionType::getFromName('Receive'),
                'reason' => 'Bill Collection (p: '. $billGenerate->project->title. ' s/h: '. $billGenerate->shareHolder->name. ', '. $billGenerate->shareHolder->phone. ')',
                'amount' => $request->amount,
                'transaction_date' => $request->date,
                'note' => $request->note,
            ]);
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('billGenerates.index')->with('status_color','success');
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
            $projectShareholder->billGenerate()->increment('due', $projectShareholder->amount);
            $projectShareholder->billGenerate()->decrement('collection', $projectShareholder->amount);

            $projectShareholder->shareHolder()->increment('due', $projectShareholder->amount);
            $projectShareholder->shareHolder()->decrement('collection', $projectShareholder->amount);

            $projectShareholder->bankAccount()->decrement('balance', $projectShareholder->amount);

            //update
            $projectShareholder->billGenerate()->decrement('due', $request->amount);
            $projectShareholder->billGenerate()->increment('collection', $request->amount);

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
            $projectShareholder->billGenerate()->increment('due', $projectShareholder->amount);
            $projectShareholder->billGenerate()->decrement('collection', $projectShareholder->amount);

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
    public function report(DateFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '') {
            $data['projectShareholders'] = ProjectShareholder::where('transaction_type', TransactionType::getFromName('Receive')->value)
                                ->whereBetween('date', [$request->start_date, $request->end_date])
                                ->paginate(250);
            return view('shareCollection.report', $data);
        } else {
            $data['projectShareholders'] = ProjectShareholder::where('transaction_type', TransactionType::getFromName('Receive')->value)
                                ->paginate(250);
            return view('shareCollection.report', $data);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function amendment(Request $request)
    {
        if ($request->ajax()) {
            $alldata= ProjectShareholder::with(['billGenerate', 'project', 'shareHolder', 'shareHolder.share', 'billType'])
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
