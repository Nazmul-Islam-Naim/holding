<?php

namespace App\Http\Controllers\Project;

use App\Enum\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\CreateRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Models\Project;
use App\Models\ProjectShare;
use App\Models\ProjectShareholder;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    use FileUploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= Project::all();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('status', function ($row) {
                $bgClass = $row->status == ProjectStatus::getFromName('Running')->value ? 'bg-warning' : ($row->status == ProjectStatus::getFromName('Stop')->value ? 'bg-danger' : 'bg-success');
                return '<span data-id="' . $row->id . '" class="badge '.$bgClass.' badge-sm button-status">' . ProjectStatus::getByValue($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('projects.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->rawColumns(['status', 'action'])
            ->make(True);
        }
        return view('project.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $data = $request->all();
            $data = $this->storeFile($data, 'project');
            Project::create($data);
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('projects.index')->with('status_color','success');
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
        $data['project'] = Project::findOrFail($id);
        return view('project.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['project'] = Project::findOrFail($id);
        return view('project.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $project = Project::findOrFail($id);
            $data = $request->all();
            $data = $this->updateFile($project, $data, 'project');
            $inputData = array_diff_key($data, array_flip(['_method', '_token']));
            $project->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('projects.index')->with('status_color','success');
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
            $project = Project::findOrFail($id);
            $this->destroyFile($project);
            $project->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('projects.index')->with('status_color','success');
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
        $data['project'] = Project::findOrFail($id);
        $data['transactions'] = ProjectShareholder::where('project_id', $id)->paginate(250);
        return view('project.ledger',$data);
    }
}
