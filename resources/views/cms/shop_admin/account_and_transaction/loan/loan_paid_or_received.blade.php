@extends('cms.master')
@section('body_content')

<!-- Page Content -->
<form action="{{route('admin.loan.paid.confirm')}}" method="post" id="form_1">
@csrf
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="search_lender">
                <div class="col-md-3"><h4><b>Loan Paid</b></h4></div>
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
                    <!-- loan paid div Start -->
                    <div class="row p-1" id="loan_paid_div">
                    <div class="col-md-12 p-3 shadow rounded">
                            <h4 class="text-primary"><b>Loan Paid =></b></h4>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Loan Paid By </label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="" name="paid_by" onchange="loan_paid_by(this)">
                                        <option value="">-- Select Payment Type --</option>
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-3 shadow rounded" id="loan_paid_by_cash_div" style="display: none;">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label">Cash in Hand</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="loan_paid_by_cash_in_hand" name="loan_paid_by_cash_in_hand"
                                        value="{{optional(Auth::user()->shop_cash)->balance+0}}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span>Loan Paid</label>
                                <div class="col-sm-8">
                                    <input type="number" step=any class="form-control" id="cash_paid" max="{{optional(Auth::user()->shop_cash)->balance+0}}" name="cash_paid">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-3 shadow rounded" id="loan_paid_by_cheque_div" style="display: none;">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-3 col-form-label"><span class="text-danger">*</span>Payable Bank</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="payable_bank" name="payable_bank">
                                        <option value="">-- Select A bank --</option>
                                        @foreach(Auth::user()->shop_info->banks as $bank)
                                        <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}] ( BL: {{optional($bank)->balance}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-5">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Cheque Num.</label>
                                    <input type="text" class="form-control" id="cheque_num" name="cheque_num">
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Cheque Date</label>
                                    <input type="date" class="form-control" id="cheque_date" value='{{date("Y-m-d")}}' name="cheque_date">
                                </div>
                                
                            </div>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-3 col-form-label"><span class="text-danger">*</span>Cheque Paid</label>
                                <div class="col-sm-9">
                                    <input type="number" step=any class="form-control" id="cheque_paid" name="cheque_paid">
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
                                    <input type="hidden" name="lender_balance_input" id="lender_balance_input" value="">
                                    <input type="hidden" name="lender_id" id="lender_id" value="">
                                    
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


    function loan_paid_by(code) {
        if(code.value == 'cash') {
            $("#loan_paid_by_cash_div").show();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").show();

            $("#cheque_num").prop('required',false);
            $("#payable_bank").prop('required',false);
            $("#cheque_paid").prop('required',false);
            $("#cash_paid").prop('required',true);
        }
        else if(code.value == 'cheque') {
            $("#loan_paid_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").show();
            $("#submit_button").show();

            $("#cheque_num").prop('required',true);
            $("#payable_bank").prop('required',true);
            $("#cheque_paid").prop('required',true);
            $("#cash_paid").prop('required',false);
            
        }
        else {
            $("#loan_paid_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").hide();

            $("#cheque_num").prop('required',false);
            $("#payable_bank").prop('required',false);
            $("#cheque_paid").prop('required',false);
            $("#cash_paid").prop('required',false);
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
