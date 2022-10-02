@extends('cms.master')
@section('body_content')
<style>
    #result{height:600px;overflow:auto;overflow-x: hidden;}
    #product_text {font-size: 13px; text-align: left;}
    .my-custom-scrollbar {
        position: relative;
        height: 350px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }

    .pd-name {
        font-size: 13px !important;
    }

    #product-item{
        border: 1px solid #2C2E3B;
        cursor: cell;
        border-radius: 5px;
    }

    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: hidden !important;
        
    }
</style>

<!-- Page Content -->

<!--<div class="content">-->
<!--    <div class="block block-rounded">-->
<!--        <div class="row">-->
<!--            <div class="col-md-12 text-center"><h1>We Are Updating Some Fetures. We Will be back in 20 minutes.</h1></div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="content">
    <div class="block block-rounded">
        <div class="p-2">
            @if(empty(optional($supplier_info)->id))
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                        <input type="text" class="form-control" id="supplier_search" placeholder="Search by supplier info"
                            name="company_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group shadow rounded p-3">
                        <select class="form-control select1" id="" onchange="javascript:selectSupplier(this)" data-live-search="true">
                            <option value="0">--Or Select Here--</option>
                            @foreach($suppliers as $supplier)
                            <option value="{{$supplier->code}}">{{$supplier->name}}({{$supplier->company_name}})
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pl-4 pr-4 pb-2">
                        <div class="card-body shadow rounded">
                        <table class="table table-bootstrap">
                            <tbody id="supplier_show_info"></tbody>
                        </table>
                        </div>
                    </div>
                
                </div>
            </div>
            @elseif(!empty(optional($supplier_info)->id))
            <input type="hidden" name="" id="toggle_yes" value='1'>
            <div class="row">
                <div class="col-md-3">
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-block js-tabs-enabled" data-toggle="tabs" role="tablist">
                            <li class="nav-item"><a class="nav-link bg-success text-light" onclick="set_tabs('supplier')" id="supplier-info-tab-button" href="javascript:void(0)">Supplier Info</a></li>
                            <li class="nav-item"><a class="nav-link" onclick="set_tabs('products')" id="products-tab-button" href="javascript:void(0)">Products</a></li>
                        </ul>
                        <div class="p-2">
                            <div class="" id="suppler-info-tab" style="">
                                <div class="block-content shadow rounded">
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="far fa-user-circle bg-muted text-light p-1 rounded"></i> </b> <span id="lender_name">{{optional($supplier_info)->name}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-business-time bg-muted text-light p-1 rounded"></i> </b> <span id="comapany_name">{{optional($supplier_info)->company_name}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-phone bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($supplier_info)->phone}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-map-marker-alt bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($supplier_info)->address}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-comments-dollar bg-muted text-light p-1 rounded"></i> </b> <span id="lender_balance">{{number_format(optional($supplier_info)->balance, 2)}}</span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="products-tabs" style="display: none;">
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
                                        <ul class="nav nav-pills flex-column push" id="myUL"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="">
                        <div class="">
                            <div class="table-responsive">
                                <form action="{{route('supplier.stock.in.confirm')}}" method="post" id="form_1">
                                    @csrf
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar shadow rounded">
                                        <table id="mainTable"
                                            class="table table-bordered table-sm">
                                            <thead>
                                                <tr class="bg-primary text-light">
                                                    <th style="padding: 10px 7px;">Product Name</th>
                                                    <th style=" width: 23%;padding: 10px 7px;">Quantity</th>
                                                    <th style="padding: 10px 7px;">Price</th>
                                                    <th style="padding: 10px 7px;">Total Price</th>
                                                    <th style="padding: 10px 7px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="demo" class="demo"></tbody>
                                        </table>
                                    </div>
                                    <div class="p-2">
                                        
                                    </div>
                                    
                                    <div class="p-1">
                                        <div class="pb-4 pr-4 pl-4 shadow rounded"> 
                                            <table class="table table-sm">
                                            <tbody class="">
                                                    <tr>
                                                        <th width="20%"> <button type="button" class="btn btn-outline-success"><i class="fa fa-shopping-bag" style="color: #F50057;"></i> Cart Item: <span id="total_cart_items" class="text-dark">0</span></button></th>
                                                        <th colspan="2" class="text-right mr-3">Total Gross</th>
                                                        <th width="30%">
                                                            <input type="text" id="sums" name="total_gross" value="" class="form-control" readonly></input>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" class="text-right mr-3 text-danger">Previous Due / Get</th>
                                                        <th>
                                                            @if(optional($supplier_info)->balance != 0)
                                                            <input type="text" id="supplier_pre_due" name="pre_due" value="{{optional($supplier_info)->balance}}" class="form-control" readonly>
                                                            @else
                                                            <input type="text" id="supplier_pre_due" name="pre_due" value="0" class="form-control" readonly>
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    <tr style="display: none;">
                                                        <th colspan="3" class="text-right mr-3">Others Crg</th>
                                                        <th class="text-right mr-3"><input type="number" oninput="change_others_charge()" id="others_crg" step=any name="others_crg"value="0" class="form-control" /></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">
                                                            <div class="form-group">
                                                                <lebel>Discount From Supplier</lebel>
                                                                <select class="form-control" id="supplier-discount" name="supplier_discount">
                                                                    <option value="0">No</option>
                                                                    <option value="flat">Flat</option>
                                                                    <option value="percent">Percent</option>
                                                                </select>
                                                            </div>
                                                        </th>
                                                        <th  width="30%">
                                                            <div id="discount-value-div" style="display: none;">
                                                                <lebel><span class="text-danger">*</span>Discount Amount</lebel>
                                                                <input type="number" oninput="change_others_charge()" min="0"  id="discountAmount" step=any name="discountAmount"value="0" class="form-control" />
                                                                <small class="text-success" id="type-of-discount"></small>
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <lebel>Total Discount Amount</lebel>
                                                            <input type="number" readonly id="total-discount-amount" step=any name="total_discount_amount"value="0" class="form-control" />
                                                        </th>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th colspan="3" class="text-right mr-3">Total Payable</th>
                                                        
                                                        <th><input type="text" id="total_payable" name="only_total_payable" class="form-control" readonly /></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" class="text-right mr-3" id="">Paid</th>
                                                        
                                                        <th>
                                                            <input type="number" name="paid" oninput="supplier_paid_change()" max="{{optional($net_cash)->balance}}" id="supplier_paid" step=any class="form-control" required>
                                                            <small class="text-success">max: {{number_format(optional($net_cash)->balance, 2)}}</small>
                                                            @error('paid')
                                                                <span class="text-danger">{{ $message }}</span>
                                                            @enderror
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" class="text-right mr-3" id="">Current Due</th>
                                                        
                                                        <th><input type="text" name="cur_due" id="currentDue" class="form-control" required value="0" step=any readonly></th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <hr class="bg-warning">
                                    <div class="p-1">
                                    <div class="shadow rounded p-2">
                                    <div class="form-group">
                                        <label for="date">Note.</label>
                                        <textarea id="w3review" name="note" class="form-control" rows="4"
                                            cols="50">Note</textarea>
                                    </div>

                                    <hr class="bg-warning">
                                    <input type="hidden" name="supplier_id" id="" class="form-control" value="{{$supplier_info->id}}"
                                        required>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Please Confirm A Place</label>
                                                <div class="form-check form-check-inline bg-warning"
                                                    style="padding: 5px 10px; border: 1px solid #F50057; border-radius: 10px; margin-left: 10px;">
                                                    <input class="form-check-input" type="radio" name="place"
                                                        id="inlineRadio1" value="SUPP_TO_G" required>
                                                    <label class="form-check-label text-light"
                                                        for="inlineRadio1"><b>Godowns</b></label>
                                                </div>
                                                @foreach($branchs as $branch)
                                                <div class="form-check form-check-inline bg-primary"
                                                    style="padding: 5px 10px; border: 1px solid #F50057; border-radius: 10px;">
                                                    <input class="form-check-input" type="radio" name="place"
                                                        id="branch_{{$branch->id}}" value="{{$branch->id}}">
                                                    <label class="form-check-label text-light"
                                                        for="branch_{{$branch->id}}"><b>{{$branch->branch_name}}</b></label>
                                                </div>
                                                @endforeach
                                                @error('place')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="form-check-label"><b>Date</b></label>
                                                <input class="form-control" type="date" name="date" id="InvDate"
                                                    value="{{date('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="form-check-label"><b>Supplier Voucher Num.</b></label>
                                                <input class="form-control" type="text" name="supp_voucher_num"  required>
                                                @error('supp_voucher_num')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                    <div class="text-right">
                                    <a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-success text-right mr-3 btn-rounded" style="padding:3px 6px;">Submit</a>
                                    </div>
                                    
                                    </div>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModalForSell" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="text-info" style="text-align:center;">
                                                        <i class="fas fa-shopping-cart"
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
                                                            <button type="submit" name="sellConfirm" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Confirm</button>
                                                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                                        </div>
                                                        <div class="col-md-6 text-center"><button class="btn btn-danger" data-dismiss="modal">Cancel</button></div>
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
            </div>
            @endif
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

    function myFunctionR() {
        var input, filter, ul, li, a, x, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (x = 0; x < li.length; x++) {
            a = li[x].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[x].style.display = "";
            } else {
                li[x].style.display = "none";
            }
        }
    }

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
            text: name+ " Is Exist Into Cart.",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
        document.getElementById('error').play(); 
    }
    else{
        $('#demo').prepend('<tr style="background-color:#F2F2F2;color: #000;"><td class="t_tittle" id = "t_tittle"><input type="hidden" name="pid[]" value="'+id+'"><input type="hidden" name="pname[]"  value="'+name+'"><strong class="pd-name">'+name+'</strong></td><td><input style="width:117px;" type="number" value = "1" id="quantity" oninput="changeQuantity()" name="quantity[]" class = "quantity" step=any></td><td><input style="width: 111px;" type="number" value = "'+price+'" id="price" oninput="change_price()" name="price[]" class = "pricesum" step=any ></td><td><input style="width: 168px;" type="number" value = "'+name+'" id="total" name="total[]" class = "total" step=any readonly></td><td><button type="button" id="remove" name="remove" class="btn btn-danger btn-sm remove btnSelect"><span class="glyphicon glyphicon-minus"></span><i class="fas fa-trash-alt"></i></button></td></tr>');
        pname.push(name);
        calculateSum();
        multiply();
       document.getElementById('success1').play(); 
    }
}

