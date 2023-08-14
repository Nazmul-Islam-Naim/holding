@extends('layouts.layout')
@section('title', 'Project Stocks')
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

      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Project Stocks</h3>
            </div>
          <!-- /.box-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12 mb-2">
                <h5>
                  Project Title: {{$project->title}} ||
                  Project Location: {{$project->location}} ||
                  Project Share: {{$project->total_share}}
                  <input type="hidden" name="projectId" id="projectId" value="{{$project->id}}">
                </h5>
              </div>
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered cell-border compact hover nowrap order-column row-border stripe" id="example"> 
                    <thead> 
                      <tr class="dt-top"> 
                        <th class="dt-wrap">Sl</th>
                        <th class="dt-wrap">Product Title</th> 
                        <th class="dt-wrap">Category</th>
                        <th class="dt-wrap">Unit</th>
                        <th class="dt-wrap">Brand</th> 
                        <th class="dt-wrap">Quantity</th>  
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
          <div class="card-footer"></div>
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
{!!Html::script('custom/yajraTableJs/jquery.js')!!}
{!!Html::script('custom/yajraTableJs/yajraDateTime.js')!!}
{!!Html::script('custom/yajraTableJs/newAjax.moment.js')!!}
{!!Html::script('custom/yajraTableJs/dataTable.js')!!}
{!!Html::script('custom/yajraTableJs/query.dataTables1.12.1.js')!!}
<script>

	$(document).ready(function() {
	  'use strict';
    var projectId = $('#projectId').val();
    
    var url = '{{route("stocks.project.products",":id")}}'; 
    url = url.replace(':id', projectId);
    var table = $('#example').DataTable({
      serverSide: true,
      processing: true,
      ajax: {
        url: url,
        data: { 'project_id': projectId}
      },
      "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'All' ]],
      dom: 'Blfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4],
                },
                messageTop: 'The information in this table is copyright to Sirius Cybernetics Corp.'
            },
            {
                extend: 'print',
                title:"",
                messageTop: function () {
                  var top = '<center><p class ="text-center"><img src="{{asset("backend/custom/images")}}/header.png" height="100"/></p></center>';
                  
                  return top;
                },
                customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');

                $(win.document.body).find('table').css('font-size', 'inherit');

                $(win.document.body).find('table thead th').css('border','1px solid #ddd');  
                $(win.document.body).find('table tbody td').css('border','1px solid #ddd');   
                },
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4],
                },
                messageBottom: null
            }
        ],
      aaSorting: [[0, "asc"]],

      columns: [
        {data: 'DT_RowIndex'},
        {
          data: 'product.title',
          render: function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return '';
            }
          }
        },
        {
          data: 'product.product_category.title',
          render: function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return '';
            }
          }
        },
        {
          data: 'product.product_unit.title',
          render: function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return '';
            }
          }
        },
        {
          data: 'product.product_brand.title',
          render: function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return '';
            }
          }
        },
        {data: 'quantity'},
      ]
    });

});
</script>
@endsection 