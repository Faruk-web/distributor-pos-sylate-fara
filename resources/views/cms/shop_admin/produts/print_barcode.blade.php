@php( $currency = ENV('DEFAULT_CURRENCY'))
@if($printer_name == 'a4_4' || $printer_name == 'a4_5' || $printer_name == 'a4_6'|| $printer_name == 'a4_7')
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <title>Print Barcode</title>
    <style>
        .barcode_image {
            margin-bottom: 5px !important;
            height: 50px !important;
        }
        .width25p {
            width: 20% !important;
        }
        .width14p {
            width: 14% !important;
        }
    </style>
  </head>
  <body>
    <section>
        <div class="container-fluid">
            <div class="row">
                @foreach($pid as $product)
                    @php( $p_info = DB::table('products')->where('id', $product)->first(['barCode', 'p_name', 'selling_price', 'discount', 'discount_amount']) )
                    @php( $i = 1 )
                        @while($i <= $print_quantity)
                            <div class="@if($printer_name == 'a4_4') col-md-3 @elseif($printer_name == 'a4_5') width25p p-1 text-center @elseif($printer_name == 'a4_6') col-md-2 @elseif($printer_name == 'a4_7') width14p p-1 text-center @endif text-center rounded p-1">
                                <div class="border mb-2">
                                    @if($product_name == 'yes')<span>{{optional($p_info)->p_name}}</span><br>@endif
                                    <img class="barcode_image"  width="90%" src="data:image/png;base64,{{DNS1D::getBarcodePNG($p_info->barCode, 'C128')}}"/><br>
                                    @if($selling_price == 'yes')
                                        @if($p_info->discount == 'percent')
                                            @php($discount_amout = ($p_info->discount_amount * $p_info->selling_price)/100)
                                            <span>{{$currency}} {{number_format(($p_info->selling_price) - $discount_amout, 2)}}</span><br>
                                        @elseif($p_info->discount == 'flat')
                                            <span>{{$currency}} {{number_format(($p_info->selling_price)-($p_info->discount_amount), 2)}}</span><br>
                                        @else
                                            <span>{{$currency}} {{number_format($p_info->selling_price, 2)}}</span><br>
                                        @endif
                                    @endif
                                    <!--<img id="barcode_image" class="" src="{{asset('barcode/barcode.php')}}?codetype=Code128&size=80&text={{$p_info->barCode}}&print=true"/>-->
                                </div>
                            </div>
                        @php( $i += 1)
                        @endwhile
                @endforeach
            </div>
            
        </div>
    </section>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script type="text/javascript">
        window.onload = function() { window.print(); }
    </script>
  </body>
</html>
@else
@php( $printer = DB::table('barcode_printers')->where('shop_id', Auth::user()->shop_id)->where('id', $printer_name)->first() )
@if(!is_null($printer))

<?php

    function check_value($item) {
        if($item == '') {
            $item = 0;
        }
        return $item;
    }

    $column_info = optional($printer)->barcode_row;
    $barcode_width_in_percent = 100 / $column_info;

