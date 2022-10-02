@extends('cms.master')
@section('body_content')


<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{route('admin.product.add.confirm')}}" method="post" enctype="multipart/form-data" id="form_1">
                    @csrf
                    <div class="row">
                    <div class="col-md-12">
                            <div class="form-group">
                                <label for="example-text-input-alt"><span class="text-danger">*</span> Product Title</label>
                                <textarea name="p_name" id="" cols="30" rows="2" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-text-input-alt">Product Brand</label>
                                <select id="" name="p_brand" class="form-control select1" data-live-search="true">
                                    <option value="">-- Select Brand --</option>
                                    @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->brand_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-text-input-alt"><span class="text-danger">*</span>Product Category</label>
                                <select id="select2" name="p_cat" class="form-control select2" required data-live-search="true">
                                    <option value="">-- Select Category --</option>
                                    @foreach($categories as $categroy)
                                    <option value="{{$categroy->id}}">{{$categroy->cat_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="example-text-input-alt"><span class="text-danger">*</span>Unit Type</label>
                                <select id="" name="p_unit_type" class="form-control select3" required data-live-search="true">
                                    <option value="">-- Select Unit Type --</option>
                                    @foreach($unit_types as $type)
                                    <option value="{{$type->id}}">{{$type->unit_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-text-input-alt"><span class="text-danger">*</span>Purchase Price</label>
                                <input type="number" class="form-control " step=any id="" name="purchase_price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-text-input-alt"><span class="text-danger">*</span>Selling Price</label>
                                <input type="number" class="form-control "  step=any id="" name="selling_price" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="example-text-input-alt">Image (80 X 80)</label>
                                <input type="file" class="form-control "  onchange="preview()" name="image">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <img src="" class="rounded" id="product_image" width="80px" height="80px" alt="">
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="row p-1">
                                <div class="col-md-6 shadow rounded border p-2">
                                    <div class="form-group">
                                        <label for="example-text-input-alt"><span class="text-danger">*</span>Active Cartoon / Packet</label>
                                        <select id="" name="is_cartoon" class="form-control" onchange="javascript:select_cartoon_status(this)" required>
                                            <option value="no">no</option>
                                            <option value="yes">Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6" id="cartoon_info_div" style="display: none;">
                                    <div class="shadow rounded p-2 border">
                                        <div class="form-group">
                                            <label for="example-text-input-alt"><span class="text-danger">*</span>Cartoon / Packet Quantity</label>
                                            <input type="number" class="form-control" step=any id="cartoon_quantity" name="cartoon_quantity">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input-alt"><span class="text-danger">*</span>Cartoon Purchase Price</label>
                                            <input type="number" class="form-control" step=any id="cartoon_purchase_price" name="cartoon_purchase_price">
                                        </div>
                                        <div class="form-group">
                                            <label for="example-text-input-alt"><span class="text-danger">*</span>Cartoon Selling Price</label>
                                            <input type="number" class="form-control" step=any id="cartoon_sales_price" name="cartoon_sales_price">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row col-md-12 shadow rounded p-2 border mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Discount Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="discount_tk" value="flat" required name="discount">
                                        <label class="custom-control-label" for="discount_tk">Flat</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-info">
                                        <input type="radio" class="custom-control-input" id="discount_percent" value="percent" name="discount">
                                        <label class="custom-control-label" for="discount_percent">Percent</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="discount_no" value="no" checked name="discount">
                                        <label class="custom-control-label" for="discount_no">No</label>
                                    </div>
                                    <div class="form-group d-none" id="discount_rate_parent_div">
                                        <br>
                                        <input type="number" class="form-control" id="discount_amount" placeholder="Discount Rate" name="discount_amount" step=any>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Vat Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="vat_status_percent" value="yes" name="vat_status">
                                        <label class="custom-control-label" for="vat_status_percent">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="vat_status_no" value="no" checked name="vat_status">
                                        <label class="custom-control-label" for="vat_status_no">No</label>
                                    </div>
                                    <div class="form-group d-none" id="vat_rate_parent_div">
                                        <br>
                                        <input type="number" class="form-control" id="vat_rate" placeholder="Vat Rate" name="vat_rate" step=any>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input-alt">Description</label>
                                <textarea name="p_description" id="" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="example-text-input-alt">Barcode</label>
                                <input type="text" onchange="product_barcode()" onkeyup="product_barcode()" class="form-control"  id="product_barcode_val" name="barCode">
                            </div>
                            <div class="form-group">
                                <div class="card">
                                    <div class="card-body rounded shadow text-center" id="barcode_result">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                      
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Save</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Overview -->

</div>
<!-- END Page Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>





<script>

    function select_cartoon_status(type) {
        if(type.value == 'no') {
            $('#cartoon_info_div').hide();
            $('#cartoon_quantity').prop('required', false);
            $('#cartoon_purchase_price').prop('required', false);
            $('#cartoon_sales_price').prop('required', false);
        }
        else if(type.value == 'yes') {
            $('#cartoon_info_div').show();
            $('#cartoon_quantity').prop('required', true);
            $('#cartoon_purchase_price').prop('required', true);
            $('#cartoon_sales_price').prop('required', true);
        }
    }
    
    
    function checkVariation(list_title, list_id) {
        
        $('#variation_tbody').append('<tr id="variation_tr_'+list_id+'"><td><input type="text" class="form-control" value="'+list_title+'" name="" readonly><input type="hidden" class="form-control" value="'+list_id+'" name="variation_id[]"></td><td><input type="number" class="form-control" required placeholder="P Price" name="variation_purchase_price[]" step=any></td><td><input type="number" class="form-control"  placeholder="S Price"  required name="variation_sell_price[]" step=any></td><td><button type="button" class="btn btn-danger" onclick="delete_variation('+list_id+')" >X</button></td></tr>');
        
        $('#list_id'+list_id).prop('disabled', true);
        
        
        
    }
    
    function delete_variation(id) {
        $('#variation_tr_'+id).remove();
        $('#list_id'+id).prop('disabled', false);
    }
    






    $('input[type=radio][name=discount]').on('change', function() {
        var discount_rate_parent = document.getElementById("discount_rate_parent_div");

        if($(this).val() == 'flat' || $(this).val() == 'percent') {
            discount_rate_parent.classList.remove("d-none");
            $('#discount_amount').val('');
            $("#discount_amount").prop('required', true);
        }
        else {
            discount_rate_parent.classList.add("d-none");
            $('#discount_amount').val('');
            $("#discount_amount").prop('required', false);
        }
    });

    $('input[type=radio][name=vat_status]').on('change', function() {
        var vat_rate_div = document.getElementById("vat_rate_parent_div");

        if($(this).val() == 'yes') {
            vat_rate_div.classList.remove("d-none");
            $('#vat_rate').val('');
            $("#vat_rate").prop('required', true);
        }
        else {
            vat_rate_div.classList.add("d-none");
            $('#vat_rate').val('');
            $("#vat_rate").prop('required', false);
        }
    });

    

    
//Begin:: Check Product Barcode
function product_barcode() {
    code = $('#product_barcode_val').val();
    var code_img = document.getElementById("barcode_image");
    if(code == '') {
        //code_img.classList.add("d-none");
    }
    $.ajax({
        url: '/admin/check-product-barcode',
        method:"GET",
        data:{ 
            code:code,
        },
        success: function (response) {
          if(response['exist'] == 'yes') {
              
            $("#barcode_result").html('<img id="barcode_image" class="" src="{{asset('barcode/barcode.php')}}?codetype=Code128&size=40&text='+code+'&print=true"/>');
          }
          else if(response['exist'] == 'no'){
            $("#barcode_result").html('<h4 class="text-danger"><b>Sorry this code is used in <span class="text-dark">'+response['product']+'</span></b></h4>');
          }
        }
      });
}
//End:: Check Product Barcode

//Begin:: product image preview
function preview() {
    product_image.src=URL.createObjectURL(event.target.files[0]);
}
//End:: product image preview

$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});
 
</script>




@endsection
