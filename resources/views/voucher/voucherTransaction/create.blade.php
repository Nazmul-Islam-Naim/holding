@extends('layouts.layout')
@section('title', 'Voucher Transaction')
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
          {!! Form::open(array('route' =>['voucherTransaction.store', $voucher->id],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Voucher Transaction</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- voucher details --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <span style="font-weight: 600">
                  Voucher Details:
                  Voucher Code: {{$voucher->code}} || 
                  Voucher Type: {{$voucher->voucher_type}} || 
                  Type: {{$voucher->type->title ?? ''}} || 
                  Sub Type: {{$voucher->subType->title ?? ''}} || 
                  Created Date: {{Carbon\Carbon::parse($voucher->date)->format('d-m-Y')}} || 
                  Note: {{$voucher->note}} || 
                  Amount: {{$voucher->amount}} || 
                  Due: {{$voucher->due}} 
                </span>
                <input type="hidden" name="due" id="due" value="{{$voucher->due}}">
              </div>
              <!------------------- transaction method --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('bank_account_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="bank_account_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($bankAccounts as $key => $bankAccount)
                    <option value="{{$bankAccount->id}}" {{($bankAccount->id == old('bank_account_id'))?'selected':''}}>
                      {{$bankAccount->account_name}} => {{$bankAccount->account_number}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Transaction Method<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- amount --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number" step="any"
                  name="amount" 
                  id="amount" 
                  class="@error('amount') is-invalid @enderror" 
                  value="{{old('amount')}}" 
                  autocomplete="off"
                  placeholder="1000"
                  required>
                  <div class="field-placeholder">Amount <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- date --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="date" 
                  name="date" 
                  class="@error('date') is-invalid @enderror" 
                  value="{{old('date')??date('Y-m-d')}}" 
                  autocomplete="off"
                  required>
                  <div class="field-placeholder">Date <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- note --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="note" 
                  class="@error('note') is-invalid @enderror" 
                  value="{{old('note')}}" 
                  autocomplete="off"
                  placeholder="short note"
                  >
                  <div class="field-placeholder">Note</div>
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
{!!Html::script('backend/custom/js/jquery.min.js')!!}
<script type="text/javascript"> 
$(document).ready(function() {
  $('#amount').keyup(function (e) { 
    var amount = parseFloat($('#amount').val()); // Corrected typo here
    var due = parseFloat($('#due').val());       // Corrected typo here
    if (amount > due) {
        alert('Amount bigger than due!');
        $('#amount').val(0);
    }
  });
});
</script>
@endsection