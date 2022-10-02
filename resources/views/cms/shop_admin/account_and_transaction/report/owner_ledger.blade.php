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

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="col-md-12 p-2 shadow rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="text-muted"><b>Business Owner Ledger</b></h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <div class="dropdown push">
                                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle"
                                        id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">Date Range</button>
                                    <div class="dropdown-menu font-size-sm"
                                        aria-labelledby="dropdown-content-rich-primary">
                                        <form class="p-2" action="{{route('admin.owner.date.range.ledger')}}"
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
                                            <input type="hidden" name="owner_id" id="owner_id"
                                                value="{{$owner_info->id}}">
                                            <div class="text-right"><button type="submit"
                                                    class="btn btn-success btn-sm">Save</button></div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr class="text-center bg-dark text-light">
                                    <th colspan="3">Balance Sheet</th>
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
                                    <th colspan="3">Balance = {{number_format($owner_info->opening_capital + $capital_add_in_cash+$capital_add_in_cheque - $capital_withdraw_in_cash - $capital_withdraw_in_cheque, 2)}}</th>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="owner_info rounded shadow p-3">
                        <div class="block block-rounded">
                            <div class="block-header block-header-default bg-primary">
                                <h3 class="block-title text-light">
                                    <i class="far fa-user-circle text-light mr-1"></i> Owner Info
                                </h3>
                            </div>
                            <div class="block-content">
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="far fa-user-circle bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_name">{{optional($owner_info)->name}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i class="fas fa-phone bg-muted text-light p-1 rounded"></i>
                                        </b> <span id="lender_phone">{{optional($owner_info)->phone}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="fas fa-map-marker-alt bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_phone">{{optional($owner_info)->address}}</span></div>
                                </div>
                                <div class="media d-flex align-items-center push">
                                    <div class="mr-3"><b><i
                                                class="fas fa-comments-dollar bg-muted text-light p-1 rounded"></i> </b>
                                        <span id="lender_balance">{{number_format($owner_info->capital, 2)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 shadow rounded p-2">
                    <div class="block-content tab-content">
                        <div class="tab-pane active" id="tab_1_view" role="tabpanel">
                            <div class="">
                                <h4><b>Summery</b></h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered invoice" id="invoices_supplier" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
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
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- END Page Content -->


<script type="text/javascript">
    var owner_id = $('#owner_id').val();

    $(document).ready(function () {
        var table = $('#invoices_supplier').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                "url": "/admin/owner-ledger-table-transaction-summery/" + owner_id,
            },
            columns: [
                {data: 'date', name: 'date'},
                {data: 'add_or_withdraw', name: 'add_or_withdraw'},
                {data: 'amount', name: 'amount'},
                {data: 'info', name: 'info'},
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    });

</script>
@endsection
