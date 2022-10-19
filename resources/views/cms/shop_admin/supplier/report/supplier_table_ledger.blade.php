@extends('cms.master')
@section('body_content')
<style>
    tr td {
        font-size: 13px;
    }
    tr td b {
        color: #F50057;
    }
    tr th {
        font-size: 13px;
    }
    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }
</style>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="row p-3">
            <div class="col-md-8">
                <h4 class="">Companies Ledger Table</h4>
                <input type="hidden" name="" id="toggle_yes" value='1'>
            </div>
            <div class="col-md-3 hidden-print">
                <div class="dropdown push">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Date Range</button>
                    <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-content-rich-primary">
                        <form class="p-2" action="javascript:void(0)" method="">
                            <div class="form-group">
                                <label for=""><span class="text-danger">*</span> Start Date</label>
                                <input type="date" class="form-control" id="date_range_start_date">
                            </div>
                            <div class="form-group">
                                <label for=""><span class="text-danger">*</span> End Date</label>
                                <input type="date" class="form-control" id="date_range_end_date">
                            </div>
                            <button type="button" onclick="date_range_supplier_table_ledger()" class="btn btn-success btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1 hidden-print"><button id="btnPrint" type="button" class="btn btn-danger btn-sm">Print</button></div>
        </div>
        @php( $currency = ENV('DEFAULT_CURRENCY'))
        <div class="block-content">
            <div class="table-responsive" id="supplier_table_ledger_body">
                
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {
        supplier_table_ledger('all', 0, 0);
        var toggle_yes = $('#toggle_yes').val();
        if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
            SidebarColpase();
        }
    });

    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });
    
    function date_range_supplier_table_ledger() {
        var date_range_start_date = $('#date_range_start_date').val();
        var date_range_end_date = $('#date_range_end_date').val();
        
        if(date_range_start_date != '' && date_range_end_date != '') {
            supplier_table_ledger('date_wise', date_range_start_date, date_range_end_date);
            $('#single_day_date').val('');
        }
        else {
            Toastify({
                text: "Select Date!",
                backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                className: "error",
            }).showToast();
            document.getElementById('error').play();
        }
    }
    
    function supplier_table_ledger(type, first_date, last_date) {
        $.ajax({
            type: 'get',
            url: '/supplier/supplier_table_ledger_data',
            data: {
                'first_date': first_date,
                'last_date': last_date,
                'type': type,
            },
            beforeSend: function() {
                $('#supplier_table_ledger_body').html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (data) {
                $('#supplier_table_ledger_body').html(data);
            }
        });
    }
    
</script>
@endsection
