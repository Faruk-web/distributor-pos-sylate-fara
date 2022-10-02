@php
date_default_timezone_set("Asia/Dhaka");
 $today = date('d M, Y. h:i a');
 $total_profit = 0;
 $i = 0;
@endphp
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <title>{{$today}} Godown Products in out Ledger</title>
    <style>
        tr th, td{
            font-size: 12px;
        }
        hr {
            margin-top: 2px !important;
            margin-bottom: 2px !important;
            border-top: 1px dotted #000000;
        }
    </style>
  </head>
  
  <body>
      <section>
          <div class="container-fluid">
              <div class="row">
                  <div class="col-md-12">
                  <table class="table table-bordered" style="margin-top: 20px; margin-bottom: 20px;">
                    <thead>
                        <tr class="text-center">
                            <th colspan="13">
                            <div class="row p-2">
                                <div class="col-md-8"><h3>{{$today}} Godown Products in out Ledger</h3>Showing {{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} Products</div>
                                <div class="col-md-4 text-right">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" onchange="change_details_view()" id="exampleCheck1" name="view_details">
                                        <label class="form-check-label" for="exampleCheck1">View Summery</label>
                                    </div>
                                </div>
                            </div>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col">SN.</th>
                            <th width="25%" scope="col">Product Info</th>
                            <th scope="col">Stock In into Godown</th>
                            <th scope="col">Stock Out From Godown</th>
                            <th scope="col">Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <?php
                            $unit_type = optional($product->unit_type_name)->unit_name;
                            $godown_current_stock = DB::table('product_stocks')->where(['pid'=>$product->id, 'branch_id'=>'G'])->sum('stock');
                            
                            $tracking_summery = DB::table('product_trackers')->where('product_id', $product->id)->Where(function($query) {
                                                    $query->where('product_form', 'SUPP_TO_G')
                                                          ->orWhere('product_form', 'G')
                                                          ->orWhere('product_form', 'DM')
                                                          ->orWhere('product_form', 'SUPP_R');
                                                })->get();
                                                
                            //$total_stock_in = $product_trackers->where('product_form', 'SUPP_TO_G')->count('quantity');
                            
                            $stock_in = $tracking_summery->filter(function($item) {
                                                return $item->product_form == 'SUPP_TO_G';
                                            });
                            $total_stock_in = $stock_in->sum('quantity');
                            
                            $direct_stock_out = $tracking_summery->filter(function($item) {
                                                return $item->product_form == 'G';
                                            });
                                            
                            $damage_stock_out = $tracking_summery->filter(function($item) {
                                                return ($item->product_form == 'DM') && ($item->invoice_id == 'G');
                                            });
                                            
                            $supplier_return_stock_out = $tracking_summery->filter(function($item) {
                                                return ($item->product_form == 'SUPP_R') && ($item->branch_id == 'g');
                                            });
                                            
                            $total_direct_stock_out = $direct_stock_out->sum('quantity');
                            $total_damage_stock_out = $damage_stock_out->sum('quantity');
                            $total_supplier_return_stock_out = $supplier_return_stock_out->sum('quantity');
                            
                                            
                            
                            ?>
                            @if($total_stock_in > 0)
                            @php($i++)

                            <tr>
                                <td>{{$i}}</td>
                                <td><p><span class="h4">{{$product->p_name}}</span></p></td>
                                <td width="30%" ><span class="text-success h4"><b>{{$total_stock_in}} {{$unit_type}}</b></span><br>
                                    <table class="table table-sm ledger_details mt-3"  style="display: none;">
                                          <thead>
                                            <tr>
                                              <th>Date</th>
                                              <th>Qty</th>
                                              <th>Invoice</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($stock_in as $in)
                                             <tr>
                                                <td>{{date('d-m-Y', strtotime($in->created_at))}}</td>
                                                <td>{{$in->quantity}} {{$unit_type}}</td>
                                                <td>{{str_replace('_', '/', $in->invoice_id)}}</td>
                                             </tr>
                                          @endforeach
                                          </tbody>
                                    </table>
                                </td>
                                <td width="30%" ><span class="text-danger h4"><b>{{($total_direct_stock_out + $total_damage_stock_out + $total_supplier_return_stock_out)}} {{$unit_type}}</b></span><br><small>Branch Stock out: {{$total_direct_stock_out}}<br>Damage Stock out: {{$total_damage_stock_out}}<br>Supplier Return Stock out: {{$total_supplier_return_stock_out}}</small>
                                    @if($total_direct_stock_out > 0)
                                        <table class="table table-sm ledger_details mt-3"  style="display: none;">
                                          <thead>
                                            <tr>
                                              <th class="text-center" colspan="3">Stock Out Into Branch</th>
                                            </tr>
                                            <tr>
                                              <th>Date</th>
                                              <th>Qty</th>
                                              <th>Invoice</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($direct_stock_out as $stock_out)
                                             <tr>
                                                    <td>{{date('d-m-Y', strtotime($stock_out->created_at))}}</td>
                                                    <td>{{$stock_out->quantity}} {{$unit_type}}</td>
                                                    <td>{{str_replace('_', '/', $stock_out->invoice_id)}}</td>
                                             </tr>
                                          @endforeach
                                          </tbody>
                                    </table>
                                    @endif
                                    
                                    @if($total_damage_stock_out > 0)
                                        <table class="table table-sm ledger_details mt-3" style="display: none;">
                                          <thead>
                                            <tr>
                                              <th class="text-center" colspan="3">Damage Stock Out</th>
                                            </tr>
                                            <tr>
                                              <th>Date</th>
                                              <th>Qty</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($damage_stock_out as $stock_out)
                                             <tr>
                                                    <td>{{date('d-m-Y', strtotime($stock_out->created_at))}}</td>
                                                    <td>{{$stock_out->quantity}} {{$unit_type}}</td>
                                             </tr>
                                          @endforeach
                                          </tbody>
                                    </table>
                                    @endif
                                    
                                    @if($total_supplier_return_stock_out > 0)
                                        <table class="table table-sm ledger_details mt-3"  style="display: none;">
                                          <thead>
                                            <tr>
                                              <th class="text-center" colspan="3">Supplier Return Stock Out</th>
                                            </tr>
                                            <tr>
                                              <th>Date</th>
                                              <th>Qty</th>
                                              <th>Invoice</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                          @foreach($supplier_return_stock_out as $stock_out)
                                             <tr>
                                                    <td>{{date('d-m-Y', strtotime($stock_out->created_at))}}</td>
                                                    <td>{{$stock_out->quantity}} {{$unit_type}}</td>
                                                    <td>{{str_replace('_', '/', $stock_out->invoice_id)}}</td>
                                             </tr>
                                          @endforeach
                                          </tbody>
                                    </table>
                                    @endif
                                    
                                </td>
                                <td><h4>{{$godown_current_stock}} {{$unit_type}}</h4></td>
                            </tr>
                            @endif
                        @endforeach
                        <tr class="text-right">
                            <td colspan="8"><h4>{{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}}</h4></td>
                        </tr>
                        
                    </tbody>
                    </table>
                    <div class="text-center mt-1"><p>Showing {{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} Products</p></div>
                        <div class="card w-100 text-center rounded-xxl border-0 p-1 mb-3 mt-2"><div class="snippet ms-auto me-auto" data-title=".dot-typing">
                            {{$products->links()}}
                        </div>
                    </div>
                  </div>
              </div>
          </div>
      </section>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"  crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"  crossorigin="anonymous"></script>
    
    
<script type="text/javascript">
function change_details_view() {
    if($('input[name="view_details"]').is(':checked')) {
      $('.ledger_details').show();
    }
    else {
     $('.ledger_details').hide();
    }
}

</script>
  </body>
</html>