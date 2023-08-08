<?php

namespace App\Http\Controllers\AccountModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\DateFilter;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /** 
    *   [fetch all transaction]
    *   @param $request
    */
    public function transaction(DateFilter $request){
        if ($request->start_date != '' && $request->end_date != '') {
            $data['transactions'] = Transaction::whereBetween('transaction_date', [$request->start_date, $request->end_date])->paginate(250);
            return view('accountModule.transaction.report',$data);
        } else {
            $data['transactions'] = Transaction::paginate(250);
            return view('accountModule.transaction.report',$data);
        }
        
    }

}
