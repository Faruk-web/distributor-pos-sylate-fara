@extends('cms.master')
@section('body_content')

<!-- Page Content -->
<form action="{{route('admin.capital.withdraw.confirm')}}" method="post" id="form_1">
@csrf
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="search_capital_person">
                <div class="col-md-3"><h4><b>Capital Withdraw</b></h4></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                    <label for=""> <span class="text-danger">*</span> Select Owners</label>
                        <select class="form-control" id="" onchange="select_owner(this)">
                            <option value="0">Select Owner</option>
                            @foreach($owners as $owner)
                            <option value="{{$owner->name}},{{$owner->id}},{{$owner->phone}},{{$owner->capital}}">{{$owner->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 text-center">

                </div>
                
            </div>
            <div class="row" id="capital_person_body" style="display: none;">
                <div class="col-md-8">
                    <!-- loan paid div Start -->
                    <div class="row p-1" id="loan_paid_div">
                    <div class="col-md-12 p-3 shadow rounded">
                            <h4 class="text-primary"><b>Capital Withdraw =></b></h4>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Capital Withdraw By </label>
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
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span>Withdrawal Amount</label>
                                <div class="col-sm-8">
                                    <input type="number" step=any class="form-control" id="cash_paid" max="{{optional(Auth::user()->shop_cash)->balance+0}}" name="cash_paid">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-3 shadow rounded" id="loan_paid_by_cheque_div" style="display: none;">
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-3 col-form-label"><span class="text-danger">*</span>Withdrawal Bank</label>
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
                                <label for="inputName" class="col-sm-3 col-form-label"><span class="text-danger">*</span>Withdrawal Amount</label>
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
                                <div class="block-header block-header-default bg-dark">
                                    <h3 class="block-title text-light">
                                        <i class="far fa-user-circle text-muted mr-1"></i> Business Owners Info
                                    </h3>
                                    
                                </div>
                                <div class="block-content">
                                <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b>Name: </b> <span id="capital_person_name"></span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b>Phone: </b> <span id="capital_person_phone"></span></div>
                                    </div>
                                    <div class="media d-flex align-items-center push">
                                        <div class="mr-3"><b>Balance: </b> <span id="capital_person_capital"></span></div>
                                    </div>
                                    <input type="hidden" name="capital_person_capital_input" id="capital_person_capital_input" value="0">
                                    <input type="hidden" name="capital_person_id" id="capital_person_id" value="0">
                                    
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
    function select_owner(code) {
        var info = code.value;
        if (info != 0) {
            var sub_info = info.split(',');
            var name = sub_info[0];
            var id = sub_info[1];
            var phone = sub_info[2];
            var capital = sub_info[3];

            $("#search_capital_person").hide();
            $("#capital_person_body").show();

            $('#capital_person_name').html(name);
            $('#capital_person_phone').html(phone);
            $('#capital_person_capital').html(capital);
            $('#capital_person_capital_input').val(capital);
            $('#capital_person_id').val(id);
       
        }
    }

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

            //$("#cheque_num").prop('required',true);
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

    

    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

</script>
<!--This Script for show and hide cash or Cheque in Received End-->

@endsection
