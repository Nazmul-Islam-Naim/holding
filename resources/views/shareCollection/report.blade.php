@extends('layouts.layout')
@section('title', 'Share Collection Report')
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
            <h3 class="card-title">Share Collection Report</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="get" action="{{ route('shareCollections.report') }}">
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
                            <input type="submit" value="Search" class="btn btn-info btn-md">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="col-md-12" id="printReport">
                <center><h5 style="margin: 0px">Share Collection Report</h5></center>
                <div class="table-responsive">
                  @if(!empty($start_date) && !empty($end_date))
                    <center><h6 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h6></center>
                  @else
                    <center><h6 style="margin: 0px">Date : {{date('d-m-Y')}}</h6></center>
                  @endif
                  <table class="reportTable" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead> 
                      <tr style="background: #ccc; color: #000"> 
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Tnx Date</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bill Type</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Project Title</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Shareholder Name</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Shareholder Phone</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Transaction Method</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Note</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Amount</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($projectShareholders as $key => $data)
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ Carbon\Carbon::parse($data->date)->format('d-m-Y') }}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->billType->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->project->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->shareHolder->name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->shareHolder->phone ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bankAccount->account_name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> {{number_format($data->amount, 2)}}</td>
                      </tr>
                      @endforeach
                      @if($projectShareholders->count()==0)
                      <tr>
                        <td colspan="9" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="8" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($projectShareholders->sum('amount'), 2)}}</b></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer" >
            <div class="col-md-12" style="display:flex; justify-content: end">
              {{$projectShareholders->appends(Request::except('page'))->links()}}
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