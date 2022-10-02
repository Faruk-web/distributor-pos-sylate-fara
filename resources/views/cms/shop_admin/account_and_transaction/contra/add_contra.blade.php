@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{route('admin.contra.confirm')}}" method="post" id="form_1">
            @csrf
            <div class="row">
                <div class="col-md-3"><h4><b>Contra</b></h4></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3 text-center">
                        <div class="form-check form-check-inline bg-success text-light"
                            style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                            <input class="form-check-input" type="radio" name="contra_by" id="inlineRadio1"
                                value="CTB" required>
                            <label class="form-check-label" for="inlineRadio1">Cash To Bank</label>
                        </div>
                        <div class="form-check form-check-inline bg-primary text-light"
                            style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                            <input class="form-check-input" type="radio" name="contra_by" id="inlineRadio2"
                                value="BTC">
                            <label class="form-check-label" for="inlineRadio2">Bank To Cash</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 text-center"></div>
            </div>
            <div class="row p-5" id="cash_to_bank" style="display: none;">
                <div class="col-md-12 p-3 shadow rounded">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label">Cash in Hand</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="cash_to_bank_exist_cash" name="cash_to_bank_exist_cash"
                                value="{{optional(Auth::user()->shop_cash)->balance+0}}" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span>Transfarable Amount</label>
                        <div class="col-sm-8">
                            <input type="number" step=any class="form-control" id="cash_to_bank_paid" max="{{optional(Auth::user()->shop_cash)->balance+0}}" name="cash_to_bank_paid">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Place</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="cash_to_bank_bank" name="cash_to_bank_bank" id="deposit_to">
                                <option value="">-- Select A bank --</option>
                                @foreach(Auth::user()->shop_info->banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}]</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row p-5" id="bank_to_cash" style="display: none;">
                <div class="col-md-12">
                <div class="col-md-12 p-3 shadow rounded">
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span> Place</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="bank_to_cash_bank" name="bank_to_cash_bank" id="deposit_to">
                                <option value="">-- Select A bank --</option>
                                @foreach(Auth::user()->shop_info->banks as $bank)
                                <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}] [{{optional($bank)->account_no}}] ( BL: {{optional($bank)->balance}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-4 col-form-label"><span class="text-danger">*</span>Transfarable Amount</label>
                        <div class="col-sm-8">
                            <input type="number" step=any class="form-control" id="bank_to_cash_paid" name="bank_to_cash_paid">
                        </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="form-group text-right pl-5 pr-5" id="submit_button" style="display: none;">
                <div class="row">
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
                </div>
                <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
            </div>
            </form>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>


<script>
    // Begin:: Customer Search for stock in
    $('#customer_search').keyup(function () {
        var customer_info = $(this).val();
        $.ajax({
            type: 'get',
            url: '/admin/take-due/search-customer',
            data: {
                'customer_info': customer_info
            },
            success: function (data) {
                $('#customer_show_info').html(data);
            }
        });
    });
    // End:: Customer Search for stock in

</script>

<!--This Script for show and hide cash or Cheque in Received Start-->
<script>
    $(document).ready(function () {
        $("input[type='radio']").change(function () {
            if ($(this).val() == "CTB") {
                $("#cash_to_bank").show();
                $("#bank_to_cash").hide();
                $("#submit_button").show();
                
                $("#cash_to_bank_paid").prop('required',true);
                $("#cash_to_bank_bank").prop('required',true);
                $("#bank_to_cash_bank").prop('required',false);
                $("#bank_to_cash_paid").prop('required',false);                
            }
            else if ($(this).val() == "BTC") {
                $("#cash_to_bank").hide();
                $("#bank_to_cash").show();
                $("#submit_button").show();

                $("#cash_to_bank_paid").prop('required',false);
                $("#cash_to_bank_bank").prop('required',false);
                $("#bank_to_cash_bank").prop('required',true);
                $("#bank_to_cash_paid").prop('required',true);
            }
        });
    });

</script>
<script>

    $("form").bind("keypress", function (e) {
        if (e.keyCode == 13) {
            return false;
        }
    });

</script>
<!--This Script for show and hide cash or Cheque in Received End-->

@endsection
