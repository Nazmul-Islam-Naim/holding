<?php

namespace App\Http\Controllers\ProjectShare;

use App\Enum\TransactionType;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectShare\CreateRequest;
use App\Http\Requests\ProjectShare\UpdateRequest;
use App\Models\Project;
use App\Models\ProjectShare;
use App\Models\ShareHolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class ProjectShareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= ProjectShare::with(['project', 'shareHolder'])->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('projectShares.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('projectShare.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['projects'] = Project::select('id', 'title')->get();
        $data['shareHolders'] = ShareHolder::select('id', 'name', 'phone')->get();
        return view('projectShare.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $project = Project::findOrFail($request->project_id);
            if ($project->total_share > ($project->shares()->sum('total_share') + $request->total_share)) {
                $projectShare = ProjectShare::updateOrCreate(
                    [
                        'project_id' => $request->project_id,
                        'share_holder_id' => $request->share_holder_id,
                    ],
                    $request->all()
                );

                $projectShare->shareHolder()->increment('bill', $request->total_amount);
                $projectShare->shareHolder()->increment('due', $request->total_amount);

                $projectShare->bill()->updateOrCreate(
                    [
                        'project_share_id' => $projectShare->id
                    ],
                    [
                        'project_id' => $request->project_id,
                        'share_holder_id' => $request->share_holder_id,
                        'transaction_type' => TransactionType::getFromName('Bill'),
                        'amount' => $request->total_amount,
                        'date' => $request->date
                    ]
                    );
                Session::flash('flash_message','Data Successfully Added.');
                return redirect()->route('projectShares.index')->with('status_color','success');
            } else {
                Session::flash('flash_message','Share Limited !');
                return redirect()->back()->with('status_color','warning');
            }
            
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
        $data['shareHolders'] = ShareHolder::select('id', 'name', 'phone')->get();
        $data['projectShare'] = ProjectShare::findOrFail($id);
        return view('projectShare.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $inpuntdata = $request->except('_method', '_token');
            $projectShare = ProjectShare::findOrFail($id);
            $project = Project::findOrFail($projectShare->project_id);
            if ($project->total_share > ($project->shares()->sum('total_share') + $request->total_share)) {
                
                $projectShare->shareHolder()->decrement('bill', $projectShare->total_amount);
                $projectShare->shareHolder()->decrement('due', $projectShare->total_amount);

                $projectShare->shareHolder()->increment('bill', $request->total_amount);
                $projectShare->shareHolder()->increment('due', $request->total_amount);
                
                $projectShare->update($inpuntdata);

                $projectShare->bill()->updateOrCreate(
                    [
                        'project_share_id' => $projectShare->id
                    ],
                    [
                        'share_holder_id' => $request->share_holder_id,
                        'amount' => $request->total_amount,
                        'date' => $request->date
                    ]
                    );
                Session::flash('flash_message','Data Successfully Added.');
                return redirect()->route('projectShares.index')->with('status_color','success');
            } else {
                Session::flash('flash_message','Share Limited !');
                return redirect()->back()->with('status_color','warning');
            }
            
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
            $projectShare = ProjectShare::findOrFail($id);
            $projectShare->shareHolder()->decrement('bill', $projectShare->total_amount);
            $projectShare->shareHolder()->decrement('due', $projectShare->total_amount);
            $projectShare->delete();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('projectShares.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Desplay all share
     */
    public function report(Request $request)
    {
        if ($request->ajax()) {
            $alldata= ProjectShare::with(['project', 'shareHolder'])->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->make(True);
        }
        return view('projectShare.report');
    }

}
