@extends('layouts.layout')
@section('title', 'Vouchers')
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
        <div class="card card-primary">
          <div class="card-header d-flex justify-content-between align-items-center">
              <h3 class="card-title">Vouchers</h3>
              <a href="{{route('vouchers.create')}}" class="btn btn-primary btn-sm"><i class="icon-plus-circle"></i> Create Voucher</a>
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
                        <th class="dt-wrap">Date</th> 
                        <th class="dt-wrap">Code</th>
                        <th class="dt-wrap">Voucher Type</th>
                        <th class="dt-wrap">Type</th> 
                        <th class="dt-wrap">Sub Type</th> 
                        <th class="dt-wrap">Bearer</th> 
                        <th class="dt-wrap">Amount</th> 
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

  function dateFormat(data) { 
    let date, month, year;
    date = data.getDate();
    month = data.getMonth() + 1;
    year = data.getFullYear();

    date = date
        .toString()
        .padStart(2, '0');

    month = month
        .toString()
        .padStart(2, '0');

    return `${date}-${month}-${year}`;
  }

	$(document).ready(function() {
	  'use strict';

    var table = $('#example').DataTable({
      serverSide: true,
      processing: true,
      ajax: {
        url: '{{route("vouchers.index")}}',
      },
      "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'All' ]],
      dom: 'Blfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8],
                    format: {
                      body: function (data, row, column, node) {
                        if (column) {
                            return data.replace(/\n/ig, "<br/>");
                        }
                        // return column === 7 ? data.replace(/\n/ig, "<br/>") : data;
                      }
                    }
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
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7,8],
                    format: {
                      body: function (data, row, column, node) {
                        if (column) {
                            return data.replace(/\n/ig, "<br/>");
                        }
                        // return column === 7 ? data.replace(/\n/ig, "<br/>") : data;
                      }
                    }
                },
                messageBottom: null
            }
        ],
      aaSorting: [[0, "asc"]],

      columns: [
        {data: 'DT_RowIndex'},
        {
          data: 'date',
          render: function(data, type, row) {
            if (data != null) {
              return dateFormat(new Date(data)).toString();
            }
          }
        },
        {
          data: 'code',
        },
        {
          data: 'voucher_type',
          render:function(data, type, row){
            if(data == 'Receive'){
              return '<span class="badge badge-sm bg-warning">' + data + '</span>';
            }else{
              return '<span class="badge badge-sm bg-danger">' + data + '</span>';
            }
          }
        },
        {
          data: 'type.title',
          render:function(data, type, row){
            if(data != null){
              return data;
            }else{
              return '';
            }
          }
        },
        {
          data: 'sub_type.title',
          render:function(data, type, row){
            if(data != null){
              return data;
            }else{
              return '';
            }
          }
        },
        {data: 'bearer'},
        {data: 'amount'},
        {data: 'due'},
        {data: 'action'},
      ]
    });

    //-------- Delete single data with Ajax --------------//
    $("#example").on("click", ".button-delete", function(e) {
			  e.preventDefault();

        var confirm = window.confirm('Are you sure want to delete data?');
        if (confirm != true) {
          return false;
        }
        var id = $(this).data('id');
        var link = '{{route("vouchers.destroy",":id")}}';
        var link = link.replace(':id', id);
        var token = '{{csrf_token()}}';
        $.ajax({
          url: link,
          type: 'POST',
          data: {
            '_method': 'DELETE',
            '_token': token
          },
          success: function(data) {
            table.ajax.reload();
          },

        });
    });

});
</script>
@endsection 