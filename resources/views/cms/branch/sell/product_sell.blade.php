@extends('cms.master')
@section('body_content')
<style>
    #result {
        height: 450px;
        overflow: auto;
        overflow-x: hidden;
    }

    #product_text {
        font-size: 12px;
        cursor: cell;
        text-align: left;
        border: 1px solid #CCCCCC;
        border-radius: 7px;
        background-color: #fff;
    }

    img {
        width: 50px;
    }

    #courser {
        cursor: cell;
    }

    .card-subtitle {
        font-size: 12px;
    }

</style>
<!-- Page Content -->
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row">
                <div class="col-md-3"><p><b>{{optional($branch_info)->branch_name}}</b></p></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                        <input type="text" class="form-control" id="customer_search"
                            placeholder="Search by Customer info (name, phone, code)" name="company_name">
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <button type="button" class="btn btn-rounded btn-primary btn-sm mb-2" data-toggle="modal"
                        data-target="#modal_add_new_customer">New Customer</button>
                    <a href="{{route('shop.walking.customer')}}" class="btn btn-rounded btn-info btn-sm">Walking
                        Customer</a>
                </div>
                <!-- Add New Customer Modal -->
                <div class="modal" id="modal_add_new_customer" tabindex="-1" role="dialog"
                    aria-labelledby="modal_add_new_customer" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="block block-rounded block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">Add New Customer</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal"
                                            aria-label="Close">
                                            <i class="fa fa-fw fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <form action="{{route('branch.add.new.customer.from.sell')}}" method="post">
                                    @csrf
                                    <div class="block-content font-size-sm">
                                        <div class="form-group">
                                            <label class="control-label" for="filebutton"><span
                                                    class="text-danger">*</span>Customer Name</label>
                                            <input type="text" name="name" class="form-control" id="" required>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="filebutton"><span
                                                    class="text-danger">*</span>Phone Number (max: 11)</label>
                                            <input type="text" maxlength="11" name="phone" class="form-control"
                                                id="check_customer_phone_from_sell" required>
                                            <div id="add_customer_phone_output"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="filebutton">Email</label>
                                            <input type="email" name="email" class="form-control"
                                                id="check_customer_email_from_sell">
                                            <div id="add_customer_email_output"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label" for="filebutton">Address</label>
                                            <input type="text" name="address" class="form-control" id="">
                                        </div>

                                    </div>
                                    <div class="block-content block-content-full text-right border-top">
                                        <button type="submit" class="btn btn-success">Submit</button>
                                        <button type="button" class="btn btn-alt-danger mr-1"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add New Customer Modal -->
                <div class="col-md-12">
                    <div class="pl-4 pr-4 pb-2">
                        <div class="card-body shadow rounded">
                            <table class="table table-bootstrap">
                                <tbody id="customer_show_info"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>


