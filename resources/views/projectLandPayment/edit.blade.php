@extends('layouts.layout')
@section('title', 'Edit Pay Bill')
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
          {!! Form::open(array('route' =>['projectLandPayments.update', $projectLandPayment->id],'method'=>'PUT','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Update Pay Bill</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- share details --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-3">
                <span>
                  Project Title: {{$projectLandPayment->project->title ?? ''}} ||
                  Project Location: {{$projectLandPayment->project->location ?? ''}} ||
                  Land Owner: {{$projectLandPayment->project->land_owner ?? ''}} ||
                  Total Land: {{$projectLandPayment->project->land_amount ?? ''}} ||
                  Total Land Cost: {{number_format($projectLandPayment->project->land_cost, 2)}} ||
                  Total Payment: {{number_format($projectLandPayment->project->projectLandPayment->sum('amount'), 2)}} ||
                  Total Due: {{number_format(($projectLandPayment->project->land_cost - $projectLandPayment->project->projectLandPayment->sum('amount')), 2)}}
                </span>
                <input type="hidden" name="due" id="due" value="{{$projectLandPayment->project->land_cost - $projectLandPayment->project->projectLandPayment->sum('amount')}}">
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
                    <option value="{{$bankAccount->id}}" {{($bankAccount->id == $projectLandPayment->bank_account_id)?'selected':''}}>
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
                  type="number" 
                  step="any"
                  name="amount" 
                  id="amount" 
                  class="@error('amount') is-invalid @enderror" 
                  value="{{$projectLandPayment->amount ?? old('amount')}}" 
                  autocomplete="off"
                  placeholder="500000"
                  required>
                  <div class="field-placeholder">Amount<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- date --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="date" 
                  name="date" 
                  class="@error('date') is-invalid @enderror" 
                  value="{{$projectLandPayment->date ?? date('Y-m-d')}}" 
                  autocomplete="off"
                  required>
                  <div class="field-placeholder">Date<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- note --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="note" 
                  class="@error('note') is-invalid @enderror" 
                  value="{{$projectLandPayment->note ?? old('note')}}" 
                  autocomplete="off"
                  placeholder="short note."
                  >
                  <div class="field-placeholder">Note</div>
                </div>
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-end">
            <button class="btn btn-primary" type="submit">Update</button>
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
    var due = parseFloat($('#due').val());
    var amount = parseFloat($('#amount').val());
    if (amount > due) {
      alert('Amount is too big !');
      $('#amount').val(0);
    }
  });

});
</script>
@endsection