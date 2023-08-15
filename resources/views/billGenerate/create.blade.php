@extends('layouts.layout')
@section('title', 'Generate Bill')
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
          {!! Form::open(array('route' =>['billGenerates.store'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Generate Bill</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- project --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('project_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="project_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($projects as $project)
                    <option value="{{$project->id}}" {{($project->id == old('project_id'))?'selected':''}}>
                      {{$project->title}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Project<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- bill type --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('bill_type_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="bill_type_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($billTypes as $billType)
                    <option value="{{$billType->id}}" {{($billType->id == old('bill_type_id'))?'selected':''}}>
                      {{$billType->title}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Bill Type<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- amount --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number"
                  name="amount" 
                  id="amount" 
                  class="@error('amount') is-invalid @enderror" 
                  value="{{old('amount')}}" 
                  autocomplete="off"
                  placeholder="1000"
                  required>
                  <div class="field-placeholder">Amount<span class="text-danger">*</span></div>
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

  $('#due').keyup(function (e) { 
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