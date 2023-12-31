<?php

namespace App\Http\Controllers\AccountModule;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccount\DepositRequest;
use App\Http\Requests\Filter\DateFilter;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class DepositController extends Controller
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
                            ->where('transaction_type', TransactionType::getFromName('Deposit'))
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
        $data['bankAccount'] = BankAccount::findOrFail($id);
        return view('accountModule.deposit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  BankAccount $id
     * @return \Illuminate\Http\Response
     */

    public function store(DepositRequest $request, $id)
    {
        try {
            $object = BankAccount::findOrFail($id);
            tap($object->increment('balance', $request->amount), function($status) use($object, $request){
                $object->transaction()->create([
                    'bank_account_id' => $object->id,
                    'transaction_type' => TransactionType::getFromName('Deposit'),
                    'reason' => $object->account_name. ' '. TransactionType::Deposit->toString(). ' Balance',
                    'amount' => $request->amount,
                    'transaction_date' => $request->transaction_date,
                    'note' => $request->note,
                ]);
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
        return view('accountModule.deposit.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepositRequest $request, $id)
    {
        try {
            $inputData = $request->except('_method', '_token');
            $object = Transaction::findOrFail($id);
            $bankAccount = BankAccount::findOrFail($object->bank_account_id);
            tap($bankAccount->decrement('balance', $object->amount), function($status) use($object,  $bankAccount, $inputData){
                $bankAccount->increment('balance', $inputData['amount']);
                $object->transaction()->update([
                    'transaction_type' => TransactionType::getFromName('Deposit'),
                    'reason' => $bankAccount->account_name. ' '. TransactionType::Deposit->toString(). ' Balance',
                    'amount' => $inputData['amount'],
                    'transaction_date' => $inputData['transaction_date'],
                    'note' => $inputData['note'],
                ]);
            });
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('deposits.index')->with('status_color','success');
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
            BankAccount::where('id', $object->amount)->decrement('balance', $object->amount);
            $object->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('bankAccounts.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}

