<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner / Capital Person Ledger</title>
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
                <td width="70%" align="left" style="border: 0px solid white;">{PAGENO}/{nbpg} [ {{date("d-m-Y", strtotime($start_date))}} To {{date("d-m-Y", strtotime($end_date))}}, Ledger Summery Of Owner / Capital Person / {{$owner_info->name}} ]</td>
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
                           Owner / Capital Person Info, <br>
                           Name: {{$owner_info->name}}<br>
                           Address: {{optional($owner_info)->address}}<br>
                           Phone: {{$owner_info->phone}}<br>
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
        <div style="padding-left: 10%; padding-right: 10%;">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center bg-dark text-light">
                        <th align="center" colspan="2">Balance Sheet</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><b>Opening Balance</b></td>
                        <td align="right" class="pr-5" width="75%">{{number_format($owner_info->opening_capital, 2)}}</td>
                    </tr>
                    <tr>
                        <td>
                            <br><b>Capital Added </b>
                        </td>
                        <td width="75%">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="80%">Capital Added By Cash</td>
                                        <td>{{number_format($capital_add_in_cash, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">Capital Added By Cheque</td>
                                        <td>{{number_format($capital_add_in_cheque, 2)}}</td>
                                    </tr>
                                    <tr class="text-right">
                                        <th align="right" colspan="2">Total Capital Added = {{number_format($capital_add_in_cash+$capital_add_in_cheque, 2)}}</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br><b>Capital Withdraw </b>
                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="80%">Capital Withdraw By Cash</td>
                                        <td>{{number_format($capital_withdraw_in_cash, 2)}}</td>
                                    </tr>
                                    <tr>
                                        <td width="80%">Capital Withdraw By Cheque</td>
                                        <td>{{number_format($capital_withdraw_in_cheque, 2)}}</td>
                                    </tr>
                                    <tr class="text-right">
                                        <th align="right" colspan="2">Total Capital Withdraw = {{number_format($capital_withdraw_in_cash+$capital_withdraw_in_cheque, 2)}}</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!--This is for Bank Received End-->
                    <tr class="text-right">
                        <th align="right" colspan="2">Balance = {{number_format($owner_info->opening_capital + $capital_add_in_cash+$capital_add_in_cheque - $capital_withdraw_in_cash - $capital_withdraw_in_cheque, 2)}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
    <br>
    </div>
    <div>
        <table class="table">
            <thead>
            <tr><td colspan="4" align="center"><h3>Summery</h3></td></tr>
                <tr>
                    <th>Date</th>
                    <th>Add or Withdrow</th>
                    <th>Amount</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{date('d-m-Y', strtotime($transaction->created_at))}}</td>
                        <td>{{$transaction->add_or_withdraw}}</td>
                        <td>{{number_format($transaction->amount, 2)}}</td>
                        <td>
                        @if($transaction->transaction == 'cash') 
                            <p>Transaction by: Cash.<br /><b>Voucher Num: </b>#{{str_replace("_","/", $transaction->voucher_num)}}<br /> <b>Note: </b>{{optional($transaction)->note}}<br /> <b>Added By: </b>{{optional($transaction->user_info)->name}}</p>
                        
                        @else if($transaction->transaction == 'cheque') {
                            <p>Transaction by: Cheque[ {{optional($transaction->bank_info)->bank_name}} ({{optional($transaction->bank_info)->account_no}}) ].<br /><b>Voucher Num: </b>#{{str_replace("_","/", $transaction->voucher_num)}}<br /> <b>Note: </b>{{optional($transaction)->note}}<br /> <b>Added By: </b>{{optional($transaction->user_info)->name}}</p>
                        @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
