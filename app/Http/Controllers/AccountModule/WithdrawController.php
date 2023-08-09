<?php

namespace App\Http\Controllers\AccountModule;

use App\Enum\ChequeNumberStatus;
use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccount\DepositRequest;
use App\Http\Requests\BankAccount\WithdrawRequest;
use App\Http\Requests\Filter\DateFilter;
use App\Models\BankAccount;
use App\Models\ChequeBook;
use App\Models\ChequeNumber;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= Transaction::with(['bankAccount', 'bankAccount.bank'])
                            ->where('transaction_type', TransactionType::getFromName('Withdraw'))
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('deposits.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('accountModule.deposit.index');
    }

    /**
     * Show the form for creating a new resource.
     * @param int $id [bank account id]
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data['chequeBooks'] = ChequeBook::whereHas('chequeNumbers', function ($query) {
                                $query->where('status', ChequeNumberStatus::getFromName('Unused'));
                            })->get();
        $data['bankAccount'] = BankAccount::findOrFail($id);
        return view('accountModule.withdraw.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  BankAccount $id
     * @return \Illuminate\Http\Response
     */

    public function store(WithdrawRequest $request, $id)
    {
        try {
            $object = BankAccount::findOrFail($id);
            tap($object->decrement('balance', $request->amount), function($status) use($object, $request){
                $object->transaction()->create([
                    'bank_account_id' => $object->id,
                    'transaction_type' => TransactionType::getFromName('Withdraw'),
                    'reason' => $object->account_name. ' '. 
                        TransactionType::Withdraw->toString(). '(C/B: '. 
                        ChequeBook::where('id', $request->cheque_book_id)->first()->title. ', C/N: '. 
                        ChequeNumber::where('id', $request->cheque_number_id)->first()->cheque_number. ')',
                    'amount' => $request->amount,
                    'transaction_date' => $request->transaction_date,
                    'note' => $request->note,
                ]);
                ChequeNumber::where('id', $request->cheque_number_id)->update(['status' => ChequeNumberStatus::getFromName('Used')]);
            });
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('bankAccounts.index')->with('status_color','success');
        } catch (\Exception $exception) {
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
   public function show(DateFilter $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  Transaction  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['deposit'] = Transaction::findOrFail($id);
        return view('accountModule.withdraw.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(WithdrawRequest $request, $id)
    {
        try {
            $inputData = $request->except('_method', '_token');
            $object = Transaction::findOrFail($id);
            $bankAccount = BankAccount::findOrFail($object->bank_account_id);

            tap($bankAccount->increment('balance', $object->amount), function($status) use($object,  $bankAccount, $inputData){
                $bankAccount->decrement('balance', $inputData['amount']);
                $object->transaction()->update([
                    'transaction_type' => TransactionType::getFromName('Withdraw'),
                    'reason' => $object->account_name. ' '. TransactionType::Withdraw->toString(). '(C/B: '. 
                                ChequeBook::where('id', $inputData['cheque_book_id'])->first()->title. ', C/N: '. 
                                ChequeNumber::where('id', $inputData['cheque_number_id'])->first()->cheque_number. ')',
                    'amount' => $inputData['amount'],
                    'transaction_date' => $inputData['transaction_date'],
                    'note' => $inputData['note'],
                ]);
                ChequeNumber::where('cheque_number', $this->findChequeNumber($object->reason))->update(['status' => ChequeNumberStatus::getFromName('Unused')]);
                ChequeNumber::where('id', $inputData['cheque_number_id'])->update(['status' => ChequeNumberStatus::getFromName('Used')]);
            });

            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('withdraws.index')->with('status_color','success');
        } catch (\Exception $exception) {
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
            $object = Transaction::findOrFail($id);
            BankAccount::where('id', $object->amount)->increment('balance', $object->amount);
            ChequeNumber::where('cheque_number', $this->findChequeNumber($object->reason))->update(['status' => ChequeNumberStatus::getFromName('Unused')]);
            $object->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('bankAccounts.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * available cheque book numbers
     * @param ChequeBook $id
     * response json
     */
    public function availableChequeNumbers(Request $request){
        $avilableChequeNumbers = ChequeNumber::select('id', 'cheque_number')
                    ->where('cheque_book_id',$request->id)
                    ->where('status', ChequeNumberStatus::getFromName('Unused'))
                    ->get();
        return Response::json($avilableChequeNumbers);
    }

    /**
     * find cheque number
     * using regula expression
     */
    public function findChequeNumber($reason){

        $pattern = '/C\/N: (\d+)/';
        $matches = [];

        if (preg_match($pattern, $reason, $matches)) {
            $chequeNumber = $matches[1];
            return $chequeNumber;
        }
    }
}