<script>
    // Begin:: Customer Search for stock in
    $('#customer_search').keyup(function () {
        var customer_info = $(this).val();
        $.ajax({
            type: 'get',
            url: '/branch/stock-out/search-customer',
            data: {
                'customer_info': customer_info
            },
            success: function (data) {
                $('#customer_show_info').html(data);
            }
        });
    });
    // End:: Customer Search for stock in


    // Begin:: Add New Customer phone number check
    $('#check_customer_phone_from_sell').keyup(function () {
        var phone = $(this).val();
        if (phone.length == 11) {
            $.ajax({
                type: 'get',
                url: '/branch/search/customer-phone',
                data: {
                    'phone': phone
                },
                success: function (data) {
                    $('#add_customer_phone_output').html(data);
                }
            });
        } else {
            $('#add_customer_phone_output').html('');
        }
    });
    // End:: Add New Customer phone number check

    // Begin:: Add New Customer phone number check
    $('#check_customer_email_from_sell').keyup(function () {
        var email = $(this).val();
        if (email.indexOf('.com') !== -1) {
            $.ajax({
                type: 'get',
                url: '/branch/search/customer-email',
                data: {
                    'email': email
                },
                success: function (data) {
                    $('#add_customer_email_output').html(data);
                }
            });
        } else {
            $('#add_customer_email_output').html('');
        }
    });
    // End:: Add New Customer phone number check


    // Category name to brand find out
    $(document).ready(function () {
        $('#catValue').on('change', function () {
            var category_id = $(this).val();
            if (category_id) {
                $.ajax({
                    type: 'get',
                    url: '/branch/sell/category-to-brand-search',
                    data: {
                        'category_id': category_id
                    },
                    success: function (data) {
                        $('#brandValue').html(data);
                        get_products();
                    }
                });
            } else {
                $('#brandValue').html('<option value="">Select Category first</option>');
                get_products();
            }
        });

        $('#brandValue').on('change', function () {
            get_products();
        });

    });
    // Category name to brand find out

    // Begin:: Customer Search for stock in
    $('#product_search').keyup(function () {
        get_products();
    });
    // End:: Customer Search for stock in

    function get_products() {
        var product_info = $('#product_search').val();
        var category_id = $('#catValue').find(":selected").val();
        var brand_id = $('#brandValue').find(":selected").val();
        $.ajax({
            type: 'get',
            url: '/branch/product-search-into-sell',
            data: {
                'product_info': product_info,
                'category_id': category_id,
                'brand_id': brand_id
            },
            beforeSend: function () {
                $('#myUL').html('<div class="col-md-12 h4 text-center pt-5">Loading....</div>');
            },
            success: function (data) {
                $('#myUL').html(data);
                $('#PAGINATE').val(1);
                $('#no_more_products').val(0);
            },
            error: function (xhr) {
                swal({
                    title: "Error",
                    text: "Error occured.please try again",
                    icon: "error",
                    button: "Ok",
                });
                var play = document.getElementById('error').play();
            },
            complete: function () {
                //alert('complete');
            },
        });

    }

    var ENDPOINT = "{{ url('/') }}";
    infinteLoadMore(1);

    $('div#result').scroll(function () {
        if ($('#no_more_products').val() == 0) {
            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                var paginate = $('#PAGINATE').val();
                paginate++;
                infinteLoadMore(paginate);
            }
        }
    });

    function infinteLoadMore(page) {
        var product_info = $('#product_search').val();
        var category_id = $('#catValue').find(":selected").val();
        var brand_id = $('#brandValue').find(":selected").val();
        $.ajax({
            type: 'get',
            datatype: "html",
            url: ENDPOINT + "/get_products_from_sell?page=" + page,
            data: {
                'product_info': product_info,
                'category_id': category_id,
                'brand_id': brand_id
            },
            beforeSend: function () {
                $('.auto-load').show();
            },
            success: function (data) {
                if (data['status'] == 'yes') {
                    $('.auto-load').hide();
                    $('#PAGINATE').val(page);
                    $("#myUL").append(data['info']);
                } else {
                    $('.auto-load').hide();
                    $("#myUL").append(data['info']);
                    $('#no_more_products').val(1);
                }
            },
            error: function (xhr) {
                swal({
                    title: "Error",
                    text: "Error occured.please try again",
                    icon: "error",
                    button: "Ok",
                });
                var play = document.getElementById('error').play();
            },
            complete: function () {
                //alert('complete');
            },
        });
    }

</script>
<!-- End::product load and search and others end -->



<script>


var pname = [];

function deleteFromArray(productName){
    const index = pname.indexOf(productName);
    if (index > -1) {
      pname.splice(index, 1);
    }
}

function myFunction(id, name, descriptionP, price,quantity, unit_name, disP, discount, discount_amount, vat_status, vat_rate) {
    var x = document.getElementsByClassName("quantity");
    if(pname.indexOf(name) !== -1){
        
        alert(name+ " Is Exist, Please Update Quantity or Price");
    }
    else{
        $('#demo').append('<tr style="background-color:#F2F2F2;color: #000;"><td style="width: 25%;" class="t_tittle" id = "t_tittle"><input type="hidden" name="pid[]" value="'+id+'"><input type="hidden" id="pname" name="pname"  class="productNameForRemove" value="'+name+'"><strong class="pd-name">'+name+'</strong><br><span style="color: green; font-size: 12px;">'+descriptionP+'</span></td><td><input style="width:117px;" type="number" value = "1" id="quantity" name="quantity[]" class = "quantity" max="'+quantity+'" step=any><br><span style="color: red; font-size: 12px;"> max = '+quantity+'</span></td><td><input style="width: 100px;" type="number" value = "'+price+'" id="price" name="price[]" class = "pricesum" step=any></td><td><input style="width: 70px;" type="number" value = "'+disP+'" id="disCP" name="disCP[]" class = "disCP" step=any><br><span style="font-size: 10px;"><input type="number" value = "'+name+'" id="ind_Dis_Price" name="ind_Dis_Price[]" class = "ind_Dis_Price" step=any placeholder="Discount Price" readonly></span></td><td><input style="width: 168px;" type="number" value = "'+name+'" id="total" name="total[]" class = "total" step=any readonly></td><td><button type="button" id="" name="" onclick="deleteRow(this)" class="btn btn-danger btn-sm remove btnSelect"><i class="fas fa-trash-alt"></i></button></td></tr>');

        pname.push(name);
        calculateSum();
        multiply();
    }
     
}

