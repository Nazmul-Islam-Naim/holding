<?php

namespace App\Http\Controllers\AccountModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChequeNumber\CreateRequest;
use App\Http\Requests\ChequeNumber\UpdateRequest;
use App\Models\ChequeBook;
use App\Models\ChequeNumber;
use Illuminate\Support\Facades\Session;

class ChequeNumberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['chequeBooks'] = ChequeBook::select('id', 'title', 'book_number')->get();
        $data['chequeNumbers'] = ChequeNumber::all();
        return view('accountModule.chequeNumber.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $chequeNumber = ChequeNumber::where('cheque_book_id', $request->cheque_book_id)->count();
            $chequeBook = ChequeBook::where('id', $request->cheque_book_id)->first()->pages;
            if ( $chequeNumber <= $chequeBook){
                ChequeNumber::create($request->all());
                Session::flash('flash_message','Data Successfully Added.');
                return redirect()->route('chequeNumbers.index')->with('status_color','success');
            }else{
                Session::flash('flash_message','You can\'t add more page in this book !');
                return redirect()->route('chequeNumbers.index')->with('status_color','warning');
            }
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
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['chequeBooks'] = ChequeBook::select('id', 'title', 'book_number')->get();
        $data['chequeNumber']= ChequeNumber::findOrFail($id);
        $data['chequeNumbers'] = ChequeNumber::all();
        return view('accountModule.chequeNumber.index', $data);
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
            ChequeNumber::where('id', $id)->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('chequeNumbers.index')->with('status_color','success');
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
            ChequeNumber::where('id',$id)->delete($id);
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('chequeNumbers.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
