<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\Filter\SupplierFilter;
use App\Http\Requests\LocalPurchase\CreateRequest;
use App\Http\Requests\LocalPurchase\UpdateRequest;
use App\Models\LocalPurchase;
use App\Models\LocalSupplier;
use App\Models\LocalSupplierLedger;
use App\Models\Product;
use App\Models\Project;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LocalPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SupplierFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->supplier_id != '') {
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.index', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->supplier_id == ''){
            $data['localPurchases'] = LocalPurchase::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.index', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->supplier_id != ''){
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            return view('localPurchase.index', $data);
        } else {
            $data['localSuppliers'] = LocalSupplier::all();
            $data['localPurchases'] = LocalPurchase::paginate(250);
            return view('localPurchase.index', $data);
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
        $data['localSuppliers'] = LocalSupplier::select('id', 'name', 'phone')->get();
        $data['products'] = Product::select('id', 'title')->get();
        return view('localPurchase.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $productAvgPrice = 0;
        try {
            DB::beginTransaction();
            
            $localPurchase = LocalPurchase::create([
                'local_supplier_id' => $request->local_supplier_id,
                'project_id' => $request->project_id,
                'amount' => $request->sub_total,
                'date' => $request->date,
                'note' => $request->note,
                'created_by' => Auth::user()->id,
            ]);

            foreach ($request->purchase_details as $key => $value) {

                $localPurchase->purchaseDetails()->create([
                    'product_id' => $value['product_id'],
                    'unit_price' => $value['unit_price'],
                    'quantity' => $value['quantity']
                ]);

                // Creating product Stock
                $stockProduct = Stock::where([['product_id', $value['product_id']],['project_id', $request->project_id]])->first();
                if (!empty($stockProduct)) {
                    
                    $stockProductPrice = $stockProduct->quantity * $stockProduct->unit_price; 
                    $purchaseProductPrice = $value['quantity'] * $value['unit_price'];
                    $amendmentProductPrice = $stockProductPrice + $purchaseProductPrice;

                    $stockProductQuantity = $stockProduct->quantity + $value['quantity'];
                    
                    if ($stockProductQuantity == 0) {
                        $productAvgPrice = 0;
                    } else {
                        $productAvgPrice = $amendmentProductPrice / $stockProductQuantity;
                    }

                    $stockProduct->update([
                        'quantity' => $stockProductQuantity,
                        'unit_price' => $productAvgPrice,
                    ]);

                }else{
                    Stock::create([
                        'project_id'=> $request->project_id,
                        'product_id'=>$value['product_id'],
                        'quantity'=>$value['quantity'],
                        'unit_price'=>$value['unit_price'],
                        'status'=>'1'
                    ]);
                }
            }

            LocalSupplier::where('id', $request->local_supplier_id)->increment('bill', $request->sub_total);
            LocalSupplier::where('id', $request->local_supplier_id)->increment('due', $request->sub_total);

            $localPurchase->supplierTransaction()->create([
                'local_supplier_id' => $request->local_supplier_id,
                'date' => $request->date,
                'reason' => 'Purchase',
                'amount' => $request->sub_total,
                'note' => $request->note,
            ]);
            DB::commit();
            Session::flash('flash_message','Local Purchase Successfully Created !');
            return redirect()->route('localPurchases.index')->with('status_color','success');
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
        $data['localPurchase'] = LocalPurchase::findOrFail($id);
        return view('localPurchase.invoice', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['localSuppliers'] = LocalSupplier::select('id', 'name', 'phone')->get();
        $data['products'] = Product::select('id', 'title')->get();
        $data['localPurchase'] = LocalPurchase::findOrFail($id);
        return view('localPurchase.edit', $data);
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
            
            $localPurchase = LocalPurchase::create([
                'local_supplier_id' => $request->local_supplier_id,
                'project_id' => $request->project_id,
                'amount' => $request->sub_total,
                'date' => $request->date,
                'note' => $request->note,
                'created_by' => Auth::user()->id,
            ]);

            foreach ($request->purchase_details as $key => $value) {

                $localPurchase->purchaseDetails()->create([
                    'product_id' => $value['product_id'],
                    'unit_price' => $value['unit_price'],
                    'quantity' => $value['quantity']
                ]);

                // Creating product Stock
                $stockProduct = Stock::where([['product_id', $value['product_id']],['project_id', $request->project_id]])->first();
                if (!empty($stockProduct)) {
                    
                    $stockProductPrice = $stockProduct->quantity * $stockProduct->unit_price; 
                    $purchaseProductPrice = $value['quantity'] * $value['unit_price'];
                    $amendmentProductPrice = $stockProductPrice + $purchaseProductPrice;

                    $stockProductQuantity = $stockProduct->quantity + $value['quantity'];
                    
                    if ($stockProductQuantity == 0) {
                        $productAvgPrice = 0;
                    } else {
                        $productAvgPrice = $amendmentProductPrice / $stockProductQuantity;
                    }

                    $stockProduct->update([
                        'quantity' => $stockProductQuantity,
                        'unit_price' => $productAvgPrice,
                    ]);

                }else{
                    Stock::create([
                        'project_id'=> $request->project_id,
                        'product_id'=>$value['product_id'],
                        'quantity'=>$value['quantity'],
                        'unit_price'=>$value['unit_price'],
                        'status'=>'1'
                    ]);
                }
            }

            LocalSupplier::where('id', $request->local_supplier_id)->increment('bill', $request->sub_total);
            LocalSupplier::where('id', $request->local_supplier_id)->increment('due', $request->sub_total);

            $localPurchase->supplierTransaction()->create([
                'local_supplier_id' => $request->local_supplier_id,
                'date' => $request->date,
                'reason' => 'Purchase',
                'amount' => $request->sub_total,
                'note' => $request->note,
            ]);
            DB::commit();
            Session::flash('flash_message','Local Purchase Successfully Updated !');
            return redirect()->route('localPurchaseList')->with('status_color','success');
        } catch (\Exception $e) {
            dd($e->getMessage());
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
            Session::flash('flash_message','Local Purchase Successfully Deleted !');
            return redirect()->route('localPurchaseList')->with('status_color','success');
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
    public function list(SupplierFilter $request)
    {
        if ($request->start_date != '' && $request->end_date != '' && $request->supplier_id != '') {
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.list', $data);
        } elseif ($request->start_date != '' && $request->end_date != '' && $request->supplier_id == ''){
            $data['localPurchases'] = LocalPurchase::whereBetween('date',[$request->start_date, $request->end_date])
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            $data['start_date'] = $request->start_date;
            $data['end_date'] = $request->end_date;
            return view('localPurchase.list', $data);
        } elseif ($request->start_date == '' && $request->end_date == '' && $request->supplier_id != ''){
            $data['localPurchases'] = LocalPurchase::where('local_supplier_id', $request->supplier_id)
                                    ->paginate(250);
            $data['localSuppliers'] = LocalSupplier::all();
            return view('localPurchase.list', $data);
        } else {
            $data['localSuppliers'] = LocalSupplier::all();
            $data['localPurchases'] = LocalPurchase::paginate(250);
            return view('localPurchase.list', $data);
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyAndUpdate($id):void{
        $productAvgPrice = 0;
        $localPurchase = LocalPurchase::findOrFail($id);
        foreach ($localPurchase->purchaseDetails as $key => $value) {
            $stockProduct = Stock::where([['product_id', $value['product_id']],['project_id', $localPurchase->project_id]])->first();

            $stockProductPrice = $stockProduct->quantity * $stockProduct->unit_price; 
            $purchaseProductPrice = $value['quantity'] * $value['unit_price'];
            $amendmentProductPrice = $stockProductPrice - $purchaseProductPrice;

            $stockProductQuantity = $stockProduct->quantity - $value['quantity'];

            if ($stockProductQuantity == 0) {
                $productAvgPrice = 0;
            } else {
                $productAvgPrice = $amendmentProductPrice / $stockProductQuantity;
            }

            $stockProduct->update([
                'quantity' => $stockProductQuantity,
                'unit_price' => $productAvgPrice,
            ]);
        }

        LocalSupplier::where('id', $localPurchase->local_supplier_id)->decrement('bill', $localPurchase->amount);
        LocalSupplier::where('id', $localPurchase->local_supplier_id)->decrement('due', $localPurchase->amount);

        $localPurchase->supplierTransaction()->delete();

        $localPurchase->purchaseDetails()->delete();
        $localPurchase->delete();
    }

    /**
     * product details ajax request
     */
    public function previousStock(Request $request){
        $previousStock = Stock::where('project_id', $request->project_id)
                        ->where('product_id', $request->product_id)
                        ->select('quantity')
                        ->first();
        return response()->json($previousStock);
    }
}
