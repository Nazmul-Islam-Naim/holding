<?php

namespace App\Http\Controllers\AccountModule;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChequeBook\CreateRequest;
use App\Http\Requests\ChequeBook\UpdateRequest;
use App\Models\Bank;
use App\Models\ChequeBook;
use Illuminate\Support\Facades\Session;

class ChequeBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['banks'] = Bank::select('id', 'title')->get();
        $data['chequeBooks'] = ChequeBook::all();
        return view('accountModule.chequeBook.index', $data);
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
            ChequeBook::create($request->all());
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('chequeBooks.index')->with('status_color','success');
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
        $data['banks'] = Bank::select('id', 'title')->get();
        $data['chequeBook']= ChequeBook::findOrFail($id);
        $data['chequeBooks'] = ChequeBook::all();
        return view('accountModule.chequeBook.index', $data);
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
            ChequeBook::where('id', $id)->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('chequeBooks.index')->with('status_color','success');
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
            ChequeBook::where('id',$id)->delete($id);
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('chequeBooks.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
