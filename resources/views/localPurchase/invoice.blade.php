@extends('layouts.layout')
@section('title', 'Purchase invoice')
@section('content')
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

  <!-- Content wrapper start -->
  <div class="content-wrapper">
    <!-- Row start -->
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        @include('common.message')
      </div>
    </div>
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Purchase invoice</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" id="printReport">
                <center><h4 style="margin: 0px">Local Purchase Invoice</h4></center>
                <div class="table-responsive">
                  <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Invoice No</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">invo#{{$localPurchase->id}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Purchase Date</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{Carbon\Carbon::parse($localPurchase->date)->format('d-m-Y')}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Name</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Phone</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->phone ?? ''}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Email</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->email ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Supplier Address</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localPurchase->supplier->address ?? ''}}</td>
                      </tr>
                    </thead>
                  </table>
                  <table style="width: 100%; font-size: 12px; margin-top:15px" cellspacing="0" cellpadding="0"> 
                    <thead> 
                      <tr style="background: #ccc;">
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">SL</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Product</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Category</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Unit</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Brand</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Unit Price</th>
                        <th style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px">Total</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($localPurchase->purchaseDetails as $key => $purchase)
                      <tr>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->product->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->product->productCategory->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->product->productUnit->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->product->productBrand->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->quantity}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$purchase->unit_price}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($purchase->quantity * $purchase->unit_price, 2)}}</td>
                      </tr>
                      @endforeach
                      @if($localPurchase->count() == 0)
                        <tr>
                          <td colspan="8" align="center">
                            <h4 style="color: #ccc">No Data Found . . .</h4>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="7" style="text-align: right; border: 1px solid #ddd; padding: 3px 3px">Total</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($localPurchase->amount, 2)}}</td>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="col-md-12" align="right"></div>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer" >
            
          </div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection 