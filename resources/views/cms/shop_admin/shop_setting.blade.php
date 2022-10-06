@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-8 col-xl-8 col-md-8">
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{route('admin.set.shop_setting')}}" method="post" enctype="multipart/form-data" id="form_1">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="example-text-input-alt"><span class="text-danger">*</span>Business / Shop Name</label>
                            <input type="text" class="form-control " value="{{optional($shop_info)->shop_name}}" id="" name="shop_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="example-text-input-alt"><span class="text-danger">*</span>Business / Shop Email</label>
                            <input type="email" class="form-control " value="{{optional($shop_info)->email}}" id="" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="example-text-input-alt"><span class="text-danger">*</span>Business / Shop Phone</label>
                            <input type="text" class="form-control " value="{{optional($shop_info)->phone}}" id="" name="phone" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="example-text-input-alt"><span class="text-danger">*</span>Business / Address</label>
                            <input type="text" class="form-control " value="{{optional($shop_info)->address}}" id="" name="address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="example-text-input-alt">Business / Shop Website</label>
                            <input type="text" class="form-control " value="{{optional($shop_info)->shop_website}}" id="" name="shop_website">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="example-text-input-alt">Business / Shop Logo</label>
                            <input type="file" class="form-control " id="" name="shop_logo">
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label class="d-block"><span class="text-danger">*</span>Vat / Tax Type</label>
                                <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                    <input type="radio" @if(optional($shop_info)->vat_type == 'individual_product_vat') checked @endif class="custom-control-input" id="products_individual_vat" value="individual_product_vat" required name="vat_type">
                                    <label class="custom-control-label" for="products_individual_vat">Products Individual Vat</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-control-primary">
                                    <input type="radio" @if(optional($shop_info)->vat_type == 'total_vat') checked @endif class="custom-control-input" id="online_sell_status_no" value="total_vat" name="vat_type">
                                    <label class="custom-control-label" for="online_sell_status_no">Total Vat</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                    <input type="radio" @if(optional($shop_info)->vat_type == 'never_used') checked @endif class="custom-control-input" id="never_used_vat" value="never_used" name="vat_type">
                                    <label class="custom-control-label" for="never_used_vat">Never Used Vat</label>
                                </div>
                            </div>
                        </div>
                            
                            <div class="form-group col-md-12 d-none">
                                <label for="example-text-input">Set Default Branch To Sell From Admin Wing.</label>
                                <select class="form-control" name="default_branch_id_for_sell">
                                    <option value="">Select Branch / Shop</option>
                                    @foreach($branches as $branch)
                                    <option @if($branch->id == optional($shop_info)->default_branch_id_for_sell) selected class="bg-success" @endif value="{{$branch->id}}">{{$branch->branch_name}} [{{$branch->branch_address}}]</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        <div class="form-group col-md-12 text-right">
                            <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Save</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                        </div>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

            <div class="col-sm-4 col-xl-4 col-md-4">
                <div class="card shadow rounded">
                    <img class="card-img-top" src="{{asset(optional($shop_info)->shop_logo)}}">
                    <hr>
                    <div class="card-body">
                        <p>
                            <b>Start Date: </b>{{date('d M, Y', strtotime(optional($shop_info)->start_date))}}<br>
                            <b>Business Code: </b>{{optional($shop_info)->shop_code}}<br>
                            
                        </p>
                        <!--<div class="remaining shadow rounded bg-light">Remaining <span>615</span> Days.</div><br>-->
                    </div>
                </div>
                <br>
                {{--
                <div class="card shadow rounded p-2">
                <form action="{{route('admin.set.shop_setting.customer.point')}}" method="post" enctype="multipart/form-data" id="form_2">
                    @csrf
                    <div class="form-group">
                        <label for="example-text-input">Do You Use Customer Points?</label>
                        <select class="form-control customer_points" name="is_active_customer_points" required id="customer_points">
                            <option  @if(optional($shop_info)->is_active_customer_points == 'no') selected class="bg-success text-light" @endif value="no">No</option>
                            <option  @if(optional($shop_info)->is_active_customer_points == 'yes') selected class="bg-success text-light" @endif  value="yes">Yes</option>
                        </select>
                    </div>

                    <div class="form-group" id="customer_points_value_div" @if(optional($shop_info)->is_active_customer_points == 'no' || optional($shop_info)->is_active_customer_points == '') style="display: none;" @endif>
                        <div class="form-group shadow p-3 rounded">
                            <div class="row">
                            <h6 class="element-header col-md-12" id="layout_title"><span class="text-danger">*</span> Point Earn Rate</h6>
                                <div class="col-sm-5">
                                    <input class="form-control NumberOnly" name="point_earn_rate" id="point_earn_rate" step=any type="number" value="{{optional($shop_info)->point_earn_rate}}">
                                </div>
                                <div class="col-sm-7 text-left">
                                    <p style="line-height: 29px;"><b>BDT TK</b> = 1 Point</p>
                                </div>
                            </div>
                            <small class="text-success fw-bold">Example: 20 টাকা সমান 1 পয়েন্ট</small>
                        </div>
                        <div class="form-group shadow p-2 rounded">
                            <div class="row">
                            <h6 class="element-header col-md-12" id="layout_title"><span class="text-danger">*</span> Point Redeem Rate</h6>
                                <div class="col-sm-4 text-center">
                                    <p style="line-height: 29px;"><b>1 Point</b> =</p>
                                </div>
                                <div class="col-sm-4">
                                    <input class="form-control NumberOnly" name="point_redeem_rate" id="point_redeem_rate" step=any type="number" value="{{optional($shop_info)->point_redeem_rate}}">
                                </div>
                                <div class="col-sm-4 text-left">
                                    <p style="line-height: 29px;">BDT TK</p>
                                </div>
                            </div>
                            <small class="text-success fw-bold">Example: ১ পয়েন্ট সমান ০.১ টাকা</small>
                        </div>
                        
                        <div class="form-group shadow p-2 rounded">
                            <div class="row">
                            <h6 class="element-header col-md-12" id="layout_title"><span class="text-danger">*</span> Minimum Purchase To Get Point</h6>
                                <div class="col-sm-8">
                                    <input class="form-control NumberOnly" name="minimum_purchase_to_get_point" step=any type="number" value="{{optional($shop_info)->minimum_purchase_to_get_point}}">
                                </div>
                                <div class="col-sm-4 text-left">
                                    <p style="line-height: 29px;">BDT TK</p>
                                </div>
                            </div>
                            <small class="text-danger">সর্বনিম্ন কত টাকার প্রোডাক্ট কিনলে পয়েন্ট পাবে</small>
                            <small class="text-success fw-bold">Example: 50 TK</small>
                        </div>
                        
                    </div>
                    <div class="text-right">
                        <button type="submit" class="btn btn-success" onclick="form_submit(2)" id="submit_button_2">Save</button>
                        <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_2">Processing....</button>
                    </div>
                    </form>
                </div>
                --}}
        </div>
    </div>
    <!-- END Overview -->

</div>
<!-- END Page Content -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
    $('select.customer_points').on('change', function() {
        var value = this.value;
        if(value == 'no') {
            $("#customer_points_value_div").hide();
            $('#point_redeem_rate').prop('required', false);
            $('#point_earn_rate').prop('required', false);

        }
        else if(value == 'yes') {
            $("#customer_points_value_div").show();
            $('#point_redeem_rate').prop('required', true);
            $('#point_earn_rate').prop('required', true);
        }
    });
</script>


@endsection
