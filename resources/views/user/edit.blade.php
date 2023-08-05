@extends('layouts.layout')
@section('title', 'Edit User Information')
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
          {!! Form::open(array('route' =>['user-list.update',$user->id],'method'=>'PUT','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Update User Information</div>
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
                  value="{{$user->name}}" 
                  autocomplete="off"
                  required>
                  <div class="field-placeholder">Name <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- email --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="email" 
                  name="email" 
                  class="@error('email') is-invalid @enderror" 
                  value="{{$user->email}}" 
                  autocomplete="off"
                  required>
                  <div class="field-placeholder">Email <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- phone --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="phone" 
                  name="phone" 
                  class="@error('phone') is-invalid @enderror" 
                  value="{{$user->phone}}" 
                  autocomplete="off"
                  >
                  <div class="field-placeholder">Phone</div>
                </div>
              </div>
              <!------------------- role --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select class="select-single select2 js-state @error('role_id') is-invalid @enderror" data-live-search="true" name="role_id" required="">
                    <option value="">Select</option>
                    @foreach($roles as $role)
                    <option value="{{$role->id}}" {{($role->id == $user->role_id)?'selected':''}}>{{$role->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Role<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- password --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input type="text" name="password" class="form-controller">
                  <div class="field-placeholder">Password</div>
                </div>
              </div>
              <!------------------- confirm password --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input type="text" name="password_confirmation" class="form-controller">
                  <div class="field-placeholder">Confirm Password</div>
                </div>
              </div>
              <!------------------- avatar --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input type="file" name="avatar" value="">
                  <div class="field-placeholder">Avatar(500 x 500)px</div>
                </div>
              </div>
              <!------------------- nid --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input type="file" name="nid" value="">
                  <div class="field-placeholder">NID (600 x 500)px</div>
                </div>
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer text-end">
            <a href="{{route('user-list.index')}}" class="btn btn-secondary">Back</a>
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
{!!Html::script('custom/js/jquery.min.js')!!}
<script>
$(document).ready(function() {
  $('#details').summernote();
});
</script>
@endsection