@extends('layouts.layout')
@section('title', 'Share Distributions')
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
          {!! Form::open(array('route' =>['projectShares.update', $projectShare->id],'method'=>'PUT','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Update Share Informaitons</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- projects --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <span>
                  Project Title: {{$projectShare->project->title ?? ''}} || 
                  Total Share: {{$projectShare->project->total_share ?? ''}} ||
                  Distributed Share: {{$projectShare->project->shares->sum('total_share') ?? ''}}
                </span>
              </div>
              <!------------------- shareholder --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('share_holder_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="share_holder_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($shareHolders as $shareHolder)
                    <option value="{{$shareHolder->id}}" {{($shareHolder->id == $projectShare->share_holder_id)?'selected':''}}>
                      {{$shareHolder->name}} => {{$shareHolder->phone}}
                    </option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Shareholder<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- total share --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number"
                  name="total_share" 
                  id="total_share" 
                  class="@error('total_share') is-invalid @enderror" 
                  value="{{$projectShare->total_share ?? old('total_share')}}" 
                  autocomplete="off"
                  placeholder="2"
                  required>
                  <div class="field-placeholder">Total Share<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- date --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="date" 
                  name="date" 
                  class="@error('date') is-invalid @enderror" 
                  value="{{$projectShare->date??date('Y-m-d')}}" 
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

  $('#total_share').keyup(function (e) { 
    var totalShare = parseFloat($('#total_share').val());
    var shareAmount = parseFloat($('#share_amount').val());
    if (isNaN(totalShare)) {
      totalShare = 0;
    }
    if (isNaN(shareAmount)) {
      shareAmount = 0;
    }
    $('#total_amount').val(totalShare * shareAmount);
  });

  $('#share_amount').keyup(function (e) { 
    var totalShare = parseFloat($('#total_share').val());
    var shareAmount = parseFloat($('#share_amount').val());
    if (isNaN(totalShare)) {
      totalShare = 0;
    }
    if (isNaN(shareAmount)) {
      shareAmount = 0;
    }
    $('#total_amount').val(totalShare * shareAmount);
  });

});
</script>
@endsection