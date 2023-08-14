<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Project;
use App\Models\Stock;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StockController extends Controller
{
    /**
     * project list
     * stock for every project
     */
    public function projects(Request $request)
    {
        if ($request->ajax()) {
            $alldata= Project::with(['stocks'])->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                ob_start() ?>
                
                <ul class="list-inline m-0">
                    <li class="list-inline-item">
                        <a href="<?php echo route('stocks.project.products',$row->id); ?>" class="badge bg-success badge-sm" data-id="<?php echo $row->id; ?>" title="Edit"><i class="icon-book-open me-1"></i>Open</a>
                    </li>
                </ul>

                <?php return ob_get_clean();
            })
            ->make(True);
        }
        return view('product.stock.project');
    }

    /**
     * products list 
     * project wise 
     */
    public function projectStock(Request $request, $id)
    {
        $data['project'] = Project::findOrFail($id);
        if ($request->ajax()) {
            $alldata= Stock::with(['product', 'product.productCategory', 'product.productUnit', 'product.productBrand'])
                            ->where('project_id', $request->project_id)
                            ->get();
            return DataTables::of($alldata)
            ->addIndexColumn()
            ->make(True);
        }
        return view('product.stock.projectStock',$data);
    }

    /**
     * stock details 
     * all projects
     */
    public function stockDetails(Request $request){
        if ($request->project_id != '' && $request->product_id != '') {
            $data['stocks'] = Stock::where('project_id', $request->project_id)->where('product_id', $request->product_id)->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['products'] = Product::select('id', 'title')->get();
            return view('product.stock.detailsStock',$data);
        } elseif ($request->project_id != '' && $request->product_id == '') {
            $data['stocks'] = Stock::where('project_id', $request->project_id)->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['products'] = Product::select('id', 'title')->get();
            return view('product.stock.detailsStock',$data);
        } elseif ($request->project_id == '' && $request->product_id != '') {
            $data['stocks'] = Stock::where('product_id', $request->product_id)->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['products'] = Product::select('id', 'title')->get();
            return view('product.stock.detailsStock',$data);
        } else {
            $data['stocks'] = Stock::paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['products'] = Product::select('id', 'title')->get();
            return view('product.stock.detailsStock',$data);
        }
    }
}
