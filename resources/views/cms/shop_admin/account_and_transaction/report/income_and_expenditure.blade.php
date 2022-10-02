@extends('cms.master')
@section('body_content')
<?php
    $shop_info = DB::table('shop_settings')->where('shop_code', Auth::user()->shop_id)->first();
?>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/toastify-js.js') }}"></script>
<style>
    @media print {
        .hidden-print,
        .hidden-print * {
            display: none !important;
        }
    }
    
    #font_size_12 {
        font-size: 12px;
        color: #F68B1F;
    }

</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="row p-2">
            <div class="col-md-6">
                <h4 class="mb-1">Income & Expenditure</h4>
                <span>{{optional($shop_info)->shop_name}}<br>{!!optional($shop_info)->address!!}</span>
            </div>
            
            <div class="col-md-3 hidden-print"><input type="month" value="{{date('Y-m')}}" name="" class="form-control" id="month_name"></div>
            
            <div class="col-md-2 hidden-print">
                <div class="dropdown push">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Date Range</button>
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
                            <button type="button" onclick="date_range_income_and_expenditure_data()" class="btn btn-success btn-sm">Save</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-1 hidden-print text-right"><button id="btnPrint" type="button" class="btn btn-dark btn-sm">Print</button></div>
            <input type="hidden" name="" id="toggle_yes" value='1'>
        </div>
        
        <div class="block-content">
            <div class="pb-30">
                <div class="" id="income_and_expenditure_data_body">
                    <div class="row">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="" id="this_month" value="{{date('Y-m')}}">
</div>
<!-- END Page Content -->


<script type="text/javascript">
    $(document).ready(function () {
        var toggle_yes = $('#toggle_yes').val();
        if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
            SidebarColpase();
        }
        var this_month = $('#this_month').val();
        income_and_expenditure_data(this_month, 'm');
        
    });


    $('#month_name').change(function() {
        var month_name = $(this).val();
        if(month_name != '') {
            income_and_expenditure_data(month_name, 'm');
            $('#date_range_start_date').val('');
        }
        else {
            Toastify({
                text: "Select Month!",
                backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                className: "error",
            }).showToast();
            document.getElementById('error').play();
        }
    });

    function date_range_income_and_expenditure_data() {
        var date_range_start_date = $('#date_range_start_date').val();
        var date_range_end_date = $('#date_range_end_date').val();
        
        if(date_range_start_date != '' && date_range_end_date != '') {
            income_and_expenditure_data(0, 'date_range', date_range_start_date, date_range_end_date);
            $('#month_name').val('');
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

  

    function income_and_expenditure_data(date_or_month, action, first_date, last_date) {
        $.ajax({
            type: 'get',
            url: '/admin/report/income-expenditure-data',
            data: {
                'date_or_month': date_or_month,
                'action': action,
                'first_date': first_date,
                'last_date': last_date,
            },
            beforeSend: function() {
                $('#income_and_expenditure_data_body').html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (data) {
                $('#income_and_expenditure_data_body').html(data);
            },
            error: function(xhr, textStatus, error) {
                console.log(xhr.responseText);
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
        });
    }

    const $btnPrint = document.querySelector("#btnPrint");
    $btnPrint.addEventListener("click", () => {
        window.print();
    });

</script>
@endsection
