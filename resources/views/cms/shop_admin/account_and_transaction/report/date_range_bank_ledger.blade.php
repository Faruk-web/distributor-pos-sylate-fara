<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Ledger</title>
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
                <td width="70%" align="left" style="border: 0px solid white;">{PAGENO}/{nbpg} [ {{date("d-m-Y", strtotime($start_date))}} To {{date("d-m-Y", strtotime($end_date))}}, Ledger Summery Of {{$bank_info->bank_name}} ]</td>
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
                           Bank Info, <br>
                           Name: {{$bank_info->bank_name}}<br>
                           Account Type: {{optional($bank_info)->account_type}}<br>
                           Account No: {{optional($bank_info)->account_no}}<br>
                           Branch Name: {{optional($bank_info)->bank_branch}}<br>
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
                    <tr class="text-light bg-dark">
                        <th colspan="2" align="center">Balance Sheet</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- <tr>
                        <td><b>Opening Balance</b></td>
                        <td align="right" class="pr-5" width="75%"></td>
                    </tr> -->
                    
                    <tr>
                        <td>
                            <br><br><b>Cash in Summery</b>
                        </td>
                        <td width="75%">
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="80%">Sell Paid</td>
                                        <td>{{number_format($bank_orders_cash_in ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Customer Due Received</td>
                                        <td>{{number_format($customer_due_cash_in ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Loan Received</td>
                                        <td>{{number_format($loan_received_in ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Capital Received</td>
                                        <td>{{number_format($capital_received_in ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Contra / Balance Transfer(CTB)</td>
                                        <td>{{number_format($contra_cash_in ,2)}}</td>
                                    </tr>
                                    @php( $total_cash_in = $bank_orders_cash_in + $customer_due_cash_in + $loan_received_in + $capital_received_in + $contra_cash_in )
                                    <tr class="text-right">
                                        <th align="right" colspan="2">Total Cash In = {{number_format($total_cash_in ,2)}}</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    
                    <tr>
                        <td>
                            <br><br><br><b>Cash Out Summery</b>

                        </td>
                        <td>
                            <table>
                                <tbody>
                                    <tr>
                                        <td width="80%">Expenses</td>
                                        <td>{{number_format($expense_out ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Supplier Payment</td>
                                        <td>{{number_format($supplier_payment_out ,2)}}</td>
                                    </tr>

                                    <tr>
                                        <td>Loan Paid To Lender</td>
                                        <td>{{number_format($loan_paid_out ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Capital Paid</td>
                                        <td>{{number_format($capital_paid_out ,2)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Contra / Balance Transfer(BTC)</td>
                                        <td>{{number_format($contra_cash_out ,2)}}</td>
                                    </tr>
                                    @php( $total_cash_out = $expense_out + $supplier_payment_out + $loan_paid_out + $capital_paid_out + $contra_cash_out)
                                    <tr class="text-right">
                                        <th align="right" colspan="2">Total Cash Out = {{number_format($total_cash_out ,2)}}</th>
                                    </tr>
                                </tbody>
                                <tbody>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <!--This is for Bank Received End-->
                    <tr class="text-right">
                        <th align="right" colspan="2">Balance = {{number_format($total_cash_in - $total_cash_out ,2)}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
<br>
            <ul style="width: 100%; float:left;">
            @if($orders_summery != '[]')
            <li style="width: 49%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr><td align="center" colspan="5"><h3>Sell Paid</h3></td></tr>
                            <tr>
                                <th>Date</th>
                                <th>Branch Name</th>
                                <th>Inv Total</th>
                                <th>Paid</th>
                                <th>Invoice Num.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php( $total_sell_paid = 0)
                            @foreach($orders_summery as $order)
                                <tr>
                                    <td>{{date("d-m-Y", strtotime($order->date))}}</td>
                                    <td>{{DB::table('branch_settings')->where('id', $order->branch_id)->first('branch_name')->branch_name;}}</td>
                                    <td>{{$order->invoice_total - $order->pre_due}}</td>
                                    <td>{{number_format($order->paid_amount, 2)}}</td>
                                    <td>#{{str_replace("_","/", $order->invoice_id)}}</td>
                                </tr>
                            @php($total_sell_paid = $total_sell_paid + $order->paid_amount)
                            @endforeach
                            <tr>
                                <td align="right" colspan="5">Total Sell Paid = {{number_format($total_sell_paid, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                @endif
                @if($due_received_transactions != '[]')
                <li style="width: 49%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr><td colspan="5" align="center"><h3>Customer Due Received</h3></td></tr>
                            <tr>
                                <th>DATE</th>
                                <th>Branch Name</th>
                                <th>CUSTOMER NAME</th>
                                <th>Amount</th>
                                <th>Voucher Num.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php( $total_due_received = 0)
                            @foreach($due_received_transactions as $due_transaction)
                                <tr>
                                    <td>{{date("d-m-Y", strtotime($due_transaction->created_at))}}</td>
                                    <td>
                                        @if(optional($due_transaction)->branch_id != '') 
                                            {{optional($due_transaction->branch_info)->branch_name}}
                                        @else
                                            Admin
                                        @endif
                                    </td>
                                    <td>{{optional($due_transaction->customer_info)->name." [".optional($due_transaction->customer_info)->phone."]"}}</td>
                                    <td>{{number_format($due_transaction->received_amount, 2)}}</td>
                                    <td>#{{str_replace("_","/", $due_transaction->voucher_number)}}</td>
                                </tr>
                            @php($total_due_received = $total_due_received + $due_transaction->received_amount)
                            @endforeach
                            <tr>
                                <td align="right" colspan="5">Total Received = {{number_format($total_due_received, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                @endif
                <br>
                @if($expense_transactions != '[]')
                <li style="width: 49%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr><td align="center" colspan="5"><h3>Expense Payments</h3></td></tr>
                            <tr>
                                <th>DATE</th>
                                <th>Head Name</th>
                                <th>Amount</th>
                                <th>Voucher Num.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php( $total_expenses = 0)
                            @foreach($expense_transactions as $expense)
                                <tr>
                                    <td>{{date("d-m-Y", strtotime($expense->created_at))}}</td>
                                    <td>{{optional($expense->head_name)->head_name}}</td>
                                    <td>{{number_format($expense->amount, 2)}}</td>
                                    <td>#{{str_replace("_","/", $expense->voucher_num)}}</td>
                                </tr>
                            @php($total_expenses = $total_expenses + $expense->amount)
                            @endforeach
                            <tr>
                                <td align="right" colspan="5">Total Expenses = {{number_format($total_expenses, 2)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </li>
                @endif
                @if($loans != '[]')
                <li style="width: 49%;">
                    <table class="table table-bordered">
                        <thead>
                        <tr><td colspan="5" align="center"><h3>Loans</h3></td></tr>
                            <tr>
                                <th>Date</th>
                                <th>Lender Info</th>
                                <th>Paid or Re..</th>
                                <th>Amount</th>
                                <th>Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loans as $loan)
                                <tr>
                                    <td>{{date("d-m-Y", strtotime($loan->created_at))}}</td>
                                    <td>{{$loan->lender_info->name." [".$loan->lender_info->phone."]"}}</td>
                                    <td>{{$loan->paid_or_received}}</td>
                                    <td>{{number_format($loan->amount, 2)}}</td>
                                    <td>
                                        @if($loan->cash_or_cheque == 'cash') 
                                            <p>Voucher Num: </b># {{str_replace("_","/", $loan->voucher_num)}}<br /> <b>Note: </b>{{optional($loan)->note}}<br /> <b>Added By: </b>{{optional($loan->user_info)->name}}</p>
                                        @elseif($loan->cash_or_cheque == 'cheque')
                                            <p><b>Voucher Num: </b># {{str_replace("_","/", $loan->voucher_num)}}<br /> <b>Note: </b>{{optional($loan)->note}}<br /> <b>Added By: </b>{{optional($loan->user_info)->name}}</p>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </li>
                @endif
            </ul>
            
    </div>
        <div>
            @if($supplier_payment_transactions != '[]')
            <table class="table">
                <thead>
                <tr><td colspan="4" align="center"><h3>Supplier Payments</h3></td></tr>
                    <tr>
                        <th>DATE</th>
                        <th>Supplier Name</th>
                        <th>Amount</th>
                        <th>Voucher Num.</th>
                    </tr>
                </thead>
                <tbody>
                    @php( $total_supplier_payment_expenses = 0)
                    @foreach($supplier_payment_transactions as $supplier_payment_transaction)
                        <tr>
                            <td>{{date("d-m-Y", strtotime($supplier_payment_transaction->created_at))}}</td>
                            <td>{{optional($supplier_payment_transaction->supplier_info)->name." [".optional($supplier_payment_transaction->supplier_info)->company_name."]"}}</td>
                            <td>{{number_format($supplier_payment_transaction->paid, 2)}}</td>
                            <td>#{{str_replace("_","/", $supplier_payment_transaction->voucher_number)}}</td>
                        </tr>
                    @php($total_supplier_payment_expenses = $total_supplier_payment_expenses + $supplier_payment_transaction->paid)
                    @endforeach
                    <tr>
                        <td align="right" colspan="4">Total Supplier Payment = {{number_format($total_supplier_payment_expenses, 2)}}</td>
                    </tr>
                </tbody>
            </table>
            @endif
        </div>
        <br />
        <div>
            @if($capital != '[]')
            <table class="table">
                <thead>
                <tr><td colspan="5" align="center"><h3>Capital Transactions</h3></td></tr>
                    <tr>
                        <th>Date</th>
                        <th>Owner Info</th>
                        <th>Add or Withdrow</th>
                        <th>Amount</th>
                        <th>Info</th>
                    </tr>
                </thead>
               
                <tbody>
                    @foreach($capital as $capital_transaction)
                        <tr>
                            <td>{{date("d-m-Y", strtotime($capital_transaction->created_at))}}</td>
                            <td>{{$capital_transaction->owner_info->name." [".$capital_transaction->owner_info->phone."]"}}</td>
                            <td>{{$capital_transaction->add_or_withdraw}}</td>
                            <td>{{number_format($capital_transaction->amount, 2)}}</td>
                            <td>
                            <b>Voucher Num: </b>#{{str_replace("_","/", $capital_transaction->voucher_num)}}<br /> <b>Note: </b>{{optional($capital_transaction)->note}}<br /> <b>Added By: </b>{{optional($capital_transaction->user_info)->name}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
        <br />
        <div>
            @if($contra != '[]')
            <table class="table">
                <thead>
                <tr><td colspan="6" align="center"><h3>Contra / Balance Transfer</h3></td></tr>
                    <tr>
                        <th>Date</th>
                        <th>Added By</th>
                        <th>Contra Subject</th>
                        <th>Voucher Num.</th>
                        <th>Amount</th>
                        <th>note</th>
                    </tr>
                </thead>
               
                <tbody>
                    @foreach($contra as $contra_transaction)
                        <tr>
                            <td>{{date("d-m-Y", strtotime($contra_transaction->created_at))}}</td>
                            <td>{{optional($contra_transaction->user_info)->name}}</td>
                            <td>
                                @if($contra_transaction->CTB_or_BTC == 'CTB')
                                    <p>Cash To Bank<br /><b>Sender: </b>Cash<br /><b>Receiver: </b>{{optional($contra_transaction->receiver_info)->bank_name}}</p>
                                @elseif($contra_transaction->CTB_or_BTC == 'BTC')
                                    <p>Bank To Cash<br /><b>Sender: </b>{{optional($contra_transaction->sender_info)->bank_name}}<br /><b>Receiver: </b>Cash</p>
                                @endif
                            </td>
                            <td>#{{str_replace("_","/", $contra_transaction->voucher_number)}}</td>
                            <td>{{number_format($contra_transaction->contra_amount, 2)}}</td>
                            <td>{{optional($contra_transaction)->note}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
</body>
</html>
