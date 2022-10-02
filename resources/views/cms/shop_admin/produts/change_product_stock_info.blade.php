
@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row">
                <div class="col-md-8 mb-4">
                    <h3><b>Change Product Stock Info</b></h3>
                    <form action="{{route('stock.change.product.stock.info.confirm')}}" method="POST" id="form_1">
                    @csrf
                    <div class="col-md-12 p-3 shadow rounded">
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label">Sales Price</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" step=any name="sales_price" value="{{$stock_info->sales_price}}" required="">
                                <small class="text-success"><b>Previous Sales Price: </b> {{number_format($stock_info->sales_price, 2)}}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label">Discount</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="cart_discount" name="discount">
                                    <option @if($stock_info->discount == 'no') selected @endif value="no">No</option>
                                    <option @if($stock_info->discount == 'flat') selected @endif value="flat">Flat</option>
                                    <option @if($stock_info->discount == 'percent') selected @endif value="percent">Percent</option>
                                </select>
                                <small class="text-success"><b>Previous Discount: </b> {{$stock_info->discount}}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputName" class="col-sm-4 col-form-label">Discount Amount</label>
                            <div class="col-sm-8">
                                <input type="number" step="any" class="form-control" value="{{$stock_info->discount_amount}}" name="discount_amount" required="">
                                <small class="text-success"><b>Previous Discount Amount: </b> {{$stock_info->discount_amount}}</small>
                            </div>
                        </div>
                        <input type="hidden" name="stock_id" id="stock_id" value="{{$stock_info->id}}">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                            <button type="button" disabled="" class="btn btn-outline-primary" style="display: none;" id="processing_button_1">Processing....</button>
                        </div>
                    </div>
                    
                    </form>
                </div>
                <div class="col-md-4 p-3">
                    <div class="lender_info rounded shadow p-3">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default bg-dark">
                                <h3 class="block-title  text-light">
                                    <i class="far fa-user-circle text-muted mr-1"></i> Product Info
                                </h3>
                            </div>
                            <div class="block-content">
                            <?php
                                $variation_name = '';
                                if($stock_info->variation_id != 0 && $stock_info->variation_id != '') {
                                    $variation_info = DB::table('variation_lists')->where(['id'=>$stock_info->variation_id])->first();
                                    $variation_name =  ' <span class="text-success">('.optional($variation_info)->list_title.')</span>';
                                }
                            ?>
                            <div class="media d-flex align-items-center push">
                                    <div class="h4 fw-bold mb-0">{{$product_info->p_name}} {!!$variation_name!!}</div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div><b>Place: </b> {{$place}}</div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div><b>Stock Qty: </b> {{$stock_info->stock}} {{$unit_type->unit_name}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

