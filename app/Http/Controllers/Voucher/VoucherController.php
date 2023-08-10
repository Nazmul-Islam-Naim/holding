<?php

namespace App\Http\Controllers\Voucher;

use App\Enum\VoucherType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Voucher\CreateRequest;
use App\Http\Requests\Voucher\UpdateRequest;
use App\Models\SubType;
use App\Models\Type;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $alldata= Voucher::with(['type', 'subType'])
                            ->where('due', '>', 0)
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $bgClass = $row->voucher_type == VoucherType::Receive->toString() ? 'bg-warning': 'bg-danger';
                ob_start() ?>
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('voucherTransaction.create',$row->id); ?>" class="badge badge-sm <?php echo $bgClass ?>" data-id="<?php echo $row->id; ?>" title="Edit"><?php echo $row->voucher_type; ?></a>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('voucher.voucher.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['types'] = Type::select('id', 'title')->get();
        $data['voucherTypes'] = VoucherType::get();
        return view('voucher.voucher.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $data = $request->all();
            $data['code'] = $this->generateUniqueCode();
            $data['user_id'] = Auth::user()->id;
            Voucher::create($data);
            Session::flash('flash_message','Data Successfully Added.');
            return redirect()->route('vouchers.index')->with('status_color','success');
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
        $data['voucher'] = Voucher::findOrFail($id);
        return view('voucher.voucher.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['types'] = Type::select('id', 'title')->get();
        $data['subTypes'] = SubType::select('id', 'title')->get();
        $data['voucherTypes'] = VoucherType::get();
        $data['voucher'] = Voucher::findOrFail($id);
        return view('voucher.voucher.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $inputData = $request->except('_method', '_token');
            Voucher::where('id', $id)->update($inputData);
            Session::flash('flash_message','Data Successfully Updated.');
            return redirect()->route('vouchers.index')->with('status_color','success');
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
            Voucher::where('id',$id)->delete($id);
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('vouchers.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $alldata= Voucher::with(['type', 'subType'])
                            ->where('due', '>', 0)
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('vouchers.edit',$row->id); ?>" class="badge bg-info badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-edit1"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <button data-id="<?php echo $row->id; ?>" class="badge bg-danger badge-sm button-delete"><i class="icon-delete"></i></button>
                    </li>
                </ul>

            <?php return ob_get_clean();
            })->make(True);
        }
        return view('voucher.voucher.index');
    }

    /** generate voucher unique code
     * 
     * return uniqueCode
     */
    public function generateUniqueCode(){
        $code = strtoupper(Str::random(8));
        if (Voucher::where('code', $code)->exists()) {
            return $this->generateUniqueCode();
        }
        return $code;
    }

    /**get sub type by type
     * 
     * return $subType
     */
    public function subType(Request $request){
        $subType = SubType::select('id', 'title')
                    ->where('type_id',$request->id)
                    ->get();
        return Response::json($subType);
    }
}
