<?php

namespace App\Http\Controllers;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\BankAccount\CreateRequest;
use App\Http\Requests\BankAccount\UpdateRequest;
use App\Models\AccountType;
use App\Models\Bank;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Session;

class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['bankAccounts'] = BankAccount::all();
        return view('accountModule.bankAccount.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['accountTypes'] = AccountType::select('id', 'title')->get();
        $data['banks'] = Bank::select('id', 'title')->get();
        return view('accountModule.bankAccount.create', $data);
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
                    'transaction_type' => TransactionType::getFromName('Opening'),
                    'reason' => $object->account_name. ' '. TransactionType::Opening. 'Balance',
                    'amount' => $object->balance,
                    'transaction_date' => $object->opening_date
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
   public function show($id)
    {
        $data['bankAccount'] = BankAccount::findOrFail($id);
        return view('accountModule.bankAccount.report', $data);
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
            tap($object->update($inputData), function($object){
                $object->transaction()->update([
                    'transaction_type' => TransactionType::getFromName('Opening'),
                    'reason' => $object->account_name. ' '. TransactionType::Opening. 'Balance',
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

