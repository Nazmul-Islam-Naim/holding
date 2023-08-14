@extends('layouts.layout')
@section('title', 'Stock Details')
@section('content')
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

  <!-- Content wrapper start -->
  <div class="content-wrapper">
    <!-- Row start -->
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Stock Details</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="get" action="{{ route('stocks.details.products') }}">
                  <div class="form-inline">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <select name="project_id" class="form-control select2">
                              <option value="">Select project</option>
                              @foreach($projects as $project)
                              <option value="{{$project->id}}">
                                {{$project->title}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="field-placeholder">Project </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <select name="product_id" class="form-control select2">
                              <option value="">Select product</option>
                              @foreach($products as $product)
                              <option value="{{$product->id}}">
                                {{$product->title}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="field-placeholder">Product </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <input type="submit" value="Search" class="btn btn-info btn-md">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="col-md-12" id="printReport">
                  <center><h5 style="margin: 0px">Stock Details</h5></center>
                  <table class="reportTable" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead> 
                      <tr style="background: #ccc; color: #000"> 
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Project Title</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Product Title</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Category</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Unit</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Brand</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Quantity</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($stocks as $key => $data)
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->project->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->productCategory->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->productUnit->title ?? ''}}</td> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->product->productBrand->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> {{number_format($data->quantity, 2)}}</td>
                      </tr>
                      @endforeach
                      @if($stocks->count()==0)
                      <tr>
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="6" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($stocks->sum('quantity'), 2)}}</b></td>
                      </tr>
                    </tfoot>
                  </table>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer" >
            <div class="col-md-12" style="display:flex; justify-content: end">
              {{$stocks->appends(Request::except('page'))->links()}}
            </div>
          </div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection 