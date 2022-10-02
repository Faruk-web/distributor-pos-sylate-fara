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
$godown_current_total_stock = ($product_info->G_current_stock + 0);


function calculate_stock($branch_id, $tracking_summery) {

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
    
    $branches_current_stock = 0; //$branch_stock->sum('stock');
    
    
    $calculuted_current_stock = $total_stock_in->sum('quantity') + $opening_stock->sum('quantity') -  $total_sold->sum('quantity') + $customer_return->sum('quantity') - $supplier_return->sum('quantity') - $damage->sum('quantity');
    
    $db_current_total_stock = $db_current_total_stock + $branches_current_stock;
    
    return '8989';

}


@endphp

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content mb-3">
            <div class="row mb-3">
                <div class="col-md-8 shadow p-2 rounded">
                    <h3>Adjust Stock</h3>
                    <h1 class="text-center mt-4 p-5 rounded bg-success text-light">Coming Soon</h1>
                    
                    <form action="" method="POST" class="d-none">
                        <table class="table table-bordered">
                          <thead>
                            <tr class="bg-dark text-light">
                              <th scope="col">Destination</th>
                              <th scope="col">Calculated Stock</th>
                              <th scope="col">Current Stock</th>
                              <th scope="col">Adjust Stock</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Godowns</td>
                              <td>Mark</td>
                              <td>
                                  {{$godown_current_total_stock}} {{$unit_type}}
                               </td>
                              <td>mdo</td>
                            </tr>
                            @foreach($branch_stock as $branch)
                            <tr>
                              <td>{{optional($branch->branch_info)->branch_name}}</td>
                              <td>{{calculate_stock($branch->branch_id, $tracking_summery)}}</td>
                              <td>{{optional($branch)->stock}} {{$unit_type}}</td>
                              <td>fat</td>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </form>
                    
                </div>

                <div class="col-md-4 p-2">
                    <div class="lender_info rounded shadow p-3">
                        <div class="block block-rounded">
                              <div class="block-header block-header-default bg-dark">
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
                                  
                              </div>
                          </div>
                        </div>
                    <input type="hidden" name="" id="product_id" value="{{$product_info->id}}">
                </div>
                
            </div>
            
        </div>
    </div>
</div>
<!-- END Page Content -->

<script type="text/javascript">

  

</script>
@endsection
