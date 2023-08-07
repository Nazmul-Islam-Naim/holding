@extends('layouts.layout')
@section('title', 'Create Bank Account')
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
      </div>
    </div>
    <div class="row gutters">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          {!! Form::open(array('route' =>['bankAccounts.store'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Create Bank Account</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- banks --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('bank_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="bank_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($banks as $bank)
                    <option value="{{$bank->id}}" {{($bank->id == old('bank_id'))?'selected':''}}>{{$bank->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Bank<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- account type --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('account_type_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="account_type_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($accountTypes as $accountType)
                    <option value="{{$accountType->id}}" {{($accountType->id == old('account_type_id'))?'selected':''}}>{{$accountType->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Account Type<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- account name --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="account_name" 
                  class="@error('account_name') is-invalid @enderror" 
                  value="{{old('account_name')}}" 
                  autocomplete="off"
                  placeholder="binary bank"
                  required>
                  <div class="field-placeholder">Account Name <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- account number --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="account_number" 
                  class="@error('account_number') is-invalid @enderror" 
                  value="{{old('account_number')}}" 
                  autocomplete="off"
                  placeholder="789-562-569"
                  required>
                  <div class="field-placeholder">Account Number <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- routing number --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="routing_number" 
                  class="@error('routing_number') is-invalid @enderror" 
                  value="{{old('routing_number')}}" 
                  autocomplete="off"
                  placeholder="074000078">
                  <div class="field-placeholder">Routing Number</div>
                </div>
              </div>
              <!------------------- branch --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="branch" 
                  class="@error('branch') is-invalid @enderror" 
                  value="{{old('branch')}}" 
                  autocomplete="off"
                  placeholder="Uttara, Dhaka">
                  <div class="field-placeholder">Branch</div>
                </div>
              </div>
              <!------------------- balance --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number" step="any"
                  name="balance" 
                  class="@error('balance') is-invalid @enderror" 
                  value="{{old('balance')}}" 
                  autocomplete="off"
                  placeholder="255689"
                  required>
                  <div class="field-placeholder">Balance <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- opening date --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="date" 
                  name="opening_date" 
                  class="@error('opening_date') is-invalid @enderror" 
                  value="{{old('opening_date')??date('Y-m-d')}}" 
                  autocomplete="off"
                  required>
                  <div class="field-placeholder">Opening Date <span class="text-danger">*</span></div>
                </div>
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit">Save</button>
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
{!!Html::script('custom/js/jquery.min.js')!!}
<script>
$(document).ready(function() {
  $('#details').summernote();
});
</script>
@endsection