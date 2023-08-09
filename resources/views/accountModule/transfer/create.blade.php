@extends('layouts.layout')
@section('title', 'Transfer')
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
          {!! Form::open(array('route' =>['transfers.store', $bankAccount->id],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Transfer Amount</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- bank account details --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <span style="font-weight: 600">
                  Bank: {{$bankAccount->bank->title ?? ''}} || 
                  Account Name: {{$bankAccount->account_name}} || 
                  Account Number: {{$bankAccount->account_number}} || 
                  Account Type: {{$bankAccount->accountType->title ?? ''}} || 
                  Routing Number: {{$bankAccount->routing_number}} || 
                  Branch: {{$bankAccount->branch}} || 
                  Available Balance: {{$bankAccount->balance}}
                </span>
              </div>
              <!------------------- bank account --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('bank_account_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="bank_account_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($bankAccounts as $bankAccount)
                    <option value="{{$bankAccount->id}}" {{($bankAccount->id == old('bank_account_id'))?'selected':''}}>
                      {{$bankAccount->account_name}} => {{$bankAccount->account_number}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Bank Account<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- amount --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number" step="any"
                  name="amount" 
                  class="@error('amount') is-invalid @enderror" 
                  value="{{old('amount')}}" 
                  autocomplete="off"
                  placeholder="255689"
                  required>
                  <div class="field-placeholder">Amount <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- transaction date --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="date" 
                  name="transaction_date" 
                  class="@error('transaction_date') is-invalid @enderror" 
                  value="{{old('transaction_date')??date('Y-m-d')}}" 
                  autocomplete="off"
                  required>
                  <div class="field-placeholder">Transaction date<span class="text-danger">*</span></div>
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
                  placeholder="short note about deposits"
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
@endsection