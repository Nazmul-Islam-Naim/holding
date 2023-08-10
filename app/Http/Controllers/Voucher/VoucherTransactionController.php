<?php

namespace App\Http\Controllers\Voucher;

use App\Enum\TransactionType;
use App\Enum\VoucherType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\DateFilter;
use App\Http\Requests\VoucherTransaction\CreateRequest;
use App\Http\Requests\VoucherTransaction\UpdateRequest;
use App\Models\BankAccount;
use App\Models\Type;
use App\Models\Voucher;
use App\Models\VoucherTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class VoucherTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= VoucherTransaction::with(['voucher', 'bankAccount'])
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('vouchers.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('voucher.voucherTransaction.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $data['voucher'] = Voucher::findOrFail($id);
        $data['bankAccounts'] = BankAccount::select('id', 'account_name', 'account_number')->get();
        return view('voucher.voucherTransaction.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request, $id)
    {
        try {
            $object = Voucher::findOrFail($id);
            if ($object->voucher_type == VoucherType::Receive->toString()) {
                tap($object->decrement('due', $request->amount), function($status) use($object, $request){
                    $voucherTnx = $object->voucherTransaction()->create([
                        'bank_account_id' => $request->bank_account_id,
                        'voucher_type' => $object->voucher_type,
                        'amount' => $request->amount,
                        'date' => $request->date,
                        'note' => $request->note,
                    ]);
                    BankAccount::where('id', $request->bank_account_id)->increment('balance', $request->amount);
                    $voucherTnx->transaction()->create([
                        'bank_account_id' => $request->bank_account_id,
                        'transaction_type' => TransactionType::getFromName('Receive'),
                        'reason' => 'Other'. TransactionType::Receive->toString(). ' (t: ' . ($object->type->title ?? '') . ' s/t: '. ($object->subType->title ?? ''). ' v/c: ' . $object->code. ')',
                        'amount' => $request->amount,
                        'transaction_date' => $request->date,
                        'note' => $request->note,
                    ]);
                });
            } else {
                tap($object->decrement('due', $request->amount), function($status) use($object, $request){
                    $voucherTnx = $object->voucherTransaction()->create([
                        'bank_account_id' => $request->bank_account_id,
                        'voucher_type' => $object->voucher_type,
                        'amount' => $request->amount,
                        'date' => $request->date,
                        'note' => $request->note,
                    ]);
                    BankAccount::where('id', $request->bank_account_id)->decrement('balance', $request->amount);
                    $voucherTnx->transaction()->create([
                        'bank_account_id' => $request->bank_account_id,
                        'transaction_type' => TransactionType::getFromName('Payment'),
                        'reason' => 'Other'. TransactionType::Payment->toString(). ' (t: ' . ($object->type->title ?? '') . ' s/t: '. ($object->subType->title ?? ''). ' v/c: ' . $object->code. ')',
                        'amount' => $request->amount,
                        'transaction_date' => $request->date,
                        'note' => $request->note,
                    ]);
                });
            }
            
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('vouchers.index')->with('status_color','success');
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
        $data['voucherTransaction'] = VoucherTransaction::findOrFail($id);
        return view('voucher.voucherTransaction.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $inputData = $request->except('_method', '_token');
            $voucherTransaction = VoucherTransaction::findOrFail($id);
            $voucher = Voucher::findOrFail($voucherTransaction->voucher_id);
            if ($voucher->voucher_type == VoucherType::Receive->toString()) {
                tap($voucher->increment('due', $voucherTransaction->amount), function($status) use($voucher, $inputData, $voucherTransaction){
                    $voucher->decrement('due', $inputData['amount']);
                    $voucher->voucherTransaction()->update([
                        'bank_account_id' => $inputData['bank_account_id'],
                        'amount' => $inputData['amount'],
                        'date' => $inputData['date'],
                        'note' => $inputData['note'],
                    ]);
                    BankAccount::where('id', $voucherTransaction->bank_account_id)->decrement('balance', $voucherTransaction->amount);
                    BankAccount::where('id', $inputData['bank_account_id'])->increment('balance', $inputData['amount']);
                    $voucherTransaction->transaction()->update([
                        'bank_account_id' => $inputData['bank_account_id'],
                        'amount' => $inputData['amount'],
                        'transaction_date' => $inputData['date'],
                        'note' => $inputData['note'],
                    ]);
                });
            } else {
                tap($voucher->decrement('due', $voucherTransaction->amount), function($status) use($voucher, $inputData, $voucherTransaction){
                    $voucher->increment('due', $inputData['amount']);
                    $voucher->voucherTransaction()->update([
                        'bank_account_id' => $inputData['bank_account_id'],
                        'amount' => $inputData['amount'],
                        'date' => $inputData['date'],
                        'note' => $inputData['note'],
                    ]);
                    BankAccount::where('id', $voucherTransaction->bank_account_id)->increment('balance', $voucherTransaction->amount);
                    BankAccount::where('id', $inputData['bank_account_id'])->decrement('balance', $inputData['amount']);
                    $voucherTransaction->transaction()->update([
                        'bank_account_id' => $inputData['bank_account_id'],
                        'amount' => $inputData['amount'],
                        'transaction_date' => $inputData['date'],
                        'note' => $inputData['note'],
                    ]);
                });
            }
            
            Type::where('id', $id)->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('types.index')->with('status_color','success');
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
            $voucherTransaction = VoucherTransaction::findOrFail($id);
            $voucher = Voucher::findOrFail($voucherTransaction->voucher_id);
            if ($voucher->voucher_type == VoucherType::Receive->toString()) {
                $voucher->decrement('due', $voucherTransaction->amount);
                $voucherTransaction->bankAccount()->decrement('balance', $voucherTransaction->amount);
            } else {
                $voucher->increment('due', $voucherTransaction->amount);
                $voucherTransaction->bankAccount()->increment('balance', $voucherTransaction->amount);
            }
            $voucherTransaction->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('types.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * fetch all receive 
     * 
     * voucher_type = Rececive
     */
    public function receiveReport(DateFilter $request){
        if ($request->start_date != '' && $request->end_date != '') {
            $data['voucherTransactions'] = VoucherTransaction::where('voucher_type', VoucherType::Receive->toString())
                                        ->whereBetween('date', [$request->start_date, $request->end_date])
                                        ->paginate(250);
            return view('voucher.report.receive', $data);
        } else {
            $data['voucherTransactions'] = VoucherTransaction::where('voucher_type', VoucherType::Receive->toString())
                                        ->paginate(250);
            return view('voucher.report.receive', $data);
        }
    }

    /**
     * fetch all payments 
     * 
     * voucher_type = Payment
     */
    public function paymentReport(DateFilter $request){
        if ($request->start_date != '' && $request->end_date != '') {
            $data['voucherTransactions'] = VoucherTransaction::where('voucher_type', VoucherType::Payment->toString())
                                        ->whereBetween('date', [$request->start_date, $request->end_date])
                                        ->paginate(250);
            return view('voucher.report.payment', $data);
        } else {
            $data['voucherTransactions'] = VoucherTransaction::where('voucher_type', VoucherType::Payment->toString())
                                        ->paginate(250);
            return view('voucher.report.payment', $data);
        }
    }
}
