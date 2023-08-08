<?php

namespace App\Http\Controllers\AccountModule;

use App\Enum\Status;
use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccount\CreateRequest;
use App\Http\Requests\BankAccount\UpdateRequest;
use App\Http\Requests\Filter\DateFilter;
use App\Models\AccountType;
use App\Models\Bank;
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
                            ->where('transaction_type', TransactionType::getFromName('Deposit')->value)
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
    public function deposit($id)
    {
        $data['accountTypes'] = BankAccount::findOrFail($id);
        return view('accountModule.deposit.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(CreateRequest $request)
    {
        try {
            tap(BankAccount::create($request->all()), function($object){
                $object->transaction()->create([
                    'bank_account_id' => $object->id,
                    'transaction_type' => TransactionType::getFromName('Opening'),
                    'reason' => $object->account_name. ' '. TransactionType::Opening->toString(). ' Balance',
                    'amount' => $object->balance,
                    'transaction_date' => $object->opening_date
                ]);
            });
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('bankAccounts.index')->with('status_color','success');
        } catch (\Exception $exception) {
            dd($exception->getMessage());
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
        if ($request->start_date != '' && $request->end_date != '') {
            $bankAccount = BankAccount::findOrFail($id);
            $bankAccount->load(['transactions' => function ($query) use ($request) {
                $query->where('transaction_date', '>=', $request->start_date)
                    ->where('transaction_date', '<=', $request->end_date);
            }]);
            $data['bankAccount'] = $bankAccount;
            return view('accountModule.bankAccount.report', $data);
        } else {
            $data['bankAccount'] = BankAccount::findOrFail($id);
            return view('accountModule.bankAccount.report', $data);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['accountTypes'] = AccountType::select('id', 'title')->get();
        $data['banks'] = Bank::select('id', 'title')->get();
        $data['bankAccount'] = BankAccount::findOrFail($id);
        return view('accountModule.bankAccount.edit', $data);
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
        try {
            $inputData = $request->except('_method', '_token');
            $object = BankAccount::findOrFail($id);
            tap($object->update($inputData), function($status) use($object){
                $object->transaction()->update([
                    'transaction_type' => TransactionType::getFromName('Opening'),
                    'reason' => $object->account_name. ' '. TransactionType::Opening->toString(). ' Balance',
                    'amount' => $object->balance,
                    'transaction_date' => $object->opening_date
                ]);
            });
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('bankAccounts.index')->with('status_color','success');
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
            BankAccount::where('id',$id)->delete($id);
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('bankAccounts.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}

