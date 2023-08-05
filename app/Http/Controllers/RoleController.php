<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use DB;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Gate::authorize('app.roles.index'));
        // Gate::authorize('app.roles.index');
        $data['roles'] = Role::all();
        return view('user.role-index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //  Gate::authorize('app.roles.create');
         $modules = Module::all();
         return view('user.role-form',compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Gate::authorize('app.roles.create');
        $request->validate([
            'title'=>'unique:roles|required|string|max:255',
            'permissions'=>'required|array'
        ]);

        try{
            $role = Role::create([
                'title' => $request->title,
                'slug'  => Str::slug($request->title),
            ]);
    
            $role->permissions()->sync($request->permissions);
         
            Session::flash('flash_message','Role Added !');
            return redirect()->route("user-role.index")->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Faild to create role !');
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
        // Gate::authorize('app.roles.edit');
        $data['modules'] = Module::all();
        $data['role'] = Role::findOrfail($id);
        return view('user.role-form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Gate::authorize('app.roles.edit');
        $role = Role::findOrFail($id);
        $request->validate([
            'title'=> 'unique:roles,title,'.$id,
            'permissions'=>'required|array'
        ]);

        try{
            $role->update([
                'title' => $request->title,
                'slug'  => Str::slug($request->title),
            ]);
    
            $role->permissions()->sync($request->permissions);
         
            Session::flash('flash_message','Role Updated !');
            return redirect()->route("user-role.index")->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Faild to update role !');
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
        // Gate::authorize('app.roles.destroy');
        $role = Role::where('deletable',true)->first();
        $role->delete();
         
        Session::flash('flash_message','Role Deleted !');
        return redirect()->back()->with('status_color','success');
    }
}
