@php
$stock = 0;
$total = 0;

function brand_info($id) {
    $brand_info = DB::table('brands')->where('id', $id)->first(['brand_name']);
    return optional($brand_info)->brand_name;
}

function unit_type_info($id) {
    $unit_info = DB::table('unit_types')->where('id', $id)->first(['unit_name']);
    return optional($unit_info)->unit_name;
}


@endphp


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="" crossorigin="anonymous">

    <title>{{date("d M, Y h:i:s a")}}, Products Summery of {{$updated_place_name}}</title>
  </head>
  <body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12 shadow rounded p-5">
                    <div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr><th colspan="6" class="text-center"><h5>{{date("d M, Y h:i:s a")}}, Products Summery of {{$updated_place_name}} With Brand: {{$brand_title}}</h5></th></tr>
                                    <tr>
                                        <th width="5%">SI.</th>
                                        <th width="50%">Product Info</th>
                                        <th class="text-right">Stock</th>
                                        <th class="text-right">Purchase Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products->chunk(100) as $product)
                                        @foreach($product as $key => $product)
                                        <?php
                                            $key++;
                                            $sum = ($product->stock + 0) * ($product->purchase_price + 0);
                                            $total = $total + $sum;
                                            $variation_name = '';
                                            if($product->variation_id != 0 && $product->variation_id != '') {
                                                $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                                                $variation_name =  '<span class="text-success">('.optional($variation_info)->list_title.')</span>';
                                            }
                                        ?>
                                        
                                            <tr>
                                                <td>{{$key}}</td>
                                                <td>
                                                    {{$product->p_name}} {!!$variation_name!!}<br><small class='text-primary'><b>Lot: </b>{{$product->lot_number}}, <b>Sales Price: </b>{{number_format($product->sales_price, 2)}}TK, <b>Discount: </b>{{$product->discount}}({{$product->discount_amount}}), <b>VAT: </b>{{$product->vat}}%"
                                                </td>
                                                <td class="text-right">{{ $product->stock }} {{unit_type_info(optional($product)->p_unit_type)}}</td>
                                                <td class="text-right">{{number_format($product->purchase_price, 2)}}</td>
                                                <td class="text-right">{{number_format($sum, 2)}}</td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                    <tr>
                                        <td style="text-align: right;" colspan="6"><h2>Total = {{number_format($total, 2)}}</h2></td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

