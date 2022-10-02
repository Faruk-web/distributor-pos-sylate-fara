@extends('cms.master')
@section('body_content')

<!-- Page Content -->
<form action="{{route('admin.add.indirect.income.confirm')}}" enctype="multipart/form-data" method="post" id="form_1">
@csrf
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="lender_body">
                <div class="col-md-9">
                    <!-- loan paid div Start -->
                    <div class="row p-1" id="loan_paid_div">
                    <div class="col-md-12 p-3 shadow rounded">
                            <h4 class="text-light bg-dark p-1"><b>Add Direct / Indirect Income</b></h4>
                            <div class="form-group row">
                                <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Add Amount By</label>
                                <div class="col-sm-8">
                                    <select class="form-control" id="" name="income_add_by" onchange="loan_paid_by(this)">
                                        <option value="">-- Select Type --</option>
                                        <option value="cash">Cash</option>
                                        <option value="cheque">Cheque</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 p-3 shadow rounded mt-3" id="loan_paid_by_cheque_div" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-12 col-form-label">Cheque No.
                                            / MFS Acc No.</label>
                                        <input type="text" class="form-control" id="checkNoOrMFSAccNo" name="checkNoOrMFSAccNo" required="">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-12 col-form-label">MFS Acc Type</label>
                                        <select name="MFSAccType" class="form-control MFSAccType">
                                            <option value="">Select One</option>
                                            <option value="Bkash">Bkash</option>
                                            <option value="Rocket">Rocket</option>
                                            <option value="Nagad">Nagad</option>
                                            <option value="mCash">mCash</option>
                                            <option value="T-Cash">T-Cash</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-12 col-form-label">Cheque
                                            Bank</label>
                                        <input type="text" id="Chequebank" class="form-control" name="Chequebank" required="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputName" class="col-form-label">Cheque / MFS Diposit
                                            to</label>
                                        <select class="form-control" id="bank" name="Dipositbank" required="">
                                            <option value="">Select A bank</option>
                                            @foreach(Auth::user()->shop_info->banks as $bank)
                                            <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}]</option>
                                            @endforeach                                                                          
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-12 col-form-label">Cheque Date.</label>
                                        <input type="date" name="Chequedate" id="Chequedate" class="form-control" required="" value="2021-12-14">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="inputName" class="col-form-label">Cheque Diposit
                                            Date.</label>
                                        <input type="date" name="DipositDate" id="DipositDate" class="form-control" required="" value="2021-12-14">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- loan paid div End -->
                    <div class="form-group text-right pl-1 pr-1 mt-3" id="submit_button" style="display: none;">
                        <div class="row p-3 shadow rounded">
                        <div class="col-md-6">
                                <div class="form-group text-left">
                                    <label><span class="text-danger">*</span>Amount</label>
                                    <input type="number" step=any class="form-control" id="amount" required name="amount">
                                    @error('amount')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group text-left">
                                    <label for="example-text-input"><span class="text-danger">*</span> Ledger Head</label>
                                    <select name="ledger_head" class="form-control select1" data-live-search="true" id="" required>
                                        <option value="">-- Select Head --</option>
                                        
                                        
                                        @foreach($expenses_group as $group)
                                            @foreach($group->ledger_heads as $head)
                                                <option value="{{$head->id}}">{{$head->head_name}} <b>[{{$group->group_name}}]</b></option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    @error('ledger_head')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
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

            $("#checkNoOrMFSAccNo").prop('required',false);
            $("#Chequebank").prop('required',false);
            $("#bank").prop('required',false);
            
        }
        else if(code.value == 'cheque') {
            $("#loan_paid_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").show();
            $("#submit_button").show();

            $("#checkNoOrMFSAccNo").prop('required',true);
            $("#Chequebank").prop('required',true);
            $("#bank").prop('required',true);
                        
        }
        else {
            $("#loan_paid_by_cash_div").hide();
            $("#loan_paid_by_cheque_div").hide();
            $("#submit_button").hide();

            $("#checkNoOrMFSAccNo").prop('required',false);
            $("#Chequebank").prop('required',false);
            $("#bank").prop('required',false);
        }
    }
    
    $('select.MFSAccType').on('change', function() {
        var value = this.value;
        if(value != '') {
            $('#Chequebank').prop('required', false);
        }
        else {
            $('#Chequebank').prop('required', true);
        }
    });

    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

</script>
<!--This Script for show and hide cash or Cheque in Received End-->

@endsection