</script>


<script type="text/javascript">


// $('#quantity').keyup(function(){
//     var supplier_info = $(this).val();
//     calculateSum();
//     console.log(supplier_info);
//     multiply();
//     //calculateSum();
// });

// $("#supplier_paid").on("input", function() {
//         calculateSum();
// });


function changeQuantity() {
    calculateSum();
    multiply();
}

function change_price() {
    calculateSum();
    multiply();
}

function supplier_paid_change() {
    calculateSum();
}

function change_others_charge() {
    calculateSum();
}


$(".addproduct").click(function(){
    calculateSum();
    multiply();
});



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
	
        var supplier_due = $('#supplier_pre_due').val();
        // var others_crg = $('#others_crg').val();
        
        //Discount Start
       var discountType = $('#supplier-discount').val();
       var discountAmount = $('#discountAmount').val();
       if(discountAmount == '') {
         discountAmount = 0;
       }
       if(discountType == 'flat') {
          sum = sum - discountAmount;
          $('#total-discount-amount').val(discountAmount);
       }
       else if(discountType == 'percent') {
           var discountParcentTk = (discountAmount * sum)/100;
           $('#total-discount-amount').val(discountParcentTk);
           sum = sum - discountParcentTk;
       }
       else {
        $('#total-discount-amount').val(0);
       }
       var total_payable = parseFloat(sum) + parseFloat(supplier_due);
    // Discount End

        $('#total_payable').val(total_payable);
        var supplier_paid = $('#supplier_paid').val();
        if(supplier_paid != '') {
            var current_due = parseFloat(total_payable) - parseFloat(supplier_paid);
            $('#currentDue').val(current_due);
        }
        else {
            $('#currentDue').val('');
        }

        var rowCount = $('#mainTable >tbody >tr').length;
        $('#total_cart_items').html(rowCount);


            
}


