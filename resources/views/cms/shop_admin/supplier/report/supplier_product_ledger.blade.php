@php
date_default_timezone_set("Asia/Dhaka");
 $today = date('d M, Y. h:i a');
 $array_products = array();
 $item_data = '[]';
 $currency = ENV('DEFAULT_CURRENCY');
 $total_sold_in_amount = 0;
 $total_return_in_amount = 0;
 

@endphp
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <title>{{$supplier_info->name}} Sold Products Ledger</title>
    <style>
        tr th, td{
            font-size: 15px;
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
                        <tr class="text-center"><th colspan="13"><h3>Supplier Sold Products Ledger</h3><span><b>Name: </b>{{optional($supplier_info)->name}} / <b>Phone: </b>{{optional($supplier_info)->phone}} / <b>Address: </b>{{optional($supplier_info)->address}}</span></th></tr>
                        <tr>
                            <th scope="col">SN.</th>
                            <th scope="col">Product Info</th>
                            <th scope="col">Purchase Quantity</th>
                            <th scope="col">Purchase Price</th>
                            <th scope="col">Return Quantity</th>
                            <th scope="col">Return Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $key => $order)
                            @foreach($order->invoice_products as $product)
                            <?php
                                $return_product = DB::table('product_trackers')->where(['invoice_id'=>$product->invoice_id, 'product_id'=>$product->product_id, 'product_form'=>'SUPP_R'])->get(['total_price', 'quantity']);
                            
                                $return_quantity = $return_product->sum('quantity');
                                $return_price = $return_product->sum('total_price');
                                
                                $item_data = '';
                                $item_id_list = array_column($array_products, 'pid');
                                $array_product_id = $product->product_id;
                                $product_id = $product->product_id;
                                
                                if(in_array($array_product_id, $item_id_list)){
                                    foreach($array_products as $keys => $values){
                                        if($array_products[$keys]["pid"] == $product_id){
                                            $array_products[$keys]["sold_quantity"] = $array_products[$keys]["sold_quantity"] + $product->quantity;
                                            $array_products[$keys]["sold_price"] = $array_products[$keys]["sold_price"] + $product->total_price;
                                            $array_products[$keys]["return_quantity"] = $array_products[$keys]["return_quantity"] + $return_quantity;
                                            $array_products[$keys]["return_price"] = $array_products[$keys]["return_price"] + $return_price;
                                            $item_data = json_encode($array_products);
                                        }
                                    }
                                }
                                else {
                                     $item_array = array(
                                        'pid' => $product_id,
                                        'sold_quantity' => $product->quantity,
                                        'sold_price' => $product->total_price,
                                        'return_quantity' => $return_quantity,
                                        'return_price' => $return_price,
                                    );
                                    
                                    $array_products[] = $item_array;
                                    $item_data = json_encode($array_products);
                                }
                                
                            
                            
                            ?>
                                
                                
                            
                            @endforeach
                        @endforeach
                        
                      
                        @php($array_products = json_decode($item_data, true) )
                        @foreach ($array_products as $key => $data)
                        <?php
                            $product_info = DB::table('products')->where('id', $data['pid'])->first(['p_name', 'p_unit_type']);
                            $unit_types = DB::table('unit_types')->where('id', $product_info->p_unit_type)->first(['unit_name']);
                            $key++;
                            
                            $total_sold_in_amount = $total_sold_in_amount + $data['sold_price'];
                            $total_return_in_amount = $total_return_in_amount + $data['return_price'];
                            
                        ?>
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$product_info->p_name}}</th>
                            <td>{{$data['sold_quantity']}} {{optional($unit_types)->unit_name}}</td>
                            <td>{{number_format($data['sold_price'], 2)}} {{$currency}}</td>
                            <td>{{$data['return_quantity']}} {{optional($unit_types)->unit_name}}</td>
                            <td>{{number_format($data['return_price'], 2)}} {{$currency}}</td>
                        </tr>
                        @endforeach
                        <tr class="bg-secondary text-light">
                            <td class="text-right mr-5" colspan="4"><b>Total Sold: </b> {{number_format($total_sold_in_amount, 2)}} {{$currency}}</td>
                            <td class="text-right mr-5" colspan="2"><b>Total Return: </b> {{number_format($total_return_in_amount, 2)}} {{$currency}}</td>
                            
                        </tr>
                    </tbody>
                    </table>
                   
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