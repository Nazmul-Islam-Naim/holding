<?php

namespace App\Http\Controllers\ProjectShare;

use App\Http\Controllers\Controller;
use App\Http\Requests\BillType\CreateRequest;
use App\Http\Requests\BillType\UpdateRequest;
use App\Models\BillType;
use Illuminate\Support\Facades\Session;

class BillTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['billTypes'] = BillType::all();
        return view('billType.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            BillType::create($request->all());
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('billTypes.index')->with('status_color','success');
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
        $data['billType']= BillType::findOrFail($id);
        $data['billTypes'] = BillType::all();
        return view('billType.index', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
       
        try {
            $inputData = $request->except('_method', '_token');
            BillType::where('id', $id)->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('billTypes.index')->with('status_color','success');
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
            BillType::where('id',$id)->delete($id);
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('billTypes.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

}
