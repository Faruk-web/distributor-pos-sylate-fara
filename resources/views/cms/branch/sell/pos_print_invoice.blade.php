<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="{{asset('posprint/style.css')}}">
        <title>POS Print Inv {{str_replace("_","/", $invoice_info->invoice_id)}}</title>
        <style>
            *{
                font-size: 8px !important;
            }
        </style>
    </head>
    <body>
        <div class="ticket" style="margin-top: -5px;">
            
            <p class="centered"><img style="width: 100px;" src="{{asset(optional($shop_info)->shop_logo)}}"><br><span style="font-size: 20px; font-weight: bold;">{{$shop_info->shop_name}}</span>
                <br>{{optional($shop_info)->address}}
                <br>{{optional($shop_info)->phone}}</p>
                @php($customer_info = $invoice_info->customer_info)
                <div>
                    <table>
                        <tr style="">
                            <td style="font-size: 8px; text-align: left; width: 100%; border-top: 1px solid white;">
                            @if($customer_info->code == $shop_info->shop_code."WALKING")
                             Bill To, Cash Customer<br>Inv #{{str_replace("_","/", $invoice_info->invoice_id)}}
                            @else
                                Bill To,&nbsp;{{$customer_info->name}}<br>Inv #{{str_replace("_","/", $invoice_info->invoice_id)}}
                            @endif
                            <br>Date: {{date('d-m-Y', strtotime(optional($invoice_info)->date))}}
                            </td>
                        </tr>
                    </table>
                </div>
                
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;" class="description">P Name</th>
                        <th class="quantity">Qty.</th>
                        <th class="quantity">Unit P</th>
                        <th class="price">Total</th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($invoice_info->invoice_products as $product)
                    <?php
                        $variation_name = '';
                        if($product->variation_id != 0 && $product->variation_id != '') {
                            $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                            $variation_name =  ' ('.optional($variation_info)->list_title.')';
                        }
                    ?>
                        <tr>
                            <td class="description">
                                {{$product->product_info->p_name}} {{$variation_name}}
                                @if($product->discount > 0)
                                  <br /><span style="color: #18191A;">Discount: {{$product->discount}} %</span>
                                @elseif($product->discount_amount > 0)
                                <br /><span style="color: #18191A;">Discount: {{$product->discount_amount}}</span>
                                @endif
                                @if($product->vat_amount > 0)
                                <br /><span style="color: #536DFE;">Tax: {{$product->vat_amount}} %</span>
                                @endif
                            </td>
                            <td class="quantity">{{$product->quantity}}</td>
                            <td class="quantity">{{number_format($product->price, 2)}}</td>
                            <td><span style="font-size: 8px;">{{number_format($product->total_price, 2)}}</span></td>
                        </tr>
                    @endforeach
                     @php( $sum = optional($invoice_info)->total_gross)
                    @php($vat_price = 0)                     
                    <tr>
                        <td class="quantity"></td>
                        <td colspan="2" style="font-size: 9px;" class="description">Total Gross: </td>
                        <td style="font-size: 10px;" class="">{{number_format($sum, 2)}}</td>
                    </tr>
                    @if($invoice_info->vat > 0)
                    @php($vat_price = $sum*($invoice_info->vat)/100)
                        <tr style="border: 1px dashed white !important;">
                            <td style="border: 1px dashed white !important;" class="quantity"></td>
                            <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">VAT({{optional($invoice_info)->vat}}%)</td>
                            <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format($vat_price, 2)}}</td>
                        </tr>
                    @endif
                    @if($invoice_info->discount_status == 'tk' || $invoice_info->discount_status == 'flat')
                    @php($sum = $sum-$invoice_info->discount_rate)
                        <tr style="border: 1px dashed white !important;">
                            <td style="border: 1px dashed white !important;" class="quantity"></td>
                            <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Dis TK</td>
                            <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format(optional($invoice_info)->discount_rate, 2)}}</td>
                        </tr>
                    @elseif($invoice_info->discount_status == 'percent')
                    @php($discount_price = ($invoice_info->discount_rate * $sum)/100)
                    @php($sum = $sum-$discount_price)
                         <tr style="border: 1px dashed white !important;">
                            <td style="border: 1px dashed white !important;" class="quantity"></td>
                            <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Discount( {{number_format(optional($invoice_info)->discount_rate, 2)}}% )</td>
                            <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format($discount_price, 2)}}</td>
                        </tr>
                   @endif

                   @if(optional($invoice_info)->delivery_crg > 0)
                   @php($sum = $sum+$invoice_info->delivery_crg)
                    <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Delivery Crg</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format(optional($invoice_info)->delivery_crg, 2)}}</td>
                    </tr>
                  @endif
                  @if(optional($invoice_info)->others_crg > 0)
                  @php($sum = $sum+$invoice_info->others_crg)
                      <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Others Crg</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format(optional($invoice_info)->others_crg, 2)}}></td>
                    </tr>
                  @endif
                  @php( $sum = $sum + $vat_price)
                    <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Subtotal</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format($sum, 2)}}</td>
                    </tr>
                  @if(!empty(optional($invoice_info)->pre_due))
                  @php($sum = $sum+$invoice_info->pre_due)
                      <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Pre Due</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format(optional($invoice_info)->pre_due, 2)}}</td>
                    </tr>
                  @endif
                  <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Total Payable</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format($sum, 2)}}</td>
                    </tr>
                    <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Paid</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format(optional($invoice_info)->paid_amount, 2)}}</td>
                    </tr>
                    @php($current_due = $sum-$invoice_info->paid_amount)
                    @if($current_due > 0)
                    <tr style="border: 1px dashed white !important;">
                        <td style="border: 1px dashed white !important;" class="quantity"></td>
                        <td colspan="2" style="font-size: 9px; border: 1px dashed white !important;" class="description">Current Due</td>
                        <td style="font-size: 10px; border: 1px dashed white !important;" class="">{{number_format($current_due, 2)}}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            
              @if(optional($invoice_info)->payment_by == 'cash')
                <p><b>*Payment By:</b>&nbsp;&nbsp; Cash</p>
              @elseif(optional($invoice_info)->payment_by == 'cheque')
                @if(!empty(optional($invoice_info)->mfs_acc_type))
                    <p><b>*Payment By:</b>&nbsp;&nbsp; {{optional($invoice_info)->mfs_acc_type}} ({{optional($invoice_info)->cheque_or_mfs_acc}})</p>
                @elseif(!empty(optional($invoice_info)->cheque_bank))
                    <p><b>*Payment By:</b>&nbsp;&nbsp; {{optional($invoice_info)->cheque_bank}} ({{optional($invoice_info)->cheque_or_mfs_acc}})</p>
                @endif
             @endif
            <p style="font-size: 8px;" class="centered">Software Developed By FARA IT limited</p>
            <div>
                .................................................................................
                .................................................................................
            </div>
        </div>
        <button id="btnPrint" class="hidden-print">Print</button>
        <script src="{{asset('posprint/script.js')}}"></script>
        <script>
            window.onload = function () {
                window.print();
            }
        </script>
    </body>
</html>