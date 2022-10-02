@extends('cms.master')
@section('body_content')
<style>
    #result{height:600px;overflow:auto;overflow-x: hidden;}
    li{
        border: 1px solid #3F3D56;
        cursor: cell;
    }
    #product_text {font-size: 13px; text-align: left;}
    
    .text-small {
        font-size: 10px;
        font-weight: bold;
        color: #E56767;
    }
    
</style>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="p-2">
            <div class="row" id="direct-return-upper-interface">
                <div class="col-md-3 text-center"><h4>Supplier Direct Return Product</h4></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                        <input type="text" class="form-control" id="supplier_search" placeholder="Search by supplier info"
                            name="company_name">
                    </div>
                </div>
                <div class="col-md-3">
                    
                </div>
                <div class="col-md-12">
                    <div class="pl-4 pr-4 pb-2">
                        <div class="card-body shadow rounded">
                        <table class="table table-bootstrap">
                            <tbody id="supplier_show_info"></tbody>
                        </table>
                        </div>
                    </div>
                <input type="hidden" name="" id="toggle_yes" value='1'>
                </div>
            </div>
           
            
            <div class="row" id="direct-return-main-interface" style="display: none;">
                <div class="col-md-3">
                  <div class="shadow p-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Search By Product Name" id="product_title">
                    <div class="form-group row mt-2">
                        <div class="input-group col-md-12">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Barcode" autofocus="autofocus" id="product_barcode_search" name="">
                        </div>
                        <div id="barcode_spin_div" class="text-center p-2"></div>
                    </div>
                    
                  </div>
                  <div class="card card-primary card-outline" id="#mydiv">
                    <div class="" id="result">
                        <ul class="nav nav-pills flex-column push" id="myUL">
                           
                        </ul>
                    </div>
                </div>
                </div>
                <div class="col-md-9 p-2">
                    <span class="text-success"><b>Supplier Direct Return Product</b></span><br>
                    <small class="text-danger text-bold">এই পদ্ধতিতে সাপ্লাইয়ার এর সাথে ক্রয়কৃত ইনভয়েস / ভাউচার এর কোন সম্পর্ক নেই। তাই এক সাপ্লাইয়ার এর প্রোডাক্ট অন্য সাপ্লাইয়ার এর কাছে রিটার্ন করা থেকে বিরত থাকতে হবে। </small>
                    <div><div class="row bg-primary text-light p-1 shadow rounded"  id="supplier-info"></div></div>
                    
                    <div class="row shadow p-2 rounded">
                        <div class="table-responsive">
                    <form action="{{route('supplier.direct.return.products.confirm')}}" method="post" id="form_1">
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
                            <tbody id = "demo" class="demo"></tbody>
                            
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-right">Total Gross</th>
                                    <th></th>
                                    <th>
                                        <input type="text" id="sums" name="total_gross" value="" class="form-control" readonly></input>
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
                                                <label for="exampleInputEmail1">Supplier Current Balance</label>
                                                <input type="text" name="supplier_balance" class="form-control" id="currentDueByCash_when_due_Minus" value="0" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="exampleInputEmail1">Total Get From  Invoice</label>
                                                <input type="text" name="TotalGetFromReturnByCash_when_due_Minus" class="form-control" id="TotalGetFromReturnByCash_when_due_Minus" value="0" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="exampleInputEmail1">Supplier Balance -
                                                    Invoice Current Total</label>
                                                <input type="text" name="totalGetByCash_for_currentDue_minus" class="form-control" id="totalGetByCash_for_currentDue_minus" value="0"
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
                        <input type="hidden" name="supplier_id" id="supplier_id" class="form-control" value="" required>
                        <input type="hidden" name="supplier_invoice_id" value="" id="">

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
            </div>
            
            <button type="button" data-toggle="modal" data-target="#supplier_product_return_place" id="hidden_set_place_button" class="btn btn-light btn-sm d-none">set place</button>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    function selectSupplier(code) {
        if (code.value != 0) {
            window.location = '/supplier/' + code.value + '/stock-in';
        }
    }

    $(document).ready(function () {
        var toggle_yes = $('#toggle_yes').val();
        if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
            SidebarColpase();
        }
    });

</script>


<script>


var pname = [];

function deleteFromArray(productName){
    const index = pname.indexOf(productName);
    if (index > -1) {
      pname.splice(index, 1);
    }
}


function myFunction(id,name,price,quantity) {
    var x = document.getElementsByClassName("quantity");
        if(pname.indexOf(name) !== -1){
            Toastify({
                text: name+ " Is Exist",
                backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                className: "error",
            }).showToast();
        }
        else{
            
        $('#demo').prepend('<tr style="background-color:#F2F2F2;color: #000;"><td class="bg-danger" id="product_'+id+'"><button type="button" data-toggle="modal" data-target="#supplier_product_return_place" onclick="set_place('+id+')" class="btn btn-light btn-sm">set place</button></td><td><input type="hidden" id="product_storage" name="product_storage" class="product_name" value="'+name+'"><input type="hidden" name="pid[]" value="'+id+'">'+name+'<input type="hidden" class="return_place_confirm form-control form-control-sm" name="return_place[]" id="return_place_'+id+'" required="" value=""></td><td><p class="text-small"><span id="max_returnable_qty_'+id+'"></span></p><input style="width:117px;" type="number" value="0" oninput="changeQuantity()" min="1" id="quantity_'+id+'" name="quantity[]" max="" class="quantity" step="any"> <b></b><br><span style="font-size: 10px; color: red;"></span></td><td><input style="width: 111px;" type="number" oninput="change_price()" value="'+price+'" id="price" name="price[]" class="pricesum" step="any"></td><td><input style="width: 158px;" type="text" value="0" id="total" name="total[]" class="total" readonly=""></td><td><button type="button" id="remove" name="remove" class="btn btn-danger btn-sm btnSelect"><i class="fas fa-trash-alt"></i></button></td></tr>');
        
            pname.push(name);
            calculateSum();
            multiply();
    }
}

