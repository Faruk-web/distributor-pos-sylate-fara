
@extends('cms.master')
@section('body_content')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>
    tr td{
        font-size: 13px;
    }
</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
    <form action="{{route('admin.report.print.transaction.history')}}" method="post" target="_blank">
            @csrf
            <div class="row p-2">
                <div class="col-md-6"><h4 id="transaction_type_title">Transaction History</h4></div>
                <div class="col-md-6 text-right row">
                    <div class="form-group col-md-6">
                        <select class="form-control bank_change" name="transaction_type" id="bank_change">
                            <option value="cash_and_banks">Cash & Banks</option>
                            <option value="only_cash">Only Cash</option>
                            <option value="all_banks">All Banks</option>
                            @foreach($banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}]</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="dropdown push">
                            <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Date Range</button>
                            <div class="dropdown-menu font-size-sm p-2" aria-labelledby="dropdown-content-rich-primary" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(202px, 31px, 0px);">
                                <div class="form-group">
                                        <label for=""><span class="text-danger">*</span> Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date">
                                    </div>
                                    <div class="form-group">
                                        <label for=""><span class="text-danger">*</span> End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 text-left">
                        <button type="submit" class="btn btn-primary btn-sm">Print</button>
                    </div>
                </div>
            </div>
        </form>
        <input type="hidden" name="" id="toggle_yes" value='1'>
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
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
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<script type="text/javascript">
    
$(document).ready(function () {

    get_data('cash_and_banks');
    $('select.bank_change').on('change', function() {
        var value = this.value;
        if(value == 'cash_and_banks') {
            get_data('cash_and_banks');
            $('#transaction_type_title').text('Transaction History');
        }
        else if(value == 'all_banks') {
            get_data('all_banks');
            $('#transaction_type_title').text('All Banks Transactions');
        }
        else if(value == 'only_cash') {
            get_data('only_cash');
            $('#transaction_type_title').text('Only Cash Transactions');
        }
        else {
            get_data(value);
            var bank_name = $( "#bank_change option:selected" ).text();
            $('#transaction_type_title').text(bank_name+" Transactions");
        }
    });

});

function get_data(type) {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        ajax: {
            "url": "/admin/account/cash-flow-data/"+type,
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
}



    $(document).ready(function () {
        var toggle_yes = $('#toggle_yes').val();
        if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
            SidebarColpase();
        }
    });


</script>
@endsection