?>
<!DOCTYPE html>
<html>
<head>
<title>Test Print</title>
</head>
<style>
    body {
        width: <?php echo check_value(optional($printer)->page_width); ?>in !important;
        min-width:<?php echo check_value(optional($printer)->page_width); ?>in !important;
        max-width:<?php echo check_value(optional($printer)->page_width); ?>in !important;
        
        
        margin-left:<?php echo check_value(optional($printer)->page_margin_left); ?>in !important;
        margin-right:<?php echo check_value(optional($printer)->page_margin_right); ?>in !important;
        margin-top:<?php echo check_value(optional($printer)->page_margin_top); ?>in !important;
        margin-bottom:<?php echo check_value(optional($printer)->page_margin_bottom); ?>in !important;
    }

    .barcode_item {
        float: left;
        text-align: center !important;
        width:<?php echo $barcode_width_in_percent; ?>% !important;
        width: <?php echo check_value(optional($printer)->barcode_width); ?>in !important;
        min-width:<?php echo check_value(optional($printer)->barcode_width); ?>in !important;
        max-width:<?php echo check_value(optional($printer)->barcode_width); ?>in !important;
        height: <?php echo check_value(optional($printer)->barcode_height); ?>in !important;
        min-height:<?php echo check_value(optional($printer)->barcode_height); ?>in !important;
        max-height:<?php echo check_value(optional($printer)->barcode_height); ?>in !important;

        margin-left:<?php echo check_value(optional($printer)->barcode_margin_left); ?>px !important;
        margin-right:<?php echo check_value(optional($printer)->barcode_margin_right); ?>px !important;
        margin-top:<?php echo check_value(optional($printer)->barcode_margin_top); ?>px !important;
        margin-bottom:<?php echo check_value(optional($printer)->barcode_margin_bottom); ?>px !important;
        
    }

    .border_class {
        border: 1px solid #000000;
        border-radius: 5px;
    }

    .barcode_image {
        height:<?php echo check_value(optional($printer)->barcode_image_height); ?>in !important;
        min-height:<?php echo check_value(optional($printer)->barcode_image_height); ?>in !important;
        max-height:<?php echo check_value(optional($printer)->barcode_image_height); ?>in !important;
    }

    .barcode_text {
        font-size:<?php echo check_value(optional($printer)->text_size); ?>px !important;
    }
    
    /*column1 aditional style*/
    @if(optional($printer)->column1_margin_left != '')
        .column1{
            margin-left:<?php echo optional($printer)->column1_margin_left; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column1_margin_right != '')
        .column1{
            margin-right:<?php echo optional($printer)->column1_margin_right; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column1_margin_top != '')
        .column1{
            margin-top:<?php echo optional($printer)->column1_margin_top; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column1_margin_bottom != '')
        .column1{
            margin-bottom:<?php echo optional($printer)->column1_margin_bottom; ?>px !important;
        }
    @endif
    /*column1 aditional style*/
    
    /*column2 aditional style*/
    @if(optional($printer)->column2_margin_left != '')
        .column2{
            margin-left:<?php echo optional($printer)->column2_margin_left; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column2_margin_right != '')
        .column2{
            margin-right:<?php echo optional($printer)->column2_margin_right; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column2_margin_top != '')
        .column2{
            margin-top:<?php echo optional($printer)->column2_margin_top; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column2_margin_bottom != '')
        .column2{
            margin-bottom:<?php echo optional($printer)->column2_margin_bottom; ?>px !important;
        }
    @endif
    /*column2 aditional style*/
    
    /*column3 aditional style*/
    @if(optional($printer)->column3_margin_left != '')
        .column3{
            margin-left:<?php echo optional($printer)->column3_margin_left; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column3_margin_right != '')
        .column3{
            margin-right:<?php echo optional($printer)->column3_margin_right; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column3_margin_top != '')
        .column3{
            margin-top:<?php echo optional($printer)->column3_margin_top; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column3_margin_bottom != '')
        .column3{
            margin-bottom:<?php echo optional($printer)->column3_margin_bottom; ?>px !important;
        }
    @endif
    /*column3 aditional style*/
    
    /*column4 aditional style*/
    @if(optional($printer)->column4_margin_left != '')
        .column4{
            margin-left:<?php echo optional($printer)->column4_margin_left; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column4_margin_right != '')
        .column4{
            margin-right:<?php echo optional($printer)->column4_margin_right; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column4_margin_top != '')
        .column4{
            margin-top:<?php echo optional($printer)->column4_margin_top; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column4_margin_bottom != '')
        .column4{
            margin-bottom:<?php echo optional($printer)->column4_margin_bottom; ?>px !important;
        }
    @endif
    /*column4 aditional style*/
    
    
    /*column4 aditional style*/
    @if(optional($printer)->column5_margin_left != '')
        .column5{
            margin-left:<?php echo optional($printer)->column5_margin_left; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column5_margin_right != '')
        .column5{
            margin-right:<?php echo optional($printer)->column5_margin_right; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column5_margin_top != '')
        .column5{
            margin-top:<?php echo optional($printer)->column5_margin_top; ?>px !important;
        }
    @endif
    
    @if(optional($printer)->column5_margin_bottom != '')
        .column5{
            margin-bottom:<?php echo optional($printer)->column5_margin_bottom; ?>px !important;
        }
    @endif
    /*column5 aditional style*/
    
    
   


</style>
<body>
    
    @php( $b = 1 )
    @foreach($pid as $product)
        @php( $p_info = DB::table('products')->where('id', $product)->first(['barCode', 'p_name', 'selling_price', 'discount', 'discount_amount']) )
        @php( $i = 1 )
            @while($i <= $print_quantity)
                <div class="barcode_item">
                    <div class="border_class column{{$b}}">
                        @if($product_name == 'yes')<span class="barcode_text">{{optional($p_info)->p_name}}</span><br>@endif
                        <img class="barcode_image"  width="90%" src="data:image/png;base64,{{DNS1D::getBarcodePNG($p_info->barCode, 'C128')}}"/><br>
                        @if($selling_price == 'yes')
                            @if($p_info->discount == 'percent')
                                @php($discount_amout = ($p_info->discount_amount * $p_info->selling_price)/100)
                                <span class="barcode_text">{{$currency}} {{number_format(($p_info->selling_price) - $discount_amout, 2)}}</span><br>
                            @elseif($p_info->discount == 'flat')
                                <span class="barcode_text">{{$currency}} {{number_format(($p_info->selling_price)-($p_info->discount_amount), 2)}}</span><br>
                            @else
                                <span class="barcode_text">{{$currency}} {{number_format($p_info->selling_price, 2)}}</span><br>
                            @endif
                        @endif
                    </div>
                </div>
            <?php
                if($b == $column_info) {
                    $b = 1;
                }
                else {
                    $b++;
                }
            ?>
            @php( $i += 1)
            @endwhile
    @endforeach
   
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="" crossorigin="anonymous"></script>
<script>
    window.onload = function () {
        window.print();
    }
</script>
    
</body>
</html>
@else
Printer Info Dosen't Match!

@endif
@endif