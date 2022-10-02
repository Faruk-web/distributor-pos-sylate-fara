@extends('cms.master')
@section('body_content')

@php
    $sms_balance = Auth::user()->shop_info->sms_limit;
@endphp


<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/toastify-js.js') }}"></script>
<style>
    #result{height:600px;overflow:auto;overflow-x: hidden;}
    #product_text {font-size: 13px; text-align: left;}
    .my-custom-scrollbar {
        position: relative;
        height: 280px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }

    .pd-name {
        font-size: 13px !important;
    }

    #product-item{
        border: 1px solid #2C2E3B;
        cursor: cell;
        border-radius: 5px;
    }

    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: hidden !important;
        
    }
</style>
<!-- Page Content -->
<div class="content">
    <input type="hidden" name="" id="toggle_yes" value='1'>
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row">
                <div class="col-md-6 p-2">
                    <div class="block block-rounded" id="sms_body">
                        <form method="POST" action="javascript:void(0)" id="send_sms_form" class="p-3 shadow rounded mt-3">
                            @csrf
                        <div class="table-wrapper-scroll-y my-custom-scrollbar shadow rounded p-2">
                            <table id="mainTable" class="table table-sm table-hover ">
                                <thead class="thead-dark">
                                    <tr class="">
                                        <th style="padding: 10px 7px;" width="50%">Name</th>
                                        <th style="padding: 10px 7px;">Phone Number</th>
                                        <th style="padding: 10px 7px;" width="5%" class="text-center">action</th>
                                    </tr>
                                </thead>
                                <tbody id="demo" class="demo">
                                    <!--<tr>-->
                                    <!--    <td>Name</td>-->
                                    <!--    <td><input type="hidden" name="phone[]" value="01627382866" id="01627382866">phone</td>-->
                                    <!--    <td class="text-center"><button type="button" id="remove" name="remove" class="btn btn-outline-danger btn-sm remove btnSelect text-center"><span class="glyphicon glyphicon-minus"></span><i class="fas fa-trash-alt"></i></button></td>-->
                                    <!--</tr>-->
                                </tbody>
                            </table>
                        </div>
                        <small>Total Contacts <span id="total_contacts">0</span></small>
                            <div class="form-group">
                                <label for=""><span class="text-danger">*</span>SMS Text</label>
                                <textarea class="form-control" id="" name="sms_text" required="" rows="5" spellcheck="true"></textarea>
                             </div>
                          <div class="form-check text-right">
                            @if($sms_balance > 0) 
                                <button type="submit" id="send_sms_form_submit_button" class="btn btn-success btn-rounded">Send</button>
                                <button type="button" id="send_sms_form_senging_button" style="display: none;" class="btn btn-primary btn-rounded">Sending....</button>
                            @else
                                <p class="fw-bold text-danger">Insufficient sms balance, Please Recharge From <a class="text-info" href="{{route('admin.sms.panel')}}">Here</a></p>
                            @endif
                          </div>
                        </form>
                    </div>
                    
                    <div class="block block-rounded" id="sms_output" style="display: none;">
                        <div class="table-wrapper-scroll-y my-custom-scrollbar shadow rounded p-2">
                            <span class="text-success fw-bold">SMS Output =></span>
                            <table id="sms_output_tabel" class="table table-sm table-hover ">
                                <thead class="bg-success text-light">
                                    <tr class="">
                                        <th style="padding: 10px 7px;">Phone Number</th>
                                        <th style="padding: 10px 7px;" width="60%">Info</th>
                                    </tr>
                                </thead>
                                <tbody id="sms_output_tabel_body" class="">
                                    <tr>
                                        <td>phone</td>
                                        <td><span class="badge badge-success">Success</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center p-3 mt-4">
                            <a type="button" class="btn btn-success btn-rounded" href="{{route('/')}}">Go Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 p-2">
                    <div class="block block-rounded shadow rounded">
                        <ul class="nav nav-tabs nav-tabs-block align-items-center js-tabs-enabled" data-toggle="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="javascript:void(0)" onclick="open_tab('tab_3')" id="tab_3">Add New </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" onclick="open_tab('tab_1')" id="tab_1" href="javascript:void(0)">Customers</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="open_tab('tab_2')" id="tab_2">Suppliers</a>
                            </li>
                            
                            <li class="nav-item ml-auto mr-2">
                                <div class="block-options pl-3 pr-2 border border-primary rounded fw-bold bg-success text-light"><b>Balance: {{number_format($sms_balance, 2)}} TK</b></div>
                            </li>
                            
                        </ul>
                        <div class="block-content tab-content">
                            <div class="tab-pane" id="tab_1_view" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered all-customers">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Phone</th>
                                                <th>Action</th>                        
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_2_view" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered all-supplier-for-ledger">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Company Name</th>
                                                <th>Phone</th>
                                                <th>Action</th>                        
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane active mb-4 p-3" id="tab_3_view" role="tabpanel">
                              <div class="form-group">
                                <label for="">Name (Optional)</label>
                                <input type="text" class="form-control" id="custom_contact_name" placeholder="">
                              </div>
                              <div class="form-group">
                                <label for=""><span class="text-danger">*</span>Phone Number</label>
                                <input type="number" class="form-control" id="custom_contact_phone" placeholder="Ex: 01627382866">
                              </div>
                              <div class="form-check text-right">
                                <button type="button" onclick="add_custom_contact()" class="btn btn-primary">Add</button>
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
    selected_tab_and_get_data('custom_phone_number');
    
    var toggle_yes = $('#toggle_yes').val();
    if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
        SidebarColpase();
    }
    
    $("#mainTable").on('click', '.btnSelect', function() {
        var currentRow = $(this).closest("tr");
        $(this).parents("tr").remove();
        row_count();
    });
    
    
});
  
