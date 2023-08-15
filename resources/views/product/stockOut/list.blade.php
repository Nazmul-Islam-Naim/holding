@extends('layouts.layout')
@section('title', 'Purchase Report')
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

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title" style="margin: 0;">Purchase Amendment</h3>
            <div class="d-flex align-items-center">
                <a href="{{ route('localPurchases.create') }}" class="btn btn-info btn-sm"><i class="icon-plus-circle"></i> Purchase Now</a>
                <a onclick="printReport();" href="javascript:0;" style="margin-left: 10px;"><i class="icon-print"></i></a>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="get" action="{{route('localPurchaseList') }}">
                  <div class="form-inline">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <input class="form-control" type="date" name="start_date" value="{{date('Y-m-d')}}" autocomplete="off">
                          </div>
                          <div class="field-placeholder">From </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <input class="form-control" type="date" name="end_date" value="{{date('Y-m-d')}}" autocomplete="off">
                          </div>
                          <div class="field-placeholder">To </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <select name="supplier_id" class="form-control select2">
                              <option value="">Select supplier</option>
                              @foreach($localSuppliers as $localSupplier)
                              <option value="{{$localSupplier->id}}">
                                {{$localSupplier->name}}
                              </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="field-placeholder">Supplier </div>
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
                <center><h4 style="margin: 0px"> Purchase Report</h4></center>
                @if(!empty($start_date) && !empty($end_date))
                  <center><h4 style="margin: 0px">From : {{Carbon\Carbon::parse($start_date)->format('d-m-Y')}} To : {{Carbon\Carbon::parse($end_date)->format('d-m-Y')}}</h4></center>
                @else
                  <center><h4 style="margin: 0px">Today : {{date('d-m-Y')}}</h4></center>
                @endif
                <div class="table-responsive">
                  <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                    <thead> 
                      <tr style="background: #ccc;"> 
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Date</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Project Name</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Supplier Name</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Invoice</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Note</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Price</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Action</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($localPurchases as $key => $data)
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">
                          {{$key+1}}
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{Carbon\Carbon::parse($data->date)->format('d-m-Y')}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->project->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->supplier->name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"><a href="{{route('localPurchases.show',$data->id)}}">Invo#{{$data->id}}</a></td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($data->amount, 2)}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">
                          @if(Auth::user()->role_id==1)
                          <div class="d-flex align-items-center">
                            <a href="{{route('localPurchases.edit', $data->id)}}" class="badge bg-info badge-sm me-1"><i class="icon-edit"></i></a>
                            {{Form::open(array('route'=>['localPurchases.destroy',$data->id],'method'=>'DELETE'))}}
                              <button type="submit" confirm="Are you sure you want to delete ?" class="badge bg-danger badge-sm confirm" title="Delete" style="padding: 3px 9px;"><i class="icon-trash"></i></button>
                            {!! Form::close() !!}
                          </div>
                          @endif  
                        </td>
                      </tr>
                      @endforeach
                      @if($localPurchases->count() == 0)
                        <tr>
                          <td colspan="8" align="center">
                            <h4 style="color: #ccc">No Data Found . . .</h4>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="6" style="text-align: center;font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>Total</b></td>
                        <td colspan="2" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($localPurchases->sum('amount'), 2)}}</b></td>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="col-md-12" align="right">{{$localPurchases->render()}}</div>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer"></div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection 