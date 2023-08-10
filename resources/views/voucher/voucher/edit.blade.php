@extends('layouts.layout')
@section('title', 'Edit Voucher')
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
          {!! Form::open(array('route' =>['vouchers.update', $voucher->id],'method'=>'PUT','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Update Voucher</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- voucher type --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('voucher_type') is-invalid @enderror" 
                  data-live-search="true" 
                  name="voucher_type" 
                  required="">
                    <option value="">Select</option>
                    @foreach($voucherTypes as $key => $voucherType)
                    <option value="{{$key}}" {{($key == $voucher->voucher_type)?'selected':''}}>{{$voucherType}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Voucher Type<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- type --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('type_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="type_id" 
                  id="type_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($types as $type)
                    <option value="{{$type->id}}" {{($type->id == $voucher->type_id)?'selected':''}}>{{$type->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Type<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- sub types --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('sub_type_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="sub_type_id" 
                  id="sub_type_id" 
                  required="">
                  <option value="">Select</option>
                  @foreach($subTypes as $subType)
                  <option value="{{$subType->id}}" {{($subType->id == $voucher->sub_type_id)?'selected':''}}>{{$subType->title}}</option>
                  @endforeach
                  </select>
                  <div class="field-placeholder">Sub Type<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- bearer --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="bearer" 
                  class="@error('bearer') is-invalid @enderror" 
                  value="{{$voucher->bearer ?? old('bearer')}}" 
                  autocomplete="off"
                  placeholder="bearer name"
                  >
                  <div class="field-placeholder">Bearer</div>
                </div>
              </div>
              <!------------------- amount --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number" step="any"
                  name="amount" 
                  class="@error('amount') is-invalid @enderror" 
                  value="{{$voucher->amount ?? old('amount')}}" 
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
                  value="{{$voucher->date ?? date('Y-m-d')}}" 
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
                  value="{{$voucher->note ?? old('note')}}" 
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
// dependancy dropdown using ajax
$(document).ready(function() {
  $('#type_id').on('change', function() {
    var chequeBookID = $(this).val();
    if(chequeBookID) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "{{route('vouchers.subType')}}",
        data: {
          'id' : chequeBookID
        },
        dataType: "json",

        success:function(data) {
          if(data){
            $('#sub_type_id').empty();
            $('#sub_type_id').focus;
            $('#sub_type_id').append('<option value="">Select</option>');
            $.each(data, function(key, value){
              $('select[name="sub_type_id"]').append('<option value="'+ value.id +'">' +  value.title+ '</option>');
            });
          }else{
            $('#sub_type_id').empty();
          }
        }
      });
    }else{
        $('#sub_type_id').empty();
    }
  });
});
</script>
@endsection