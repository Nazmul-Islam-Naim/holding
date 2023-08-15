@extends('layouts.layout')
@section('title', 'Bill Type')
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
      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        @if(!empty($billType))
          {!! Form::open(array('route' =>['billTypes.update', $billType->id],'method'=>'PUT','files'=>true)) !!}
          <?php $info ="Update";?>
        @else
        {!! Form::open(array('route' =>['billTypes.store'],'method'=>'POST','files'=>true)) !!}
          <?php $info ="Add";?>
        @endif
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{$info}} Bill Type</div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input 
                    class="form-control" 
                    type="text" 
                    name="title" 
                    value="{{(!empty($billType->title))?$billType->title:''}}" 
                    placeholder="bill type"
                    required="" 
                    autocomplete="off">
                  </div>
                  <div class="field-placeholder">Title<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
              </div>
            </div>
            <!-- Row end -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <button class="btn btn-primary" type="submit">{{$info}}</button>
          </div>
        </div>
        {!! Form::close() !!}
      </div>
      
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Bill Types</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="dataTable" class="table v-middle">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($billTypes as $key => $billType)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$billType->title}}</td>
                    <td>
                      <div class="actions">
                        <a href="{{ route('billTypes.edit', $billType->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                          <i class="icon-edit1 text-info"></i>
                        </a>
                        {{Form::open(array('route'=>['billTypes.destroy',$billType->id],'method'=>'DELETE'))}}
                          <button type="submit" class="btn btn-default btn-xs confirmdelete" confirm="You want to delete this informations ?" title="Delete" style="width: 100%"><i class="icon-x-circle text-danger"></i></button>
                        {!! Form::close() !!}
                      </div>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
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