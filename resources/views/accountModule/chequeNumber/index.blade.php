@extends('layouts.layout')
@section('title', 'Cheque Number')
@section('content')
@php
use App\Enum\ChequeNumberStatus;
@endphp
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
        @if(!empty($chequeNumber))
          {!! Form::open(array('route' =>['chequeNumbers.update', $chequeNumber->id],'method'=>'PUT','files'=>true)) !!}
          <?php $info ="Update";?>
        @else
        {!! Form::open(array('route' =>['chequeNumbers.store'],'method'=>'POST','files'=>true)) !!}
          <?php $info ="Add";?>
        @endif
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{$info}} Cheque Number</div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select 
                    class="select-single select2 js-state @error('cheque_book_id') is-invalid @enderror" 
                    data-live-search="true" 
                    name="cheque_book_id" 
                    required="">
                      <option value="">Select</option>
                      @foreach($chequeBooks as $chequeBook)
                      <option value="{{$chequeBook->id}}" {{(!empty($chequeNumber) && $chequeBook->id == $chequeNumber->cheque_book_id)?'selected':''}}>
                        {{$chequeBook->title}} =>
                        {{$chequeBook->book_number}}
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">Cheque Book<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input 
                    class="form-control" 
                    type="text" 
                    name="cheque_number" 
                    value="{{(!empty($chequeNumber->cheque_number))?$chequeNumber->cheque_number:''}}" 
                    placeholder="102 135 256"
                    required=""
                    autocomplete="off">
                  </div>
                  <div class="field-placeholder">Cheque Number<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
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
            <div class="card-title">Cheque Numbers</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="dataTable" class="table v-middle">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Book Title</th>
                    <th>Book Number</th>
                    <th>Cheque Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($chequeNumbers as $key => $chequeNumber)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$chequeNumber->chequeBook->title ?? ''}}</td>
                    <td>{{$chequeNumber->chequeBook->book_number ?? ''}}</td>
                    <td>{{$chequeNumber->cheque_number}}</td>
                    <td>
                      @if ($chequeNumber->status == ChequeNumberStatus::getFromName('Used')->value)
                      <span class="badge badge-sm bg-{{ChequeNumberStatus::Used->color()}}">{{ChequeNumberStatus::Used->toString()}}</span>
                      @else
                      <span class="badge badge-sm bg-{{ChequeNumberStatus::Unused->color()}}">{{ChequeNumberStatus::Unused->toString()}}</span>
                      @endif
                    </td>
                    <td>
                      <div class="actions">
                        <a href="{{ route('chequeNumbers.edit', $chequeNumber->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                          <i class="icon-edit1 text-info"></i>
                        </a>
                        {{Form::open(array('route'=>['chequeNumbers.destroy',$chequeNumber->id],'method'=>'DELETE'))}}
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