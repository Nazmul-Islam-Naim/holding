@extends('layouts.layout')
@section('title', 'Project Ledger')
@section('content')
@php
use App\Enum\TransactionType;
$bill = 0;
$collection = 0;
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
            <h3 class="card-title">Project Ledger</h3>
                
            <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
          </div>
          <!-- /.box-header -->
          
          <div class="card-body">
            <div class="row">

              <div class="col-md-12" id="printReport">
                <center><h5 style="margin: 0px">Project Information</h5></center>
                <div class="table-responsive">
                  <table class="" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead> 
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Project Title</td>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$project->title}}</td>
  
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Location</td>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$project->location}}</td>
                      </tr>
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Toatl Share</td>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$project->total_share}}</td>
  
                        <td style="border: 1px solid #ddd; padding: 3px 3px">Description</td>
                        <td colspan="3" style="border: 1px solid #ddd; padding: 3px 3px">{{$project->description}}</td>
                      </tr>
                    </thead>
                  </table>
                </div>
                <center><h5 style="margin: 0px">Project Ledger</h5></center>
                  <table class="reportTable" style="width: 100%; font-size: 12px;" cellspacing="0" cellpadding="0">
                    <thead> 
                      <tr style="background: #ccc; color: #000"> 
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Sl</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Date</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Shareholder Name</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Shareholder Phone</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bank Account</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bill Type</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Bill</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Collection</th>
                        <th style="border: 1px solid #ddd; padding: 3px 3px">Balance</th>
                      </tr>
                    </thead>
                    <tbody> 
                      @foreach($transactions as $key => $data)
                      <tr> 
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$key+1}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{ Carbon\Carbon::parse($data->transaction_date)->format('d-m-Y') }}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->shareHolder->name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->shareHolder->phone ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->bankAccount->account_name ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px">{{$data->billType->title ?? ''}}</td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          @php
                          if($data->transaction_type == TransactionType::getFromName('Bill')->value) {
                            echo number_format($data->amount, 2);
                            $sum = $sum + $data->amount;
                            $bill = $bill+$data->amount;
                          }
                          @endphp
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> 
                          @php
                              if ($data->transaction_type == TransactionType::getFromName('Receive')->value) {
                                  echo number_format($data->amount, 2);
                                  $sum = $sum - $data->amount;
                                  $collection = $collection + $data->amount;
                              }
                          @endphp
                        </td>
                        <td style="border: 1px solid #ddd; padding: 3px 3px"> {{number_format($sum, 2)}}</td>
                      </tr>
                      @endforeach
                      @if($transactions->count()==0)
                      <tr>
                        <td colspan="9" align="center">
                          <h4 style="color: #ccc">No Data Found . . .</h4>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot> 
                      <tr> 
                        <td colspan="6" style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><center><b>Total</b></center></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($bill, 2);?></b></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($collection, 2);?></b></td>
                        <td style="font-weight: bold; border: 1px solid #ddd; padding: 3px 3px"><b><?php echo number_format($sum, 2);?></b></td>
                      </tr>
                    </tfoot>
                  </table>
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