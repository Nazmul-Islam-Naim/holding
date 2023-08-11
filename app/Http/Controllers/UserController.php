<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Session;
use Hash;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\FileUploadTrait;


class UserController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Gate::authorize('app.users.index');
        if ($request->ajax()) {
            $alldata= User::with(['role'])
                            ->where('role_id','!=',1)
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('user-list.edit', $row->id); ?>" class="badge bg-primary badge-sm" data-id="<?php echo $row->id; ?>"><i class="icon-edit-3"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate::authorize('app.users.create');
        $data['roles']= Role::select('id','title')->get();
        return view('user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        // Gate::authorize('app.users.create');
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $data = $this->storeFile($data, 'user');

        try{
            User::create($data);
            Session::flash('flash_message','User Successfully Added !');
            return redirect()->route('user-list.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Faild to create user!');
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
        // Gate::authorize('app.users.create');
        $user = User::findOrFail($id);
        return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Gate::authorize('app.users.edit');
        $roles= Role::select('id','title')->get();
        $user=User::findOrFail($id);
        return view('user.edit', ['roles' => $roles,'user' =>$user]);
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
        // Gate::authorize('app.users.edit');
        $user = User::findOrFail($id);
        $data = $request->all();
        if ($request->password !="") {
            $data['password'] = Hash::make($request->password);
        }else{
            $data['password'] = $user->password;
        }
        $data = $this->updateFile($user, $data, 'user');
        $method = Arr::pull($data, '_method');
        $token = Arr::pull($data, '_token');
        try{
            $user->update($data);
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect()->route('user-list.index')->with('status_color','warning');
        }catch(\Exception $e){
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
        // Gate::authorize('app.users.delete');
        try{
            $user = User::findOrFail($id);
            $this->destroyFile($user);
            $user->delete();
            Session::flash('flash_message','User Successfully Deleted !');
            return redirect()->route('user-list.index')->with('status_color','warning');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

}
