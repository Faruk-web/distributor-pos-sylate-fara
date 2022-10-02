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
            <div class="row">
                <div class="col-md-12 shadow rounded p-2">
                    <h4><b>Ledger</b></h4>
                    <div class="block block-rounded">
                        <ul class="nav nav-tabs nav-tabs-block align-items-center js-tabs-enabled" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" onclick="open_tab('tab_1')" id="tab_1" href="javascript:void(0)">Customer Ledger</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_2')" id="tab_2">Supplier Ledger</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_3')" id="tab_3">Lender Ledger</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_4')" id="tab_4">Bank Ledger</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_5')" id="tab_5">Owner Ledger</a>
                            </li>
                            <li class="nav-item ml-auto">
                                <div class="block-options pl-3 pr-2">
                                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"><i class="si si-size-fullscreen"></i></button>
                                </div>
                            </li>
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane active" id="tab_1_view" role="tabpanel">
                                <div class=""><h4><b>Customers =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered all-customers">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Code</th>
                                                <th>Balance</th>
                                                <th>Action</th>                        
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2_view" role="tabpanel">
                                <div class=""><h4><b>Suppliers =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered all-supplier-for-ledger">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Company Name</th>
                                                <th>Phone</th>
                                                <th>Code</th>
                                                <th>Balance</th>
                                                <th>Action</th>                        
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_3_view" role="tabpanel">
                                <div class=""><h4><b>Lenders =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered lenders-for-ledger" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Lender Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Balance</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_4_view" role="tabpanel">
                                <div class=""><h4><b>All Banks =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered banks-for-ledger" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Bank Name</th>
                                                <th>Account No.</th>
                                                <th>Branch Name</th>
                                                <th>Account Type</th>
                                                <th>Balance</th>
                                                <th>action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_5_view" role="tabpanel">
                                <div class=""><h4><b>Capital persons / Owners =></b></h4></div>
                                <div class="table-responsive">
                                    <table class="table table-bordered capital-persons-for-ledger" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Nid Numbers</th>
                                                <th>Address</th>
                                                <th>Capital</th>
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

var customer_id = 1;

$( document ).ready(function() {
    selected_tab_and_get_data('customer_ledger');
});
  
function selected_tab_and_get_data(tab_data) {
    if(tab_data == 'customer_ledger') {
         var customer_type = 'all';
        var table = $('table.all-customers').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                "url": "/admin/customer-report-customer-info/"+customer_type,
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'code', name: 'code'},
                {data: 'balance', name: 'balance'},
                {data: 'action', name: 'action'},
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
    else if(tab_data == 'supplier_ledger') {
        var supplier_type = 'all';
        var table = $('.all-supplier-for-ledger').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: {
                "url": "/admin/supplier-report-supplier-info/"+supplier_type,
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'company_name', name: 'company_name'},
                {data: 'phone', name: 'phone'},
                {data: 'code', name: 'code'},
                {data: 'balance', name: 'balance'},
                {data: 'action', name: 'action'},
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
    else if(tab_data == 'lender_ledger') {
        var table = $('table.lenders-for-ledger').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: "{{ route('admin.all.lender.for.ledger') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'balance', name: 'balance'},
                {data: 'action', name: 'action'}
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
    else if(tab_data == 'banks_ledger') {
        var table = $('table.banks-for-ledger').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: "{{ route('admin.all.banks.for.ledger') }}",
            columns: [
                {data: 'bank_name', name: 'bank_name'},
                {data: 'account_no', name: 'account_no'},
                {data: 'bank_branch', name: 'bank_branch'},
                {data: 'account_type', name: 'account_type'},
                {data: 'balance', name: 'balance'},
                {data: 'action', name: 'action'}
            ],
            "scrollY": "300px",
            "pageLength": 50,
            "ordering": false,
        });
    }
    else if(tab_data == 'owners_ledger') {
        var table = $('table.capital-persons-for-ledger').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: "{{ route('admin.all.owners.for.ledger') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'nid_number', name: 'nid_number'},
                {data: 'address', name: 'address'},
                {data: 'capital', name: 'capital'},
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
        
        selected_tab_and_get_data('customer_ledger');
    }
    else if(tab_name == 'tab_2') {
        
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

        selected_tab_and_get_data('supplier_ledger');
        
    }
    else if(tab_name == 'tab_3') {
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

        selected_tab_and_get_data('lender_ledger');
    }
    else if(tab_name == 'tab_4') {
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

        selected_tab_and_get_data('banks_ledger');
    }
    else if(tab_name == 'tab_5') {
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

        selected_tab_and_get_data('owners_ledger');
    }
    
}

   
</script>
@endsection
