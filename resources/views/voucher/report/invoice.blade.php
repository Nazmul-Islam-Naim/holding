@extends('layouts.layout')
@section('title', 'Payment Report')
@section('content')


<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

    <!-- Content wrapper start -->
    <div class="content-wrapper">

        <!-- Row start -->
        <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <!-- Card start -->
                <div class="card">
                    <div class="card-header-lg">
                        <h4>View Invoice</h4>
                        <div class="text-end">
                          <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
                        </div>
                    </div>
                    <div class="card-body" >


                            <!-- Row start -->
                            <div class="row gutters">
                              <div class="col-12">

                                  <div class="table-responsive" id="printReport">
                                      <table class="table table-bordered" style="width: 100%" cellpadding="0px" cellspacing="0px">
                                          <tbody>
                                            <tr style="margin-bottom: 5px">
                                                <td colspan="2" style="text-align:center">
                                                  <img src="{{asset('backend/custom/images/logo.png')}}" width="80px" alt="">
                                                  <div>
                                                    <strong>Jamana Holdings Ltd.</strong> <br>
                                                    Mob: +8801714-090 338 <br>
                                                    Tel: +88 0222 666 3757 <br>
                                                    Address: 1145/2, Darul Intejar, 2 <sup>nd</sup> Floor Malibagh, Chowdhury Para,<br>
                                                     Dhaka-1219.
                                                  </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left">
                                                  Code: {{$voucher->code}}<br>
                                                  Bearer: {{ucfirst($voucher->bearer ?? '.........')}}<br>
                                                  Note: {{ucfirst($voucher->note ?? '.........')}}<br>
                                                </td>
                                                <td style="text-align:right">Date: {{Carbon\Carbon::parse($voucher->date)->format('d F Y')}}</td>
                                            </tr>
                                            <tr>
                                                <td style="border: 1px solid #ddd; text-align:center">Details</td>
                                                <td style="border: 1px solid #ddd; text-align:center">Amount</td>
                                            </tr>
                                            <tr style="height: 60px">
                                                <td style="border: 1px solid #ddd; text-align:justify">
                                                  <div>
                                                    Purpose: {{ucfirst($voucher->type->title ?? '')}}/{{ucfirst($voucher->subType->title ?? '')}}
                                                  </div>
                                                </td>
                                                <td style="border: 1px solid #ddd; text-align:center">{{number_format($voucher->amount,2)}}</td>
                                            </tr>
                                            <tr style="height: 60px">
                                                <td colspan="2"></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center; text-decoration:overline">Authorized By</td>
                                                <td style="text-align:center; text-decoration:overline">Received By</td>
                                            </tr>
                                          </tbody>
                                      </table>
                                  </div>

                              </div>
                          </div>
                          <!-- Row end -->

                    </div>
                </div>
                <!-- Card end -->

            </div>
        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->
</div>
@endsection
