@extends('layouts.layout')
@section('title', 'Daily Transaction')
@section('content')
<!-- Content Header (Page header) -->
<?php
  $baseUrl = URL::to('/');
?>
<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

  <!-- Content wrapper start -->
  <div class="content-wrapper">
    <!-- Row start -->
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        @include('common.message')
        @include('common.commonFunction')
      </div>
    </div>
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">{{ __('home.Daily_Transaction_Report') }}</h3>
                
            <a onclick="printReport();" href="javascript:0;"><img class="img-thumbnail" style="width:30px;" src='{{asset("custom/img/print.png")}}'></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <form method="post" action="{{ route('transaction.filter') }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
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

              <div class="col-md-12" id="printTable">
                <center><h5 style="margin: 0px">{{ __('home.Daily_Transaction_Report') }}</h5></center>
                <div class="table-responsive">
                  @if(!empty($start_date) && !empty($end_date))
                    <center><h6 style="margin: 0px">From : {{dateFormateForView($start_date)}} To : {{dateFormateForView($end_date)}}</h6></center>
                  @else
                    <center><h6 style="margin: 0px">Date : {{date('d-m-Y')}}</h6></center>
                  @endif
                  <table class="reportTable" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead> 
                      <tr style="background: #ccc; color: #000"> 
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.SL') }}</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.date') }}</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.reason') }}</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.transaction_Method') }}</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.Receive') }}</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.Payment') }}</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">{{ __('home.Balance') }}</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php                           
                        $number = 1;
                        $numElementsPerPage = 250; // How many elements per page
                        $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                        $rowCount = 0;

                        $sum = 0;
                        $debit = 0;
                        $credit = 0;
                      ?>
                      @foreach($alldata as $data)
                        <?php $rowCount++; ?>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          <?php echo dateFormateForView($data->transaction_date); ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->transactionreport_bank_object->bank_name}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          <?php
                            $reasons = $data->reason;

                            if(preg_match("/Opening Balance/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }elseif (preg_match("/deposit/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }elseif (preg_match("/receive/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }elseif (preg_match("/bill collection/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }
                          ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          <?php
                            if(preg_match("/withdraw/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum-$data->amount;
                              $debit = $debit+$data->amount;
                            }elseif (preg_match("/transfer/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum-$data->amount;
                              $debit = $debit+$data->amount;
                            }elseif (preg_match("/payment/", $reasons)) {
                              echo number_format($data->amount, 2);
                              $sum = $sum-$data->amount;
                              $debit = $debit+$data->amount;
                            }
                          ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          {{number_format($sum, 2)}}
                        </td>
                      </tr>
                      @endforeach
                      @if($rowCount==0)
                      <tr>
                        <td colspan="7" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="4" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>{{ __('home.total') }}</b></center></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($credit, 2);?></b></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($debit, 2);?></b></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($sum, 2);?></b></td>
                      </tr>
                    </tfoot>
                  </table>
                  <div class="col-md-12" align="right">

                  </div>
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