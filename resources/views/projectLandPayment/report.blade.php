@extends('layouts.layout')
@section('title', 'Land Payment Report')
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
            <h3 class="card-title">Land Payment Report</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="get" action="{{ route('projectLandPayments.report') }}">
                  <div class="form-inline">
                    <div class="row">
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <input class="form-control" type="date" name="start_date" value="" autocomplete="off">
                          </div>
                          <div class="field-placeholder">From </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <input class="form-control" type="date" name="end_date" value="" autocomplete="off">
                          </div>
                          <div class="field-placeholder">To </div>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="field-wrapper">
                          <div class="input-group">
                            <select name="project_id" class="form-control select2">
                              <option value="">Select Project</option>
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
                            <input type="submit" value="Search" class="btn btn-info btn-md">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <div class="col-md-12" id="printReport">
                <center><h5 style="margin: 0px">Land Payment Report</h5></center>
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
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Transaction Date</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Project Title</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Land Owner</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Total Land</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Transaction Method</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Note</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Amount</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($projectLandPayments as $key => $data)
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ Carbon\Carbon::parse($data->date)->format('d-m-Y') }}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->project->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->project->land_owner ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->project->land_amount ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bankAccount->account_name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->note}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> {{number_format($data->amount, 2)}}</td>
                      </tr>
                      @endforeach
                      @if($projectLandPayments->count()==0)
                      <tr>
                        <td colspan="8" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="7" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{number_format($projectLandPayments->sum('amount'), 2)}}</b></td>
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
              {{$projectLandPayments->appends(Request::except('page'))->links()}}
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