@extends('cms.master')
@section('body_content')
@php( $total_gross = 0 )
@php( $customer_info = $invoice->customer_info)
@php( $branch_info = DB::table('branch_settings')->where('id', $branch_id)->first())
<style>
    tr td {
        padding: 10px;
    }
    .max_exchange_qty {
        font-size: 10px;
        color: #E56767;
    }
    .text-small {
        font-size: 10px;
        font-weight: bold;
        color: #E56767;
    }
</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <input type="hidden" name="" id="toggle_yes" value='1'>
        <div class="card-body">
            <div class="row">
                <div class="col-md-10">
                    <h4 class="p-2 bg-dark rounded shadow text-light"><b>You are Returning From <span class="text-danger">{{$branch_info->branch_name}}</span></b></h4>
                <p><b>Produt Return To Customer ----></b>, <span class="text-warning">যে যে প্রোডাক্ট রিটার্ন
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
                
                <div class="table-responsive">
                    <form action="{{route('customer.invoice.return.confirm')}}" method="post" id="form_1">
                        @csrf
                        <table id="orderTables" class="display table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="15%">Name</th>
                                    <th width="15%">Return or Exchange</th>
                                    <th width="15%">Quantity</th>
                                    <th width="10%">Price</th>
                                    <th width="15%">Discount</th>
                                    <th>Vat</th>
                                    <th width="8%">Subtotal</th>
                                    <th width="5%" class="text-center no-sort">Action</th>
                                </tr>
                            </thead>
                            <input type="hidden" name="" id="individual_vat_status" value="yes">
                            <tbody id="demo">
                            @foreach($invoice->invoice_products as $product)
                            @php($previous_returned = DB::table('order_return_porducts')->where('product_id', $product->product_info->id)->where('invoice_id', $invoice->invoice_id)->sum('quantity'))
                            @php($rest_quantity = $product->quantity-$previous_returned)
                            @if($rest_quantity > 0)
                            <tr>
                                <td class="t_tittle" id="t_tittle"><input type="hidden" name="pid[]" value="{{$product->product_id}}"><input type="hidden"id="product_storage" name="product_storage" class="product_name"
                                        value="{{$product->product_info->p_name}}">{{$product->product_info->p_name}}</td>
                                <td>
                                    <select class="form-control return_or_exchange_{{$product->product_id}}" id="return_or_exchange" name="return_or_exchange[]" required>
                                        <option value="">-- Select One --</option>
                                        <option value="r,{{$product->product_id}}">Return</option>
                                        <option value="e,{{$product->product_id}}">Exchange</option>
                                    </select>
                                </td>
                                <td><div id="return_or_exchange_status_info_output_{{$product->product_id}}"></div>
                                <p class="text-small">Rest Qty: <span id="inv_rest_qty_{{$product->product_id}}">{{$rest_quantity}}</span></p>
                                    <input type="number" step="any" style="width: 80px;" value="{{$rest_quantity}}" class="quantity" id="quantity_{{$product->product_id}}"
                                        name="quantity[]" max="{{$rest_quantity}}"> {{$product->product_info->unit_type_name->unit_name}} <span class="text-danger">@if($previous_returned != 0) {{$previous_returned}} {{$product->product_info->unit_type_name->unit_name}} returnded @endif</span></td>
                                <td><input type="number" step="any" value="{{$product->price}}" class="form-control pricesum" id="price"
                                        name="price[]"></td>
                                <td style="font-size: 12px;"><span>Percent: </span><input style="width: 70px; font-size: 10px;" type="number"  readonly step="any" value="{{$product->discount}}"
                                        class="discount_percent" onchange="change_indv_p_discount_percent({{$product->product_id}})"
                                        onkeyup="change_indv_p_discount_percent({{$product->product_id}})" id="disCP_{{$product->product_id}}" name="disCP[]"><br /><span>Flat Rate:
                                    </span><input style="width: 70px; font-size: 10px;" type="number" step="any" readonly value="{{$product->discount_amount}}" class="rounded flat_discount"
                                        onkeyup="change_indv_p_flat_discount({{$product->product_id}})" onchange="change_indv_p_flat_discount({{$product->product_id}})" id="disC_flat_{{$product->product_id}}"
                                        name="disC_flat[]"></td>
                                <td><input style="width: 111px;" type="number" readonly="" step="any" value="{{$product->vat_amount}}"
                                        class="form-control individual_product_vat" id="individual_product_vat"
                                        name="individual_product_vat[]"></td>
                                <td><input style="width: 111px;" type="number" step="any" value="{{$product->total_price}}" class="form-control total" readonly id="total"
                                        name="total[]"></td>
                                <td>
                                    <div class="card-toolbar text-center"><span><i class="fas fa-trash-alt text-danger remove btnSelect"></i></span></div>
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
                                            @if(!empty($invoice->vat))
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

                                            @if($invoice->discount_status == 'tk')
                                            @php($sum = $sum-$invoice->discount_rate)
                                            <tr>
                                                <th class="text-right" colspan="2">Discount TK</th>
                                                <th><input type="number" id="discount_TK" name="discount_Tk" value="0"
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
                                            @else
                                            
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

                                            @if(!empty($invoice->others_crg))
                                            @php($sum = $sum+$invoice->others_crg)
                                            <tr>
                                                <th class="text-right" colspan="2">Others Charge</span></th>
                                                <th><input type="number" id="only_others_crg" name="only_others_crg"
                                                        value="{{$invoice->others_crg}}" max="{{$invoice->others_crg}}" class="form-control" step=any></th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="only_others_crg_tk"
                                                        name="only_others_crg_tk" value="{{$invoice->others_crg}}" class="form-control"
                                                        readonly step=any>
                                                </th>
                                            </tr>
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
                                            <tr>
                                                <th class="text-right" colspan="3">Customer Due ( <span class="text-success">কাস্টমার থেকে পাবো</span> )</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="customer_due" name="customer_due"
                                                        class="form-control" value="{{$customer_info->balance+0}}" step=any readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="3">Total With inv & current due ( <span class="text-info">বর্তমানে কাস্টমার পাবে</span> )</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="total_payable_with_customer_due" name="total_payable_with_customer_due"
                                                        class="form-control" value="{{($customer_info->balance+0)-$sum}}" step=any readonly>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-right" colspan="3">Paid to customer</th>
                                                <th></th>
                                                <th colspan="2">
                                                    <input type="number" id="paid" name="paid" class="form-control" @if($customer_info->code == Auth::user()->shop_id."WALKING") value="{{abs(($customer_info->balance+0)-$sum)}}" readonly @endif step=any required>
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

