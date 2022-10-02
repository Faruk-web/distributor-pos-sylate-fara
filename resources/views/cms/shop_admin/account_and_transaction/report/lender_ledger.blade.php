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
                            <div class="col-md-6"><h4 class="text-muted"><b>Lender Ledger</b></h4></div>
                            <div class="col-md-6 text-right">
                            <div class="dropdown push">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Date Range</button>
                                <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-content-rich-primary">
                                    <form class="p-2" action="{{route('admin.lender.date.range.ledger')}}" method="POST" target="_blank">
                                    @csrf    
                                    <div class="form-group">
                                            <label for=""><span class="text-danger">*</span> Start Date</label>
                                            <input type="date" required class="form-control" id="start_date" name="start_date">
                                        </div>
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">*</span> End Date</label>
                                            <input type="date" required class="form-control" id="end_date" name="end_date">
                                        </div>
                                        <input type="hidden" name="lender_id" id="lender_id" value="{{$lender_info->id}}">
                                        <div class="text-right"><button type="submit" class="btn btn-success btn-sm">Save</button></div>
                                    </form>
                                </div>
                            </div>
                            </div>
                        </div>
                            <table class="table table-bordered">
                                <thead>
                                <tr class="text-center"><th colspan="2"><p><b>Balance Sheet</b></p></th></tr>
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
                                    <tr class="text-right">
                                        @php( $balance = $lender_info->opening_balance + $cash_loan_received + $bank_loan_received - $cash_loan_paid - $bank_loan_paid)
                                        <td colspan="2">Balance( Total Received - Total Paid ) = {{number_format($balance, 2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="col-md-4 p-2">
                    <div class="lender_info rounded shadow p-3">
                    <div class="block block-rounded">
                                <div class="block-header block-header-default bg-primary">
                                    <h3 class="block-title text-light">
                                        <i class="fas fa-people-carry text-light mr-1"></i> Lender Info
                                    </h3>
                                </div>
                                <div class="block-content">
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="far fa-user-circle bg-muted text-light p-1 rounded"></i> </b> <span id="lender_name">{{optional($lender_info)->name}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-phone bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($lender_info)->phone}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-envelope-square bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($lender_info)->email}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-map-marker-alt bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($lender_info)->address}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-comments-dollar bg-muted text-light p-1 rounded"></i> </b> <span id="lender_balance">{{number_format($lender_info->balance, 2)}}</span></div>
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
                            <div class=""><h4><b>Summery</b></h4></div>
                            <div class="table-responsive">
                                <table class="table table-bordered invoice" id="invoices_supplier" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Added By</th>
                                            <th>PAID OR RECEIVED</th>
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

var lender_id = $('#lender_id').val();

$( document ).ready(function() {
    var table = $('#invoices_supplier').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        ajax: {
            "url": "/admin/lender-ledger-table-invoice-summery/"+lender_id,
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'added_by', name: 'added_by'},
            {data: 'paid_or_received', name: 'paid_or_received'},
            {data: 'amount', name: 'amount'},
            {data: 'info', name: 'info'}
        ],
        "scrollY": "300px",
        "pageLength": 50,
        "ordering": false,
    });
});

</script>
@endsection
