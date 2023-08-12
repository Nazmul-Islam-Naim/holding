@extends('layouts.layout')
@section('title', 'Project Shares')
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
              <h3 class="card-title">Project Shares</h3>
              <a href="{{route('projectShares.create')}}" class="btn btn-primary btn-sm"><i class="icon-plus-circle"></i> Distribute Share</a>
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
                        <th class="dt-wrap">Project Title</th> 
                        <th class="dt-wrap">Shareholder Name</th>
                        <th class="dt-wrap">Shareholder Phone</th>
                        <th class="dt-wrap">Total Share</th> 
                        <th class="dt-wrap">Total Bill</th> 
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
        url: '{{route("projectShares.index")}}',
      },
      "lengthMenu": [[ 100, 150, 250, -1 ],[ '100', '150', '250', 'All' ]],
      dom: 'Blfrtip',
        buttons: [
            'copy',
            {
                extend: 'excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6],
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
                    columns: [ 0, 1, 2, 3, 4, 5, 6],
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
          data: 'project.title',
          render:function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return ''
            }
          }
        },
        {
          data: 'share_holder.name',
          render:function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return ''
            }
          }
        },
        {
          data: 'share_holder.phone',
          render:function(data, type, row){
            if (data != '') {
              return data;
            } else {
              return ''
            }
          }
        },
        {data: 'total_share'},
        {data: 'total_amount'},
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
        var link = '{{route("projectShares.destroy",":id")}}';
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