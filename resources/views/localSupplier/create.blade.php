@extends('layouts.layout')
@section('title', 'Add Supplier')
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
          {!! Form::open(array('route' =>['localSuppliers.store'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Add Supplier</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- name --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
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
              <!------------------- email --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="email"
                  name="email" 
                  class="@error('email') is-invalid @enderror" 
                  value="{{old('email')}}" 
                  autocomplete="off"
                  placeholder="test@email.com"
                  >
                  <div class="field-placeholder">Email</div>
                </div>
              </div>
              <!------------------- Pre due --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number"
                  step="any"
                  name="pre_due" 
                  class="@error('pre_due') is-invalid @enderror" 
                  value="{{old('pre_due')}}" 
                  autocomplete="off"
                  placeholder="1000"
                  >
                  <div class="field-placeholder">Pre Due</div>
                </div>
              </div>
              <!------------------- address --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="field-wrapper">
                  <textarea 
                  name="address" 
                  id="address" 
                  rows="5"
                  class="@error('address') is-invalid @enderror" 
                  autocomplete="off"
                  placeholder="supplier address...">
                  {{ old('address') }}
                </textarea>
                  <div class="field-placeholder">Address</div>
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