$(".addproduct").click(function(){
    calculateSum();
    $(".pricesum").each(function() {
    $(".quantity").on("change paste keyup cut select", function() {
            multiply();
    	});
    });
    $(".quantity").each(function() {
    $(".pricesum").on("change paste keyup cut select", function() {
        multiply();
    });
    });
  
});		

function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".pricesum");
    var i, qty = quantity.length;
    for (i = 0; i < qty; i++) {
        a = Number(document.getElementsByClassName('quantity')[i].value);
        b = Number(document.getElementsByClassName('pricesum')[i].value);
        // Do the multiplication
        c = a*b;
        document.getElementsByClassName('total')[i].value=c.toFixed(2);
    }
    calculateSum();
}   


$(document).ready(function(){

    $("#mainTable").on('click', '.btnSelect', function() {
    // get the current row
        var currentRow = $(this).closest("tr");
        $(this).parents("tr").remove();
        var col2 = currentRow.find(".pd-name").html(); // get current row 2nd table cell TD value
        var ProDName = col2;
        deleteFromArray(ProDName);
        calculateSum();
        multiply();
    });

});

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
        url: '/supplier/stock-in/search-supplier',
        data:{'supplier_info':supplier_info},
        success:function(data){
        $('#supplier_show_info').html(data);
        }
    });
});
// End:: Supplier Search for stock in

