@extends('layouts.layout')
@section('title', 'Transactions')
@section('content')
@php
use App\Enum\TransactionType;
$credit = 0;
$debit = 0;
$sum = 0;
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
            <h3 class="card-title">Transactions</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="get" action="{{ route('transactions') }}">
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
                <center><h5 style="margin: 0px">Transactions</h5></center>
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
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Reason</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bank</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bank Account</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Receive</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Payment</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Balance</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($transactions as $key => $data)
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ Carbon\Carbon::parse($data->opening_date)->format('d-m-Y') }}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bankAccount->bank->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bankAccount->account_name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          @php
                              if ($data->transaction_type == TransactionType::getFromName('Opening')->value ||
                                  $data->transaction_type == TransactionType::getFromName('Deposit')->value ||
                                  $data->transaction_type == TransactionType::getFromName('Receive')->value) {
                                  echo number_format($data->amount, 2);
                                  $sum = $sum + $data->amount;
                                  $credit = $credit + $data->amount;
                              }
                          @endphp
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          @php
                          if($data->transaction_type == TransactionType::getFromName('Withdraw')->value ||
                            $data->transaction_type == TransactionType::getFromName('Payment')->value) {
                            echo number_format($data->amount, 2);
                            $sum = $sum-$data->amount;
                            $debit = $debit+$data->amount;
                          }
                          @endphp
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> {{number_format($sum, 2)}}</td>
                      </tr>
                      @endforeach
                      @if($transactions->count()==0)
                      <tr>
                        <td colspan="8" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="5" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($credit, 2);?></b></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($debit, 2);?></b></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($sum, 2);?></b></td>
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
              {{$transactions->appends(Request::except('page'))->links()}}
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