<?php

namespace App\Http\Controllers\Supplier;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\DateFilter;
use App\Http\Requests\LocalSupplier\CreateRequest;
use App\Http\Requests\LocalSupplier\PaymentRequest;
use App\Http\Requests\LocalSupplier\UpdateRequest;
use App\Models\LocalSupplier;
use App\Models\LocalSupplierLedger;
use App\Models\BankAccount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Session;
use Yajra\DataTables\Facades\DataTables;

class LocalSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= LocalSupplier::with(['preDue'])->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('localSuppliers.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('localSupplier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('localSupplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->all();
        $data['bill'] = $request->pre_due??0;
        $data['due'] = $request->pre_due??0;
        try{
            $localSupplier = LocalSupplier::create($data);
            $localSupplier->supplierTransaction()->create([
                'local_supplier_id' => $localSupplier->id,
                'date' => Carbon::now(),
                'reason' => 'Previous due',
                'amount' => $request->pre_due??0
            ]);
            Session::flash('flash_message','Local Supplier Successfully Added !');
            return redirect()->route('localSuppliers.index')->with('status_color','success');
        }catch(\Exception $e){
            dd($e->getMessage());
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['localSupplier']= LocalSupplier::findOrFail($id);
        return view('localSupplier.ledger', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['localSupplier']= LocalSupplier::findOrFail($id);
        return view('localSupplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $token = Arr::pull($data, '_token');
        $method = Arr::pull($data, '_method');
        $preDue = Arr::pull($data, 'pre_due');
        $localSupplier = LocalSupplier::findOrFail($id);
        $data['bill'] =abs($localSupplier->bill - $localSupplier->preDue->amount + ($request->pre_due??0));
        $data['due'] =abs(($localSupplier->bill - $localSupplier->preDue->amount +  ($request->pre_due??0) - $localSupplier->payment));
        try{
            $localSupplier = LocalSupplier::where('id', $id)->update($data);
            LocalSupplierLedger::where([['local_supplier_id',$id],['reason', 'like', '%Previous due%']])->update([
                'amount' => $request->pre_due??0
            ]);
            Session::flash('flash_message','Local Supplier Successfully Updated !');
            return redirect()->route('localSuppliers.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            LocalSupplier::where('id', $id)->delete();
            Session::flash('flash_message','Local Supplier Successfully Deleted !');
            return redirect()->route('localSuppliers.index')->with('status_color','success');
        }catch(\Exception $e){
            dd($e->getMessage());
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    // bill actions
    public function payableSuppliers(Request $request){
        if ($request->ajax()) {
            $alldata= LocalSupplier::where('due', '>', 0)->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('paymentForm',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Payment">Payment</a>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('localSupplier.payableSuppliers');
    }

    public function paymentForm($id){
        $data['bankAccounts']= BankAccount::select('id', 'account_name', 'account_number')->get();
        $data['payableSupplier']= LocalSupplier::findOrFail($id);
        return view('localSupplier.paymentForm', $data);
    }

    public function paymentStore(PaymentRequest $request){
        try {
            $localSupplier = LocalSupplier::findOrFail($request->local_supplier_id);
            $localSupplier->decrement('due', $request->amount);
            $localSupplier->increment('payment', $request->amount);

            BankAccount::where('id', $request->bank_account_id)->decrement('balance', $request->amount);

            $localSupplierLedger = $localSupplier->supplierTransaction()->create([
                'local_supplier_id' => $request->local_supplier_id,
                'bank_account_id' => $request->bank_account_id,
                'date' => $request->date,
                'reason' => 'Payment',
                'amount' => $request->amount,
                'note' => $request->note
            ]);

            $localSupplierLedger->transaction()->create([
                'bank_account_id' => $request->bank_account_id,
                'transaction_type' => TransactionType::getFromName('Payment'),
                'reason' => 'Supplier '.TransactionType::Payment->toString(). ' (s/n: '. $request->supplier_name. ')',
                'amount' => $request->amount,
                'transaction_date' => $request->date,
                'note' => $request->note,
            ]);
            Session::flash('flash_message','Payment Successfully.');
            return redirect()->route('payableSuppliers')->with('status_color','success');
        } catch (\Exception $e) {
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    public function paymentsReport(DateFilter $request){
        if ($request->start_date != '' && $request->end_date != '') {
            $data['localSuppliers'] = LocalSupplierLedger::where('reason', 'Payment')->whereBetween('date', [$request->start_date, $request->end_date])
                                                    ->paginate(500);
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localSupplier.paymentsReport', $data);
        } else {
            $data['localSuppliers'] = LocalSupplierLedger::where('reason', 'Payment')->paginate(250);
            return view('localSupplier.paymentsReport', $data);
        }
    }
    
    public function paymentDueReport(Request $request){
        if ($request->ajax()) {
            $alldata= LocalSupplier::all();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->make(True);
        }
        return view('localSupplier.paymentDueReport');
    }
}
