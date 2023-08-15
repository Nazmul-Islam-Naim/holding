<?php

namespace App\Http\Controllers\ShareHolder;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShareHolder\CreateRequest;
use App\Http\Requests\ShareHolder\UpdateRequest;
use App\Models\ProjectShareholder;
use App\Models\ShareHolder;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ShareHolderController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= ShareHolder::all();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('shareHolders.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('shareHolder.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shareHolder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $data = $request->all();
            $data = $this->storeFile($data, 'shareHolder');
            ShareHolder::create($data);
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('shareHolders.index')->with('status_color','success');
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
        $data['shareHolder'] = ShareHolder::findOrFail($id);
        return view('shareHolder.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['shareHolder'] = ShareHolder::findOrFail($id);
        return view('shareHolder.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $shareHolder = ShareHolder::findOrFail($id);
            $data = $request->all();
            $data = $this->updateFile($shareHolder, $data, 'shareHolder');
            $inputData = array_diff_key($data, array_flip(['_method', '_token']));
            $shareHolder->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('shareHolders.index')->with('status_color','success');
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
            $shareHolder = ShareHolder::findOrFail($id);
            $this->destroyFile($shareHolder);
            $shareHolder->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('shareHolders.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**   [fetch all records]
    *   @param $request
    */
    public function ledger($id)
    {
        $data['shareHolder'] = ShareHolder::findOrFail($id);
        $data['transactions'] = ProjectShareholder::where('share_holder_id', $id)->paginate(250);
        return view('shareHolder.ledger',$data);
    }
}
