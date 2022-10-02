@extends('cms.master')
@section('body_content')
@php( $total_gross = 0 )
<!-- Page Content -->
<style>
    .text-small {
        font-size: 10px;
        font-weight: bold;
        color: #E56767;
    }
</style>
<div class="content">
    <div class="block block-rounded">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                <p><b>Produt Return To Supplier ----> Supplier Info</b>, <span class="text-warning">যে যে প্রোডাক্ট রিটার্ন
                    করব সাপ্লায়ার এর কাছে সেগুলো রেখে বাকি গুলো ডিলিট করে দিতে হবে।</span> <span class="badge badge-danger">{{$how_many_time_returns+1}} Times Return Running</span></p>
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">{{$supplier_info->name}}</button>
            </div>
            </div>
            <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Supplier Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 class=""><b class="text-bold text-primary">Name: </b>{{$supplier_info->name}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Company Name: </b>{{$supplier_info->company_name}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Phone: </b>{{$supplier_info->phone}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Email: </b>{{optional($supplier_info)->email}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Code: </b>{{$supplier_info->code}}</h6>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <form action="{{route('supplier.invoice.return.confirm')}}" method="post" id="form_1">
                        @csrf
                        <table id="mainTable" class="table">
                            <thead>
                                <tr style="background-color:#1769aa;color:#fff;">
                                    <th style="padding: 10px 7px;">Return Place</th>
                                    <th style="padding: 10px 7px;">Product Name</th>
                                    <th style=" width: 23%;padding: 10px 7px;">Quantity</th>
                                    <th style="padding: 10px 7px;">Price</th>
                                    <th style="padding: 10px 7px;">Total Price</th>
                                    <th style="padding: 10px 7px;">Action</th>
                                </tr>
                            </thead>
                            <!--<tbody id = "demo" class="demo"></tbody>-->
                            <tbody>
                                @foreach($supplier_invoice->invoice_products as $product)
                                    @php($previous_returned = DB::table('supplier_return_products')->where('product_id', $product->product_info->id)->where('supp_invoice_id', $supplier_invoice->supp_invoice_id)->sum('quantity'))
                                    @php($rest_quantity = $product->quantity-$previous_returned)
                                    
                                @if($rest_quantity > 0)
                                <tr style="background-color:#F2F2F2;color: #000;">
                                    <td class="bg-danger" id="product_{{$product->product_id}}"><button type="button" data-toggle="modal" data-target="#supplier_product_return_place" onclick="set_place('{{$product->product_id}}')" class="btn btn-light btn-sm">set place</button></td>
                                    <td>
                                        <input type="hidden" name="pid[]" value="{{$product->product_id}}">{{$product->product_info->p_name}}<input type="hidden" class="return_place_confirm form-control form-control-sm" name="return_place[]" id="return_place_{{$product->product_id}}" required value="">
                                    </td>
                                    <td><p class="text-small">Returnable Qty: <span id="inv_rest_qty_{{$product->product_id}}">{{$rest_quantity}}</span><br><span id="max_returnable_qty_{{$product->product_id}}"></span></p><input style="width:117px;" type="number" value="{{$rest_quantity}}" id="quantity_{{$product->product_id}}" name="quantity[]" max="{{$rest_quantity}}" class="quantity" step=any> <b>{{$product->product_info->unit_type_name->unit_name}}</b><br><span style="font-size: 10px; color: red;">@if($previous_returned != 0) {{$previous_returned}} {{$product->product_info->unit_type_name->unit_name}} returnded @endif</span></td>
                                    <td><input style="width: 111px;" type="number" value="{{$product->price}}" id="price" name="price[]" class="pricesum" step=any></td>
                                    <td><input style="width: 158px;" type="text" value="{{$product->price*$rest_quantity}}" id="total" name="total[]" class="total" readonly></td>
                                    <td><button type="button" id="remove" name="remove" onclick="deleteRow(this)" class="btn btn-danger btn-sm btnSelect"><span class="glyphicon glyphicon-minus"></span><i class="fas fa-trash-alt"></i></button></td>
                                </tr>
                                @php($total_gross = $total_gross+($product->price*$rest_quantity))
                                @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total Gross</th>
                                    <th></th>
                                    <th>
                                        <input type="text" id="sums" name="total_gross" value="{{$total_gross}}" class="form-control" readonly></input>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="supplier_product_return_place" tabindex="-1" role="dialog" aria-labelledby="supplier_product_return_place" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-dark text-light">
                                <h5 class="modal-title text-light" id="exampleModalLabel">Select Place To Return</h5>
                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body" id="select_return_place_body">
                                
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <hr>
                            </div>
                            <br>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="exampleInputEmail1">Supplier Current
                                                    Balance</label>
                                                <input type="text"
                                                    name="supplier_balance"
                                                    class="form-control"
                                                    id="currentDueByCash_when_due_Minus"
                                                    value="{{$supplier_info->balance+0}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="exampleInputEmail1">Total Get From
                                                    Invoice</label>
                                                <input type="text"
                                                    name="TotalGetFromReturnByCash_when_due_Minus"
                                                    class="form-control"
                                                    id="TotalGetFromReturnByCash_when_due_Minus"
                                                    value="{{$total_gross}}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="exampleInputEmail1">Supplier Balance -
                                                    Invoice Current Total</label>
                                                <input type="text" name="totalGetByCash_for_currentDue_minus" class="form-control" id="totalGetByCash_for_currentDue_minus" value="{{$supplier_info->balance-$total_gross}}"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Note</label>
                            <textarea id="" class="form-control" name="note" rows="3" cols="50"
                                required></textarea>
                        </div>
                        <!--sms send end-->
                        <input type="hidden" name="supplier_id" id="date" class="form-control"
                            value="{{$supplier_info->id}}" required>
                            <input type="hidden" name="supplier_invoice_id" value="{{$supplier_invoice->supp_invoice_id}}" id="">

                        <!--<input type="submit" name="ReturnAndRefund" id="insert" value="Confirm" class="btn btn-success form-control" required>-->

                        <div class="text-right" id="submit_button" style= "display: none;"><a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-rounded btn-success">Submit</a></div>
                        

                        <!--Modal -->
                        <div class="modal fade" id="exampleModalForSell" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="text-danger" style="text-align:center;">
                                            <i class="fas fa-exclamation-triangle"
                                                style="font-size: 60px;"></i>
                                        </div>
                                        <div>
                                            <h2 class="text-center font-bold">Are You Sure?</h2>
                                        </div>
                                        <div>
                                            <p class="text-center">You will not be able to recover this
                                                content!</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 text-center">
                                                <input type="submit" name="ReturnToSupplier" class="btn btn-rounded btn-success" value="Confirm" onclick="form_submit(1)" id="submit_button_1">
                                                <button type="button" disabled class="btn btn-rounded btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                            </div>
                                            <div class="col-md-6 text-center"><button
                                                    class="btn btn-rounded btn-danger"
                                                    data-dismiss="modal">Cancel</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>





        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
// quantity keyup start
$(".quantity").on("click change paste keyup cut select", function() 
{
	calculateSum();
	multiply();
});
// quantity keyup end

// price keyup start
$(".pricesum").on("click change paste keyup cut select", function() {
	calculateSum();
	multiply();
});
// price keyup end

// total sum start
function calculateSum() {
        var sum = 0;
        
		//iterate through each textboxes and add the values
		$(".total").each(function() {

			//add only if the value is number
			if(!isNaN(this.value) && this.value.length!=0) {
				sum += parseFloat(this.value);
			}

		});
      // document.getElementsByClassName('sum')[0].innerText = sum
        document.getElementById("sums").value = sum;
		$("#sums").val(sum.toFixed(2));
	
        $("#TotalGetFromReturnByCash_when_due_Minus").val(sum.toFixed(2));
        var currentDue = $("#currentDueByCash_when_due_Minus").val();
        var nowPayable = parseFloat(currentDue) - parseFloat(sum);
        $("#totalGetByCash_for_currentDue_minus").val(nowPayable.toFixed(2));
        
		  
}
// total sum end


//multiply function start
function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".pricesum");
    
    // Declare i and qty for "for" loop
    var i, qty = quantity.length;
    // Use "for" loop to iterate through NodeList
    for (i = 0; i < qty; i++) {
        
            a = Number(document.getElementsByClassName('quantity')[i].value);
            b = Number(document.getElementsByClassName('pricesum')[i].value);
            // Do the multiplication
            c = a*b;
            document.getElementsByClassName('total')[i].value=c.toFixed(2);
            
    }
    calculateSum();
    
}   
//multiply function end
</script>

<script>
    $("#total_paid_ByCash_for_currentDue_minus").on("click change paste keyup cut select", function() {
	 var totalGetByCash_for_currentDue_minus = $('#totalGetByCash_for_currentDue_minus').val();
	 var total_paid_ByCash_for_currentDue_minus = $('#total_paid_ByCash_for_currentDue_minus').val();
	 var finale_get_by_cash_by_due_minus =  parseFloat(totalGetByCash_for_currentDue_minus) + parseFloat(total_paid_ByCash_for_currentDue_minus);
	 //alert(finale_get_by_cash_by_due_minus);
	 //console.log(finale_get_by_cash_by_due_minus);
	 $('#finale_get_Cash_for_currentDue_minus').val(finale_get_by_cash_by_due_minus.toFixed(2));
	 
});
</script>

<!--This is for product delete-->
<script>

$(document).ready(function(){

    $("#mainTable").on('click', '.btnSelect', function() {
  // get the current row
  var currentRow = $(this).closest("tr");
  
   $(this).parents("tr").remove();
   check_return_place();
  calculateSum();
  multiply();
  
});
});

function set_place(pid) {
    $.ajax({
        type: 'get',
        url: '/admin/supplier/return-product-place',
        data: {
            'pid': pid,
        },
        beforeSend: function() {
            $('#select_return_place_body').html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
        },
        success: function (data) {
            $('#select_return_place_body').html(data);
           check_return_place();
        }
    });
}

function getval(content) {
    var content = content.value;
    var details = content.split("_,");
    var pid = details[0];
    var place = details[1];
    var place_name = details[2];
    var max_return_qty = details[3];
    if(place != 'only') {
        $('#product_'+pid).html('<span class="text-light">'+place_name+'</span><p style="font-size: 10px; color: #FFFFFF;"><b>Max: </b>'+max_return_qty+'</p><i class="fas fa-edit text-light" data-toggle="modal" data-target="#supplier_product_return_place" onclick="set_place('+pid+')"></i>');
        $('#product_'+pid).removeClass('bg-danger').addClass('bg-success');
        $('#return_place_'+pid).val(place);
        $('#max_returnable_qty_'+pid).text('Max Returnable Qty from '+place_name+': '+max_return_qty);
        var inv_rest_qty = $('#inv_rest_qty_'+pid).text();
        if(max_return_qty >= inv_rest_qty) {
            $('#quantity_'+pid).prop('max', inv_rest_qty);
        }
        else {
            $('#quantity_'+pid).prop('max', max_return_qty);
        }
        check_return_place();
    }
    else {
        $('#product_'+pid).html('<button type="button" data-toggle="modal" data-target="#supplier_product_return_place" onclick="set_place('+pid+')" class="btn btn-light btn-sm">set place</button>');
        $('#product_'+pid).removeClass('bg-success').addClass('bg-danger');
        $('#return_place_'+pid).val('');
        $('#max_returnable_qty_'+pid).text('');
        $('#quantity_'+pid).prop('max', inv_rest_qty);
        check_return_place();
    }
}

function check_return_place() {
    var inputs = $(".return_place_confirm");
    
    for(var i = 0; i < inputs.length; i++){
        if($(inputs[i]).val() != '') {
            $('#submit_button').show();
        }
        else {
            $('#submit_button').hide();
            break;
            
        }
    }
}


</script>

@endsection
