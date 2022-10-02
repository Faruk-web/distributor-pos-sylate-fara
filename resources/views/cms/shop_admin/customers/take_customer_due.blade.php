@extends('cms.master')
@section('body_content')
<style>
    #result {
        height: 450px;
        overflow: auto;
        overflow-x: hidden;
    }

    #product_text {
        font-size: 12px;
        cursor: cell;
        text-align: left;
        border: 1px solid #CCCCCC;
        border-radius: 7px;
        background-color: #fff;
    }

    img {
        width: 50px;
    }

    #courser {
        cursor: cell;
    }

    .card-subtitle {
        font-size: 12px;
    }

</style>

<!-- Page Content -->
<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="p3">
                <h4><b>Take Customer Due</b></h4>
            </div>
            @if(empty($customer_info->id))
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                        <input type="text" class="form-control" id="customer_search"
                            placeholder="Search by Customer info (name, phone, code)" name="company_name">
                    </div>
                </div>
                <div class="col-md-3 text-center">

                </div>
                <div class="col-md-12">
                    <div class="pl-4 pr-4 pb-2">
                        <div class="card-body shadow rounded">
                            <table class="table table-bootstrap">
                                <tbody id="customer_show_info"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            @else
            <div class="row">
                <div class="col-md-12 pr-4 pl-4 pb-4">
                    <div class="row shadow p-3 rounded">
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center"><b>Name<br></b>{{$customer_info->name}}</h6>
                        </div>
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center">
                                <b>Address<br></b>{{optional($customer_info)->address}} </h6>
                        </div>
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center"><b>Phone<br></b> {{$customer_info->phone}}</h6>
                        </div>
                        <div class="col-md-3 empty-2">
                            <h6 class="card-subtitle text-center"><b>Email<br></b> {{optional($customer_info)->email}}
                            </h6>
                        </div>
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center"><b>Code<br></b> {{$customer_info->code}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="form-horizontal" style="padding: 30px;" action="{{route('admin.received.customer.due.confirm')}}" method="POST" id="form_1">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Received Amount By</label>
                                    <div class="form-check form-check-inline bg-primary text-light"
                                        style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                        <input class="form-check-input" type="radio" name="paymentBy" id="inlineRadio1"
                                            value="cash" required>
                                        <label class="form-check-label" for="inlineRadio1">Cash</label>
                                    </div>
                                    <div class="form-check form-check-inline bg-danger text-light"
                                        style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                        <input class="form-check-input" type="radio" name="paymentBy" id="inlineRadio2"
                                            value="cheque">
                                        <label class="form-check-label" for="inlineRadio2">Cheque / Mobile
                                            Banking</label>
                                    </div>
                                </div>


                                <!--This is for cash -->
                                <div id="cashForm" class="shadow rounded" style="padding: 20px; display: none">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Customer Due</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="totalDueforCash" name="totalDue_by_cash"
                                                value="{{$customer_info->balance}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Amount TK</label>
                                        <div class="col-sm-10">
                                            <input type="number" step=any class="form-control" id="amountTkforCash"
                                                name="paid_amount_by_cash">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Current Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="balanceForCash"
                                                name="Current_balanceByCash" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!--This is for check-->
                                <div id="checkForm" class="shadow rounded" style="padding: 20px; display:none;">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Customer Due</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="totalDueForCheck"
                                                name="totalDue_by_cheque" value="{{$customer_info->balance}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Amount TK</label>
                                        <div class="col-sm-10">
                                            <input type="number" step=any class="form-control" id="amountTkForCheck"
                                                name="paid_amount_by_cheque">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Current Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="balanceForCheck"
                                                name="Current_balanceByCheque" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-12 col-form-label">Cheque No. /
                                                    Mobile Banking Acc No.</label>
                                                <input type="text" class="form-control" name="cheque_or_mfs_account" id="cheque_or_mfs_account">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-12 col-form-label">Cheque
                                                    Date.</label>
                                                <input type="date" name="cheque_date" id="Chequedate"
                                                    class="form-control" required value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-sm-12 col-form-label">Cheque Bank / M
                                                    Banking Name</label>
                                                <input type="text" class="form-control" id="cheque_bank_or_mfs_name" name="cheque_bank_or_mfs_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                          
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="inputName" class="col-form-label">Cheque Diposit to</label>
                                                <select class="form-control" name="deposit_to" id="deposit_to">
                                                    <option value="">Select A bank</option>
                                                    @foreach(Auth::user()->shop_info->banks as $bank)
                                                    <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-form-label">Cheque Diposit
                                                    Date.</label>
                                                <input type="date" name="deposit_date" class="form-control" value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--This input for client code-->
                                <input type="hidden" class="form-control" name="customer_code" value="{{$customer_info->code}}">

                                <div class="form-group row mt-3">
                                    <label for="inputName" class="col-sm-2 col-form-label">Transaction Date</label>
                                    <div class="col-sm-10">
                                        <input type="date" class="form-control" name="tansectionDate"
                                            value="{{date('Y-m-d')}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Note</label>
                                    <div class="col-sm-10">
                                        <textarea id="" class="form-control" name="note" rows="4"
                                            cols="50"></textarea>
                                    </div>
                                </div>
                                
                                <div class="text-right">
                                    <input type="submit" name="receivedCorC"  value="Confirm" class="btn btn-info" onclick="form_submit(1)" id="submit_button_1">
                                    <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
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

<!--This script for Received Live Calculate-->
<script>
    $(document).on("change keyup blur", "#amountTkforCash", function () {

        var dueCash = document.getElementById('totalDueforCash').value;
        var amountCashTK = document.getElementById('amountTkforCash').value;

        var subtractforCash = dueCash - amountCashTK;
        $('#balanceForCash').val(subtractforCash.toFixed(2));
    });

    $(document).on("change keyup blur", "#amountTkForCheck", function () {

        var dueCheck = document.getElementById('totalDueForCheck').value;
        var amountCheckTK = document.getElementById('amountTkForCheck').value;

        var subtractforCheck = dueCheck - amountCheckTK;
        $('#balanceForCheck').val(subtractforCheck.toFixed(2));
    });

</script>
<!--This script for Received Live Calculate End-->

<!--This Script for show and hide cash or Cheque in Received Start-->
<script>
    $(document).ready(function () {
        $("input[type='radio']").change(function () {
            if ($(this).val() == "cash") {
                $("#cashForm").show();
                $("#checkForm").hide();

                $("#cheque_or_mfs_account").prop('required',false);
                $("#deposit_to").prop('required',false);
                $("#amountTkForCheck").prop('required',false);
                $("#cheque_bank_or_mfs_name").prop('required',false);
                $("#amountTkforCash").prop('required',true);
                
            }
            else if ($(this).val() == "cheque") {
                $("#cashForm").hide();
                $("#checkForm").show();
                $("#amountTkforCash").prop('required',false);
                $("#cheque_or_mfs_account").prop('required',true);
                $("#deposit_to").prop('required',true);
                $("#amountTkForCheck").prop('required',true);
                $("#cheque_bank_or_mfs_name").prop('required',true);

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
