@extends('layouts.layout')
@section('title', 'Supplier Ledger')
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
            <h3 class="card-title">Supplier Ledger</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">
              <div class="col-md-12" id="printReport">
                <center><h4 style="margin:0">Supplier Ledger</h4></center>
                <div class="table-responsive">
                  <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0"> 
                    <thead>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Name</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->name}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Id</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Sup#{{$localSupplier->id}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Phone</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->phone}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Email</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->email}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Address</td>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$localSupplier->address}}</td>
                      </tr>
                    </thead>
                  </table>
                  <br>
                  <table style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead> 
                      <tr style="background: #ccc;">
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Date</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Reason</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bill</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Payment</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Balance</th>
                      </tr>
                    </thead>
                    <tbody> 
                      <?php                           
                        $number = 1;
                        $numElementsPerPage = 250; // How many elements per page
                        $pageNumber = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $currentNumber = ($pageNumber - 1) * $numElementsPerPage + $number;
                        $rowCount = 0;

                        $credit = 0;
                        $debit = 0;
                        $sum = 0;
                      ?>
                      @foreach($localSupplier->ledger as $data)
                        <?php 
                          $rowCount++;
                        ?>
                      <tr>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$currentNumber++}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{Carbon\Carbon::parse($data->date)->format('d-m-Y')}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ucfirst($data->reason)}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">
                          <?php
                            $reasons = $data->reason;

                            if(preg_match("/Bill/", $reasons)) {
                              echo number_format($data->amount,2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }elseif(preg_match("/Previous due/", $reasons)) {
                              echo number_format($data->amount,2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }elseif(preg_match("/Purchase/", $reasons)) {
                              echo number_format($data->amount,2);
                              $sum = $sum+$data->amount;
                              $credit = $credit+$data->amount;
                            }
                          ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">
                          <?php
                            $reasons = $data->reason;

                            if(preg_match("/Payment/", $reasons)) {
                              echo number_format($data->amount,2);
                              $sum = $sum-$data->amount;
                              $debit = $debit+$data->amount;
                            }
                          ?>
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{number_format($sum,2)}}</td>
                      </tr>
                      @endforeach
                      @if($rowCount==0)
                        <tr>
                          <td colspan="6" align="center">
                            <h4 style="color: #ccc">No Data Found . . .</h4>
                          </td>
                        </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      
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