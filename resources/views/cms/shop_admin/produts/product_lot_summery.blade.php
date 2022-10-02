@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

@php

$unit_type = optional($product_info->unit_type_name)->unit_name;


$currency = ENV('DEFAULT_CURRENCY');



$variation_name = '';
if($purchase_line_info->variation_id != 0 || $purchase_line_info->variation_id != '') {
    $variation_info = DB::table('variation_lists')->where(['id'=>$purchase_line_info->variation_id])->first();
    $variation_name =  '<span class="fw-bold text-success">('.optional($variation_info)->list_title.')</span>';
}


@endphp

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content mb-3">
            <div class="row mb-3">
                <div class="col-md-8 shadow p-2 rounded">
                    <h4 class="mb-1"><b>Lot Number {{$purchase_line_info->lot_number}} Summery Of {{$product_info->p_name}} {!!$variation_name!!}</b></h4>
                    <small><b class="text-info">Purchase Summery: </b> <b>Purchase Price: </b> {{$purchase_line_info->purchase_price}}, <b>Sales Price: </b> {{$purchase_line_info->sales_price}}, <b>Discount: </b> {{$purchase_line_info->discount}}({{$purchase_line_info->discount_amount}}), <b>VAT: </b> {{$purchase_line_info->vat}}%, <b>Quantity: </b> {{$purchase_line_info->quantity}} {{$unit_type}}, <b>Note: </b> {{$purchase_line_info->note}}</small>
                    
                    <table class="table table-bordered mt-3">
                      <thead>
                        <tr class="text-center bg-dark text-light">
                          <th colspan="2">This Lot Tracking Summery</th>
                        </tr>
                        <tr>
                          <th>Info</th>
                          <th>Stock</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($branch_stock as $b_stock)
                        <tr>
                          <td>@if(optional($b_stock)->branch_id == 'G')Godown @else{{optional($b_stock->branch_info)->branch_name}}@endif</td>
                          <td>{{optional($b_stock)->stock}} {{$unit_type}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>

                <div class="col-md-4 p-1">
                <div class="lender_info rounded shadow p-1">
                    <div class="block block-rounded">
                          <div class="block-header block-header-default bg-primary">
                              <h3 class="block-title text-light">
                                  <i class="fa fa-coins text-light mr-1"></i> Current Stock
                              </h3>
                          </div>
                          <div class="block-content">
                              <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Info</th>
                                  <th>Stock</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($branch_stock as $b_stock)
                                <tr>
                                  <td>@if(optional($b_stock)->branch_id == 'G')Godown @else{{optional($b_stock->branch_info)->branch_name}}@endif</td>
                                  <td>{{optional($b_stock)->stock}} {{$unit_type}}</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- END Page Content -->

<script type="text/javascript">

</script>
@endsection
