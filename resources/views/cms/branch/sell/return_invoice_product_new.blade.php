@extends('cms.master')
@section('body_content')
@php( $total_gross = 0 )
@php( $customer_info = $invoice->customer_info)
@php( $branch_info = DB::table('branch_settings')->where('id', $branch_id)->first())
@php( $sold_branch_info = DB::table('branch_settings')->where(['id'=>$invoice->branch_id])->first(['branch_name', 'branch_address']) )
<style>
    tr td{
        padding: 10px;
    }
    .max_exchange_qty {
        font-size: 10px;
        color: #E56767;
    }
    .text-small{
        font-size: 10px;
        font-weight: bold;
        color: #E56767;
    }
    
    i.fa.fa-plus.plus_icon {
        background-color: #F49D2A;
        padding: 3px;
        color: #fff;
        border-radius: 50%;
        cursor: grab;
    }
</style>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <input type="hidden" name="" id="toggle_yes" value='1'>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="p-2 bg-dark rounded shadow text-light"><b>You are Returning From =><span class="text-danger">{{$branch_info->branch_name}}</span></b><br><b>Sold From =><span class="text-success">{{$sold_branch_info->branch_name}}, {{$sold_branch_info->branch_address}}</span></b></h4>
                <p><span class="text-warning">যে যে প্রোডাক্ট রিটার্ন
                    করব সেগুলো রেখে বাকি গুলো ডিলিট করে দিতে হবে।</span> <span class="badge badge-danger">{{$how_many_time_returns+1}} Times Return Running</span></p>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">{{$customer_info->name}}</button>
                </div>
            </div>
            <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Customer Info</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6 class=""><b class="text-bold text-primary">Name: </b>{{$customer_info->name}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Phone: </b>{{$customer_info->phone}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Email: </b>{{optional($customer_info)->email}}</h6>
                            <h6 class=""><b class="text-bold text-primary">Code: </b>{{$customer_info->code}}</h6>
                        </div>
                        </div>
                    </div>
                </div>
                
                <div class="">
                    <form action="{{route('customer.invoice.return.confirm.new')}}" method="post" id="form_">
                        @csrf
                        <table id="orderTables"  class="display table table-bordered" style="width:100%">
                            <thead>
                                <tr class="bg-primary text-light">
                                    <th>Action</th>
                                    <th width="35%">Product Info</th>
                                    <th width="15%">Quantity</th>
                                    <th width="15%">Price</th>
                                    <th width="12%">Subtotal</th>
                                    <th class="text-center">X</th>
                                </tr>
                            </thead>
                            <input type="hidden" name="" id="individual_vat_status" value="yes">
                            
                            <tbody id="demo">
                            @foreach($invoice->invoice_products as $product)
                            @php($previous_returned = DB::table('order_return_porducts')->where(['product_id'=>$product->product_id, 'invoice_id'=>$product->invoice_id, 'variation_id'=>$product->variation_id, 'discount'=>$product->discount, 'discount_amount'=>$product->discount_amount, 'vat'=>$product->vat_amount])->sum('quantity'))
                            
                            @php($rest_quantity = $product->quantity - $previous_returned)
                            
                            @if($rest_quantity > 0)
                            
                            <?php
                                $trackers_info = DB::table('product_trackers')->where(['product_id'=>$product->product_info->id, 'invoice_id'=>$invoice->invoice_id, 'variation_id'=>$product->variation_id, 'product_form'=>'S'])->get();
                            
                                $variation_name = '';
                                $generate_key = '';
                                if($product->variation_id != 0 && $product->variation_id != '') {
                                    $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                                    $variation_name = '<span class="text-success">('.optional($variation_info)->list_title.')</span>';
                                    $generate_key = $product->id."_".$product->variation_id."_".$product->lot_number;
                                }
                                else {
                                    $generate_key = $product->id."_".$product->lot_number;
                                }
                                
                                $flat_discount = 0;
                                $discount_percent = 0;
                                if($product->discount == 'percent') { $discount_percent = $product->discount_amount; } else if($product->discount == 'flat') { $flat_discount = $product->discount_amount; }
                                
                            ?>
                            
                            <tr id="cart_tr{{$generate_key}}">
                                <td>
                                    <select onchange="return_or_exhange_onchange('{{$generate_key}}')" class="form-control" id="return_or_exchange_{{$generate_key}}" name="return_or_exchange[]" required>
                                        <option value="">-- Select One --</option>
                                        <option value="r">Return</option>
                                        <option value="e">Exchange</option>
                                    </select>
                                    <input type="hidden" class="r_or_e" name="r_or_e[]" id="r_or_e_{{$generate_key}}" value="">
                                </td>
                                
                                <td>
                                    <h6 class="text-success">{{$product->product_info->p_name}} {!!$variation_name!!} <i class="fa fa-plus plus_icon ml-2"  data-toggle="modal" data-target="#cart_modal_{{$generate_key}}"></i></h6>
                                    <small><b>Lot Number:</b> {{$product->lot_number}}, <b>Sales Price:</b> {{$product->price}}, <b>Discount:</b> {{$product->discount}}( {{$product->discount_amount}}), <b>VAT:</b> {{$product->vat_amount + 0}}%</small>
                                    
                                    <input type="hidden" name="pid[]" value="{{$product->product_id}}" id="pid_{{$generate_key}}">
                                    <input type="hidden" name="lot_number[]" value="{{$product->lot_number}}">
                                    <input type="hidden" name="variation_id[]" value="{{$product->variation_id}}" id="variation_id{{$generate_key}}">
                                    <input type="hidden" name="ordered_product_id[]" value="{{$product->id}}">
                                    <input type="hidden" name="discount_amount[]" value="{{$product->discount_amount}}">
                                    
                                    
                                    <div class="modal fade text-left show" id="cart_modal_{{$generate_key}}" tabindex="-1" role="dialog" aria-labelledby="cart_modal_level_{{$generate_key}}" aria-modal="true"><div class="modal-dialog modal-dialog-scrollable" role="document"><div class="modal-content"><div class="modal-header bg-dark"><h5 class="modal-title fw-bold text-light" id="cart_modal_level_{{$generate_key}}">{{$product->product_info->p_name}} {!!$variation_name!!}</h5></div><div class="modal-body">
                                        <div class="row">
                                            <div class="form-group col-md-6 col-sm-6">
                                                <label>Percent Discount</label>
                                                <input class="form-control discount_percent" type="number" step=any readonly name="disCP[]" value="{{$discount_percent}}">
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6">
                                                <label>Flat Discount</label>
                                                <input class="form-control flat_discount" type="number" step=any readonly name="disC_flat[]" value="{{$flat_discount}}">
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12">
                                                <label>VAT</label>
                                                <input class="form-control individual_product_vat" name="individual_product_vat[]" type="number" readonly value="{{$product->vat_amount}}">
                                            </div>
                                            <div class="text-right col-md-12 col-sm-12"><button type="button" class="btn-secondary btn white pt-1 pb-1" data-dismiss="modal" aria-label="Close">Close</button>
                                            </div>
                                        </div></div></div></div></div>
                                </td>
                                <td>
                                    <div id="return_or_exchange_status_info_output_{{$generate_key}}"></div>
                                <p class="text-small">Rest Qty: <span id="inv_rest_qty_{{$generate_key}}">{{$rest_quantity}}</span></p>
                                    <input type="number" step="any" style="width: 80px;" value="{{$rest_quantity}}" class="quantity" id="quantity_{{$generate_key}}"
                                        name="quantity[]" max="{{$rest_quantity}}"> {{$product->product_info->unit_type_name->unit_name}} <br><span class="text-danger">@if($previous_returned != 0) {{$previous_returned}} {{$product->product_info->unit_type_name->unit_name}} returnded @endif</span></td>
                                <td>
                                    <input type="number" step="any" value="{{$product->price}}" class="form-control pricesum" readonly id="price" name="price[]"></td>
                                <td>
                                    <input style="width: 111px;" type="number" step="any" value="{{$product->total_price}}" class="form-control total" readonly id="total"
                                        name="total[]">
                                </td>
                                <td>
                                    <button type="button" id="remove" name="remove" onclick="remove_cart_tr('{{$generate_key}}')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </td>
                            </tr>
                            
                            @php($total_gross = $total_gross + ($product->total_price))
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                        @php( $sum = $total_gross)
                        @php($vat_price = 0)
                        <div class="row mt-5">
                            <div class="col-md-2">
                                <hr>
                            </div>
                            <br>
                            <div class="col-md-10">
                                <div class="card">
                                    <div class="card-body">
                                    <table class="table">
                                      <tbody>
                                            <tr>
                                                <th class="text-right" colspan="2">Total Gross</th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="text" id="sums" name="subtotal" value="{{$total_gross}}"
                                                        class="form-control" readonly></input>
                                                </th>
                                            </tr>
                                            @if($invoice->discount_status == 'tk' || $invoice->discount_status == 'flat')
                                            @php($sum = $sum-$invoice->discount_rate)
                                            <tr>
                                                <th class="text-right" colspan="2">Discount TK</th>
                                                <th><input type="number" id="discount_TK" name="discount_Tk" value="{{$invoice->discount_rate}}"
                                                        class="form-control" step=any></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="discount_tk_price" name="discount_tk_price"
                                                        value="{{$invoice->discount_rate}}" class="form-control" readonly step=any>
                                                </th>
                                            </tr>
                                            @elseif($invoice->discount_status == 'percent')
                                            @php($discount_price = ($invoice->discount_rate * $sum)/100)
                                            @php($sum = $sum-$discount_price)
                                            <tr>
                                                <th class="text-right" width="30%" colspan="2">Discount Parcent (%)</th>
                                                <th><input type="number" readonly id="discount_Percent" name="discount_Percent"
                                                        value="{{$invoice->discount_rate}}" class="form-control" step=any></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="discount_Percent_price"
                                                        name="discount_Percent_price" value="{{$discount_price}}" class="form-control"
                                                        readonly step=any>
                                                </th>
                                            </tr>
                                            @endif
                                            
                                            @if($invoice->vat > 0)
                                            @php($vat_price = $sum*($invoice->vat)/100)
                                            <tr>
                                                <th class="text-right" colspan="2">VAT(%)</th>
                                                <th><input type="number" id="vat" name="vat" value="{{$invoice->vat}}"
                                                        class="form-control" readonly></input></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="vat_price" name="vat_price" value="{{$vat_price}}"
                                                        class="form-control" step=any readonly step=any></input>
                                                </th>
                                            </tr>
                                            @endif
                                            
                                            @if(!empty($invoice->others_crg))
                                            @php($sum = $sum+$invoice->others_crg)
                                            <tr>
                                                <th class="text-right" colspan="2">Others Charge</span></th>
                                                <th><input type="number" id="only_others_crg" name="only_others_crg" value="{{$invoice->others_crg}}" max="{{$invoice->others_crg}}" class="form-control" step=any></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="only_others_crg_tk" name="only_others_crg_tk" value="{{$invoice->others_crg}}" class="form-control" readonly step=any>
                                                </th>
                                            </tr>
                                            @endif
                                            
                                            @php($sum = $sum+$vat_price)
                                            <tr>
                                                <th class="text-right" colspan="2">Sub Total</th>
                                                <th></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="subTotal" name="subTotal" value="{{$sum}}"
                                                        class="form-control" readonly step=any>
                                                </th>
                                            </tr>

                                            
                                            @if($invoice->wallet_point > 0)
                                            <tr>
                                                <th colspan="2" class="text-right">Wallet Point</th>
                                                <th>
                                                    <input type="number" id="invoice_wallet_point" readonly name="invoice_wallet_point" value="{{$invoice->wallet_point}}" class="form-control" step="any">
                                                </th>
                                                <th></th>
                                                <th>
                                                    <input type="number" id="back_wallet_point" name="back_wallet_point" value="{{$invoice->wallet_point}}" class="form-control bg-warning text-light" step="any" readonly="">
                                                </th>
                                            </tr>
                                            @else
                                                <input type="hidden" id="invoice_wallet_point" name="invoice_wallet_point" value="0" step="any">
                                                <input type="hidden" id="back_wallet_point" name="back_wallet_point" value="0" step="any">
                                            @endif
                                            
                                            <tr>
                                                <th colspan="2" class="text-danger text-right">Extra Fine</th>
                                                <th><input type="number" id="extra_fine" name="extra_fine" value="0" class="form-control" step="any"></th>
                                                <th></th>
                                                <th>
                                                    <input type="number" id="extra_fine_tk" name="extra_fine_tk" value="0" class="form-control bg-danger text-light" step="any" readonly="">
                                                </th>
                                            </tr>
                                            

                                            <tr>
                                                <th class="text-right" colspan="3">Total Payable ( <span class="text-danger">কাস্টমার পাবে</span> )</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="total_payable" name="total_payable"
                                                        class="form-control bg-success text-light" value="{{$sum}}" step=any readonly>
                                                </th>
                                            </tr>
                                            <?php
                                                if($customer_info->code == Auth::user()->shop_id."WALKING") {
                                                    $customer_balance = 0;
                                                }
                                                else {
                                                    $customer_balance = $customer_info->balance+0;
                                                }
                                            ?>
                                            
                                            <tr>
                                                <th class="text-right" colspan="3">Customer Due ( <span class="text-success">কাস্টমার থেকে পাবো</span> )</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="customer_due" name="customer_due"
                                                        class="form-control" value="{{$customer_balance}}" step=any readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="3">Total With inv & current due ( <span class="text-info">বর্তমানে কাস্টমার পাবে</span> )</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="total_payable_with_customer_due" name="total_payable_with_customer_due"
                                                        class="form-control" value="{{$customer_balance-$sum}}" step=any readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="3">Paid to customer</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="paid" name="paid" class="form-control" @if($customer_info->code == Auth::user()->shop_id."WALKING") value="{{abs($customer_balance-$sum)}}" readonly @endif step=any required>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="3">Customer Current Balance ( <span class="text-primary">কাস্টমারের বর্তমান ব্যালান্স</span> )</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="customer_current_balance" name="customer_current_balance"
                                                        class="form-control" value="" step=any readonly>
                                                </th>
                                            </tr>
                                        </tbody>
									</table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Note</label>
                            <textarea id="" class="form-control" name="note" rows="3" cols="50"></textarea>
                        </div>

                        <input type="hidden" name="customer_id" id="date" class="form-control" value="{{$customer_info->id}}" required>
                        
                        <input type="hidden" name="walking_custoemr" id="walking_custoemr" class="form-control" value="@if($customer_info->code == Auth::user()->shop_id."WALKING"){{1}}@else{{0}}@endif" required>
                        
                            <input type="hidden" name="invoice_id" value="{{$invoice->invoice_id}}" id="">

                        <div class="text-right" id="submit_button" style=""><a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-rounded btn-success">Submit</a></div>
                        
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
                                                <input type="submit" name="ReturnToSupplier" class="btn btn-primary" value="Confirm" onclick="form_submit(1)" id="submit_button_1">
                                                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                            </div>
                                            <div class="col-md-6 text-center"><button
                                                    class="btn btn-danger"
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
</div>





<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

$(document).ready(function () {
    var toggle_yes = $('#toggle_yes').val();
    if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
        SidebarColpase();
    }
});

function return_or_exhange_onchange(generate_key) {
    
    var what_to_do = $('#return_or_exchange_'+generate_key).val();
    var pid = $('#pid_'+generate_key).val();
    var variation_id = $('#variation_id'+generate_key).val();
    var generate_id = generate_key;
    
    var inv_rest_qty = $('#inv_rest_qty_'+generate_id).text();
    
    if(what_to_do == 'e') {
        $.ajax({
            type: 'get',
            url: '/branch/return_products/exchange_status_new',
            data: {
                'pid': pid,
                'variation_id': variation_id,
            },
            beforeSend: function() {
                $('#return_or_exchange_status_info_output_'+generate_id).html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (data) {
                if(data['status'] == 'yes') {
                    $('#return_or_exchange_status_info_output_'+generate_id).html('<span class="max_exchange_qty">Current Stock of This Branch: '+data['stock']+'</span>');
                    if(data['stock'] >= inv_rest_qty) {
                        $('#quantity_'+generate_id).prop('max', inv_rest_qty);
                    }
                    else {
                        $('#quantity_'+generate_id).prop('max', data['stock']);
                    }
                }
                else {
                    $('#return_or_exchange_status_info_output_'+generate_id).html('');
                    $('#quantity_'+generate_id).prop('max', inv_rest_qty);
                    $('.return_or_exchange_'+generate_id).val('').change();
                    swal({
                        title: "Error!",
                        text: "Sorry, This Product has no stock in this Branch.",
                        icon: "error",
                        button: "Ok",
                    });
                    var play = document.getElementById('error').play();
                }
            }
        });
        
        $('#r_or_e_'+generate_id).val('e');
    }
    else if(what_to_do == 'r') {
        $('#quantity_'+generate_id).prop('max', inv_rest_qty);
        $('#return_or_exchange_status_info_output_'+generate_id).html('');
        $('#r_or_e_'+generate_id).val('r');
    }
    else {
        $('#r_or_e_'+generate_id).val('');
    }
    
    multiply();
}


// quantity keyup start
$(".quantity").on("click change paste keyup cut select", function() 
{
	multiply();
	calculateSum();
});
// quantity keyup end

// price keyup start
$(".pricesum").on("click change paste keyup cut select", function() {
	multiply();
	calculateSum();
});
// price keyup end

$("#paid").on("click change paste keyup cut select", function() {
    multiply();
	calculateSum();
});

$("#extra_fine").on("click change paste keyup cut select", function() {
    multiply();
	calculateSum();
});

$("#only_others_crg").on("click change paste keyup cut select", function() {
    multiply();
	calculateSum();
});

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
            calculateSum();
            multiply();
        }
    });
}

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
		//.toFixed() method will roundoff the final sum to 2 decimal places
		
        // document.getElementsByClassName('sum')[0].innerText = sum
        document.getElementById("sums").value = sum;
		$("#sums").val(sum.toFixed(2));
	
        // discount taka or percent start
          var discountTk = $("#discount_TK").val();
          var discountParcent = $('#discount_Percent').val();
          if(typeof(discountTk) != 'undefined' && discountTk != null) {
              sum = parseFloat(sum) - parseFloat(discountTk);
              $("#discount_tk_price").val(discountTk);
          }
          else if(typeof(discountParcent) != 'undefined' && discountParcent != null) {
            var discountParcentTk = (discountParcent * sum)/100;
            sum = parseFloat(sum) - parseFloat(discountParcentTk);
            $("#discount_Percent_price").val(discountParcentTk.toFixed(2));
         }
        // discount taka or percent End

        // vat parcent and vat parcent rate start
        var vatParcent = $("#vat").val();
        
        if(typeof(vatParcent) != 'undefined' && vatParcent != null){ 
            var vatParcentPrice = sum*vatParcent/100;
            sum = parseFloat(sum) + parseFloat(vatParcentPrice);
            $("#vat_price").val(vatParcentPrice.toFixed(2));
        }
        // vat parcent and vat parcent rate End

        
        //Others Charge 
        var others_charge = $("#only_others_crg").val();
        
        if(typeof(others_charge) != 'undefined' && others_charge != null){ 
            if(others_charge == ''){
                others_charge = 0;
            }
            sum = parseFloat(sum) + parseFloat(others_charge);
            $("#only_others_crg_tk").val(parseFloat(others_charge));
        }
        //Others Charge
        
        $("#subTotal").val(sum.toFixed(2));

        //Extra fine
        var extra_fine = $('#extra_fine').val();
        if(extra_fine == ''){
            extra_fine = 0;
        }
        sum = parseFloat(sum) - parseFloat(extra_fine);
        $("#extra_fine_tk").val(parseFloat(extra_fine));
        //Extra fine

        $("#total_payable").val(sum.toFixed(2));

        //Customer Due
        var customer_due = $('#customer_due').val();
        if(customer_due == ''){
            customer_due = 0;
        }
        sum = parseFloat(customer_due) - parseFloat(sum);
        //Customer Due
        
        $("#total_payable_with_customer_due").val(sum.toFixed(2));
        
        var walking_custoemr = $('#walking_custoemr').val();
        if(walking_custoemr == 1) {
            $('#paid').val(Math.abs(sum.toFixed(2)));
        }
        
        //Paid to customer
        var paid = $('#paid').val();
        if(paid == ''){
            paid = 0;
        }
        sum = parseFloat(paid) + parseFloat(sum);
        //Paid to customer

        
        //this is for full payment paid
        $("#customer_current_balance").val(sum.toFixed(2));
        
     
}
// total sum end


