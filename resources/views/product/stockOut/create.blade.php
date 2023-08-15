@extends('layouts.layout')
@section('title', 'Stock Out')
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
          {!! Form::open(array('route' =>['stockOuts.store'],'method'=>'POST','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Stock Out</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-md-4 form-group"> 
                <label>Project<span class="text-danger">*</span></label>
                <select 
                name="project_id" 
                id="project_id" 
                class="form-control select2" required>
                  <option value="">Select One</option>
                  @foreach($projects as $project)
                  <option value="{{$project->id}}">
                    {{$project->title}}
                  </option>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Date<span class="text-danger">*</span></label>
                <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}" autocomplete="off"  required>
              </div>
              <div class="col-md-4 form-group"> 
                <label>Note</label> 
                <input type="text" name="note" class="form-control" value="" autocomplete="off" >
              </div>

              <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-body"> 
                    <div class="table-responsive"> 
                    <table class="table"> 
                      <thead> 
                        <tr>
                          <th style="text-align: center">Product <span style="color: red">*</span></th>
                          <th style="text-align: center">Stock</th>
                          <th style="text-align: center">Quantity <span style="color: red">*</span></th>
                          <th style="text-align: center">Unit Price<span style="color: red">*</span></th>
                          <th style="text-align: center">Total</th>
                          <th style="text-align: center">Action</th> 
                        </tr> 
                      </thead>
                      <?php $row_num = 1; ?>
                      <tbody class="row_container"> 
  
                      </tbody> 
                      <tfoot>
                        <tr> 
                          <td colspan="4" style="text-align: right"><b>Total</b></td>
                          <td>
                            <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="" readonly>
                          </td>
                          <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();getProducts();"><i class="icon-plus-circle"></i></a>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                    </div>
                  </div>
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
{!!Html::script('backend/custom/js/jquery.min.js')!!}
<script>
    // dynamic add more field
  var RowNum = '<?php echo $row_num;?>'; 
  function addrow(){  
    if($('#project_id').val() == ""){
        alert('At first Select project !');
        $('#project_id').click();
        return true;
    }
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td style="width:20%">'; 
    html +='<select class="form-control allProductList select2" name="purchase_details['+RowNum+'][product_id]" id="productId_'+RowNum+'" onchange="getProductDetails(this.value, '+RowNum+')" required=""><option value="">--Select--</option></select>';  
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" class="form-control individualBookStockQnty" id="stockqnty_'+RowNum+'" readonly>'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" name="purchase_details['+RowNum+'][quantity]" class="form-control individualBookQnty" id="quantity_'+RowNum+'" onkeyup="multiply('+RowNum+');" required="" autocomplete="off">'; 
    html +='</td>'; 
    html +='<td>';
    html +='<input type="text" name="purchase_details['+RowNum+'][unit_price]" class="form-control individualBookPrice" id="rate_'+RowNum+'" onkeyup="multiply('+RowNum+');" required="" autocomplete="off">'; 
    html +='</td>';
    html +='<td>';
    html +='<input type="text" name="total[]" class="form-control individualBookTtlPrice" id="Total_'+RowNum+'">'; 
    html +='</td>';
    html +='<td>'; 
    html +='<a href="javascript:;" class="btn btn-sm btn-danger pull-right" onclick="$(\'#div_'+RowNum+'\').remove();subTotal()"><i class="icon-trash"></i></a>'; 
    html +='</td>'; 
    html +='</tr>';
    $('.row_container').append(html);
    $(".select2").select2({});
    RowNum++;
  }
  
    
  function getProducts(rowNum) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "{{route('availableStockProduct')}}",
        data: {
          'project_id' : document.getElementById('project_id').value
        },
        dataType: "json",
        success:function(data) {
          console.log(data);
          $(".allProductList").empty();
          $(".allProductList").append('<option  value="">--Select--</option>');
          $.each(data, function(key, value){
              console.log(value.name);
              $(".allProductList").append('<option  value='+value.product.id+'>'+value.product.title+'</option>');
          });
        }
      });
  }

  function getProductDetails(value, RowNums) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "{{route('currentStock')}}",
        data: {
          'product_id' : value,
          'project_id' : document.getElementById('project_id').value
        },
        dataType: "json",
        success:function(data) {
          $('#stockqnty_'+RowNums).val(data.quantity);
          $('#rate_'+RowNums).val(data.unit_price);
        }
      });
  }
  
  function multiply(RowNum){
      var qnty = document.getElementById('quantity_'+RowNum).value;
      var rate = document.getElementById('rate_'+RowNum).value;
      var total = parseFloat(qnty)*parseFloat(rate);
  
      if (isNaN(total)) {
        document.getElementById('Total_'+RowNum).value = 0;
      }else{
        document.getElementById('Total_'+RowNum).value = total.toFixed(2);
      }
      subTotal();
  }

  function subTotal() {
      var arr = document.getElementsByName('total[]');
      var tot = 0;
      for (var i = 0; i < arr.length; i++) {
          if (parseInt(arr[i].value))
              tot += parseInt(arr[i].value);
      }
      document.getElementById('subTotal').value = tot.toFixed(2);
  }
</script>
@endsection