@extends('cms.master')
@section('body_content')
<style>
    #result{height:550px;overflow:auto;overflow-x: hidden;}
    #product_text {font-size: 13px; cursor: cell; text-align: left; border: 1px solid #3F3D56;}
</style>
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="p-3" id="select_branch_row">
            <div class="row mb-3 shadow rounded-pill border">
                <div class="col-md-5 p-4">
                    <div class="p-3">
                        <label for=""><span class="text-danger">*</span>Sender Branch</label>
                        <select name="0" id="sender_branch" class="form-control">
                            <option value="">-- Select Sender Branch --</option>
                            @foreach ($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-5 p-4">
                    <div class="p-3">
                        <label for=""><span class="text-danger">*</span>Receiver Branch</label>
                        <select name="" id="receiver_branch" class="form-control">
                            <option value="0">-- Select Receiver Branch --</option>
                            @foreach ($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2 p-4">
                    <div class="p-3">
                        <button type="button" onclick="branch_select_next_step()" class="btn btn-dual rounded-pill text-light mt-4 ml-2 bg-primary mr-2">Next</button>
                    </div>
                </div>
            </div>
            </div>
            <div class="row" id="main_body_row" style="display: none;">
                <div class="col-md-3">
                <h6><b>Product Transfer From <span id="sender_branch_title_for_product"></span></b></h6>
                    <div class="" >
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
                
                <div class="col-md-9">
                <input type="hidden" name="" id="toggle_yes" value='1'>
                    <div class="" style="padding: 0px 2px;">
                        <h4 class="fw-bold mb-2" id="branch_titles"></h4>
                        <div class="shadow border p-2">
                            <div class="">
                                <form action="{{route('godown.stock.out.confirm.new')}}" method="post" id="form_1">
                                    @csrf
                                    <table id="mainTable" class="table editable-table table-bordered  table-sm mb-0">
                                        <thead>
                                            <tr style="background-color:#1769aa;color:#fff;">
                                                <th width="45%" style="padding: 10px 7px;">Product info</th>
                                                <th style="padding: 10px 7px;">Unit</th>
                                                <th style=" width: 23%;padding: 10px 7px;">Godown Stock</th>
                                                <th style="padding: 10px 7px; text-align: center;">X</th>
                                            </tr>
                                        </thead>
                                        <tbody id = "demo" class="demo"></tbody>
                                    </table>
                                    <hr class="bg-warning">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name" accesskey="U"><span class="text-danger">*</span>Note</label>
                                                <textarea id="" name="note" class="form-control" rows="4" cols="50">Note</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name" accesskey="U"><span class="text-danger">*</span>Date</label>
                                                <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}" id="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        
                                        <a data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-primary" >Submit</a>
                                    </div>
                                    
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalForSell" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                        <div class="text-danger" style="text-align:center;">
                                                            <i class="fas fa-shopping-cart" style="font-size: 60px;"></i>
                                                        </div>
                                                        <div><h2 class="text-center font-bold">Are You Sure?</h2></div>
                                                        <div><p class="text-center">You will not be able to recover this content!</p></div>
                                                        <div class="row">
                                                            <div class="col-md-8 text-center"><button type="submit" name="sell" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Confirm Stock Transfer</button>
                                                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                                            
                                                            </div>
                                                            <div class="col-md-4 text-center"><button class="btn btn-danger" data-dismiss="modal">Cancel</button></div>
                                                                
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

function godown_stock_empty() {
    swal({
        title: "Error",
        text: "Empty Stock",
        icon: "error",
        button: "Ok",
    });
}


function myFunction(row_id, id, variation_id, variation_name, purchase_line_id, lot_number, name, purchase_price, sales_price, vat, discount, discount_amount,  godown_stock, unit_type) {
    
    var variation_info = '';


    if(variation_id == '0' || variation_id == '') {  var generate_id = row_id+'_'+lot_number;  }  else {  var generate_id = row_id+'_'+lot_number+'_'+variation_id;  variation_info = '<span class="text-primary">('+variation_name+')</span>'; }
    
     if($('#check_id'+generate_id).val()) {
        Toastify({
            text: name+ " Is Exist Into Cart.",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
        document.getElementById('error').play();
    }
     else {
         
        const cartDom = `<tr id="cart_tr`+generate_id+`">
                            <td>
                                <input type="hidden" name="pid[]" value="`+id+`">
                                <input type="hidden" name="row_id[]" value="`+row_id+`">
                                <input type="hidden" name="lot_number[]" value="`+lot_number+`">
                                <input type="hidden" name="variation_id[]" value="`+variation_id+`">
                                <input type="hidden" id="check_id`+generate_id+`" value="`+generate_id+`">
                                <h6 class="mb-0 text-success">`+name+` `+variation_info+`</h6>
                                <small><b>Lot Number:</b> `+lot_number+`, <b>Sales Price:</b> `+sales_price+`, <b>Discount:</b> `+discount+`(`+discount_amount+`), <b>VAT:</b> `+vat+`%</small>
                            </td>
                            <td>
                                <input type="number" required="" style="width: 100px;" value="" id="quantity" name="quantity[]" max="`+godown_stock+`" class="quantity" step="any"> `+unit_type+`
                            </td>
                            <td>
                                <input style="width: 100px;" type="number" value="`+godown_stock+`" id="godown_stock" name="godown_stock[]" class="godown_stock" readonly step="any"> `+unit_type+`
                            </td>
                            <td class="text-center">
                                <button type="button"  onclick="remove_cart_tr('`+generate_id+`')" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>`;
         
         $('#demo').prepend(cartDom);
        
    }
}

function remove_cart_tr(generated_id) {
    $('#cart_tr'+generated_id).remove();
}


</script>


<script>
$(".addproduct").click(function(){
    multiply();

    $(".quantity").on("click change paste keyup cut select", function() {
        multiply();
    });

});


function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".unit");
    
    // Declare i and qty for "for" loop
    var i, qty = quantity.length;
    // Use "for" loop to iterate through NodeList
    for (i = 0; i < qty; i++) {
        a = Number(document.getElementsByClassName('quantity')[i].value);
        b = Number(document.getElementsByClassName('unit')[i].value);
        // Do the multiplication
        c = a+b;
        document.getElementsByClassName('total')[i].value=c.toFixed(2);
            
    }
}   

</script>

<!--This is for product delete-->
<script>


//product barcode to product
$('#product_barcode_search').keypress(function(e) {
    $('#product_title').val('');
    $('#myUL').html('');
    var barcode = $('#product_barcode_search').val();
    if(e.which == 13 && barcode != '') {
        jQuery(this).blur();
        $.ajax({
            type: 'get',
            url: '/godown/stock-out/product_search_by_barcode_new',
            data: { 'barcode': barcode, },
            beforeSend: function () {
                $('#barcode_spin_div').html('<div class="spinner-border text-dark text-center" role="status"><span class="sr-only">Loading...</span></div>');
            },
            success: function (data) {
                if(data['exist'] == 'yes') {
                    //console.log(data.product_output);
                    $('#variation_modal_body').html(data.product_output)
                    $('#variation_modal_button').click();
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
        });
    }
});
//product barcode to product

function branch_select_next_step() {
    var sender_branch = $('#sender_branch').val();
    var receiver_branch = $('#receiver_branch').val();
    if(sender_branch != 0 && receiver_branch != 0) {
        if(sender_branch != receiver_branch){
            var sender_branch_name = $("#sender_branch option:selected" ).text();
            var receiver_branch_name = $("#receiver_branch option:selected" ).text();

            $('#main_body_row').show();
            $('#select_branch_row').hide();
            $('#sender_branch_title_for_product').text(sender_branch_name);
            var title = sender_branch_name+" To "+receiver_branch_name+" Transfer Product";
            $('#branch_titles').text(title);
            success('Sender and Receiver Branch Selected.');
        }
        else {
            error('Same Branch can not Transfer!!!');
        }
    }
    else {
        error('Please Select Branch!!!');
    }
}

//product search by product name
$('#product_title').keyup(function(){
    $('#product_barcode_search').val('');
    var title = $(this).val();
    $.ajax({
        type : 'get',
        url: '/godown/stock-out/search-product-by-title_new',
        data:{'title':title},
        success:function(data){
            $('#myUL').html(data);
        }
    });
});
//product search by product name



</script>


@endsection
