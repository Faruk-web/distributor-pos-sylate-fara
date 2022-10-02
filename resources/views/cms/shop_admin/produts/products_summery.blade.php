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


$db_current_total_stock = 0;

$total_stock_in = $tracking_summery->filter(function($item) {
  return $item->product_form == 'SUPP_TO_G' || $item->product_form == 'SUPP_TO_B' || $item->product_form == 'OWS';
});



$total_sold = $tracking_summery->filter(function($item) {
  return $item->product_form == 'S';
});

$customer_return = $tracking_summery->filter(function($item) {
  return $item->product_form == 'R';
});

$supplier_return = $tracking_summery->filter(function($item) {
  return $item->product_form == 'SUPP_R';
});

$damage = $tracking_summery->filter(function($item) {
  return $item->product_form == 'DM';
});

$opening_stock = $tracking_summery->filter(function($item) {
  return $item->product_form == 'OP';
});

$branches_current_stock = $branch_stock->sum('stock');

$total_stock_in_price = $total_stock_in->sum('total_price') + $opening_stock->sum('total_price');
$total_stock_in_qty = $total_stock_in->sum('quantity') + $opening_stock->sum('quantity');

if($total_stock_in_price != 0 || $total_stock_in_price != 0) {
  $avg_purchase_price = $total_stock_in_price / $total_stock_in_qty;
}
else {
  $avg_purchase_price = 0;
}

$total_stock_out_in_price = $total_sold->sum('total_price');
$total_stock_out_in_quantity = $total_sold->sum('quantity');

if($total_stock_out_in_price != 0 || $total_stock_out_in_quantity != 0) {
  $avg_selling_price = $total_stock_out_in_price / $total_stock_out_in_quantity;
}
else {
  $avg_selling_price = 0;
}


$calculuted_current_stock = $total_stock_in->sum('quantity') + $opening_stock->sum('quantity') -  $total_sold->sum('quantity') + $customer_return->sum('quantity') - $supplier_return->sum('quantity') - $damage->sum('quantity');


