@extends('layouts.layout')
@section('title', 'Cheque Book')
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
        @if(!empty($chequeBook))
          {!! Form::open(array('route' =>['chequeBooks.update', $chequeBook->id],'method'=>'PUT','files'=>true)) !!}
          <?php $info ="Update";?>
        @else
        {!! Form::open(array('route' =>['chequeBooks.store'],'method'=>'POST','files'=>true)) !!}
          <?php $info ="Add";?>
        @endif
        <div class="card">
          <div class="card-header">
            <div class="card-title">{{$info}} Cheque Book</div>
          </div>
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <select 
                    class="select-single select2 js-state @error('bank_id') is-invalid @enderror" 
                    data-live-search="true" 
                    name="bank_id" 
                    required="">
                      <option value="">Select</option>
                      @foreach($banks as $bank)
                      <option value="{{$bank->id}}" {{(!empty($chequeBook) && $bank->id == $chequeBook->bank_id)?'selected':''}}>{{$bank->title}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="field-placeholder">Bank<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input 
                    class="form-control" 
                    type="text" 
                    name="title" 
                    value="{{(!empty($chequeBook->title))?$chequeBook->title:''}}" 
                    placeholder="Islamic bank"
                    required="" 
                    autocomplete="off">
                  </div>
                  <div class="field-placeholder">Title<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input 
                    class="form-control" 
                    type="text" 
                    name="book_number" 
                    value="{{(!empty($chequeBook->book_number))?$chequeBook->book_number:''}}" 
                    placeholder="102 135 256"
                    required=""
                    autocomplete="off">
                  </div>
                  <div class="field-placeholder">Book Number<span class="text-danger">*</span></div>
                </div>
                <!-- Field wrapper end -->
                <!-- Field wrapper start -->
                <div class="field-wrapper">
                  <div class="input-group">
                    <input 
                    class="form-control" 
                    type="number" 
                    name="pages" 
                    value="{{(!empty($chequeBook->pages))?$chequeBook->pages:''}}" 
                    placeholder="10"
                    required="" 
                    autocomplete="off">
                  </div>
                  <div class="field-placeholder">Pages<span class="text-danger">*</span></div>
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
            <div class="card-title">Cheque Books</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="dataTable" class="table v-middle">
                <thead>
                  <tr>
                    <th>SL</th>
                    <th>Title</th>
                    <th>Number</th>
                    <th>Bank</th>
                    <th>Pages</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($chequeBooks as $key => $chequeBook)
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$chequeBook->title}}</td>
                    <td>{{$chequeBook->book_number}}</td>
                    <td>{{$chequeBook->bank->title ?? ''}}</td>
                    <td>{{$chequeBook->pages}}</td>
                    <td>
                      <div class="actions">
                        <a href="{{ route('chequeBooks.edit', $chequeBook->id) }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                          <i class="icon-edit1 text-info"></i>
                        </a>
                        {{Form::open(array('route'=>['chequeBooks.destroy',$bank->id],'method'=>'DELETE'))}}
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