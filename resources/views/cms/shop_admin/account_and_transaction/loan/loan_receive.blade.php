@extends('cms.master')
@section('body_content')
<style>
    
</style>

<!-- Page Content -->
<form action="{{route('admin.loan.receive.confirm')}}" method="post" id="form_1">
@csrf
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="search_lender">
                <div class="col-md-3"><h4><b>Loan Receive</b></h4></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                        <input type="text" class="form-control" id="lender_search"
                            placeholder="Search by Lender info (name, phone, email)" name="">
                    </div>
                </div>
                <div class="col-md-3 text-center">

                </div>
                <div class="col-md-12">
                    <div class="pl-4 pr-4 pb-2">
                        <div class="card-body shadow rounded">
                            <table class="table table-bootstrap">
                                <tbody id="lender_show_info"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row" id="lender_body" style="display: none;">
                <div class="col-md-8">
                    <!-- loan Receive div Start -->
                    <div class="row p-1" id="loan_paid_div">
                    <div class="col-md-12 p-3 shadow rounded">
                            <h4 class="text-success"><b>Loan Receive =></b></h4>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label text-primary"><span class="text-danger">*</span> Loan Received By </label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="" name="received_by" onchange="loan_received_by(this)">
                                        <option value="">-- Select Payment Type --</option>
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-3 shadow rounded" id="loan_received_by_cash_div" style="display: none;">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span>Loan Received Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" step=any class="form-control" id="cash_received" name="cash_received">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-3 shadow rounded" id="loan_paid_by_cheque_div" style="display: none;">
                            <div class="form-group">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Bank Account No. / Mobile Banking Acc No.</label>
                                    <input type="text" class="form-control" id="bank_account_num" name="bank_account_num">
                            </div>
                            <div class="form-group">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Bank Name / M Banking Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name">
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-sm-7">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Cheque Num.</label>
                                    <input type="text" class="form-control" id="cheque_num" name="cheque_num">
                                </div>
                                <div class="col-sm-5">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Cheque Date</label>
                                    <input type="date" class="form-control" id="cheque_date" value='{{date("Y-m-d")}}' name="cheque_date">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-7">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Cheque Diposit to</label>
                                    <select class="form-control" id="receiable_bank" name="receiable_bank">
                                        <option value="">-- Select A bank --</option>
                                        @foreach(Auth::user()->shop_info->banks as $bank)
                                        <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}]</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-5">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Diposit Date</label>
                                    <input type="date" class="form-control" id="deposit_date" value='{{date("Y-m-d")}}' name="deposit_date">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-3 col-form-label"><span class="text-danger">*</span>Loan Amount</label>
                                <div class="col-sm-9">
                                    <input type="number" step=any class="form-control" id="receiable_amount" name="receiable_amount">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!-- loan paid div End -->

                    <div class="form-group text-right pl-1 pr-1" id="submit_button" style="display: none;">
                        <div class="row p-3 shadow rounded">
                            <div class="col-md-6">
                            <div class="form-group text-left">
                                <label for="inputName" class="text-left">Note</label>
                                <textarea name="note" id="" cols="30" rows="3" class="form-control"></textarea>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group text-left">
                                <label for="inputName" class="text-left"><span class="text-danger">*</span>Date</label>
                                <input type="date" name="date" class="form-control" value='{{date("Y-m-d")}}' id="">
                            </div>
                            </div>
                        </div><br />
                        <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                        <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                    </div>
                    
                    
                </div>
                <div class="col-md-4 p-3">
                    <div class="lender_info rounded shadow p-3">
                    <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">
                                        <i class="far fa-user-circle text-muted mr-1"></i> Lender Info
                                    </h3>
                                    
                                </div>
                                <div class="block-content">
                                <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b>Name: </b> <span id="lender_name"></span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b>Phone: </b> <span id="lender_phone"></span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b>Balance: </b> <span id="lender_balance"></span></div>
                                    </div>
                                    <input type="hidden" name="lender_balance_input" id="lender_balance_input" value="0">
                                    <input type="hidden" name="lender_id" id="lender_id" value="0">
                                    
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END Full Table -->
</div>
</form>
<!-- END Page Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>

<script>
    // Begin:: Lender Search
    $('#lender_search').keyup(function () {
        var lender_info = $(this).val();
        $.ajax({
            type: 'get',
            url: '/admin/lender-search',
            data: {
                'lender_info': lender_info
            },
            success: function (data) {
                $('#lender_show_info').html(data);
            }
        });
    });
    // End:: Lender Search
</script>

<script>

    function loan_received_by(code) {
        if(code.value == 'cash') {
            $("#loan_received_by_cash_div").show();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").show();

            $("#bank_account_num").prop('required',false);
            $("#bank_name").prop('required',false);
            $("#cheque_num").prop('required',false);
            $("#cheque_date").prop('required',false);
            $("#receiable_bank").prop('required',false);
            $("#receiable_amount").prop('required',false);
            $("#cash_received").prop('required',true);
        }
        else if(code.value == 'cheque') {
            $("#loan_received_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").show();
            $("#submit_button").show();

            $("#bank_account_num").prop('required',true);
            $("#bank_name").prop('required',true);
            $("#cheque_num").prop('required',true);
            $("#cheque_date").prop('required',true);
            $("#receiable_bank").prop('required',true);
            $("#receiable_amount").prop('required',true);
            $("#cash_received").prop('required',false);
            
        }
        else {
            $("#loan_received_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").hide();

            $("#bank_account_num").prop('required',false);
            $("#bank_name").prop('required',false);
            $("#cheque_num").prop('required',false);
            $("#cheque_date").prop('required',false);
            $("#receiable_bank").prop('required',false);
            $("#receiable_amount").prop('required',false);
            $("#cash_received").prop('required',false);
        }
    }

    function select_lender(id, name, phone, balance) {
        $("#search_lender").hide();
        $("#lender_body").show();

        $('#lender_name').html(name);
        $('#lender_phone').html(phone);
        $('#lender_balance').html(balance);
        $('#lender_balance_input').val(balance);
        $('#lender_id').val(id);
        
    }



    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

</script>
<!--This Script for show and hide cash or Cheque in Received End-->

@endsection
