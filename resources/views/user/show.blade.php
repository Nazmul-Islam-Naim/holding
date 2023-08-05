@extends('layouts.layout')
@section('title', 'প্রোফাইল')
@section('content')
<!-- Content Header (Page header) -->
@php
    use App\Enum\SexEnum;
    use App\Enum\MaritialStatusEnum;
    use Rakibhstu\Banglanumber\NumberToBangla;
    $numTo = new NumberToBangla();
@endphp
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
  
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
          
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">প্রোফাইল</div>
                    <div class="graph-day-selection" role="group">
                      <a onclick="printReport();" href="javascript:0;"><i class="icon-print"></i></a>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12" id="printReport">
                        <div class="table-responsive">
                          <table class="table table-bordered " style="width: 100%; font-size: 14px;" cellspacing="0" cellpadding="0">
                            <tbody>  
                              <tr>
                                <td colspan="4" style=" text-align:center">
                                  <h3>ইসলামিক ফাউন্ডেশন</h3>
                                  <p><small>[প্রতিষ্ঠাতাঃ জাতির পিতা বঙ্গবন্ধু শেখ মুজিবুর রহমান]</small></p>
                                  <p><u>আগারগাঁও, শেরে বাংলানগর, ঢাকা-১২০৭</u></p>
                                </td>
                                <td colspan="4" style="text-align:center">
                                  @if (!empty($user->avatar))
                                  <img class="profile-user-img img-responsive img-circle" src="{{asset('storage/'.$user->avatar)}}" width="150" height="150" alt="User profile picture">
                                  @else
                                  <img class="profile-user-img img-responsive img-circle" src="{{asset('custom/img/noImage.png')}}" width="150" height="150" alt="User profile picture">
                                  @endif
                                </td>
                              </tr>
                              <tr>
                                <td colspan="8" style="text-align: center">ক. সাধারন তথ্যাদি</td>
                              </tr>
                              <tr>
                                <td colspan="4" style="border: 1px solid #ddd; padding: 3px 3px;margin-left:0px; white-space: unset; text-align:justify; ">নামঃ {{$user->name}} </td>
                                <td colspan="4" style="border: 1px solid #ddd; padding: 3px 3px;margin-left:0px; white-space: unset; text-align:justify; ">পদবীঃ {{$user->designation->title ?? ''}}</td>
                              </tr>
                              <tr>
                                <td colspan="4" style="border: 1px solid #ddd; padding: 3px 3px;margin-left:0px; white-space: unset; text-align:justify; ">মোবাইলঃ {{$user->phone}}</td>
                                <td colspan="4" style="border: 1px solid #ddd; padding: 3px 3px;margin-left:0px; white-space: unset; text-align:justify; ">ফ্যাক্সঃ {{$user->fax}}</td>
                              </tr>
                              <tr>
                                <td colspan="8" style="border: 1px solid #ddd; padding: 3px 3px;margin-left:0px; white-space: unset; text-align:justify; ">ইমেইলঃ {{$user->email}}</td>
                              </tr>
                              <tr style="border:none; text-align: center; height:50px">
                                <td colspan="8" style="border:none; text-align: center;">খ. বিস্তারিত তথ্যাদি</td>
                              </tr>
                              <tr>
                                <td colspan="8" style="border: 1px solid #ddd; padding: 3px 3px;margin-left:0px; white-space: unset; text-align:justify; ">{!! $user->details !!}</td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.row -->
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
@endsection 