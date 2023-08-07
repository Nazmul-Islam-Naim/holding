@extends('layouts.layout')
@section('title', 'Bank Report')
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
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Search Area</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12">
              <form method="get" action="{{ route('bankAccounts.show', $bankAccount->id) }}" autocomplete="off">
                <div class="form-inline">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="field-wrapper">
                        <div class="input-group">
                          <input class="form-control" type="date" name="start_date" value="<?php echo date('Y-m-d');?>" autocomplete="off">
                        </div>
                        <div class="field-placeholder">From </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="field-wrapper">
                        <div class="input-group">
                          <input class="form-control" type="date" name="end_date" value="<?php echo date('Y-m-d');?>" autocomplete="off">

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
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Bank Account Report</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="col-md-12" id="printReport">
              <center><h5 style="margin: 0px">Bank Account Information</h5></center>
              <div class="table-responsive">
                <table class="" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                  <thead> 
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Bank</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->bank->title ?? ''}}</td>

                      <td style="border: 1px solid #ddd; padding: 3px 3px">Account Name</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->account_name}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Account Number</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->account_number}}</td>

                      <td style="border: 1px solid #ddd; padding: 3px 3px">Account Type</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->accountType->title ?? ''}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Routing Number</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->routing_nubmer}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Branch</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->branch}}</td>
                    </tr>
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Opening Date</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ Carbon\Carbon::parse($bankAccount->opening_date)->format('d-m-Y') }}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">Balance</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$bankAccount->balance}}</td>
                    </tr>
                  </thead>
                </table>
              </div>
              <br>
              <center><h5 style="margin: 0px">Transactions</h5></center>
              <div class="table-responsive">
                @if(!empty($start_date) && !empty($end_date))
                <center><h6 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h6></center>
                @else
                <center><h6 style="margin: 0px">Date : {{date('d-m-Y')}}</h6></center>
                @endif
                <table class="" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">  
                  <thead> 
                    <tr style="background: #ccc; color: #000"> 
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Tnx Date</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Reason</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Credit</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Debit</th>
                      <th style="border: 1px solid #ddd; padding: 3px 3px">Balance</th>
                    </tr>
                  </thead>
                  <tbody> 
                    @foreach($bankAccount->transactions as $key => $data)
                    <tr> 
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px"> {{ Carbon\Carbon::parse($data->transaction_date)->format('d-m-Y') }} </td>
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
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
                      <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($sum, 2)}}</td>
                    </tr>
                    @endforeach
                    @if($bankAccount->transactions->count()==0)
                    <tr>
                      <td colspan="6" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px; text-align:center">
                        <h4 style="color: #ccc">No Data Found . . .</h4>
                      </td>
                    </tr>
                    @endif
                    <tr> 
                      <td colspan="3" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($credit, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($debit, 2)}}</b></td>
                      <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b>{{Session::get('currency')}} {{number_format($sum, 2)}}</b></td>
                    </tr>
                  </tbody>
                  <tfoot> 
                    
                  </tfoot>
                </table>
                <div class="col-md-12" align="right">

                </div>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection 