@extends('layouts.layout')
@section('title', 'User Role')
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
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">User Role</div>
          </div>
          <div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
              <div class="card">
                @if(!empty($role))
                {!! Form::open(array('route' =>['user-role.update',$role->id],'method'=>'PUT')) !!}
                <?php $btn='Update';?>
                @else
                {!! Form::open(array('route' =>['user-role.store'],'method'=>'POST')) !!}
                <?php $btn='Add';?>
                @endif
                
                <div class="card-body">
                  <!-- Row start -->
                  <div class="row gutters">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                      <div class="field-wrapper">
                        <input type="text" name="title" value="{{isset($role)?$role->title:''}}" class="form-control">
                        <div class="field-placeholder">Role<span class="text-danger">*</span></div>
                      </div>
                    </div>
                    @foreach($modules as $module)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                      <div >
                        <div><h5>{{$module->title}}</h5></div>
                        @foreach($module->permissions as $permission)
                        <input type="checkbox" class="form-check-input"
                                                        @if(isset($role))
                                                        @foreach($role->permissions as $rPermission)
                                                        {{ $permission->id == $rPermission->id ? 'checked' : '' }}
                                                        @endforeach
                                                          @endif
                                                           id="permission-{{ $permission->id }}"
                                                           value="{{ $permission->id }}"
                                                           name="permissions[]">
                        <label class="custom-control-label" for="permission-{{ $permission->id }}">{{ $permission->title }}</label><br>
                        @endforeach
                        
                      </div>
                    </div>
                    @endforeach
                  </div>
                  <!-- Row end -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button class="btn btn-primary" type="submit">{{$btn}}</button>
                </div>
                {!! Form::close() !!}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Row end -->
  </div>
  <!-- Content wrapper end -->
</div>
<!-- Content wrapper scroll end -->
@endsection 