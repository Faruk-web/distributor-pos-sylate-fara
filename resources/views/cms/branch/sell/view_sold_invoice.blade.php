@php($customer_info = $invoice_info->customer_info)
@php( $currency = ENV('DEFAULT_CURRENCY'))
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sold Invoice</title>
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
                            {!!$shop_info->address!!}<br>
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
                <td width="33%" style="border: 0px solid white;">{PAGENO}/{nbpg} [Sold Invoice #{{str_replace("_","/", $invoice_info->invoice_id)}} ]</td>
                <td width="33%" style="text-align: center; border: 0px solid white;">
                    <p style="font-size: 13px; text-align: center; font-family: Arial; border-top: 1px solid #000000;">Authorized Signature </p>
                </td>
                <td width="33%" style="text-align: center; border: 0px solid white;">
                    <p style="font-size: 13px; text-align: center; font-family: Arial; border-top: 1px solid #000000;">Customer Signature </p>
                </td>
            </tr>
        </table>
    </htmlpagefooter>
    
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
                    <p class="invoiceIDandDate" style="font-family: Arial;">Invoice #{{str_replace("_","/", $invoice_info->invoice_id)}}<br>Date:
                        {{date('d-m-Y', strtotime(optional($invoice_info)->date))}}<br>Voucher: <span style="color: #ffffff;">{{date('d-m-Y', strtotime(optional($invoice_info)->date))}}</span>
                        </p>
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
                    <th scope="col" style="text-align: center;">Qty</th>
                    <th scope="col" style="text-align: center;">Price</th>
                    <th scope="col" style="text-align: center;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach($invoice_info->invoice_products as $product)
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
                    <td style="text-align: center;">{{number_format($product->price, 2)}} {{$currency}}</td>
                    <td style="text-align: center;">{{number_format($product->total_price, 2)}} {{$currency}}</td>
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
                    <td style="text-align:right; width:150px;">{{number_format($sum, 2)}} {{$currency}}</td>
              </tr>
              @if($invoice_info->discount_status == 'tk' || $invoice_info->discount_status == 'flat')
              @php($sum = $sum - $invoice_info->discount_rate)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Discount TK</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->discount_rate, 2)}}</td>
              </tr>
              @elseif($invoice_info->discount_status == 'percent')
              @php($discount_price = ($invoice_info->discount_rate * $sum)/100)
              @php($sum = $sum - $discount_price)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Discount( {{number_format(optional($invoice_info)->discount_rate, 2)}}% )</b></td>
                    <td style="text-align: right;">{{number_format($discount_price, 2)}} {{$currency}}</td>
              </tr>
              @endif
              
              @if($invoice_info->vat > 0)
              @php($vat_price = $sum*($invoice_info->vat)/100)
              @php( $sum = $sum + $vat_price)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>VAT({{optional($invoice_info)->vat}}%)</b></td>
                    <td style="text-align: right;">{{number_format($vat_price, 2)}} {{$currency}}</td>
                </tr>
              @endif
              

              @if(optional($invoice_info)->others_crg > 0)
              @php($sum = $sum+$invoice_info->others_crg)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Others Charge</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->others_crg, 2)}}</td>
              </tr>
              @endif
              
              
              @if(optional($invoice_info)->delivery_crg > 0)
              @php($sum = $sum+$invoice_info->delivery_crg)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Delivery Charge</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->delivery_crg, 2)}}</td>
              </tr>
              @endif
              
              <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Sub Total</b></td>
                    <td style="text-align: right;">{{number_format($sum, 2)}} {{$currency}}</td>
              </tr>
              @if(!empty(optional($invoice_info)->pre_due))
              @php($sum = $sum+$invoice_info->pre_due)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Previous Due</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->pre_due, 2)}}</td>
              </tr>
              @endif
              
              @if(optional($invoice_info)->wallet_status == 'yes' && optional($invoice_info)->wallet_balance > 0)
              @php($sum = $sum - optional($invoice_info)->wallet_balance)
                  <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Wallet Balance</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->wallet_balance, 2)}}</td>
              </tr>
              @endif
              
              <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Total Payable</b></td>
                    <td style="text-align: right;">{{number_format($sum, 2)}} {{$currency}}</td>
              </tr>
              
              @if(optional($invoice_info)->change_amount > optional($invoice_info)->paid_amount)
              @php($change_amount = optional($invoice_info)->change_amount - optional($invoice_info)->paid_amount)
              <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Paid</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->change_amount, 2)}}</td>
              </tr>
              <tr style="text-align: right;">
                <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Change Amount</b></td>
                <td style="text-align: right;">{{number_format($change_amount, 2)}}</td>
              </tr>
              @else
              <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Paid</b></td>
                    <td style="text-align: right;">{{number_format(optional($invoice_info)->paid_amount, 2)}}</td>
              </tr>
              @endif
              
              @php($current_due = $sum - $invoice_info->paid_amount)
              @if($current_due != 0)
              <tr style="text-align: right;">
                    <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;"><b>Current Due</b></td>
                    <td style="text-align: right; width:150px;">{{number_format($current_due, 2)}} {{$currency}}</td>
              </tr>
              @endif
         </tbody>
        </table>
    </div>
    <div>
        <p><b>Note:</b></p>
        {{optional($invoice_info)->note}}

        @if(optional($invoice_info)->payment_by == 'cash')
            <p><b>*Payment By:</b>&nbsp;&nbsp; Cash</p>
        @elseif(optional($invoice_info)->payment_by == 'cheque')
            @if(optional($invoice_info)->card_or_mfs == 'card')
                <p><b>*Payment By:</b>&nbsp;&nbsp; {{optional($invoice_info)->cheque_bank}} ({{optional($invoice_info)->cheque_or_mfs_acc}})</p>
            @elseif(optional($invoice_info)->card_or_mfs == 'mfs')
                <p><b>*Payment By:</b>&nbsp;&nbsp; {{optional($invoice_info)->mfs_acc_type}} ({{optional($invoice_info)->cheque_or_mfs_acc}})</p>
            @endif
        @elseif(optional($invoice_info)->payment_by == 'multiple')
            <p><b>*Payment By:</b>&nbsp;&nbsp; Multiple</p>
            @php($multiple_payment_info = $invoice_info->multiple_payments)
            @foreach($multiple_payment_info as $key=>$payment_item)
            @php($key++)
            @if($payment_item->payment_type == 'cash')
            <p>{{$key}}. Cash: {{number_format($payment_item->paid_amount, 2)}}</p>
            @elseif($payment_item->payment_type == 'card')
             <p>{{$key}}. {{$payment_item->info}}: {{number_format($payment_item->paid_amount, 2)}}, Taken By: {{$payment_item->bank_info->bank_name}} [{{$payment_item->bank_info->account_no}}]</p>
            @endif
            @endforeach
        @endif
    </div>
</body>
</html>
