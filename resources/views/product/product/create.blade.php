@extends('layouts.layout')
@section('title', 'Add Product')
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
          {!! Form::open(array('route' =>['products.store'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Add Product</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <!------------------- title --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <input 
                  type="text" 
                  name="title" 
                  class="@error('title') is-invalid @enderror" 
                  value="{{old('title')}}" 
                  autocomplete="off"
                  placeholder="product title/name"
                  required>
                  <div class="field-placeholder">Title <span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- category --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('product_category_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="product_category_id" 
                  id="product_category_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($productCategories as $productCategory)
                    <option value="{{$productCategory->id}}" {{($productCategory->id == old('product_category_id'))?'selected':''}}>{{$productCategory->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Category<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- unit --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('product_unit_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="product_unit_id" 
                  id="product_unit_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($productUnits as $productUnit)
                    <option value="{{$productUnit->id}}" {{($productUnit->id == old('product_unit_id'))?'selected':''}}>{{$productUnit->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Unit<span class="text-danger">*</span></div>
                </div>
              </div>
              <!------------------- brand --------------------------->
              <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
                <div class="field-wrapper">
                  <select 
                  class="select-single select2 js-state @error('product_brand_id') is-invalid @enderror" 
                  data-live-search="true" 
                  name="product_brand_id" 
                  id="product_brand_id" 
                  required="">
                    <option value="">Select</option>
                    @foreach($productBrands as $productBrand)
                    <option value="{{$productBrand->id}}" {{($productBrand->id == old('product_brand_id'))?'selected':''}}>{{$productBrand->title}}</option>
                    @endforeach
                  </select>
                  <div class="field-placeholder">Brand<span class="text-danger">*</span></div>
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