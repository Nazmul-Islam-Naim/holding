@extends('layouts.layout')
@section('title', 'Withdraw')
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
          {!! Form::open(array('route' =>['withdraws.store', $bankAccount->id],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Bank Account Withdraw</div>
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
              <!------------------- cheque books --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('cheque_book_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="cheque_book_id" 
                  id="cheque_book_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($chequeBooks as $chequeBook)
                    <option value="{{$chequeBook->id}}" {{($chequeBook->id == old('cheque_book_id'))?'selected':''}}>
                      {{$chequeBook->title}} => {{$chequeBook->book_number}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Cheque Book<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- cheque numbers --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('cheque_number_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="cheque_number_id" 
                  id="cheque_number_id" 
                  required="">
                  </select>
                  <div class="field-placeholder">Cheque Book<span class="text-danger">*</span></div>
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
{!!Html::script('backend/custom/js/jquery.min.js')!!}
<script type="text/javascript"> 
// dependancy dropdown using ajax
$(document).ready(function() {
  $('#cheque_book_id').on('change', function() {
    var chequeBookID = $(this).val();
    if(chequeBookID) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "{{route('withdraws.availableChequeNumbers')}}",
        data: {
          'id' : chequeBookID
        },
        dataType: "json",

        success:function(data) {
          if(data){
            $('#chequeNumber').empty();
            $('#chequeNumber').focus;
            $('#chequeNumber').append('<option value="">Select</option>');
            $.each(data, function(key, value){
              $('select[name="cheque_number_id"]').append('<option value="'+ value.id +'">' +  value.cheque_number+ '</option>');
            });
          }else{
            $('#chequeNumber').empty();
          }
        }
      });
    }else{
        $('#chequeNumber').empty();
    }
  });
});
</script>
@endsection