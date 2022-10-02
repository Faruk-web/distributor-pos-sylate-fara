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
    <input type="hidden" name="" id="toggle_yes" value='1'>
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
                
                <div class="">
                    <form action="{{route('supplier.invoice.return.confirm.new')}}" method="post" id="form_1">
                        @csrf
                        <table id="mainTable" class="table table-bordered">
                            <thead>
                                <tr class="bg-success text-light">
                                    <th width="10%" style="padding: 10px 7px;">Place</th>
                                    <th width="45%" style="padding: 10px 7px;">Product Name</th>
                                    <th width="20%" style="padding: 10px 7px;">Quantity</th>
                                    <th style="padding: 10px 7px;">Unit Price</th>
                                    <th style="padding: 10px 7px;">Total Price</th>
                                    <th style="padding: 10px 7px; text-align: center;">X</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($supplier_invoice->invoice_products as $product)
                                    @php($previous_returned = DB::table('supplier_return_products')->where(['product_id'=>$product->product_info->id, 'variation_id'=>$product->variation_id, 'supp_invoice_id'=>$supplier_invoice->supp_invoice_id, 'lot_number'=>$product->lot_number])->sum('quantity'))
                                    @php($rest_quantity = $product->quantity - $previous_returned)
                                    
                                @if($rest_quantity > 0)
                                <?php
                                    $variation_name = '';
                                    $generate_key = '';
                                    if($product->variation_id != 0 || $product->variation_id != '') {
                                        $variation_info = DB::table('')->where(['id'=>$product->variation_id])->first();
                                        $variation_name =  '<span class="text-success">('.optional($variation_info)->list_title.')</span>';
                                        $generate_key = $product->product_id."_".$product->variation_id."_".$product->lot_number;
                                    }
                                    else {
                                        $generate_key = $product->product_id."_".$product->lot_number;
                                    }
                                    
                                    $rest_stocks = DB::table('product_stocks')->where(['pid'=>$product->product_id, 'lot_number'=>$product->lot_number, 'variation_id'=>$product->variation_id])->where('stock', '>', 0)->get();
                                    
                                ?>
                                <tr id="cart_tr{{$generate_key}}">
                                    <td id="product_{{$product->product_id}}"><button type="button" data-toggle="modal" data-target="#placeModal{{$generate_key}}" class="btn btn-primary btn-sm">set place</button>
                                    
                                        <div class="modal fade" id="placeModal{{$generate_key}}" tabindex="-1" role="dialog" aria-labelledby="placeModal{{$generate_key}}Label" aria-hidden="true">
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header bg-dark">
                                                <h5 class="modal-title text-light" id="placeModal{{$generate_key}}Label">{{$product->product_info->p_name}} {!!$variation_name!!}</h5>
                                                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                              </div>
                                              <div class="modal-body">
                                                  <table class="table table-bordered">
                                                      <thead>
                                                        <tr>
                                                          <th width="60%" scope="col">Place</th>
                                                          <th scope="col">Return Qty</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>
                                                          @foreach($rest_stocks as $key=>$rest_stock)
                                                          <?php
                                                            $place_name = '';
                                                            if($rest_stock->branch_id == 'G') {
                                                                $place_name = 'Godown';    
                                                            }
                                                            else {
                                                                $branch_info = DB::table('branch_settings')->where('id', $rest_stock->branch_id)->first(['branch_name', 'branch_address']);
                                                                $place_name = $branch_info->branch_name." [".$branch_info->branch_address."]";
                                                            }
                                                            
                                                            $generate_key_for_return = $generate_key."_".$key;
                                                          
                                                          ?>
                                                            <tr>
                                                              <td>
                                                                  {{$place_name}}
                                                                  <input type="hidden" value="{{$rest_stock->id}}" name="return_db_id_{{$product->product_id}}[]" id="">
                                                                  <input type="hidden" value="" name="" id="">
                                                                  
                                                              </td>
                                                              <td><input type="number"  oninput="set_return_qty('{{$generate_key_for_return}}', '{{$generate_key}}', '{{$rest_stock->stock}}')" id="return_stock_{{$generate_key_for_return}}" name="return_qty_{{$product->product_id}}[]" placeholder="Max: {{$rest_stock->stock}}" max="{{$rest_stock->stock}}" class="form-control return_stock_{{$generate_key}}" step=any>
                                                                <small class="text-success fw-bold ">Returnable Qty: {{$rest_stock->stock}}</small>
                                                              </td>
                                                            </tr>
                                                          @endforeach
                                                      </tbody>
                                                    </table>
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <input type="hidden" name="pid[]" value="{{$product->product_id}}">{{$product->product_info->p_name}} {!!$variation_name!!}
                                        <input type="hidden" name="lot_number[]" value="{{$product->lot_number}}">
                                        <input type="hidden" name="return_place[]" id="return_place_{{$product->product_id}}" required value="">
                                        <input type="hidden" name="variation_id[]" value="{{$product->variation_id}}">
                                    </td>
                                    <td id="quantity_td_{{$generate_key}}">
                                        <input style="width:90px;" type="number" value="" id="quantity_{{$generate_key}}" readonly name="quantity[]" max="{{$rest_quantity}}" class="quantity" step=any>
                                        <b>{{$product->product_info->unit_type_name->unit_name}}</b><br>
                                        <input type="hidden" value="{{$rest_quantity}}" name="" id="max_return_quantity_{{$generate_key}}">
                                        <span class="text-small">Returnable Qty: {{$rest_quantity}}</span>
                                    </td>
                                    <td>
                                        <input style="width: 111px;" type="number" value="{{$product->price}}" id="price" name="price[]" class="pricesum form-control" step=any>
                                    </td>
                                    <td>
                                        <input style="width: 138px;" type="text" value="" id="total" name="total[]" class="total form-control" readonly>
                                    </td>
                                    <td>
                                        <button type="button" id="remove" name="remove" onclick="remove_cart_tr('{{$generate_key}}')" class="btn btn-danger btn-sm btnSelect"><i class="fas fa-trash-alt"></i></button>
                                    </td>
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
                                        <input type="text" id="sums" name="total_gross" value="0" class="form-control" readonly></input>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        
                       
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
                                                <label for="exampleInputEmail1">Supplier Current Balance</label>
                                                <input type="text" name="supplier_balance" class="form-control" id="currentDueByCash_when_due_Minus" value="{{$supplier_info->balance+0}}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="exampleInputEmail1">Total Get From Invoice</label>
                                                <input type="text" name="TotalGetFromReturnByCash_when_due_Minus" class="form-control" id="TotalGetFromReturnByCash_when_due_Minus" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="exampleInputEmail1">Supplier Balance -
                                                    Invoice Current Total</label>
                                                <input type="text" name="totalGetByCash_for_currentDue_minus" class="form-control" id="totalGetByCash_for_currentDue_minus" value="{{$supplier_info->balance}}"
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

                        <div class="text-right" id="submit_button" ><a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-rounded btn-success">Submit</a></div>
                        

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

