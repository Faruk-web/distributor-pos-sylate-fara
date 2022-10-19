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
    
    .list-group-item {
        position: relative;
        display: block;
        padding: 1px 1px !important;
        border: none !important;
    }
    
    .coursor_plus {
        cursor: cell;
    }
    .coursor_plus:hover {
        border: 2px solid #269E70;
    }
    
    i.fa.fa-plus.plus_icon {
        background-color: #30c78d;
        padding: 3px;
        color: #fff;
        border-radius: 50%;
        cursor: grab;
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
            <button type="button" id="variation_modal_button" class="d-none" data-toggle="modal" data-target="#variation_modal"></button>
            <div class="modal fade" id="variation_modal" tabindex="-1" role="dialog" aria-labelledby="variation_modalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header bg-dark">
                    <h5 class="modal-title text-light" id="variation_modalLabel">Select Product</h5>
                    <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body p-4">
                      <div id="variation_modal_body" class="row">
                          
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <form action="{{route('set.opening.stock.confirm')}}" method="post" id="form_1">
            <input type="hidden" name="" id="toggle_yes" value='1'>
            <div class="row" id="place_div">
                <div class="col-md-12 ">
                    <div class="form-group px-10">
                        <label for="place"><span class="text-danger">*</span>Select Place</label>
                        <select class="form-control" name="place" required="" id="stock_place">
                            <option value="0">-- Select Place --</option>
                            @foreach($branchs as $branch)
                            <option value="{{$branch->id}}">{{$branch->branch_name}} [{{$branch->branch_address}}]</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" id="product_info_div" style="display: none;">
                <div class="col-md-9">
                    <div class="">
                        <h5><b>Set Opening Stock For <span class="text-success" id="place_info_show"></span></b></h5>
                        <div class="">
                            <div class="table-responsive">
                                    @csrf
                                    <div class="table-wrapper-scroll-y my-custom-scrollbar shadow rounded">
                                        <table id="mainTable" class="table table-bordered table-sm">
                                            <thead>
                                                <tr class="bg-warning text-light">
                                                    <th style="padding: 10px 7px; width: 40%;">Product Info</th>
                                                    <th style=" width: 15%;padding: 10px 7px;">Quantity</th>
                                                    <th style=" width: 15%;padding: 10px 7px;">	CARTOON QTY</th>
                                                    <th style="padding: 10px 7px;">P Price</th>
                                                    <th style="padding: 10px 7px; text-align:center;">X</th>
                                                </tr>
                                            </thead>
                                            <tbody id="demo" class="demo"></tbody>
                                        </table>
                                    </div>
                                    <div class="p-2">
                                        
                                    </div>
                                    
                                    <div class="p-1">
                                    <div class="shadow rounded p-2">
                                    

                                    <hr class="bg-warning">
                                    
                                    

                                    <div class="row">
                                        <div class="col-md-6">
                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-check-label"><b>Date</b></label>
                                                <input class="form-control" type="date" name="date" id="InvDate" value="{{date('Y-m-d')}}" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="text-right">
                                        <a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-success text-right mr-3 btn-rounded">Submit</a>
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="block block-rounded">
                        <div class="" id="products-tabs">
                            <div class="shadow p-2">
                                <input type="text" class="form-control form-control-sm" placeholder="Search By Product Name" id="product_title">
                                <div class="form-group row mt-2 d-none">
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
            </form>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<!-- Modal -->


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
    function selectSupplier(code) {
        if (code.value != 0) {
            window.location = '/supplier/' + code.value + '/stock-in-new';
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


function myFunction(id,name,price,sales_price,vat_status, vat_rate, discount, discount_rate, variation_name,variation_id, is_cartoon, cartoon_quantity) {
    var x = document.getElementsByClassName("quantity");
    var flat_d_status, p_d_status, cartoon_status, cartoon_text  = '';
    var variation_info = '';
    if(variation_name == 'simple') { var generate_id = id; } else { var generate_id = id+'_'+variation_id; variation_info = '<small class="text-success">('+variation_name+')</small>' }
    if(vat_status != 'yes'){ vat_rate = 0; }
    if(discount == 'flat') { flat_d_status = 'selected'; } else if(discount == 'percent') { p_d_status = 'selected'; }else { discount_rate = 0; discount = 'no'; }
    
    if($('#check_id'+generate_id).val()) {
        Toastify({
            text: name+ " Is Exist Into Cart.",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
        document.getElementById('error').play();
    }
    else {
        if(is_cartoon == 1){ cartoon_text= "1 Cartoon = "+cartoon_quantity; }else {  cartoon_status = 'readonly'; cartoon_text = "<span class='text-danger'>Status is deactive.</span>"; }
        const cartDom = `<tr id="cart_tr`+generate_id+`">
                            <td>
                                <input type="hidden" name="pid[]" value="`+id+`">
                                <input type="hidden" name="is_cartoon[]" value="`+is_cartoon+`">
                                <input type="hidden" name="cartoon_quantity[]" value="`+cartoon_quantity+`">
                                <input type="hidden" name="variation_id[]" value="`+variation_id+`">
                                <input type="hidden" id="check_id`+generate_id+`" value="`+generate_id+`">
                                <h5 class="fw-bold mb-0">`+name+` `+variation_info+` <i class="fa fa-plus plus_icon ml-2" data-toggle="modal" data-target="#cart_modal_`+generate_id+`"></i></h5>
                                <small class="mb-5"><b>Sales Price: </b><span id="sp_show_`+generate_id+`">`+sales_price+`</span> || <b>Discount: </b><span id="dis_show_`+generate_id+`">`+discount+`(`+discount_rate+`)</span> || <b>Vat: </b><span id="vat_show_`+generate_id+`">`+vat_rate+`%</span></small>
                                
                                <div class="modal fade text-left show" id="cart_modal_`+generate_id+`" tabindex="-1" role="dialog" aria-labelledby="cart_modal_level_`+generate_id+`" aria-modal="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark text-light">
                                                <h5 class="modal-title fw-bold text-light" id="cart_modal_level_`+generate_id+`">`+name+` `+variation_info+`</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-md-12 col-sm-12"><label>Sales Price</label>
                                                        <input type="number" step=any name="sales_price[]" id="sales_price`+generate_id+`" onchange="c_sales_price('`+generate_id+`')"
                                                            onkeyup="c_sales_price('`+generate_id+`')" class="form-control" value="`+sales_price+`">
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-6"><label>Sales Discount</label>
                                                        <select class="form-control" onchange="change_discount('`+generate_id+`')" id="discount_`+generate_id+`" name="p_discount[]">
                                                            <option value="no">No</option>
                                                            <option `+flat_d_status+` value="flat">Flat</option>
                                                            <option `+p_d_status+` value="percent">Percent</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6 col-sm-6"><label>Discount Amount</label>
                                                        <input class="form-control flat_discount" onchange="change_discount_amount('`+generate_id+`')"
                                                            onkeyup="change_discount_amount('`+generate_id+`')" type="number" step=any id="p_discount_amount_`+generate_id+`"
                                                            name="discount_amount[]" value="`+discount_rate+`">
                                                    </div>
                                                    <div class="form-group col-md-12 col-sm-12"><label>VAT(%)</label>
                                                        <input class="form-control vat" name="vat[]" type="number" readonly value="`+vat_rate+`">
                                                    </div>
                                                    <div class="text-right col-md-12 col-sm-12">
                                                        <button type="button" class="btn-secondary btn white pt-1 pb-1" data-dismiss="modal"
                                                            aria-label="Close">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td>
                                <div class="mb-2 p-1 border rounded shadow">
                                    <input style="width:117px;" type="number" class="quantity quantity`+generate_id+`" value="" id="quantity" oninput="changeQuantity('`+generate_id+`', '`+cartoon_quantity+`')" name="quantity[]" step="any" required>
                                </div>
                            </td>
                            <td>
                                <div class="mb-2 p-1 border rounded shadow">
                                    <input style="width:117px;" type="number" class="cartoon_amount cartoon_amount`+generate_id+`" value="0" id="cartoon_amount" `+cartoon_status+` oninput="change_cartoon_amount('`+generate_id+`', '`+cartoon_quantity+`')" name="cartoon_amount[]" step="any" required>
                                    <br><small>`+cartoon_text+`</small>
                                </div>
                            </td>

                            <td>
                                <input style="width: 111px;" type="number" value="`+price+`" id="price" oninput="change_price()" name="price[]" class="pricesum" step="any">
                            </td>
                            <td class="text-center"><button type="button" onclick="remove_cart_tr('`+generate_id+`')" class="btn btn-danger btn-sm">X</button></td>
                        </tr>`;
                        
        $('#demo').prepend(cartDom);
        
        calculateSum();
        multiply();
       document.getElementById('success1').play(); 
    }
}


function changeQuantity(generated_id, cartoon_quantity) {
    quantity_info_change(generated_id, cartoon_quantity, 'single_qty');
    
}

function change_cartoon_amount(generated_id, cartoon_quantity) {
    quantity_info_change(generated_id, cartoon_quantity, 'cartoon_qty');
}

function quantity_info_change(generated_id, cartoon_quantity, info) {
    if(info == 'single_qty') {
        if(cartoon_quantity > 0) {
            var qty = $('.quantity'+generated_id).val();
            var total_cartoon = qty / cartoon_quantity;
            $('.cartoon_amount'+generated_id).val(total_cartoon.toFixed(2));
        }
    }
    else if(info == 'cartoon_qty') {
        if(cartoon_quantity > 0) {
            var cartoon_qty = $('.cartoon_amount'+generated_id).val();
            var total_qty = cartoon_quantity * cartoon_qty;
            $('.quantity'+generated_id).val(total_qty.toFixed(2));
        }
    }
}


function remove_cart_tr(generated_id) {
    $('#cart_tr'+generated_id).remove();
    calculateSum();
    multiply();
}


$("#stock_place").change(function() {
    var place_info = $(this).val();
    const opt = document.querySelector('#stock_place option:checked');
    var inner_text = opt.text;
    if(place_info != 0) {
        $("#place_div").hide();
        $("#product_info_div").show();
        $("#place_info_show").text(inner_text);
    }
    else {
        $("#place_div").show();
        $("#product_info_div").hide();
    }
});

function change_discount(generated_id) {
    discount_output_td(generated_id);
    Toastify({
        text: "Discount is changed.",
        backgroundColor: "linear-gradient(to right, #5AC146, #00BFA6)",
        className: "success",
    }).showToast();
    document.getElementById('success').play();
}

function change_discount_amount(generated_id) {
    discount_output_td(generated_id);
}


function discount_output_td(generated_id) {
    var discountType = $('#discount_'+generated_id).val();
    var d_amount = $('#p_discount_amount_'+generated_id).val();
    
    var discount_status = discountType+'('+d_amount+')';
    
    if(discountType == 'no'){ $('#p_discount_amount_'+generated_id).val(0);  d_amount = 0; }
    $('#dis_show_'+generated_id).text(discount_status);
}

function c_sales_price(generated_id) {
    var price = $('#sales_price'+generated_id).val();
    $('#sp_show_'+generated_id).text(price);
}

</script>


<script type="text/javascript">


$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});



/*
//product barcode to product

$('#product_barcode_search').keypress(function(e) {
    $('#product_title').val('');
    $('#myUL').html('');
    var barcode = $('#product_barcode_search').val();
    if(e.which == 13 && barcode != '') {
        jQuery(this).blur();
        $.ajax({
            type: 'get',
            url: '/supplier/product-purchase-search-barcode_new',
            data: { 'barcode': barcode, },
            beforeSend: function () {
                $('#barcode_spin_div').html('<div class="spinner-border text-dark text-center" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function (data) {
                if(data['exist'] == 'yes') {
                    if(data['type'] == 'variable') {
                        $('#variation_modal_body').html(data.variation_output)
                        $('#variation_modal_button').click();
                    }
                    else {
                        myFunction(data.pid, data.p_name, data.purchase_price, data.selling_price, data.vat_status, data.vat_rate, data.discount, data.discount_rate, 'simple', 0);
                    }
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

*/

//product search by product name
$('#product_title').keyup(function(){
    $('#product_barcode_search').val('');
    var title = $(this).val();
    var stock_place = $('#stock_place').val();
    $.ajax({
        type : 'get',
        url: '/admin/get_products_search_by_title_into_opening_stock_new',
        data:{
            'title':title,
            'stock_place': stock_place,
        },
        success:function(data){
        $('#myUL').html(data);
        }
    });
});
//product search by product name

</script>


@endsection
