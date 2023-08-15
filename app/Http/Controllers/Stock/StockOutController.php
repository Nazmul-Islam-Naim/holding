<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\ProjectDateFilter;
use App\Http\Requests\StockOut\CreateRequest;
use App\Http\Requests\StockOut\UpdateRequest;
use App\Models\Project;
use App\Models\Stock;
use App\Models\StockOut;
use App\Models\StockOutDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StockOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectDateFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->project_id != '') {
            $data['stockOuts'] = StockOut::where('project_id', $request->project_id)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('product.stockOut.index', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->project_id == ''){
            $data['stockOuts'] = StockOut::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('product.stockOut.index', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->project_id != ''){
            $data['stockOuts'] = StockOut::where('project_id', $request->project_id)
                                    ->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            return view('product.stockOut.index', $data);
        } else {
            $data['stockOuts'] = StockOut::paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            return view('product.stockOut.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['projects'] = Project::select('id', 'title')->get();
        return view('product.stockOut.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $stockOut = StockOut::create([
                'project_id' => $request->project_id,
                'date' => $request->date,
                'note' => $request->note,
            ]);

            foreach ($request->purchase_details as $key => $value) {

                $stockOut->stockOutDetails()->create([
                    'product_id' => $value['product_id'],
                    'quantity' => $value['quantity'],
                    'unit_price' => $value['unit_price']
                ]);

                Stock::where('project_id', $request->project_id)->where('product_id', $value['product_id'])->decrement('quantity', $value['quantity']);
                
            }
            DB::commit();
            Session::flash('flash_message','Stock Out.');
            return redirect()->route('stockOuts.index')->with('status_color','success');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('flash_message','Something Error Found !');
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
        $data['stockOut'] = StockOut::findOrFail($id);
        return view('product.stockOut.invoice', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['stockOut'] = StockOut::findOrFail($id);
        return view('product.stockOut.edit', $data);
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
        try {
            DB::beginTransaction();

            $this->destroyAndUpdate($id);
            
            $stockOut = StockOut::create([
                'project_id' => $request->project_id,
                'date' => $request->date,
                'note' => $request->note,
            ]);

            foreach ($request->purchase_details as $key => $value) {

                $stockOut->purchaseDetails()->create([
                    'product_id' => $value['product_id'],
                    'quantity' => $value['quantity'],
                    'unit_price' => $value['unit_price']
                ]);

                Stock::where('project_id', $request->project_id)->where('product_id', $value['product_id'])->decrement('quantity', $value['quantity']);
                
            }
            DB::commit();
            Session::flash('flash_message','Data Successfully Updated !');
            return redirect()->route('stockOuts.list')->with('status_color','success');
        } catch (\Exception $e) {
            DB::rollBack();
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
        try {
            DB::beginTransaction();
            $this->destroyAndUpdate($id);
            DB::commit();
            Session::flash('flash_message','Data Successfully Deleted !');
            return redirect()->route('stockOuts.destroy')->with('status_color','success');
        } catch (\Exception $e) {
            DB::rollBack();
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stockOutProductDetails(ProjectDateFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->project_id != '') {
            $data['stockOutDetails'] = StockOutDetails::whereHas('stockOut', function ($query) use ($request) {
                $query->where('project_id', $request->project_id)
                    ->whereBetween('date', [$request->start_date, $request->end_date]);
            })->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('product.stockOut.details', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->project_id == ''){
            $data['stockOutDetails'] = StockOutDetails::whereHas('stockOut', function ($query) use ($request) {
                $query->whereBetween('date',[$request->start_date, $request->end_date]);
            })->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('product.stockOut.details', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->project_id != ''){
            $data['stockOutDetails'] = StockOutDetails::whereHas('stockOut', function ($query) use ($request) {
                $query->where('project_id', $request->project_id);
            })->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            return view('product.stockOut.details', $data);
        } else {
            $data['stockOutDetails'] = StockOutDetails::paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            return view('product.stockOut.details', $data);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(ProjectDateFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->project_id != '') {
            $data['stockOuts'] = StockOut::where('project_id', $request->project_id)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('product.stockOut.list', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->project_id == ''){
            $data['stockOuts'] = StockOut::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('product.stockOut.list', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->project_id != ''){
            $data['stockOuts'] = StockOut::where('project_id', $request->project_id)
                                    ->paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            return view('product.stockOut.list', $data);
        } else {
            $data['stockOuts'] = StockOut::paginate(250);
            $data['projects'] = Project::select('id', 'title')->get();
            return view('product.stockOut.list', $data);
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAndUpdate($id):void{
        $stockOut = StockOut::findOrFail($id);

        $stockOut->stockOutDetails()->delete();
        $stockOut->delete();
    }

    /**
     * product details ajax request
     */
    public function availableStockProduct(Request $request){
        $availableStockProduct = Stock::with('product')->where('project_id', $request->project_id)
                        ->get();
        return response()->json($availableStockProduct);
    }
    
    /**
     * product details ajax request
     */
    public function currentStock(Request $request){
        $currentStock = Stock::where('project_id', $request->project_id)
                        ->where('product_id', $request->product_id)
                        ->select('quantity', 'unit_price')
                        ->first();
        return response()->json($currentStock);
    }
}
