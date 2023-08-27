<?php

namespace App\Http\Controllers\Project;

use App\Enum\ProjectStatus;
use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\DateFilter;
use App\Http\Requests\Filter\ProjectDateFilter;
use App\Http\Requests\ProjectLandPayment\CreateRequest;
use App\Http\Requests\ProjectLandPayment\UpdateRequest;
use App\Models\BankAccount;
use App\Models\Project;
use App\Models\ProjectLandPayment;
use App\Models\ProjectShareholder;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ProjectLandPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata = Project::with('projectLandPayment')->where('land_cost', '>', function ($query) {
                $query->select(DB::raw('COALESCE(SUM(amount), 0)'))->from('project_land_payments');
                
            })->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('projectLandPayments.create',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Payment"><i class="icon-attach_money"></i>Pay</a>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('projectLandPayment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $data['bankAccounts'] = BankAccount::select('id', 'account_name', 'account_number')->get();
        $data['project'] = Project::findOrFail($id);
        return view('projectLandPayment.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, $id)
    {
        try {
            $projectLandPayment = ProjectLandPayment::create($request->all());

            $projectLandPayment->transaction()->create([
                'bank_account_id' => $projectLandPayment->bank_account_id,
                'transaction_type' => TransactionType::getFromName('Payment'),
                'reason' => TransactionType::Payment->toString(). ' for land to (l/o: '. Project::where('id', $id)->first()->land_owner . ')',
                'amount' => $projectLandPayment->amount,
                'transaction_date' => $projectLandPayment->date,
                'note' => $projectLandPayment->note,
            ]);

            $projectLandPayment->bankAccount()->decrement('balance', $projectLandPayment->amount);

            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('projectLandPayments.index')->with('status_color','success');
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
        $data['projectLandPayment'] = ProjectLandPayment::findOrFail($id);
        return view('projectLandPayment.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $inputData = $request->except('_method', '_token');

            $projectLandPayment = ProjectLandPayment::findOrFail($id);
            //reverse
            $projectLandPayment->bankAccount()->increment('balance', $projectLandPayment->amount);

            //update
            $projectLandPayment->update($inputData);

            $projectLandPayment->transaction()->update([
                'bank_account_id' => $projectLandPayment->bank_account_id,
                'amount' => $projectLandPayment->amount,
                'transaction_date' => $projectLandPayment->date,
                'note' => $projectLandPayment->note,
            ]);

            $projectLandPayment->bankAccount()->decrement('balance', $projectLandPayment->amount);

            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('projectLandPayments.amendment')->with('status_color','success');
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
            $projectLandPayment = ProjectLandPayment::findOrFail($id);

            $projectLandPayment->bankAccount()->increment('balance', $projectLandPayment->amount);

            $projectLandPayment->transaction()->delete();

            $projectLandPayment->delete();

            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('projectLandPayments.amendment')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function report(ProjectDateFilter $request)
    {
        $data['projects'] = Project::select('id', 'title', 'land_owner')->get();
        if ($request->start_date != '' && $request->end_date != '' && $request->project_id != '') {
            $data['projectLandPayments'] = ProjectLandPayment::where('project_id', $request->project_id)
                                ->whereBetween('date', [$request->start_date, $request->end_date])
                                ->paginate(250);
            return view('projectLandPayment.report', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->project_id == '') {
            $data['projectLandPayments'] = ProjectLandPayment::whereBetween('date', [$request->start_date, $request->end_date])
                                ->paginate(250);
            return view('projectLandPayment.report', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->project_id != '') {
            $data['projectLandPayments'] = ProjectLandPayment::where('project_id', $request->project_id)
                                ->paginate(250);
            return view('projectLandPayment.report', $data);
        } else {
            $data['projectLandPayments'] = ProjectLandPayment::paginate(250);
            return view('projectLandPayment.report', $data);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function amendment(Request $request)
    {
        if ($request->ajax()) {
            $alldata = ProjectLandPayment::with('project', 'bankAccount')->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('projectLandPayments.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('projectLandPayment.amendment');
    }

}
