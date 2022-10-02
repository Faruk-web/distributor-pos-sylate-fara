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
        <div class="row p-3">
            <div class="col-md-10">
                <h4>Godown Stock In-Out Summery For <b class="text-primary">{{optional($product_info)->p_name}}</b></h4>
            </div>
            <div class="col-md-2 hidden-print text-right"><button id="btnPrint" type="button" class="btn btn-dark btn-sm">Print</button></div>
            <!--<div class="col-md-2 text-left">-->
            <!--    <img class="rounded border" src="{{asset(optional($product_info)->image)}}" alt="">-->
            <!--</div>-->
            <input type="hidden" name="" id="toggle_yes" value='1'>
            <input type="hidden" name="product_id" id="product_id" value='{{optional($product_info)->id}}'>
            
        </div>
        
        
        <div class="block-content">
            <div class="pb-30">
                <div class="" id="ledger_data_body">
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
    var this_month = $('#this_month').val();
    var product_id = $('#product_id').val();
    
    $(document).ready(function () {
        var toggle_yes = $('#toggle_yes').val();
        if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
            SidebarColpase();
        }
       
        ledger_data(this_month, 'all', product_id);
        
    });


    function change_details_view() {
        if($('input[name="view_details"]').is(':checked')) {
          $('.ledger_details').show();
        }
        else {
         $('.ledger_details').hide();
        }
    }

  
    function ledger_data(date_or_month, action, product_id) {
       
        $.ajax({
            type: 'get',
            url: '/admin/report/godowns-product-in-out-summery-data',
            data: {
                'date_or_month': date_or_month,
                'action': action,
                'product_id': product_id,
            },
            beforeSend: function() {
                $('#ledger_data_body').html('<div class="text-center"><div class="spinner-border text-dark mb-5" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            success: function (data) {
                $('#ledger_data_body').html(data);
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

