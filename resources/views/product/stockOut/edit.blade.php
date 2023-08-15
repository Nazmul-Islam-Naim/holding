@extends('layouts.layout')
@section('title', 'Edit Purchase')
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
          {!! Form::open(array('route' =>['localPurchases.update', $localPurchase->id],'method'=>'PUT','files'=>true)) !!}
          <div class="card-header">
            <div class="card-title">Update Purchase</div>
          </div>
          
          <div class="card-body">
            <!-- Row start -->
            <div class="row gutters">
              <div class="col-md-3 form-group"> 
                <label>Project<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$localPurchase->project->title ?? ''}}" autocomplete="off" readonly>
                <input type="hidden" name="project_id" id="project_id" class="form-control" value="{{$localPurchase->project_id}}" autocomplete="off">
              </div>
              <div class="col-md-3 form-group"> 
                <label>Supplier Name<span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{$localPurchase->supplier->name ?? ''}}" autocomplete="off" readonly>
                <input type="hidden" name="local_supplier_id" class="form-control" value="{{$localPurchase->local_supplier_id}}" autocomplete="off">
              </div>
              <div class="col-md-3 form-group"> 
                <label>Purchase Date<span class="text-danger">*</span></label>
                <input type="date" name="date" class="form-control" value="{{$localPurchase->date}}" autocomplete="off"  required>
              </div>
              <div class="col-md-3 form-group"> 
                <label>Note</label> 
                <input type="text" name="note" class="form-control" value="{{$localPurchase->note}}" autocomplete="off" >
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
                          @if(!empty($localPurchase))
                              @foreach($localPurchase->purchaseDetails as $value)
                              <tr id="div_{{$row_num}}">
                                  <td>
                                      <select class="form-control allProductList select2" name="purchase_details[{{$row_num}}][product_id]" id="productId_{{$row_num}}" onchange="getProductDetails(this.value, {{$row_num}})" required="">
                                          <option value="">--Select--</option>
                                          @foreach($products as $product)
                                          <option value="{{$product->id}}" {{($product->id==$value->product_id)?'selected':''}}>{{$product->title}}</option>
                                          @endforeach
                                      </select>
                                  </td>
                                  <td>
                                      <input type="text" class="form-control individualBookStockQnty" id="stockqnty_{{$row_num}}" value="{{$value->product->stock->quantity ?? ''}}" readonly>
                                  </td>
                                  <td>
                                      <input type="text" name="purchase_details[{{$row_num}}][quantity]" class="form-control individualBookQnty" id="quantity_{{$row_num}}" onkeyup="multiply({{$row_num}});" value="{{$value->quantity}}" required="" autocomplete="off">
                                  </td>
                                  <td>
                                      <input type="text" name="purchase_details[{{$row_num}}][unit_price]" class="form-control individualBookPrice" id="rate_{{$row_num}}" onkeyup="multiply({{$row_num}});" value="{{$value->unit_price}}" required="" autocomplete="off">
                                  </td>
                                  <td>
                                      <input type="text" name="total[]" class="form-control individualBookTtlPrice" id="Total_{{$row_num}}" value="{{$value->unit_price*$value->quantity}}" readonly>
                                  </td>
                                  <td>
                                      <a href="javascript:;" class="btn btn-sm btn-danger pull-right" onclick="$('#div_{{$row_num}}').remove();subTotal()"><i class="icon-trash"></i></a>
                                  </td>
                              </tr>
                              <?php $row_num++; ?>
                              @endforeach
                          @endif
                      </tbody> 
                      <tfoot>
                        <tr> 
                          <td colspan="4" style="text-align: right"><b>Total</b></td>
                          <td>
                            <input type="text" name="sub_total" class="form-control bookSubTtlPrice" id="subTotal" value="{{$localPurchase->amount}}" readonly>
                          </td>
                          <td>
                            <a href="javascript:void(0)" class="btn btn-sm btn-info pull-right" onclick="addrow();"><i class="icon-plus-circle"></i></a>
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

<?php
  $result = "";
  foreach ($products as $value) {
    $result .= '<option value="'.$value["id"].'">'.$value["title"].'</option>';
  }
?>
{!!Html::script('backend/custom/js/jquery.min.js')!!}
<script>
    // dynamic add more field
  var Result = '<?php echo $result;?>';
  var RowNum = '<?php echo $row_num;?>'; 
  function addrow(){  
    var html = ""; 
    html += '<tr id="div_'+RowNum+'">';
    html +='<td style="width:20%">'; 
    html +='<select class="form-control allProductList select2" name="purchase_details['+RowNum+'][product_id]" onchange="getProductDetails(this.value, '+RowNum+')" required=""><option value="">--Select--</option>'+Result+'</select>';  
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
  
    
  function getProductDetails(value, RowNums) {
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: "POST",
        url: "{{route('previousStock')}}",
        data: {
          'product_id' : value,
          'project_id' : document.getElementById('project_id').value
        },
        dataType: "json",
        success:function(data) {
          $('#stockqnty_'+RowNums).val(data.quantity);
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