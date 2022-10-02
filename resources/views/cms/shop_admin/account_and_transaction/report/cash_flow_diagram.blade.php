
@extends('cms.master')
@section('body_content')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
  
      function drawChart() {
        var data = google.visualization.arrayToDataTable();
   
        var options = {
          chart: {
            title: 'Website Performance',
            subtitle: 'Click and Views',
          },
        };
  
        var chart = new google.charts.Bar(document.getElementById('barchart_material'));
  
        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>


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
    
    #border_right{
        border-right: 1px solid #6C757D !important;
    }
    
</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
            <div class="row p-2">
                <div class="col-md-6"><h4 id="transaction_type_title">Cash Flow Diagrams</h4></div>
                <div class="col-md-6 text-right row hidden-print">
                    <div class="form-group col-md-6">
                        <select class="form-control select_info" name="transaction_type" id="select_info">
                            {{--<option value="cash_and_banks">Cash & Banks</option>--}}
                            <option value="only_cash">Cash</option>
                            <option value="all_banks">All Banks</option>
                            @foreach($banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}]</option>
                            @endforeach
                        </select>
                    </div>
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
                                    <button type="button" onclick="date_range_data()" class="btn btn-success btn-sm">Save</button> <button type="button" onclick="clear_date_range_data()" class="btn btn-danger btn-sm">Clear Date</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 hidden-print text-right"><button id="btnPrint" type="button" class="btn btn-dark btn-sm">Print</button></div>
                </div>
            </div>
        <input type="hidden" name="" id="toggle_yes" value='1'>
        <div class="block-content">
            <div class="pb-30">
                <div class="" id="expenses_data_body">
                    
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- END Page Content -->

<script type="text/javascript">
    
$(document).ready(function () {
    get_data()
    $('select.select_info').on('change', function() {
        var value = this.value;
        get_data()
        if(value == 'cash_and_banks') {
            $('#transaction_type_title').text('Transaction History');
        }
        else if(value == 'all_banks') {
            $('#transaction_type_title').text('All Banks Transactions');
        }
        else if(value == 'only_cash') {
            $('#transaction_type_title').text('Only Cash Transactions');
        }
        else {
            var bank_name = $( "#select_info option:selected" ).text();
            $('#transaction_type_title').text(bank_name+" Transactions");
        }
    });

});

function date_range_data() {
    var date_range_start_date = $('#date_range_start_date').val();
    var date_range_end_date = $('#date_range_end_date').val();
    
    if(date_range_start_date != '' && date_range_end_date != '') {
        get_data()
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

function clear_date_range_data() {
     $('#date_range_start_date').val('');
     $('#date_range_end_date').val('');
     success('All Date Cleared!');
     get_data()
}

function get_data() {
    var first_date = $('#date_range_start_date').val();
    var last_date = $('#date_range_end_date').val();
    var select_info = $('#select_info').val();
    
    $.ajax({
        type: 'get',
        url: '/admin/account/cash_flow_diagram_data',
        data: {
            'first_date': first_date,
            'last_date': last_date,
            'select_info': select_info,
        },
        beforeSend: function() {
            $('#expenses_data_body').html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
        },
        success: function (data) {
            $('#expenses_data_body').html(data);
            $('#exampleCheck1').prop('checked', false);
        },
        error: function(xhr, textStatus, error) {
            console.log(xhr.responseText);
            console.log(xhr.statusText);
            console.log(textStatus);
            console.log(error);
        }
    });
    
}


$(document).ready(function () {
    var toggle_yes = $('#toggle_yes').val();
    if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
        SidebarColpase();
    }
});

const $btnPrint = document.querySelector("#btnPrint");
$btnPrint.addEventListener("click", () => {
    window.print();
});

</script>
@endsection
