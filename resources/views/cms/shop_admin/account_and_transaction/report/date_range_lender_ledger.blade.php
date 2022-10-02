<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lender Ledger</title>
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
                <td width="70%" align="left" style="border: 0px solid white;">{PAGENO}/{nbpg} [ {{date("d-m-Y", strtotime($start_date))}} To {{date("d-m-Y", strtotime($end_date))}}, Ledger Summery Of Lender / {{$lender_info->name}} ]</td>
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
                           Lender Info, <br>
                           Name: {{$lender_info->name}}<br>
                           Address: {{optional($lender_info)->address}}<br>
                           Phone: {{$lender_info->phone}}<br>
                           Email: {{optional($lender_info)->email}}<br>
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
            <table class="table table-bordered">
                <thead>
                <tr class="text-center"><th colspan="2" align="center"><p><b>Balance Sheet</b></p></th></tr>
                    <tr>
                    <th>Info</th>
                    <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Opening Balance</td><td>{{number_format($lender_info->opening_balance, 2)}}</td></tr>
                    <tr><td>Loan Received By Cash</td><td>{{number_format($cash_loan_received, 2)}}</td></tr>
                    <tr><td>Loan Received By Bank</td><td>{{number_format($bank_loan_received, 2)}}</td></tr>
                    <tr><td>Paid Loan By Cash</td><td>{{number_format($cash_loan_paid, 2)}}</td></tr>
                    <tr><td>Paid Loan By Bank</td><td>{{number_format($bank_loan_paid, 2)}}</td></tr>
                    <tr>
                        @php( $balance = $lender_info->opening_balance + $cash_loan_received + $bank_loan_received - $cash_loan_paid - $bank_loan_paid)
                        <td align="right" colspan="2">Balance( Total Received - Total Paid ) = {{number_format($balance, 2)}}</td>
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
                    <th>Paid or Received</th>
                    <th>Amount</th>
                    <th>Info</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{date('d-m-Y', strtotime($transaction->created_at))}}</td>
                        <td>{{$transaction->paid_or_received}}</td>
                        <td>{{number_format($transaction->amount, 2)}}</td>
                        <td>
                            @if($transaction->cash_or_cheque == 'cash') 
                                <p>Transaction by: Cash.<br /><b>Voucher Num: </b>#{{str_replace("_","/", $transaction->voucher_num) }}<br /> <b>Note: </b>{{optional($transaction)->note}}</p>
                            @else if($transaction->cash_or_cheque == 'cheque') 
                                <p>Transaction by: Cheque[ {{optional($transaction->bank_info)->bank_name}} ({{optional($transaction->bank_info)->account_no}}) ].<br /><b>Voucher Num: </b>#{{str_replace("_","/", $transaction->voucher_num)}}<br /> <b>Note: </b>{{optional($transaction)->note}}</p>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