$( "#supplier-discount" ).change(function() {
    var discountType = $('#supplier-discount').val();
    if(discountType == 'flat') {
        $('#discount-value-div').show();
        $('#type-of-discount').text('You are selected Flat discount');

    }
    else if(discountType == 'percent') {
        $('#discount-value-div').show();
        $('#type-of-discount').text('You are selected Percent(%) discount');
    }
    else {
        $('#discount-value-div').hide();
        $('#discountAmount').val(0);
    }
    calculateSum();
});


function set_tabs(info) {
    if(info == 'supplier') {
        $('#supplier-info-tab-button').addClass('bg-success text-light');
        $('#supplier-info-tab-button').removeClass('text-dark');
        $('#products-tab-button').removeClass('bg-success text-light');
        $('#products-tab-button').addClass('text-dark');
        $('#suppler-info-tab').show();
        $('#products-tabs').hide();
    }
    else {
        $('#products-tab-button').addClass('bg-success text-light');
        $('#products-tab-button').removeClass('text-dark');
        $('#supplier-info-tab-button').removeClass('bg-success text-light');
        $('#supplier-info-tab-button').addClass('text-dark');
        $('#suppler-info-tab').hide();
        $('#products-tabs').show();
    }
}

//product barcode to product
$('#product_barcode_search').keypress(function(e) {
    $('#product_title').val('');
    $('#myUL').html('');
    var barcode = $('#product_barcode_search').val();
    if(e.which == 13 && barcode != '') {
        jQuery(this).blur();
        $.ajax({
            type: 'get',
            url: '/supplier/product-purchase-search-barcode',
            data: { 'barcode': barcode, },
            beforeSend: function () {
                $('#barcode_spin_div').html('<div class="spinner-border text-dark text-center" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function (data) {
                if(data['exist'] == 'yes') {
                    myFunction(data.pid, data.p_name, data.purchase_price, 0);
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

//product search by product name
$('#product_title').keyup(function(){
    $('#product_barcode_search').val('');
    var title = $(this).val();
    $.ajax({
        type : 'get',
        url: '/supplier/product-purchase/search-product-by-title',
        data:{'title':title},
        success:function(data){
        $('#myUL').html(data);
        }
    });
});
//product search by product name

</script>


@endsection
