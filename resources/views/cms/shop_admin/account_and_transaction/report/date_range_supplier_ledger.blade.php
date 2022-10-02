<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Ledger</title>
</head>
<style>
    @page {
        header: page-header;
        footer: page-footer;
        margin-top: 40mm;


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
            <ul>
                <li id="LI">
                    <div>
                        <img src="" alt="">
                    </div>
                </li>
                <li id="LI">
                    <p style="font-size: 13px; text-align: right;"><span
                            style="font-size: 18px; font-weight: bold;">{{$shop_info->shop_name}}</span><br>
                        {{$shop_info->address}},<br>
                        {{$shop_info->phone}}, </b><br>
                        {{$shop_info->email}}<br>
                        {{$shop_info->shop_website}}
                    </p>
                </li>
            </ul>
            <hr style="border: 1px solid #81d4fa; margin-top: -20px;">
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <table width="100%">
            <tr>
                <td width="70%" align="left" style="border: 0px solid white;">{PAGENO}/{nbpg} [ {{date("d-m-Y", strtotime($start_date))}} To {{date("d-m-Y", strtotime($end_date))}}, Ledger Summery Of {{$supplier_info->name}} ]</td>
                <td width="30%" style="text-align: center; border: 0px solid white;">
                    <p style="font-size: 13px; text-align: center; font-family: Arial;">Powered By <b>FARA IT Fusion</b></p>
                </td>
                
            </tr>
        </table>
    </htmlpagefooter>
    @php( $currency = ENV('DEFAULT_CURRENCY'))
    <div>
        <table>
            <tr>
                <th style="border: 0px solid white;">
                    <div>
                        <p>
                           Supplier Info, <br>
                           Name: {{$supplier_info->name}}<br>
                           Company Name: {{optional($supplier_info)->company_name}}<br>
                           Address: {{optional($supplier_info)->address}}<br>
                           Phone: {{$supplier_info->phone}}<br>
                           Email: {{optional($supplier_info)->email}}<br>
                          </p>
                    </div>
                </th>
                <th style="text-align: right; border: 0px solid white;">
                    <p class="invoiceIDandDate" style="font-family: Arial;">{{date("d M, Y", strtotime($start_date))}} To {{date("d M, Y", strtotime($end_date))}}, Ledger Summery<br>Print Date: {{date("d M, Y")}}</p>
                </th>
            </tr>
        </table>
    </div>
    <br />
    <div>
        <div style="padding-left: 20%; padding-right: 20%;">
            <table class="table">
                <thead>
                <tr><td colspan="2" align="center"><h3>Balance Sheet</h3></td></tr>
                    <tr>
                    <th>Info</th>
                    <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Opening Balance</td><td>{{number_format($supplier_info->opening_bl, 2)}}</td></tr>
                    <tr><td>Total Sell</td><td>{{number_format($total_gross, 2)}}</td></tr>
                    <tr><td>Instant Paid</td><td>{{number_format($paid_amount, 2)}}</td></tr>
                    <tr><td>Due Payment</td><td>{{number_format($total_due_payments, 2)}}</td></tr>
                    <tr><td>Total Return</td><td>{{number_format($total_return_products_amount, 2)}}</td></tr>
                    <tr class="text-right">
                        @php( $balance = $supplier_info->opening_bl + $total_gross - $paid_amount - $total_due_payments - $total_return_products_amount)
                        <td align="right" colspan="2">Balance = {{number_format($balance, 2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
<br>
            <ul style="width: 100%; float:left;">
                <li style="width: 49%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr><td align="center" colspan="3"><h3>Due Payments</h3></td></tr>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Voucher Num.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php( $total_payment = 0)
                            @foreach($due_payments as $payment)
                            <tr><td>{{date('d-m-Y', strtotime($payment->created_at))}}</td><td>{{number_format($payment->paid, 2)}}</td><td>#{{str_replace("_","/", $payment->voucher_number)}}</td></tr>
                            @php( $total_payment = $total_payment + $payment->paid)
                            @endforeach
                            <tr>
                                <td align="right" colspan="3">Total Received = {{number_format($total_payment, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                <li style="width: 49%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr><td colspan="4" align="center"><h3>Stock In Invoices</h3></td></tr>
                            <tr>
                                <th>Date</th>
                                <th>Inv Total</th>
                                <th>Inatant Paid</th>
                                <th>Inv Num.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php( $invoice_total = 0)
                            @foreach($invoices as $order)
                            <tr><td>{{date('d-m-Y', strtotime($order->date))}}</td><td>{{number_format($order->total_gross, 2)}}</td><td>{{number_format($order->paid, 2)}}</td><td>#{{str_replace("_","/", $order->supp_invoice_id)}}</td></tr>
                            @php( $invoice_total = $invoice_total+$order->total_gross)
                            @endforeach
                            <tr>
                                <td align="right" colspan="4">Total Sell = {{number_format($invoice_total, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
            </ul>
    </div>
    <div>
            <table class="table">
                <thead>
                <tr><td colspan="4" align="center"><h3>Returned Product</h3></td></tr>
                    <tr>
                        <th>Date</th>
                        <th>Invoice</th>
                        <th>Current Return Time</th>
                        <th>Refundable Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @php( $total_refund = 0)
                    @foreach($total_return_invoices as $return_product)
                    <tr>
                        <td>{{date('d-m-Y', strtotime($return_product->date))}}</td>
                        <td>#{{str_replace("_","/", $return_product->supp_invoice_id)}}</td>
                        <td>{{$return_product->how_many_times_edited}}</td>
                        <td>{{number_format($return_product->total_gross, 2)}}</td>
                    </tr>
                    @php( $total_refund = $total_refund+$return_product->total_gross)
                    @endforeach
                    <tr>
                        <td align="right" colspan="4">Total Returned = {{number_format($total_refund, 2)}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
</body>
</html>
