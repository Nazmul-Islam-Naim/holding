<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangePassword;
use App\Models\User;
use Session;
use Hash;

class SettingController extends Controller
{
    public function index()
    {
        return view('user.setting');
    }

    public function updateUserPassword(ChangePassword $request, $id)
    {
        $data=User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['password_hint'] = $request->password;
        try{
            $data->update($input);
            Session::flash('flash_message','Data Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