</script>

<script>
$(".addproduct").click(function(){
    	calculateSum();
		multiply();
				
$(".pricesum").on("click change paste keyup cut select", function() {
	calculateSum();
	});
});

$( document ).ready(function() {
    $(document).on("click change paste keyup cut select", "#price", function() {
        calculateSum();
		multiply();
    }); 
    
    $(document).on("click change paste keyup cut select", "#quantity", function() {
        calculateSum();
		multiply();
    }); 
    
     $(document).on("click change paste keyup cut select", "#disCP", function() {
        calculateSum();
		multiply();
    }); 
    
    
    $(document).on("click change paste keyup cut select", "#discount_Percent", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#discount_TK", function() {
        calculateSum();
        //console.log("hello discount");
    }); 
    
    $(document).on("click change paste keyup cut select", "#delivery_others_crg", function() {
        calculateSum();
    });
    
    $(document).on("click change paste keyup cut select", "#only_others_crg", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#partial_paid", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#cash_on_delivery_paid", function() {
        calculateSum();
    }); 
    
    $(document).on("click change paste keyup cut select", "#mfs_paid", function() {
        calculateSum();
    }); 
     
    
    
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
	
        // vat parcent and vat parcent rate start
        	var vatParcent = $("#vat").val();
            var vatParcentPrice = sum*vatParcent/100;
            var subtotalWithVat = sum+vatParcentPrice;
            $("#vat_price").val(vatParcentPrice.toFixed(2));
        // vat parcent and vat parcent rate End
        
        // discount taka start
          var discountTk = $("#discount_TK").val();
          $("#discount_tk_price").val(discountTk);
        // discount taka End
        
        // discount parcent Start
            var discountParcent = $('#discount_Percent').val();
            var discountParcentTk = (discountParcent * sum)/100;
            $("#discount_Percent_price").val(discountParcentTk.toFixed(2));
        // discount parcent End
        
        // This is return full tag name for check specific featcher is active or not Start
        var vatParcentForCalculation =  document.getElementById('vat');
        var discountParcentForCalculation =  document.getElementById('discount_Percent');
        var discountTKForCalculation =  document.getElementById('discount_TK');
        var delivery_charge = document.getElementById('delivery_others_crg');
        
        
        if(typeof(vatParcentForCalculation) != 'undefined' && vatParcentForCalculation != null){
            
            if(typeof(discountParcentForCalculation) != 'undefined' && discountParcentForCalculation != null){
                var calculated_sub_total = subtotalWithVat - discountParcentTk;
            }
            else if(typeof(discountTKForCalculation) != 'undefined' && discountTKForCalculation != null){
                var calculated_sub_total = subtotalWithVat - discountTk;
            }
            else{
                var calculated_sub_total = subtotalWithVat;
            }
        }
        else {
            //var calculated_sub_total = sum;
            if(typeof(discountParcentForCalculation) != 'undefined' && discountParcentForCalculation != null){
                var calculated_sub_total = sum - discountParcentTk;
            }
            else if(typeof(discountTKForCalculation) != 'undefined' && discountTKForCalculation != null){
                var calculated_sub_total = sum - discountTk;
            }
            else{
                var calculated_sub_total = sum;
            }
        }
        
        
        $("#subTotal").val(calculated_sub_total.toFixed(2));
        
        var previousDue = $('#previous_due').val();
        var sub_total_WithPreDue = parseFloat(calculated_sub_total) + parseFloat(previousDue);
        
        // Delivery Charge Start
          var delivery_online_charge = $("#delivery_others_crg").val(); // this is for find tag
          $("#delivery_others_crg_tk").val(parseFloat(delivery_online_charge));
          
        var delivery_others_crg_tk = $("#delivery_others_crg_tk").val();
        
        if(typeof(delivery_charge) != 'undefined' && delivery_charge != null){
            if(delivery_online_charge == ''){
                delivery_online_charge = 0;
            }
           var total_payable =  parseFloat(sub_total_WithPreDue) + parseFloat(delivery_online_charge); 
        }
        else {
            var total_payable =  parseFloat(sub_total_WithPreDue);
            //console.log(total_payable);
        }
        // Delivery Charge End
        
        // Others Charge Start
        var only_others_crg = document.getElementById('only_others_crg'); // this is for find tag
        var others_charge = $("#only_others_crg").val();
          $("#only_others_crg_tk").val(parseFloat(others_charge));
          
        if(typeof(only_others_crg) != 'undefined' && only_others_crg != null){
            if(others_charge == ''){
                others_charge = 0;
            }
           var total_payable =  parseFloat(total_payable) + parseFloat(others_charge); 
        }
        else {
            var total_payable =  parseFloat(total_payable);
            //console.log(total_payable);
        }
        
        // Others Charge End
        
        $("#total_payable").val(total_payable.toFixed(2));
        
        //this is for full payment paid
        $("#full_payment").val(total_payable.toFixed(2));
        
        
        //this is for partial payment
        var partial_paid_tag = document.getElementById('partial_paid');
        if(typeof(partial_paid_tag) != 'undefined'){
            $("#partial_paid_for_show").val(total_payable.toFixed(2));
            var partial_paid = $("#partial_paid").val();
            var current_due_for_partial_paid = parseFloat(total_payable) - parseFloat(partial_paid);
            $("#partial_due").val(current_due_for_partial_paid.toFixed(2));
        }
        
        //this is for Cash on delivery payment
        var cash_on_delivery_tag = document.getElementById('cash_on_delivery_paid');
        if(typeof(cash_on_delivery_tag) != 'undefined'){
            $("#COD_paid_for_show").val(total_payable.toFixed(2));
            var cash_on_de_paid = $("#cash_on_delivery_paid").val();
            var current_due_for_cashOn_paid = parseFloat(total_payable) - parseFloat(cash_on_de_paid);
            $("#cash_on_delivery_due").val(current_due_for_cashOn_paid.toFixed(2));
        }
        
        //this is for MFS payment
        var mfs_paid_tag = document.getElementById('mfs_current_due');
        if(typeof(mfs_paid_tag) != 'undefined'){
            $("#mfs_paid_for_show").val(total_payable.toFixed(2));
            var mfs_paid = $("#mfs_paid").val();
            var current_due_for_mfs_paid = parseFloat(total_payable) - parseFloat(mfs_paid);
            $("#mfs_current_due").val(current_due_for_mfs_paid);
        }
        
        
             
              
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
    //dis
    
});		

