@extends('layouts.layout')
@section('title', 'Supplier Payment Form')
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
        <div class="card">
          {!! Form::open(array('route' =>['paymentStore'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Supplier Payment Form</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- supplier details --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <span>
                  Name: {{$payableSupplier->name}} || 
                Phone: {{$payableSupplier->phone}} || 
                Emai: {{$payableSupplier->email}} ||
                Address: {{$payableSupplier->address}} ||
                Bill: {{$payableSupplier->bill}} ||
                Payment: {{$payableSupplier->payment}} ||
                Due: {{$payableSupplier->due}}
                </span>
                <input type="hidden" value="{{$payableSupplier->due}}" id="due">
                <input type="hidden" name="local_supplier_id" value="{{$payableSupplier->id}}">
                <input type="hidden" name="supplier_name" value="{{$payableSupplier->name}}">
              </div>
              <!------------------- amount --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number"
                  step="any"
                  name="amount" 
                  id="amount" 
                  class="@error('amount') is-invalid @enderror" 
                  value="{{old('amount')}}" 
                  autocomplete="off"
                  placeholder="1000"
                  >
                  <div class="field-placeholder">Amount</div>
                </div>
              </div>
              <!------------------- transaction method --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('bank_account_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="bank_account_id" 
                  id="bank_account_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($bankAccounts as $bankAccount)
                    <option value="{{$bankAccount->id}}" {{($bankAccount->id == old('bank_account_id'))?'selected':''}}>
                      {{$bankAccount->account_name}} => {{$bankAccount->account_number}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Transaction Method<span class="text-danger">*</span></div>
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
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
<script>
  $(document).ready(function () {
    $('#amount').keyup(function (e) { 
      var amount = parseFloat($(this).val());
      var due = parseFloat($('#due').val());
      if (amount > due) {
        alert('Value is greater than due amount !');
        $(this).val(0);
      }
    });
  });
</script>
@endsection