@endphp

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content mb-3">
            <div class="row mb-3">
                <div class="col-md-7 shadow p-2 rounded">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td align="center" colspan="3"><h4><b>Summery</b></h4></td>
                            </tr>
                          <tr>
                                <td><b>Opening Stock</b></td>
                                <td>{{$opening_stock->sum('quantity')}} {{$unit_type}}</td>
                                <td>{{number_format($opening_stock->sum('total_price'), 2)}} {{$currency}}</td>
                            </tr>
                            <tr>
                                <td><b>Total Stock In</b></td>
                                <td>{{$total_stock_in->sum('quantity')}} {{$unit_type}}</td>
                                <td>{{number_format($total_stock_in->sum('total_price'), 2)}} {{$currency}}</td>
                            </tr>
                            
                            <tr>
                                <td><b>Total Sold</b></td>
                                <td>{{$total_sold->sum('quantity')}} {{$unit_type}}</td>
                                <td>{{number_format($total_sold->sum('total_price'), 2)}} {{$currency}}</td>
                            </tr>
                            
                            <tr>
                                <td><b>Total Customer Return</b></td>
                                <td>{{$customer_return->sum('quantity')}} {{$unit_type}}</td>
                                <td>{{number_format($customer_return->sum('total_price'), 2)}} {{$currency}}</td>
                            </tr>
                            <tr>
                                <td><b>Total Supplier Return</b></td>
                                <td>{{$supplier_return->sum('quantity')}} {{$unit_type}}</td>
                                <td>{{number_format($supplier_return->sum('total_price'), 2)}} {{$currency}}</td>
                            </tr>
                            <tr>
                                <td><b>Total Damage</b></td>
                                <td>{{$damage->sum('quantity')}} {{$unit_type}}</td>
                                <td>{{number_format($damage->sum('total_price'), 2)}} {{$currency}}</td>
                            </tr>
                            <tr>
                                <td><b>Current Stock</b></td>
                                <td align="center" colspan="2">{{$branches_current_stock}} {{$unit_type}} <i class="fa fa-question-circle  btn btn-rounded btn-outline-success" data-toggle="modal" data-target="#branches_product_stock_info"> Info</i></td>
                            </tr>
                            {{--
                            <tr>
                                <td><b>Godown Current Stock</b></td>
                                <td align="center" colspan="2">{{$product_info->G_current_stock}} {{$unit_type}}</td>
                            </tr>
                            --}}
                        </tbody>
                    </table>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="branches_product_stock_info" tabindex="-1" role="dialog" aria-labelledby="branches_product_stock_info" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-dark">
                            <h5 class="modal-title text-light" id="branches_product_stock_info">Godown / Shop Current Stock</h5>
                            <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Branch Name</th>
                                  <th>Stock</th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($branch_stock as $b_stock)
                                <?php
                                    $variation_name = '';
                                    if($b_stock->variation_id != 0 || $b_stock->variation_id != '') {
                                        $variation_info = DB::table('variation_lists')->where(['id'=>$b_stock->variation_id])->first();
                                        $variation_name =  ' ('.optional($variation_info)->list_title.')';
                                    }
                                ?>
                                <tr>
                                  <td>@if(optional($b_stock)->branch_id == 'G')Godown @else{{optional($b_stock->branch_info)->branch_name}}@endif <br><small class="text-success"><b>Variation: {{$variation_name}}</b></small></td>
                                  <td>{{optional($b_stock)->stock}} {{$unit_type}}</td>
                                </tr>
                                @php( $db_current_total_stock = $db_current_total_stock + optional($b_stock)->stock )
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    
                    <div class="shadow runded p-2">
                        <table class="table table-bordered">
                          <thead>
                            <tr class="bg-dark">
                              <th colspan="2" class="text-light text-center">Current Stock Proof</th>
                            </tr>
                            <tr>
                              <th scope="col">Calculated Stock</th>
                              <th scope="col">Database Stock</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>{{ $calculuted_current_stock }} {{$unit_type}}</td>
                              <td>{{$db_current_total_stock}} {{$unit_type}}</td>
                            </tr>
                            <tr class="bg-dark">
                                @if(number_format($calculuted_current_stock, 2) == number_format($db_current_total_stock, 2))
                                    <td colspan="2" class="text-success text-center bg-light h4 fw-bold shadow">Calculation Matched ✅</td>
                                @elseif($calculuted_current_stock != $db_current_total_stock)
                                    <td colspan="2" class="text-danger text-center bg-light h4">Calculation isn't Matched <a href="{{route('admin.adjust.product.stock', [ 'id' => $product_info->id])}}" class="btn btn-success btn-sm btn-rounded">Adjust</a></td>
                                @endif
                            </tr>
                          </tbody>
                        </table>
                    </div>
                    
                    
                </div>

                
                
                <div class="col-md-5 p-1">
                <div class="lender_info rounded shadow p-3">
                    <div class="block block-rounded">
                          <div class="block-header block-header-default bg-success">
                              <h3 class="block-title text-light">
                                  <i class="fa fa-coins text-light mr-1"></i> Product Info
                              </h3>
                          </div>
                          <div class="block-content">
                              <div class="media d-flex align-items-center push">
                                  <div class="mr-1"><b><i class="fa-solid fa-b bg-muted text-light pt-1 pb-1 pl-2 pr-2 rounded">P</i></b> <span id="lender_name">{{$product_info->p_name}}</span></div>
                              </div>
                              <div class="media d-flex align-items-center push">
                                  <div class="mr-1"><b><i class="fa-solid fa-b bg-muted text-light pt-1 pb-1 pl-2 pr-2 rounded">B</i> </b> <span id="comapany_name">{{optional($product_info->brand_info)->brand_name}}</span></div>
                              </div>
                              {{--
                              <div class="media d-flex align-items-center push">
                                  <div class="mr-1"><b>Purchase Price: </b> <span id="">{{number_format($product_info->purchase_price, 2)}}</span></div>
                              </div>
                              <div class="media d-flex align-items-center push">
                                  <div class="mr-1"><b>Sales Price: </b> <span id="">{{number_format($product_info->selling_price, 2)}}</span></div>
                              </div>
                              --}}
                              
                              @if($product_info->is_variable == 'variable')
                              <table class="table table-hover table-bordered">
                              <thead>
                                <tr>
                                  <th width="20%" scope="col">Variations</th>
                                  <th scope="col">P Price</th>
                                  <th scope="col">S Price</th>
                                </tr>
                              </thead>
                              <tbody id="variation_tbody">
                                 @foreach(App\Models\ProductWithVariation::Where('pid', optional($product_info)->id)->get() as $variation)
                                <tr>
                                    <td>{{optional($variation->variation_list_info)->list_title}}</td>
                                    <td>{{optional($variation)->purchase_price}} Tk</td>
                                    <td>{{optional($variation)->selling_price}} TK</td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                              @else
                              <div class="text-center"><h4>Simple Product</h4></div>
                              @endif
                          </div>
                      </div>
                    </div>

                    <div class="rounded shadow p-3 mt-2">
                    <div class="block block-rounded">
                          <div class="block-header block-header-default bg-dark text-center">
                              <h3 class="block-title text-light">ANALYZE</h3>
                          </div>
                          <div class="block-content">
                          <div class="media d-flex align-items-center push shadow rounded p-2">
                                <div class="mr-3">
                                    <a class="item item-rounded bg-info" href="javascript:void(0)">
                                        <i class="si si-social-dropbox fa-2x text-white-75"></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="font-w600">Average Purchase Price</div>
                                    <div class="font-size-sm">{{number_format($avg_purchase_price, 2)}} {{$currency}}</div>
                                </div>
                            </div>
                              <div class="media d-flex align-items-center push shadow rounded p-2">
                                <div class="mr-3">
                                    <a class="item item-rounded bg-info" href="javascript:void(0)">
                                        <i class="si si-rocket fa-2x text-white-75"></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="font-w600">Average Sales Price</div>
                                    <div class="font-size-sm">{{number_format($avg_selling_price, 2)}} {{$currency}}</div>
                                </div>
                            </div>
                            <div class="media d-flex align-items-center push shadow rounded p-2">
                                <div class="mr-3">
                                    <a class="item item-rounded bg-info" href="javascript:void(0)">
                                        <i class="fa fa-money-check-alt fa-2x text-white-75"></i>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="font-w600">Profit in per {{$unit_type}}</div>
                                    <div class="font-size-sm">@if($avg_selling_price != 0) {{number_format($avg_selling_price - $avg_purchase_price, 2)}} {{$currency}} @else Have No Sales! @endif</div>
                                </div>
                            </div>
                          </div>
                      </div>
                    </div>

                    <input type="hidden" name="" id="product_id" value="{{$product_info->id}}">
                </div>
                
            </div>
            
            <div class="table-responsive shadow p-2 rounded">
              <h4><b>Lot Tracking History =></b></h4>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Lot Num</th>
                            <th>Qty({{$unit_type}})</th>
                            <th>Place</th>
                            <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            
            <div class="table-responsive shadow p-2 rounded mt-4">
              <h4><b>Tracking History =></b></h4>
                <table class="table table-bordered summery-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Quantity( {{$unit_type}} )</th>
                            <th>IN or OUT</th>
                            <th>Summery</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<script type="text/javascript">

  $(function () {
    var product_id = $('#product_id').val();
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            url: "/admin/prodcut-summery-data/"+product_id
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'lot_number', name: 'lot_number'},
            {data: 'quantity', name: 'quantity'},
            {data: 'place', name: 'place'},
            {data: 'note', name: 'note'},
            {data: 'action', name: 'action'},
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
    
  });
  
  
  $(function () {
    var product_id = $('#product_id').val();
    var table = $('.summery-table').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            url: "/admin/prodcut-summery-data-from-trackers/"+product_id
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'quantity', name: 'quantity'},
            {data: 'in_or_out', name: 'in_or_out'},
            {data: 'summery', name: 'summery'},
            
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
  });


</script>
@endsection