$(document).ready(function () {
    var toggle_yes = $('#toggle_yes').val();
    if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
        SidebarColpase();
    }
});


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

function set_place(pid, lot_number, variation_id) {
    $.ajax({
        type: 'get',
        url: '/admin/supplier/return_product_place_new',
        data: {
            'pid': pid,
            'lot_number': lot_number,
            'variation_id': variation_id,
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

function set_return_qty(generate_key_for_return, generate_key, max_stock) {
    
    var max_return_quantity = $('#max_return_quantity_'+generate_key).val();
    var return_stock_qty = $('#return_stock_'+generate_key_for_return).val();
    
    var stock_sum = 0;
    
	$(".return_stock_"+generate_key).each(function() {
		if(!isNaN(this.value) && this.value.length!=0) {
			stock_sum += parseFloat(this.value);
		}
	});
    
    if(stock_sum > max_return_quantity) {
        error("Reached Max Quantity!");
    }
    
    // if(max_stock < return_stock_qty) {
    //     error("Reached Item Max Quantity!");
    // }
    
    $('#quantity_'+generate_key).val(stock_sum);
    multiply();
    
}

function remove_cart_tr(generated_id) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
           $('#cart_tr'+generated_id).remove();
            multiply();
        }
    });
}



</script>

@endsection
