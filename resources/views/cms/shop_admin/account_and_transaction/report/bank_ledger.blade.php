@extends('cms.master')
@section('body_content')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/toastify-js.js') }}"></script>
<style>


</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="col-md-12 p-2 shadow rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-muted"><b>Bank Ledger</b></h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="dropdown push">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Date Range</button>
                                    <div class="dropdown-menu font-size-sm"
                                        aria-labelledby="dropdown-content-rich-primary">
                                        <form class="p-2" action="{{route('admin.bank.date.range.ledger')}}"
                                            method="POST" target="_blank">
                                            @csrf
                                            <div class="form-group">
                                                <label for=""><span class="text-danger">*</span> Start Date</label>
                                                <input type="date" required class="form-control" id="start_date"
                                                    name="start_date">
                                            </div>
                                            <div class="form-group">
                                                <label for=""><span class="text-danger">*</span> End Date</label>
                                                <input type="date" required class="form-control" id="end_date"
                                                    name="end_date">
                                            </div>
                                            <input type="hidden" name="bank_id" id="bank_id"
                                                value="{{$bank_info->id}}">
                                            <div class="text-right"><button type="submit"
                                                    class="btn btn-success btn-sm">Save</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    
                        <table class="table table-bordered">
                            <thead>
                                <tr align="center" class="text-light bg-dark">
                                    <th colspan="3">Balance Sheet</th>
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
                                                    <th colspan="2">Total Cash In = {{number_format($total_cash_in ,2)}}</th>
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
                                                    <th colspan="2">Total Cash Out = {{number_format($total_cash_out ,2)}}</th>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <!--This is for Bank Received End-->
                                <tr class="text-right">
                                    <th colspan="3">Balance = {{number_format($total_cash_in - $total_cash_out ,2)}}</th>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="lender_info rounded shadow p-3">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default bg-dark">
                                <h3 class="block-title text-light">
                                    <i class="fa fa-university text-light mr-1"></i> Bank Info
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="fa fa-university bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_name">{{optional($bank_info)->bank_name}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i class="fab fa-accusoft bg-muted text-light p-1 rounded"></i>
                                        </b> <span id="lender_phone">{{optional($bank_info)->account_type}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="fab fa-adn bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_phone">{{optional($bank_info)->account_no}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="fas fa-map-marker-alt bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_phone">{{optional($bank_info)->bank_branch}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="fas fa-comments-dollar bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_balance">{{number_format($bank_info->balance, 2)}}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 shadow rounded p-2">
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-block align-items-center js-tabs-enabled" data-toggle="tabs"
                            role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" onclick="open_tab('tab_summery')" id="tab_summery"
                                    href="javascript:void(0)">Summery</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="open_tab('tab_1')" id="tab_1"
                                    href="javascript:void(0)">Selll Paid</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_2')"
                                    id="tab_2">Customer Due Received</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_3')"
                                    id="tab_3">Expense Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_4')"
                                    id="tab_4">Loan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_5')"
                                    id="tab_5">Supplier Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_6')"
                                    id="tab_6">Capital</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_7')"
                                    id="tab_7">Contra / Balance Transfer</a>
                            </li>
                            
                            
                            <li class="nav-item ml-auto">
                                <div class="block-options pl-3 pr-2">
                                    <button type="button" class="btn-block-option" data-toggle="block-option"
                                        data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                </div>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="tab_summery_view" role="tabpanel">
                                <div class="">
                                    <h4><b>All Transaction Summery =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered invoice" id="bank_transaction_summery" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Added By</th>
                                                <th>Info</th>
                                                <th>CR / DR</th>
                                                <th>Amount</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_1_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Sell Paid =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered invoice" id="sell_paid_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Branch Name</th>
                                                <th>Inv Total</th>
                                                <th>Paid</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Customer Due Received =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered customer-due-received" width="100%">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>Branch Name</th>
                                                <th>CUSTOMER NAME</th>
                                                <th>Amount</th>
                                                <th>Voucher Num.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Expense Payments =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered expense-payments" width="100%">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>Head Name</th>
                                                <th>Amount</th>
                                                <th>Voucher Num.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Loans =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered loans-transaction" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Lender Info</th>
                                                <th>Paid or Re..</th>
                                                <th>Amount</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_5_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Supplier Payments =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered supplier-payment" width="100%">
                                        <thead>
                                            <tr>
                                                <th>DATE</th>
                                                <th>Supplier Name</th>
                                                <th>Amount</th>
                                                <th>Voucher Num.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_6_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Capital =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered capital-transaction" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Owner Info</th>
                                                <th>Add or Withdrow</th>
                                                <th>Amount</th>
                                                <th>Info</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_7_view" role="tabpanel">
                                <div class="">
                                    <h4><b>Contra / Balance Transfer =></b></h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered contra-transaction" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Added By</th>
                                                <th>Contra Subject</th>
                                                <th>Voucher Num.</th>
                                                <th>Amount</th>
                                                <th width="20%">note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->


<script type="text/javascript">
    var bank_id = $('#bank_id').val();

    $(document).ready(function () {
        selected_tab_and_get_data('bank_summery');
    });

    function selected_tab_and_get_data(tab_data) {
        if (tab_data == 'bank_summery') {
            var table = $('#bank_transaction_summery').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/bank-ledger-transaction-summery/"+bank_id,
                },
                columns: [  
                    {data: 'date', name: 'date'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'info', name: 'info'},
                    {data: 'cr_or_dr', name: 'cr_or_dr'},
                    {data: 'amount', name: 'amount'},
                    {data: 'note', name: 'note'},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        } else if (tab_data == 'sell_paid') {
            var table = $('#sell_paid_table').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/cheque-sell-paid-invoice-summery/"+bank_id,
                },
                columns: [  
                    { data: 'date', name: 'date' },
                    { data: 'branch_name', name: 'branch_name' },
                    { data: 'invoice_total', name: 'invoice_total' },
                    { data: 'paid_amount', name: 'paid_amount' },
                    { data: 'action', name: 'action' }
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        } else if (tab_data == 'customer_due_received') {
            var table = $('table.customer-due-received').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/customer-due-received-summery-by-bank/"+bank_id,
                },
                columns: [  
                    {data: 'date', name: 'date'},
                    {data: 'branch_name', name: 'branch_name'},
                    {data: 'customer_name', name: 'customer_name'},
                    {data: 'received_amount', name: 'received_amount'},
                    {data: 'voucher_num', name: 'voucher_num'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        } 
        else if (tab_data == 'expenses_payment') {
            var table = $('table.expense-payments').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/bank-ledger-expenses-summery/"+bank_id,
                },
                columns: [  
                    {data: 'date', name: 'date'},
                    {data: 'head_name', name: 'head_name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'voucher_num', name: 'voucher_num'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        }
        else if (tab_data == 'loan_transaction') {
            var table = $('table.loans-transaction').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/bank-ledger-loans-summery/"+bank_id,
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'lender_info', name: 'lender_info'},
                    {data: 'paid_or_received', name: 'paid_or_received'},
                    {data: 'amount', name: 'amount'},
                    {data: 'info', name: 'info'},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        }
        else if (tab_data == 'supplier_payments') {
            var table = $('table.supplier-payment').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/bank-ledger-supplier-payments-summery/"+bank_id,
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'supplier_name', name: 'supplier_name'},
                    {data: 'paid', name: 'paid'},
                    {data: 'voucher_num', name: 'voucher_num'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        }
        else if (tab_data == 'capitals') {
            var table = $('table.capital-transaction').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/bank-ledger-capitals-summery/"+bank_id,
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'owner_info', name: 'owner_info'},
                    {data: 'add_or_withdraw', name: 'add_or_withdraw'},
                    {data: 'amount', name: 'amount'},
                    {data: 'info', name: 'info'},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        }
        else if (tab_data == 'contra') {
            var table = $('table.contra-transaction').DataTable({
                processing: true,
                serverSide: true,
                "bDestroy": true,
                ajax: {
                    "url": "/admin/bank-ledger-contras-summery/"+bank_id,
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'added_by', name: 'added_by'},
                    {data: 'subject', name: 'subject'},
                    {data: 'voucher_num', name: 'voucher_num'},
                    {data: 'contra_amount', name: 'contra_amount'},
                    {data: 'note', name: 'note'},
                ],
                "scrollY": "300px",
                "pageLength": 50,
                "ordering": false,
            });
        }
        
    }


    function open_tab(tab_name) {

        if (tab_name == 'tab_summery') {
            $('#tab_summery').addClass('active');
            $('#tab_summery_view').addClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('bank_summery');
            
        } else if (tab_name == 'tab_1') {
            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').addClass('active');
            $('#tab_1_view').addClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('sell_paid');
            
        } else if (tab_name == 'tab_2') {

            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').addClass('active');
            $('#tab_2_view').addClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('customer_due_received');

        } else if (tab_name == 'tab_3') {
            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').addClass('active');
            $('#tab_3_view').addClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('expenses_payment');
        }
        else if (tab_name == 'tab_4') {
            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').addClass('active');
            $('#tab_4_view').addClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('loan_transaction');
        }
        else if (tab_name == 'tab_5') {
            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').addClass('active');
            $('#tab_5_view').addClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('supplier_payments');
        }
        else if (tab_name == 'tab_6') {
            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').addClass('active');
            $('#tab_6_view').addClass('active');
            $('#tab_7').removeClass('active');
            $('#tab_7_view').removeClass('active');

            selected_tab_and_get_data('capitals');
        }
        else if (tab_name == 'tab_7') {
            $('#tab_summery').removeClass('active');
            $('#tab_summery_view').removeClass('active');
            $('#tab_1').removeClass('active');
            $('#tab_1_view').removeClass('active');
            $('#tab_2').removeClass('active');
            $('#tab_2_view').removeClass('active');
            $('#tab_3').removeClass('active');
            $('#tab_3_view').removeClass('active');
            $('#tab_4').removeClass('active');
            $('#tab_4_view').removeClass('active');
            $('#tab_5').removeClass('active');
            $('#tab_5_view').removeClass('active');
            $('#tab_6').removeClass('active');
            $('#tab_6_view').removeClass('active');
            $('#tab_7').addClass('active');
            $('#tab_7_view').addClass('active');

            selected_tab_and_get_data('contra');
        }
    }

</script>
@endsection
