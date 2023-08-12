@extends('layouts.layout')
@section('title', 'Add Shareholder')
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
          {!! Form::open(array('route' =>['shareHolders.store'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Add Shareholder</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- name --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="name" 
                  class="@error('name') is-invalid @enderror" 
                  value="{{old('name')}}" 
                  autocomplete="off"
                  placeholder="shareholder name"
                  required>
                  <div class="field-placeholder">Name <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- phone --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text"
                  name="phone" 
                  class="@error('phone') is-invalid @enderror" 
                  value="{{old('phone')}}" 
                  autocomplete="off"
                  placeholder="123456789"
                  required>
                  <div class="field-placeholder">Phone<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- mail --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="email"
                  name="mail" 
                  class="@error('mail') is-invalid @enderror" 
                  value="{{old('mail')}}" 
                  autocomplete="off"
                  placeholder="test@mail.com"
                  >
                  <div class="field-placeholder">Mail</div>
                </div>
              </div>
              <!------------------- details --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="field-wrapper">
                  <textarea 
                  name="details" 
                  id="details" 
                  rows="5"
                  class="@error('details') is-invalid @enderror" 
                  autocomplete="off"
                  placeholder="shareholder details...">
                  {{ old('details') }}
                </textarea>
                  <div class="field-placeholder">Detials</div>
                </div>
              </div>
              <!------------------- avatarr --------------------------->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="file" 
                  name="avatar" 
                  class="@error('avatar') is-invalid @enderror" 
                  value="{{old('avatar')}}" 
                  >
                  <div class="field-placeholder">Avatar</div>
                </div>
              </div>
              <!------------------- nid --------------------------->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="file" 
                  name="nid" 
                  class="@error('nid') is-invalid @enderror" 
                  value="{{old('nid')}}" 
                  >
                  <div class="field-placeholder">NID</div>
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