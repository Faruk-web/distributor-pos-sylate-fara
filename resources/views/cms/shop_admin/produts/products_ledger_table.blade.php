@php
date_default_timezone_set("Asia/Dhaka");
 $today = date('d M, Y. h:i a');
 $total_profit = 0;
@endphp
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <title>{{$today}} Products Ledger</title>
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
                        <tr class="text-center"><th colspan="13"><h3>{{$today}} Products Ledger</h3>Showing {{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} Products</th></tr>
                        <tr>
                            <th scope="col">SN.</th>
                            <th width="15%" scope="col">Product Info</th>
                            <th scope="col">Purchase</th>
                            <th scope="col">Sell</th>
                            <th scope="col">Total Damage</th>
                            <th scope="col">Closing Stock(CS)</th>
                            <th scope="col">Avg P/S Price</th>
                            <th scope="col">Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $key => $product)
                        @php( $tracking_summery = DB::table('product_trackers')->where('product_id', $product->id)->get(['total_price', 'quantity', 'product_form', 'total_purchase_price']))
                        @php($currency = 'TK')
                        <?php

                            $unit_type = optional($product->unit_type_name)->unit_name;
                            
                            $total_stock_in = $tracking_summery->filter(function($item) {
                                return $item->product_form == 'SUPP_TO_G' || $item->product_form == 'SUPP_TO_B' || $item->product_form == 'OWS';
                            });
                            
                            
                            $godown_stock_in = $tracking_summery->filter(function($item) {
                                return $item->product_form == 'SUPP_TO_G';
                            });
                            
                            $godown_stock_out = $tracking_summery->filter(function($item) {
                                return $item->product_form == 'G';
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
                            
                            $own_stock = $tracking_summery->filter(function($item) {
                                return $item->product_form == 'OWS';
                            });
                            
                            
                            $branches_current_stock = DB::table('product_stocks')->where('pid', $product->id)->where('branch_id', '!=', 'G')->sum('stock');
                            $godown_current_stock = DB::table('product_stocks')->where('pid', $product->id)->where('branch_id', '=', 'G')->sum('stock');
                            $total_stock_in_price = $total_stock_in->sum('total_purchase_price') + $opening_stock->sum('total_purchase_price');
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
                            
                            
                            
                            $actual_purchase_in_qty = ( $opening_stock->sum('quantity') + $own_stock->sum('quantity') + $total_stock_in->sum('quantity') ) - $supplier_return->sum('quantity');
                            
                            $actual_purchase_in_price = ( $opening_stock->sum('total_price') + $own_stock->sum('total_price') + $total_stock_in->sum('total_price') ) - $supplier_return->sum('total_price');
                            
                            if($actual_purchase_in_price != 0 || $actual_purchase_in_qty != 0) {
                                $avg_purchase_price = $actual_purchase_in_price / $actual_purchase_in_qty;
                            }
                            else {
                                $avg_purchase_price = 0;
                            }
                            
                           $actual_sell = $total_sold->sum('quantity') - $customer_return->sum('quantity');
                            
                           $profit = (($actual_sell * $avg_selling_price) - ( $actual_sell * $avg_purchase_price )) - $damage->sum('total_price');
                           $total_profit = $total_profit + $profit;
                            
                        ?>
                        <tr>
                            <td>{{$products->firstItem() + $key}}</td>
                            <td>
                                <h5>{{$product->p_name}}</h5><b>Brand:</b> {{optional($product->brand_info)->brand_name}}
                            </th>
                            <td>
                                <b>Opening Stock: </b>{{$opening_stock->sum('quantity')}} {{$unit_type}} [ {{number_format($opening_stock->sum('total_price'), 2)}} {{$currency}} ]<hr>
                                <b>Own Stock: </b>{{$own_stock->sum('quantity')}} {{$unit_type}} [ {{number_format($own_stock->sum('total_price'), 2)}} {{$currency}} ]<hr>
                                <b>Purchase: </b>{{$total_stock_in->sum('quantity')}} {{$unit_type}} [ {{number_format($total_stock_in->sum('total_price'), 2)}} {{$currency}} ]<hr>
                                <b>Pur Return: </b>{{$supplier_return->sum('quantity')}} {{$unit_type}} [ {{number_format($supplier_return->sum('total_price'), 2)}} {{$currency}} ]
                            </td>
                            <td>
                                <b>Sell: </b>{{$total_sold->sum('quantity')}} {{$unit_type}} [ {{number_format($total_sold->sum('total_price'), 2)}} {{$currency}} ]<hr>
                                <b>Sell Return: </b>{{$customer_return->sum('quantity')}} {{$unit_type}} [ {{number_format($customer_return->sum('total_price'), 2)}} {{$currency}} ] <hr>
                                <b>Actual Sell: </b>{{$total_sold->sum('quantity') - $customer_return->sum('quantity')}} {{$unit_type}} [ {{number_format($total_sold->sum('total_price') - $customer_return->sum('total_price'), 2)}} {{$currency}} ]
                                
                            </td>
                            <td>{{$damage->sum('quantity')}} {{$unit_type}}<hr>{{number_format($damage->sum('total_price'), 2)}} {{$currency}}</td>
                            <td>
                                <b>CS: </b>{{$godown_current_stock + $branches_current_stock}} {{$unit_type}}<hr>
                                <b>G stock: </b>{{$godown_current_stock}} {{$unit_type}}<hr>
                                <b>Branch stock: </b>{{$branches_current_stock}} {{$unit_type}}
                            </td>
                            
                            <td>
                                <span>
                                    <b>Avg PP: </b> {{number_format($avg_purchase_price, 2)}}<hr>
                                    <b>Avg SP: </b> @if(!is_null($avg_selling_price)) {{number_format($avg_selling_price, 2)}} @else Have No Sales! @endif
                                </span>
                            </td>
                            <td>@if(!is_null($profit)) {{number_format($profit, 2)}} {{$currency}} @else Have No Sales! @endif</td>
                        </tr>
                        @endforeach
                        <tr class="text-right">
                            <td colspan="8"><h4>{{$products->firstItem()}} to {{$products->lastItem()}} of {{$products->total()}} Products Total Profit = {{number_format($total_profit, 2)}} {{$currency}}</h4></td>
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
  </body>
</html>