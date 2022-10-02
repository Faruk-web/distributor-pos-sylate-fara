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
                            <div class="col-md-6"><h4 class="text-muted"><b>Supplier Ledger</b></h4></div>
                            <div class="col-md-6 text-right">
                            <div class="dropdown push">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Date Range</button>
                                <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-content-rich-primary">
                                    <form class="p-2" action="{{route('admin.supplier.date.range.ledger')}}" method="POST" target="_blank">
                                    @csrf    
                                    <div class="form-group">
                                            <label for=""><span class="text-danger">*</span> Start Date</label>
                                            <input type="date" required class="form-control" id="start_date" name="start_date">
                                        </div>
                                        <div class="form-group">
                                            <label for=""><span class="text-danger">*</span> End Date</label>
                                            <input type="date" required class="form-control" id="end_date" name="end_date">
                                        </div>
                                        <input type="hidden" name="supplier_id" id="supplier_id" value="{{$supplier_info->id}}">
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
                                    <tr><td>Opening Balance</td><td>{{number_format($supplier_info->opening_bl, 2)}}</td></tr>
                                    <tr><td>Total Sell</td><td>{{number_format($total_gross, 2)}}</td></tr>
                                    <tr><td>Instant Paid</td><td>{{number_format($paid_amount, 2)}}</td></tr>
                                    <tr><td>Due Payments</td><td>{{number_format($others_paid, 2)}}</td></tr>
                                    <tr><td>Total Return</td><td>{{number_format($total_return, 2)}}</td></tr>
                                    <tr class="text-right">
                                        @php( $balance = $supplier_info->opening_bl + $total_gross - $paid_amount - $others_paid - $total_return)
                                        <td colspan="2">Balance = {{number_format($balance, 2)}}</td>
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
                                        <i class="fas fa-people-carry text-light mr-1"></i> Supplier Info
                                    </h3>
                                </div>
                                <div class="block-content">
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="far fa-user-circle bg-muted text-light p-1 rounded"></i> </b> <span id="lender_name">{{optional($supplier_info)->name}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-business-time bg-muted text-light p-1 rounded"></i> </b> <span id="comapany_name">{{optional($supplier_info)->company_name}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-phone bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($supplier_info)->phone}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-envelope-square bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($supplier_info)->email}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-map-marker-alt bg-muted text-light p-1 rounded"></i> </b> <span id="lender_phone">{{optional($supplier_info)->address}}</span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b><i class="fas fa-comments-dollar bg-muted text-light p-1 rounded"></i> </b> <span id="lender_balance">{{number_format($supplier_info->balance, 2)}}</span></div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 shadow rounded p-2">
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-block align-items-center js-tabs-enabled" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" onclick="open_tab('tab_1')" id="tab_1" href="javascript:void(0)">Supplier Invoice</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_2')" id="tab_2">Supplier Payment</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_3')" id="tab_3">Returned Product</a>
                            </li>
                            <li class="nav-item ml-auto">
                                <div class="block-options pl-3 pr-2">
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                </div>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="tab_1_view" role="tabpanel">
                                <div class=""><h4><b>Supplier Invoice =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered invoice" id="invoices_supplier" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice Total</th>
                                                <th>Paid</th>
                                                <th>Invoice Num.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2_view" role="tabpanel">
                                <div class=""><h4><b>Supplier Payment =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered payment" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Pay By</th>
                                                <th>Paid Amount</th>
                                                <th>Voucher Num.</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3_view" role="tabpanel">
                                <div class=""><h4><b>Supplier Returned Product =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered returned-product_table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Invoice Num.</th>
                                                <th>How many times Edit</th>
                                                <th>action</th>
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

var supplier_id = $('#supplier_id').val();

$( document ).ready(function() {
    selected_tab_and_get_data('invoices');
});

function selected_tab_and_get_data(tab_data) {
    if(tab_data == 'invoices') {
        var table = $('#invoices_supplier').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                "url": "/admin/supplier-ledger-table-invoice-summery/"+supplier_id,
            },
            columns: [
                {data: 'date', name: 'date'},
                {data: 'total_gross', name: 'total_gross'},
                {data: 'paid', name: 'paid'},
                {data: 'invoice_num', name: 'invoice_num'},
                {data: 'action', name: 'action'}
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
    else if(tab_data == 'payment') {
        var table = $('table.payment').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                "url": "/admin/supplier-ledger-table-payment-summery/"+supplier_id,
            },
            columns: [
                {data: 'date', name: 'date'},
                {data: 'paymentBy', name: 'paymentBy'},
                {data: 'paid', name: 'paid'},
                {data: 'voucher_num', name: 'voucher_num'},
                {data: 'action', name: 'action'}
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
    else if(tab_data == 'returned_product') {
        var table = $('table.returned-product_table').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                "url": "/admin/supplier-returned-product-summery/"+supplier_id,
            },
            columns: [
                {data: 'date', name: 'date'},
                {data: 'invoice_num', name: 'invoice_num'},
                {data: 'how_many_times_edited', name: 'how_many_times_edited'},
                {data: 'action', name: 'action'}
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
}



function open_tab(tab_name) {
  
    if(tab_name == 'tab_1') {
        selected_tab_and_get_data('invoices');
        $('#tab_1').addClass('active');
        $('#tab_1_view').addClass('active');
        $('#tab_2').removeClass('active');
        $('#tab_2_view').removeClass('active');
        $('#tab_3').removeClass('active');
        $('#tab_3_view').removeClass('active');
    }
    else if(tab_name == 'tab_2') {
        
        $('#tab_1').removeClass('active');
        $('#tab_1_view').removeClass('active');
        $('#tab_2').addClass('active');
        $('#tab_2_view').addClass('active');
        $('#tab_3').removeClass('active');
        $('#tab_3_view').removeClass('active');
        selected_tab_and_get_data('payment');
        
    }
    else if(tab_name == 'tab_3') {
        $('#tab_1').removeClass('active');
        $('#tab_1_view').removeClass('active');
        $('#tab_2').removeClass('active');
        $('#tab_2_view').removeClass('active');
        $('#tab_3').addClass('active');
        $('#tab_3_view').addClass('active');
        selected_tab_and_get_data('returned_product');
    }
}
 
</script>
@endsection
