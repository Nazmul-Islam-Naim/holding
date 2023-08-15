@extends('layouts.layout')
@section('title', 'Stock out invoice')
@section('content')
@php
    $totalQuantity = 0;
@endphp
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
            <h3 class="card-title">Stock out invoice</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" id="printReport">
                <center><h4 style="margin: 0px">Stock out Invoice</h4></center>
                <div class="table-responsive">
                  <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Invoice No</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">invo#{{$stockOut->id}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Date</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{Carbon\Carbon::parse($stockOut->date)->format('d-m-Y')}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Project Title</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->project->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Project Location</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->project->location ?? ''}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Note</td>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->note}}</td>
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
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($stockOut->stockOutDetails as $key => $stockOut)
                      <tr>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->product->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->product->productCategory->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->product->productUnit->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$stockOut->product->productBrand->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">
                          @php
                              echo number_format($stockOut->quantity, 2);
                              $totalQuantity += $stockOut->quantity;
                          @endphp
                        </td>
                      </tr>
                      @endforeach
                      @if($stockOut->count() == 0)
                        <tr>
                          <td colspan="6" align="center">
                            <h4 style="color: #ccc">No Data Found . . .</h4>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="5" style="text-align: right; border: 1px solid #ddd; padding: 3px 3px">Total</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($totalQuantity, 2)}}</td>
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