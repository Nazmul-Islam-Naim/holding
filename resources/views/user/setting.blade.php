@extends('layouts.layout')
@section('title', 'Settings')
@section('content')
<!-- Content Header (Page header) -->

<!-- Content wrapper scroll start -->
<div class="content-wrapper-scroll">

  <!-- Content wrapper start -->
  <div class="content-wrapper">
    <!-- Row start -->
    <div class="row gutters">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        @include('common.message')
      </div>
    </div>
    <div class="row gutters">
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title"> Change your password.</div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="accordion" id="settingsAccordion">
                  <div class="accordion-item">
                      <h2 class="accordion-header" id="chngPwd">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#chngPwdCollapse" aria-expanded="false" aria-controls="chngPwdCollapse">
                              Change Password
                          </button>
                      </h2>
                      <div id="chngPwdCollapse" class="accordion-collapse collapse" aria-labelledby="chngPwd" data-bs-parent="#settingsAccordion">
                          <div class="accordion-body">
                              {!! Form::open(array('route' =>['update-user-password',Auth::user()->id],'method'=>'PUT')) !!}
                              <div class="field-wrapper">
                                  <input type="password" value="" name="password" id="newPass" class="keyup">
                                  <div class="field-placeholder">New Password</div>
                              </div>
                              <div class="field-wrapper">
                                  <input type="password" value="" name="password_confirmation" id="confirmPass" class="keyup">
                                  <div class="field-placeholder">Confirm Password</div>
                                  <span id="confirmMsg"></span>
                              </div>
                              <div class="field-wrapper m-0">
                                  <button class="btn btn-primary stripes-btn">Save</button>
                              </div>
                              {!! Form::close() !!}
                          </div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
          </div>
        </div>
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection 