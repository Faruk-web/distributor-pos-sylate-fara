<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Return Invoice</title>
</head>
<style>
    @page {
        header: page-header;
        footer: page-footer;
        margin-top: 30mm;


    }

    body {
        font-family: 'examplefont', nikosh;
    }

    li {
        list-style: none;
        float: left;
        overflow: hidden;
    }

    p {
        font-size: 13px;
    }

    .customar_info {
        width: 100%;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid black;
        text-align: left;
        padding: 5px;
        font-size: 13px;
    }

    .invoiceIDandDate {
        text-align: right;

    }

    .clientInfo {
        background-color: red;
    }

</style>

<body>
    <htmlpageheader name="page-header">
        <div>
            <table style="margin-top: 10px;">
            <tr>
                <td style="border: 0px solid white;">
                    <div>
                        <img src="{{asset(optional($shop_info)->shop_logo)}}" alt="">
                    </div>
                </td>
                <td style="text-align: right; border: 0px solid white;">
                    <div>
                    <p style="font-size: 13px; text-align: right; overflow: hidden;"><span style="font-size: 15px; font-weight: bold;">
                        {{$shop_info->shop_name}}</span><br>
                            {{$shop_info->address}},<br>
                            {{$shop_info->phone}}, </b><br>
                            {{$shop_info->email}}<br>
                            {{$shop_info->shop_website}}
                        </p>
                        </div>
                </td>
            </tr>
        </table>
        
            <hr style="border: 1px solid #81d4fa;">
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <table width="100%">
            <tr>
                <td width="5%" align="center" style="border: 0px solid white;">{PAGENO}/{nbpg}</td>
                <td width="90%" style="text-align: center; border: 0px solid white;">
                    <p style="font-size: 13px; text-align: center; font-family: Arial;">This Software Created by <b>FARA
                            IT Fusion</b>(www.faraitfusion.com)</p>
                </td>
                <td width="5%" style="text-align: right; border: 0px solid white;"></td>
            </tr>
        </table>
    </htmlpagefooter>
    @php($customer_info = $invoice_info->customer_info)
    @php( $currency = ENV('DEFAULT_CURRENCY'))
    <div>
        <table>
            <tr>
                <th style="border: 0px solid white;">
                    <div>
                    @if($customer_info->code == $shop_info->shop_code."WALKING")
                        <p>
                           Bill To,Customer
                          </p>
                    @else
                       <div>
                        <p>
                           Bill To, <br>
                           Name: {{$customer_info->name}}<br>
                           Address: {{optional($customer_info)->address}}<br>
                           Phone: {{$customer_info->phone}}<br>
                           Email: {{optional($customer_info)->email}}<br>
                          </p>
                          </div>
                    @endif
                    </div>
                </th>
                <th style="text-align: right; border: 0px solid white;">
                    <h3 style="color: red; font-family: Arial;"><b>Customer Return Invoice</b></h3>
                    <p class="invoiceIDandDate" style="font-family: Arial;">Invoice #{{str_replace("_","/", $invoice_info->invoice_id)}}<br>Current Returning Times: {{$invoice_info->return_current_times}}<br>Date:
                        {{date('d M, Y', strtotime(optional($invoice_info)->date))}}</p>
                </th>
            </tr>
        </table>
    </div>
    <br />
    <div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr style="text-align: right; background-color: #dddddd;">
                    <th scope="col" style="text-align: center;">SN</th>
                    <th width="50px" style="text-align: left;">Product Name</th>
                    <th scope="col" style="text-align: center;">Quantity</th>
                    <th scope="col" style="text-align: center;">Price</th>
                    <th scope="col" style="text-align: center;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach($products as $product)
                <?php
                    $variation_name = '';
                    if($product->variation_id != 0 && $product->variation_id != '') {
                        $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  ' ('.optional($variation_info)->list_title.')';
                    }
                ?>
                <tr style="text-align: right;">
                    <th scope="row" style="text-align: center;">{{$i}}</th>
                    <td width="350px" style="text-align: left;">
                        {{$product->product_info->p_name}} {{$variation_name}}
                        @if($product->discount > 0)
                          <br /><span style="color: #00BFA6;">Discount: {{$product->discount}} %</span>
                        @elseif($product->discount_amount > 0)
                        <br /><span style="color: #00BFA6;">Discount: {{$product->discount_amount}} {{$currency}}</span>
                        @endif

                        @if($product->vat_amount > 0)
                        <br /><span style="color: #536DFE;">Tax: {{$product->vat_amount}} %</span>
                        @endif
                    </td>
                    <td style="text-align: center;">{{$product->quantity}} {{$product->product_info->unit_type_name->unit_name}}</td>
                    <td style="text-align: center;">{{$product->price}} {{$currency}}</td>
                    <td style="text-align: center;">{{$product->total_price}} {{$currency}}</td>
                </tr>
                @php($i += 1)
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 8px; text-align: right;">
        <table>
        @php( $sum = optional($invoice_info)->total_gross)
        @php($vat_price = 0)
        <tbody style="text-align: right;">
                              <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Total Gross</b></td>
                                    <td style="text-align:right; width:100px !important;">{{number_format($sum, 2)}} {{$currency}}</td>
                              </tr>
                              @if($invoice_info->vat_status > 0)
                              @php($vat_price = $sum*($invoice_info->vat_status)/100)
                                  <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>VAT({{number_format(optional($invoice_info)->vat_status, 2)}}%)</b></td>
                                    <td style="text-align: right;">{{number_format($vat_price, 2)}} {{$currency}}</td>
                              </tr>
                              @endif
                              @if($invoice_info->discount_status == 'tk')
                              @php($sum = $sum-$invoice_info->discount_rate)
                                  <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Discount TK</b></td>
                                    <td style="text-align: right;">{{number_format(optional($invoice_info)->discount_rate, 2)}}</td>
                              </tr>
                              @elseif($invoice_info->discount_status == 'percent')
                              @php($discount_price = ($invoice_info->discount_rate * $sum)/100)
                              @php($sum = $sum-$discount_price)
                                  <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Discount( {{number_format(optional($invoice_info)->discount_rate, 2)}}% )</b></td>
                                    <td style="text-align: right;">{{number_format($discount_price, 2)}} {{$currency}}</td>
                              </tr>
                              @endif

                              @if(optional($invoice_info)->others_crg > 0)
                              @php($sum = $sum+$invoice_info->others_crg)
                                  <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Others Charge</b></td>
                                    <td style="text-align: right;">{{number_format(optional($invoice_info)->others_crg, 2)}}</td>
                              </tr>
                              @endif
                              @if(optional($invoice_info)->fine > 0)
                              @php($sum = $sum+$invoice_info->fine)
                                  <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Extra Fine</b></td>
                                    <td style="text-align: right;">{{number_format(optional($invoice_info)->others_crg, 2)}}</td>
                              </tr>
                              @endif
                              
                              @php( $sum = $sum + $vat_price)
                              <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Sub Total</b></td>
                                    <td style="text-align: right;">{{number_format($sum, 2)}} {{$currency}}</td>
                              </tr>

                              @if(!empty(optional($invoice_info)->currentDue))
                              @php($sum = $invoice_info->currentDue-$sum)
                                  <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Customer Due / Get</b></td>
                                    <td style="text-align: right;">{{number_format(optional($invoice_info)->currentDue, 2)}}</td>
                              </tr>
                              @endif
                              <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Total Payable</b></td>
                                    <td style="text-align: right;">{{number_format($sum, 2)}} {{$currency}}</td>
                              </tr>
                              <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Paid</b></td>
                                    <td style="text-align: right;">{{number_format(optional($invoice_info)->paid, 2)}}</td>
                              </tr>
                              @php($current_due = $sum-$invoice_info->paid)
                              <tr style="text-align: right;">
                                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Customer Current Balance</b></td>
                                    <td style="text-align: right; width:150px;">{{number_format($current_due, 2)}} {{$currency}}</td>
                              </tr>
                         </tbody>
        </table>
    </div>
    <div>
        <p><b>Note:</b></p>
        {{optional($invoice_info)->note}}
    </div>
</body>
</html>
