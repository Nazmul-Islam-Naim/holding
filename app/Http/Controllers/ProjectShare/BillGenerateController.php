<?php

namespace App\Http\Controllers\ProjectShare;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\DateFilter;
use App\Http\Requests\BillGenerate\CreateRequest;
use App\Http\Requests\BillGenerate\UpdateRequest;
use App\Models\BankAccount;
use App\Models\BillGenerate;
use App\Models\BillType;
use App\Models\Project;
use App\Models\ProjectShare;
use App\Models\ProjectShareholder;
use App\Models\ShareHolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class BillGenerateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= BillGenerate::with(['project', 'shareHolder', 'shareHolder.share', 'billType'])->where('due', '>', 0)->get();
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
        return view('billGenerate.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['projects'] = Project::select('id', 'title')->get();
        $data['billTypes'] = BillType::select('id', 'title')->get();
        return view('billGenerate.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $project = Project::findOrFail($request->project_id);
            foreach($project->shares as $share){
                $bill = BillGenerate::create([
                    'project_id' => $share->project_id,
                    'share_holder_id' => $share->share_holder_id,
                    'bill_type_id' => $request->bill_type_id,
                    'bill' => $share->total_share * $request->amount,
                    'due' => $share->total_share * $request->amount,
                    'date' => $share->date,
                    'note' => $share->note,
                ]);

                $bill->projectShareholders()->create([
                    'project_id' => $bill->project_id,
                    'share_holder_id' => $bill->share_holder_id,
                    'bill_type_id' => $bill->bill_type_id,
                    'transaction_type' => TransactionType::getFromName('Bill'),
                    'amount' => $share->total_share * $request->amount,
                    'date' => $share->date,
                    'note' => $share->note,
                ]);

                $share->shareHolder()->increment('bill', $share->total_share * $request->amount);
                $share->shareHolder()->increment('due', $share->total_share * $request->amount);
            }
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function report(DateFilter $request)
    {
        //
    }

    /**
     * Display a listing of the resource.
     */
    public function amendment(Request $request)
    {
        //
    }
}
