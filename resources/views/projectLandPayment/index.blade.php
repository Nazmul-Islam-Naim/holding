@extends('layouts.layout')
@section('title', 'Project Land Payment')
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
              <h3 class="card-title">Project Land Payment</h3>
            </div>
          <!-- /.box-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered cell-border compact hover nowrap order-column row-border stripe" id="example"> 
                    <thead> 
                      <tr class="dt-top"> 
                        <th class="dt-wrap">Sl</th>
                        <th class="dt-wrap">Title</th> 
                        <th class="dt-wrap">Location</th>
                        <th class="dt-wrap">Owner</th>
                        <th class="dt-wrap">Land</th> 
                        <th class="dt-wrap">Amount</th> 
                        <th class="dt-wrap">Payment</th> 
                        <th class="dt-wrap">Due</th> 
                        <th class="dt-wrap">Action</th> 
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

    var table = $('#example').DataTable({
      serverSide: true,
      processing: true,
      ajax: {
        url: '{{route("projectLandPayments.index")}}',
      },
      "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'All' ]],
      dom: 'Blfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7],
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
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7],
                },
                messageBottom: null
            }
        ],
      aaSorting: [[0, "asc"]],

      columns: [
        {data: 'DT_RowIndex'},
        {
          data: 'title',
        },
        {data: 'location'},
        {data: 'land_owner'},
        {data: 'land_amount'},
        {data: 'land_cost'},
        {
          data: 'land_cost',
          render:function(data, type, row){
            var payment = row.project_land_payment.reduce(function (acc, payment) {
              return acc + parseFloat(payment.amount);
            }, 0);
            
            return payment.toFixed(2);
          }
        },
        {
          data: 'land_cost',
          render:function(data, type, row){
            var due = row.project_land_payment.reduce(function (acc, payment) {
              return acc + parseFloat(payment.amount);
            }, 0);
            
            return (data - due).toFixed(2);
          }
        },
        {data: 'action'},
      ]
    });

});
</script>
@endsection 