function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".pricesum");
    //var discountP = 
    
    // Declare i and qty for "for" loop
    var i, qty = quantity.length;
    // Use "for" loop to iterate through NodeList
    for (i = 0; i < qty; i++) {
        
            a = Number(document.getElementsByClassName('quantity')[i].value);
            b = Number(document.getElementsByClassName('pricesum')[i].value);
            disCP = Number(document.getElementsByClassName('disCP')[i].value);
            // Do the multiplication
            c = a*b;
            //console.log(disCP);
            discount_p_amount = c*disCP/100;
            totalPr = c-discount_p_amount;
            document.getElementsByClassName('total')[i].value=totalPr.toFixed(2);
            document.getElementsByClassName('ind_Dis_Price')[i].value = discount_p_amount.toFixed(2);
            
    }
    calculateSum();
}   

</script>

<!--This is for product delete-->
<script>

$(document).ready(function(){

    $("#mainTable").on('click', '.btnSelect', function() {
  // get the current row
  var currentRow = $(this).closest("tr");
  
   $(this).parents("tr").remove();
    
  //var col1 = currentRow.find(".pd-price").html(); // get current row 1st table cell TD value
  var col2 = currentRow.find(".pd-name").html(); // get current row 2nd table cell TD value

  
  var ProDName = col2;
  deleteFromArray(ProDName);
  calculateSum();
  multiply();
  
});
});
</script>


@endsection
