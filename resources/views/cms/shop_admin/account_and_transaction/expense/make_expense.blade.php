@extends('cms.master')
@section('body_content')

<!-- Page Content -->
<form action="{{route('admin.expense.entry.confirm')}}" enctype="multipart/form-data" method="post" id="form_1">
@csrf
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="lender_body">
                <div class="col-md-9">
                    <!-- loan paid div Start -->
                    <div class="row p-1" id="loan_paid_div">
                    <div class="col-md-12 p-3 shadow rounded">
                            <h4 class="text-muted"><b>Make Expenses Entry</b></h4>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Pay Amount By</label>
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
                                    <label for="inputName" class="col-form-label">Cheque Num.</label>
                                    <input type="text" class="form-control" id="cheque_num" name="cheque_num">
                                </div>
                                <div class="col-sm-4">
                                    <label for="inputName" class="col-form-label"><span class="text-danger">*</span>Cheque Date</label>
                                    <input type="date" class="form-control" id="cheque_date" value='{{date("Y-m-d")}}' name="cheque_date">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <!-- loan paid div End -->
                    <div class="form-group text-right pl-1 pr-1" id="submit_button" style="display: none;">
                        <div class="row p-3 shadow rounded">
                        <div class="col-md-6">
                                <div class="form-group text-left">
                                    <label><span class="text-danger">*</span>Amount</label>
                                    <input type="number" step=any class="form-control" id="cash_paid" required name="paid_amount">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-left">
                                    <label for="example-text-input"><span class="text-danger">*</span> Ledger Head</label>
                                    <select name="ledger_head" class="form-control select1" id="" data-live-search="true" required>
                                        <option value="">-- Select Head --</option>
                                        @foreach($expenses_group as $group)
                                            @foreach($group->ledger_heads as $head)
                                                <option value="{{$head->id}}">{{$head->head_name}} <b>[{{$group->group_name}}]</b></option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-left">
                                    <label for="inputName" class="text-left">Voucher No.</label>
                                    <input type="text" name="voucher" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-left">
                                    <label for="inputName" class="text-left">File</label>
                                    <input type="file" name="file" class="form-control" >
                                </div>
                            </div>
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
                <div class="col-md-3 p-1">
                    <div class="lender_info rounded shadow">
                    <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Procedure</h3>
                                </div>
                                <div class="block-content text-muted text-justify">
                                    <p style="font-size: 13px;">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in c</p>
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
    
    function loan_paid_by(code) {
        if(code.value == 'cash') {
            $("#loan_paid_by_cash_div").show();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").show();

            $("#cheque_num").prop('required',false);
            $("#payable_bank").prop('required',false);
        }
        else if(code.value == 'cheque') {
            $("#loan_paid_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").show();
            $("#submit_button").show();

            //$("#cheque_num").prop('required',true);
            $("#payable_bank").prop('required',true);
                        
        }
        else {
            $("#loan_paid_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").hide();

            $("#cheque_num").prop('required',false);
            $("#payable_bank").prop('required',false);
            $("#cheque_paid").prop('required',false);
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
