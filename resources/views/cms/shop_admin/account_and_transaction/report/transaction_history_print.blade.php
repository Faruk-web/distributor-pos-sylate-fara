@php

$total_cr = 0;
$total_dr = 0;

@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$for_what_transaction}}</title>
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
                <td width="70%" align="left" style="border: 0px solid white;">{PAGENO}/{nbpg} @if(!empty($start_date && !empty($end_date))) <p>[ {{date("d M, Y", strtotime($start_date))}} To {{date("d M, Y", strtotime($end_date))}}, {{$for_what_transaction}}]</p> @else <p>[{{$for_what_transaction}}, Print Date: {{date("d M, Y")}} ]</p> @endif</td>
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
                    @if(!empty($start_date && !empty($end_date))) <p>{{date("d M, Y", strtotime($start_date))}} To {{date("d M, Y", strtotime($end_date))}}, {{$for_what_transaction}}</p> @else <p>{{$for_what_transaction}}</p> @endif
                    </div>
                </th>
                <th style="text-align: right; border: 0px solid white;">
                    <p class="invoiceIDandDate" style="font-family: Arial;">Print Date: {{date("d M, Y")}}</p>
                </th>
            </tr>
        </table>
    </div>
    <br />
    <div>
        @if(!empty($start_date && !empty($end_date)))
        <?php
            $first_date_number = strtotime($start_date);
            $last_date_number = strtotime($end_date);
            $j = 2;
            $i = 0;
        ?>
        @if($first_date_number <= $last_date_number)
            @for($i; $i < $j; $i++)
                @if($first_date_number <= $last_date_number)
                @php($start_date = $start_date)
                    <table class="table">
                        <thead>
                        <tr><td colspan="6" align="center"><h3>Summery of {{ date("d M, Y", strtotime($start_date))}}</h3></td></tr>
                            <tr>
                                <th>Date</th>
                                <th>Added By</th>
                                <th width="20%">Info</th>
                                <th>Credit / Debit</th>
                                <th>Amount</th>
                                <th width="25%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($type == 'cash_and_banks')
                                @php($transactions = App\Models\Transaction::where(['shop_id'=>$shop_id])->where('created_at', $start_date)->orderBy('id', 'desc')->get())
                            @elseif($type == 'all_banks')
                                @php($transactions = App\Models\Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '!=', 'cash')->where('created_at', $start_date)->orderBy('id', 'desc')->get())
                            @elseif($type == 'only_cash')
                                @php($transactions = App\Models\Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', 'cash')->where('created_at', $start_date)->orderBy('id', 'desc')->get())
                            @else
                                @php($transactions = App\Models\Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', $type)->where('created_at', $start_date)->orderBy('id', 'desc')->get())
                            @endif
                            @foreach($transactions as $transaction)
                            {{ ($transaction->creadit_or_debit == 'CR') ? $total_cr = $total_cr + $transaction->amount : $total_dr = $total_dr + $transaction->amount }}
                                <tr>
                                    <td>{{date('d-m-Y', strtotime($transaction->created_at))}}</td>
                                    <td>
                                        @if(!empty($transaction->branch_id)) 
                                            <b>Branch: </b> {{($transaction->brnach_info)->branch_name}} [ {{optional($transaction->user_info)->name}} ]
                                        @else 
                                            Admin Wing[ {{optional($transaction->user_info)->name}} ]
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->for_what == 'SDP')
                                            <p>Supplier Due Payment. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @elseif($transaction->for_what == 'CONTRA')
                                            <p>Contra / Balance Transfer. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @elseif($transaction->for_what == 'CDR')
                                            <p>Customer Due Received. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @elseif($transaction->for_what == 'SIP')
                                            <p>Supplier Instant Payment. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @elseif($transaction->for_what == 'LP')
                                            <p>Loan Paid to Lender</p>
                                        @elseif($transaction->for_what == 'LR')
                                            <p>Loan Received from Lender</p>
                                        @elseif($transaction->for_what == 'CA')
                                            <p>Capital Added From Owner</p>
                                        @elseif($transaction->for_what == 'CW')
                                            <p>Capital Withdraw</p>
                                        @elseif($transaction->for_what == 'E')
                                            <p>Expense Payment. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @elseif($transaction->for_what == 'CPR')
                                            <p>Customer Product Return</p>
                                        @elseif($transaction->for_what == 'S')
                                            <p>Sell. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @elseif($transaction->for_what == 'IE')
                                            <p>Indirect Income. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        @if($transaction->cash_or_bank == 'cash')
                                            <b>{{$transaction->creadit_or_debit}}</b>( Cash )
                                        @else
                                            <b>{{$transaction->creadit_or_debit}}</b>( {{optional($transaction->bank_info)->bank_name}} [{{optional($transaction->bank_info)->account_no}}])
                                        @endif
                                    </td>
                                    <td>{{number_format($transaction->amount, 2)}}</td>
                                    <td>{{optional($transaction)->note}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <br>
                <?php
                    $start_date = date('Y-m-d', strtotime($start_date . ' +1 day'));
                    $first_date_number = strtotime($start_date);
                    $j += 1;
                ?>
                @else
                    
                @endif
            @endfor
            <div>
                <h2>Total CR: {{$total_cr}}</h2>
                <h2>Total DR: {{$total_dr}}</h2>
            </div>
        @else
            <tr>
                <td colspan="6">No Data Found</td>
            </tr>
        @endif
        @else
        <table class="table">
            <thead>
            <tr><td colspan="6" align="center"><h3>Summery</h3></td></tr>
                <tr>
                    <th>Date</th>
                    <th>Added By</th>
                    <th width="20%">Info</th>
                    <th>Credit / Debit</th>
                    <th>Amount</th>
                    <th width="25%">Description</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{date('d-m-Y', strtotime($transaction->created_at))}}</td>
                        <td>
                            @if(!empty($transaction->branch_id)) 
                                <b>Branch: </b> {{($transaction->brnach_info)->branch_name}} [ {{optional($transaction->user_info)->name}} ]
                            @else 
                                Admin Wing[ {{optional($transaction->user_info)->name}} ]
                            @endif
                        </td>
                        <td>
                            @if($transaction->for_what == 'SDP')
                                <p>Supplier Due Payment. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @elseif($transaction->for_what == 'CONTRA')
                                <p>Contra / Balance Transfer. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @elseif($transaction->for_what == 'CDR')
                                <p>Customer Due Received. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @elseif($transaction->for_what == 'SIP')
                                <p>Supplier Instant Payment. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @elseif($transaction->for_what == 'LP')
                                <p>Loan Paid to Lender</p>
                            @elseif($transaction->for_what == 'LR')
                                <p>Loan Received from Lender</p>
                            @elseif($transaction->for_what == 'CA')
                                <p>Capital Added From Owner</p>
                            @elseif($transaction->for_what == 'CW')
                                <p>Capital Withdraw</p>
                            @elseif($transaction->for_what == 'E')
                                <p>Expense Payment. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @elseif($transaction->for_what == 'CPR')
                                <p>Customer Product Return</p>
                            @elseif($transaction->for_what == 'S')
                                <p>Sell. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @elseif($transaction->for_what == 'IE')
                                <p>Indirect Income. <br>Voucher Num: #{{str_replace("_","/", $transaction->refference)}}</p>
                            @endif
                        </td>
                        <td>
                            @if($transaction->cash_or_bank == 'cash')
                                <b>{{$transaction->creadit_or_debit}}</b>( Cash )
                            @else
                                <b>{{$transaction->creadit_or_debit}}</b>( {{optional($transaction->bank_info)->bank_name}} [{{optional($transaction->bank_info)->account_no}}])
                            @endif
                        </td>
                        <td>{{number_format($transaction->amount, 2)}}</td>
                        <td>{{optional($transaction)->note}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</body>
</html>