$('select').on('change', function(){
    var info = this.value.split(",");
    var what_to_do = info[0];
    var pid = info[1];
    
    if(what_to_do == 'e') {
        $.ajax({
            type: 'get',
            url: '/branch/return-products/exchange-status',
            data: {
                'pid': pid,
            },
            beforeSend: function() {
                $('#return_or_exchange_status_info_output_'+pid).html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (data) {
                var inv_rest_qty = $('#inv_rest_qty_'+pid).text();
                if(data['status'] == 'yes') {
                    $('#return_or_exchange_status_info_output_'+pid).html('<span class="max_exchange_qty">Current Stock of This Branch: '+data['stock']+'</span>');
                    if(data['stock'] >= inv_rest_qty) {
                        $('#quantity_'+pid).prop('max', inv_rest_qty);
                    }
                    else {
                        $('#quantity_'+pid).prop('max', data['stock']);
                    }
                }
                else {
                    $('#return_or_exchange_status_info_output_'+pid).html('');
                    $('#quantity_'+pid).prop('max', inv_rest_qty);
                    $('.return_or_exchange_'+pid).val('').change();
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
    }
    else if(what_to_do == 'r') {
        $('#return_or_exchange_status_info_output_'+pid).html('');
    }
    
});




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

        $("#subTotal").val(sum.toFixed(2));
        

        //Others Charge 
        var others_charge = $("#only_others_crg").val();
        //alert(others_charge);
        if(typeof(others_charge) != 'undefined' && others_charge != null){ 
            if(others_charge == ''){
                others_charge = 0;
            }
            sum = parseFloat(sum) + parseFloat(others_charge);
            $("#only_others_crg_tk").val(parseFloat(others_charge));
        }
        //Others Charge

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

            individual_quantity = Number(document.getElementsByClassName('quantity')[i].value);
            individual_price = Number(document.getElementsByClassName('pricesum')[i].value);
            individual_discount_percent = Number(document.getElementsByClassName('discount_percent')[i].value);
            individual_flat_discount = Number(document.getElementsByClassName('flat_discount')[i].value);
            individual_product_vat = Number(document.getElementsByClassName('individual_product_vat')[i].value);
            
            sum = individual_quantity*individual_price;
            vat_price = sum*individual_product_vat/100;
            if(individual_flat_discount != 0 && individual_flat_discount != '') { sum = sum-individual_flat_discount; }
            else if(individual_discount_percent != 0 && individual_discount_percent != '') {
                discountParcent_amount_tk = (individual_discount_percent * sum)/100;
                sum = sum-discountParcent_amount_tk;
            }
            sum = sum+vat_price;
             document.getElementsByClassName('total')[i].value=sum.toFixed(2);
            
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


});


$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});




</script>


@endsection
