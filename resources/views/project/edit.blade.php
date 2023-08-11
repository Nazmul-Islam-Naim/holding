@extends('layouts.layout')
@section('title', 'Edit Project')
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
          {!! Form::open(array('route' =>['projects.update', $project->id],'method'=>'PUT','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Update Project</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- title --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="title" 
                  class="@error('title') is-invalid @enderror" 
                  value="{{$project->title ?? old('title')}}" 
                  autocomplete="off"
                  placeholder="put your project title here."
                  required>
                  <div class="field-placeholder">Title <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- share --------------------------->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number"
                  name="total_share" 
                  class="@error('total_share') is-invalid @enderror" 
                  value="{{$project->total_share ?? old('total_share')}}" 
                  autocomplete="off"
                  placeholder="50"
                  required>
                  <div class="field-placeholder">Total Share <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- location --------------------------->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="location" 
                  class="@error('location') is-invalid @enderror" 
                  value="{{$project->location ?? old('location')}}" 
                  autocomplete="off"
                  placeholder="sector-6, uttara, dhaka-1230"
                  >
                  <div class="field-placeholder">Location </div>
                </div>
              </div>
              <!------------------- description --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="field-wrapper">
                  <textarea 
                  name="description" 
                  id="description" 
                  rows="5"
                  class="@error('description') is-invalid @enderror" 
                  autocomplete="off"
                  placeholder="Enter your project description...">
                  {{$project->description ?? old('description')}}
                </textarea>
                  <div class="field-placeholder">Description</div>
                </div>
              </div>
              <!------------------- avatarr --------------------------->
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="file" 
                  name="avatar" 
                  class="@error('avatar') is-invalid @enderror" 
                  value="{{old('avatar')}}" 
                  placeholder="short note"
                  >
                  <div class="field-placeholder">Avatar</div>
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
@endsection