function selected_tab_and_get_data(tab_data) {
    if(tab_data == 'customer_ledger') {
        var table = $('table.all-customers').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: "{{ route('admin.sms.send.customer.data') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action'},
            ],
            "scrollY": "300px",
            "pageLength": 100,
            "ordering": false,
        });
    }
    else if(tab_data == 'supplier_ledger') {
        var table = $('.all-supplier-for-ledger').DataTable({
            processing: true,
            serverSide: true,
            "bDestroy": true,
            ajax: "{{ route('admin.sms.send.supplier.data') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'company_name', name: 'company_name'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action'},
            ],
            "scrollY": "300px",
            "pageLength": 100,
            "ordering": false,
        });
    }
    else if(tab_data == 'custom_phone_number') {
        
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

        selected_tab_and_get_data('custom_phone_number');
    }
    
}


function add_custom_contact() {
    var name = $('#custom_contact_name').val();
    var phone = $('#custom_contact_phone').val();
    if(phone.length == 11) {
       add_to_contact_store(name, phone); 
    }
    else {
        Toastify({
            text: "Phone number must be 11 digits!",
            backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
            className: "error",
        }).showToast();
        var play = document.getElementById('error').play();
    }
    
}




function add_to_contact_store(name, phone) {
    var check_phone = $('#'+phone).val();
    if(phone.length == 11) {
        if(check_phone == null) {
            $('#demo').prepend('<tr><td>'+name+'</td><td><input type="hidden" name="phone[]" value="'+phone+'" id="'+phone+'">'+phone+'</td><td class="text-center"><button type="button" id="remove" name="remove" class="btn btn-outline-danger btn-sm remove btnSelect text-center"><span class="glyphicon glyphicon-minus"></span><i class="fas fa-trash-alt"></i></button></td></tr>');
            document.getElementById('success1').play();
        }
        else {
            Toastify({
                text: "This Contact is already exist!",
                backgroundColor: "linear-gradient(to right, #6E32CF, #6E32CF)",
                className: "error",
            }).showToast();
            var play = document.getElementById('error').play();
        }
    }
    else {
        Toastify({
            text: "Phone number must be 11 digits!",
            backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
            className: "error",
        }).showToast();
        var play = document.getElementById('error').play();
    }
    row_count();
}

function row_count() {
    var rowCount = $('#mainTable >tbody >tr').length;
    $('#total_contacts').html(rowCount);
}



$('#send_sms_form_submit_button').click(function(e){
    if (document.getElementById("send_sms_form").checkValidity()) { 
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //$('#send_form').html('Sending..');
        
        $.ajax({
            url: "/admin/send-single-group-sms",
            method: 'post',
            data: $('#send_sms_form').serialize(),
            beforeSend: function() {
                $('#send_sms_form_senging_button').show();
                $('#send_sms_form_submit_button').hide();
            },
            success: function(response){
                if(response['status'] == 'yes') {
                    $('#sms_output').show();
                    $('#sms_body').hide();
                    $('#sms_output_tabel_body').html(response.output);
                    $('#send_sms_form_senging_button').hide();
                    $('#send_sms_form_submit_button').show();
                }
                else {
                    Toastify({
                        text: response.reason,
                        backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                        className: "error",
                    }).showToast();
                    var play = document.getElementById('error').play();
                    $('#send_sms_form_senging_button').hide();
                    $('#send_sms_form_submit_button').show();
                }
            },
        });
    }
    else {
        Toastify({
            text: "Error Occoured!",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
        var play = document.getElementById('error').play(); 
        $('#send_sms_form_senging_button').hide();
        $('#send_sms_form_submit_button').show();
    }
});





   
</script>
@endsection