//multiply function start
function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".pricesum");
    var discount_pernect = document.querySelectorAll(".discount_percent");
    var flat_discount = document.querySelectorAll(".flat_discount");
    
    // Declare i and qty for "for" loop
    var i, qty = quantity.length;
    // Use "for" loop to iterate through NodeList
    for (i = 0; i < qty; i++) {
        
           var return_or_exchange = document.getElementsByClassName('r_or_e')[i].value;
            console.log(return_or_exchange);
            if(return_or_exchange == 'r') {
                individual_quantity = Number(document.getElementsByClassName('quantity')[i].value);
                individual_price = Number(document.getElementsByClassName('pricesum')[i].value);
                individual_discount_percent = Number(document.getElementsByClassName('discount_percent')[i].value);
                individual_flat_discount = Number(document.getElementsByClassName('flat_discount')[i].value);
                individual_product_vat = Number(document.getElementsByClassName('individual_product_vat')[i].value);
                
                sum = individual_quantity*individual_price;
                
                if(individual_flat_discount != 0 && individual_flat_discount != '') { 
                    var t_discount = individual_flat_discount * individual_quantity;
                    sum = sum - t_discount; 
                }
                else if(individual_discount_percent != 0 && individual_discount_percent != '') {
                    discountParcent_amount_tk = (individual_discount_percent * sum)/100;
                    sum = sum-discountParcent_amount_tk;
                }
                vat_price = sum*individual_product_vat/100;
                sum = sum+vat_price;
                 document.getElementsByClassName('total')[i].value=sum.toFixed(2);
            }
            else {
                document.getElementsByClassName('total')[i].value=0;
            }
            
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

/*
$("#orderTables").on('click', '.btnSelect', function() {

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete) {
           // get the current row
            var currentRow = $(this).closest("tr");
            $(this).parents("tr").remove();
            var product_name = currentRow.find(".product_name").val(); // get current row 2nd table cell TD value
            multiply();
            calculateSum();
            var play = document.getElementById('success').play();
        }
    });
});

*/

});


$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});




</script>


@endsection
