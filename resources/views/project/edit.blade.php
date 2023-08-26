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
              <!------------------- land owner --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="land_owner" 
                  class="@error('land_owner') is-invalid @enderror" 
                  value="{{$project->land_owner ?? old('land_owner')}}" 
                  autocomplete="off"
                  placeholder="land owner name."
                  required>
                  <div class="field-placeholder">Land Owner <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- land amount --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="land_amount" 
                  class="@error('land_amount') is-invalid @enderror" 
                  value="{{$project->land_amount ?? old('land_amount')}}" 
                  autocomplete="off"
                  placeholder="1.5 acore."
                  required>
                  <div class="field-placeholder">Land Amount <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- land cost --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="number" 
                  step="any"
                  name="land_cost" 
                  class="@error('land_cost') is-invalid @enderror" 
                  value="{{$project->land_cost ?? old('land_cost')}}" 
                  autocomplete="off"
                  placeholder="50000000"
                  required>
                  <div class="field-placeholder">Land Cost <span class="text-danger">*</span></div>
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
              <!------------------- avatar --------------------------->
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
              <!------------------- document --------------------------->
              <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="file" 
                  name="document" 
                  class="@error('document') is-invalid @enderror" 
                  value="{{old('document')}}"
                  >
                  <div class="field-placeholder">Document</div>
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