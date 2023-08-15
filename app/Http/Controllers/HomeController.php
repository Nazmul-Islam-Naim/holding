<?php

namespace App\Http\Controllers;
use App\Models\BillGenerate;
use App\Models\Product;
use App\Models\Project;
use App\Models\ProjectShare;
use App\Models\ShareHolder;
use App\Models\Stock;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['projects'] = Project::count();
        $data['sharholders'] = ShareHolder::count();
        $data['shares'] = Project::sum('total_share');
        $data['projectShares'] = ProjectShare::sum('total_share');
        $data['products'] = Product::count();
        $data['stocks'] = Stock::sum('quantity');
        $data['shareBills'] = BillGenerate::sum('bill');
        $data['shareDues'] = BillGenerate::sum('due');
        $data['shareCollecitons'] = $data['shareBills'] - $data['shareDues'];
        return view('dashboard.dashboard',$data);
    }
}