</script>


<script type="text/javascript">


$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});

// Begin:: Supplier Search for stock in
$('#supplier_search').keyup(function(){
    var supplier_info = $(this).val();
    $.ajax({
        type : 'get',
        url: '/supplier/direct-stock-out/search-supplier',
        data:{'supplier_info':supplier_info},
        success:function(data){
        $('#supplier_show_info').html(data);
        }
    });
});
// End:: Supplier Search for stock in

function setSupplier(id, name, company_name, phone, code, balance, address) {
    $('#direct-return-upper-interface').hide();
    $('#direct-return-main-interface').show();
    $('#currentDueByCash_when_due_Minus').val(balance);
    $('#supplier_id').val(id);
    $('#supplier-info').html('<div class="col-md-2 empty-3"><h6 class="card-subtitle text-center text-light"><b>Name<br></b> '+name+'</h6></div><div class="col-md-3 empty-3"><h6 class="card-subtitle text-center text-light"><b>Company<br></b> '+company_name+'</h6></div><div class="col-md-2 empty-2"><h6 class="card-subtitle text-center text-light"><b>Address<br></b> '+address+'</h6></div><div class="col-md-2 empty-2"><h6 class="card-subtitle text-center text-light"><b>Phone<br></b> '+phone+'</h6></div><div class="col-md-2 empty-2"><h6 class="card-subtitle text-center text-light"><b>Code<br></b> '+code+'</h6></div>');
}


$('#product_title').keyup(function(){
    var title = $(this).val();
    $.ajax({
        type : 'get',
        url: '/supplier/product-searchby-title/direct-return',
        data:{'title':title},
        success:function(data){
        $('#myUL').html(data);
        }
    });
});

//product barcode to product
$('#product_barcode_search').keypress(function(e) {
    var barcode = $('#product_barcode_search').val();
    if(e.which == 13 && barcode != '') {
        jQuery(this).blur();
        $.ajax({
            type: 'get',
            url: '/supplier/product-info-from-barcode',
            data: { 'barcode': barcode, },
            beforeSend: function () {
                $('#barcode_spin_div').html('<div class="spinner-border text-dark text-center" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function (data) {
                if(data['exist'] == 'yes') {
                    setProduct(data.pid, data.p_name, data.purchase_price);
                }
                else {
                    Toastify({
                        text: "Product is not exist",
                        backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                        className: "error",
                    }).showToast();
                    var play = document.getElementById('error').play(); 
                }

                $('#barcode_spin_div').html('');
                $('#product_barcode_search').val('');
                $('#product_barcode_search').focus();
            },
            error: function (xhr) {
                swal({
                    title: "Error",
                    text: "Error occured.please try again",
                    icon: "error",
                    button: "Ok",
                });
                var play = document.getElementById('error').play();
                $('#barcode_spin_div').html('');
                $('#product_barcode_search').val('');
                $('#product_barcode_search').focus();
            },
            complete: function () {
                //alert('complete');
            },
        });
    }
});
//product barcode to product


function setProduct(pid, name, price) {
    if(pname.indexOf(name) !== -1){
        Toastify({
            text: name+ " Is Exist",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
       document.getElementById('error').play();
    }
    else{ 
        $('#hidden_set_place_button').click();
        myFunction(pid, name, price)
        set_place(pid);
    }
}

</script>

<script>
function changeQuantity() {
    calculateSum();
	multiply();
}

function change_price() {
    calculateSum();
	multiply();
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
        $('#quantity_'+pid).prop('max', max_return_qty);
        $('#max_returnable_qty_'+pid).text('Max Returnable Qty from '+place_name+': '+max_return_qty);
        check_return_place();
        
        // $('#max_returnable_qty_'+pid).text('Max Returnable Qty from '+place_name+': '+max_return_qty);
        // var inv_rest_qty = $('#inv_rest_qty_'+pid).text();
        // if(max_return_qty >= inv_rest_qty) {
        //     $('#quantity_'+pid).prop('max', inv_rest_qty);
        // }
        // else {
        //     $('#quantity_'+pid).prop('max', max_return_qty);
        // }
        
    }
    else {
        $('#product_'+pid).html('<button type="button" data-toggle="modal" data-target="#supplier_product_return_place" onclick="set_place('+pid+')" class="btn btn-light btn-sm">set place</button>');
        $('#product_'+pid).removeClass('bg-success').addClass('bg-danger');
        $('#return_place_'+pid).val('');
        $('#quantity_'+pid).prop('max', 0);
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

$(document).ready(function(){
    $("#mainTable").on('click', '.btnSelect', function() {
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
                var product_name = currentRow.find(".product_name").val(); // get current row 2nd table cell TD value
                deleteFromArray(product_name);
                $(this).parents("tr").remove();
                calculateSum();
                multiply();
                check_return_place();
                //var play = document.getElementById('success').play();
            }
        });
    });
});


</script>



@endsection
