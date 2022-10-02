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
                <h4 class="text-primary"><b>Payment To Supplier</b></h4>
            </div>
            @if(empty($supplier_info->id))
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-group shadow rounded p-3">
                        <input type="text" class="form-control" id="search_supplier"
                            placeholder="Search by Supplier info (Name, Phone, Company Name)" name="supplier_info">
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
                            <h6 class="card-subtitle text-center"><b>Name<br></b>{{$supplier_info->name}}</h6>
                        </div>
                        <div class="col-md-3 empty-2">
                            <h6 class="card-subtitle text-center"><b>Company Name<br></b> {{optional($supplier_info)->company_name}}
                            </h6>
                        </div>
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center">
                                <b>Address<br></b>{{optional($supplier_info)->address}} </h6>
                        </div>
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center"><b>Phone<br></b> {{$supplier_info->phone}}</h6>
                        </div>
                        <div class="col-md-2 empty-2">
                            <h6 class="card-subtitle text-center"><b>Code<br></b> {{$supplier_info->code}}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row shadow">
                        <div class="col-md-12">
                            <form class="form-horizontal" style="padding: 30px;" action="{{route('admin.supplier.payment.confirm')}}" method="POST" id="form_1">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Supplier Balance</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="supplier_due" name="totalDue_by_cash"
                                            value="{{$supplier_info->balance}}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Payment By</label>
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
                                        <label for="inputName" class="col-sm-2 col-form-label">Cash in Hand</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="cash_in_hand" name="cash_in_hand"
                                                value="{{optional(Auth::user()->shop_cash)->balance+0}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Paid</label>
                                        <div class="col-sm-10">
                                            <input type="number" step=any class="form-control" id="amountTkforCash"
                                                name="paid_amount_by_cash" max="{{optional(Auth::user()->shop_cash)->balance+0}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Supplier Current Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="supplier_current_balance_by_cash"
                                                name="Current_balanceByCash" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!--This is for check-->
                                <div id="checkForm" class="shadow rounded" style="padding: 20px; display:none;">
                                    <div class="row">
                                        <div class="col-md-2">
                                          
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputName" class="col-form-label">Payment Bank</label>
                                                <select class="form-control" id="selectBank" name="deposit_to" >
                                                    <option value="">-- Select One --</option>
                                                    @foreach(Auth::user()->shop_info->banks as $bank)
                                                    <option value="{{$bank->id}}">{{$bank->bank_name}} [{{optional($bank)->bank_branch}}][{{optional($bank)->account_no}}]</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3" id="bank_balance_output">
                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group row">
                                                <label for="inputName" class="col-form-label">Cheque Diposit
                                                    Date.</label>
                                                <input type="date" name="deposit_date" class="form-control" value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Paid</label>
                                        <div class="col-sm-10">
                                            <input type="number" step=any class="form-control" id="amountTkForCheck"
                                                name="paid_amount_by_cheque">
                                                <span id="paid_by_check_warning" class="text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputName" class="col-sm-2 col-form-label">Supplier Current Balance</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="balanceForCheck"
                                                name="Current_balanceByCheque" readonly>
                                        </div>
                                    </div>
                                    
                                </div>

                                <!--This input for client code-->
                                <input type="hidden" class="form-control" name="supplier_code" value="{{$supplier_info->code}}">

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
                                    <input type="submit" name="receivedCorC" id="insert_product" value="Confirm" class="btn btn-info" onclick="form_submit(1)" id="submit_button_1">
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
    $('#search_supplier').keyup(function () {
        var supplier_info = $(this).val();
        $.ajax({
            type: 'get',
            url: '/admin/supplier-payment/search-supplier',
            data: {
                'supplier_info': supplier_info
            },
            success: function (data) {
                $('#customer_show_info').html(data);
            }
        });
    });
    // End:: Customer Search for stock in

    $('#selectBank').change(function(){
		var bankID = $(this).val();
		if(bankID != '')
		{
			$.ajax({
                type: 'get',
                url: '/admin/supplier-payment/change-bank/',
                data:{bankID:bankID},
                success:function(data)
                {
                    $('#bank_balance_output').html(data);
                    $('#amountTkForCheck').val('');
                    $('#balanceForCheck').val('');
                }
            });
		}
		else{
			$('#bank_balance_output').html('');	
		}
	});

</script>

<!--This script for Received Live Calculate-->
<script>
    $(document).on("change keyup blur", "#amountTkforCash", function () {

        var supplier_due = document.getElementById('supplier_due').value;
        var amountCashTK = document.getElementById('amountTkforCash').value;
        var subtractforCash = supplier_due - amountCashTK;
        $('#supplier_current_balance_by_cash').val(subtractforCash.toFixed(2));
    });

    $(document).on("change keyup blur", "#amountTkForCheck", function () {
        var bank_balance = $('#BankBalanceC').val();
        var amountCheckTK = document.getElementById('amountTkForCheck').value;
        
        if(amountCheckTK == '') {
            $('#paid_by_check_warning').html('');
            $('#balanceForCheck').val('');
        }
        else {
            if(parseFloat(amountCheckTK) <= parseFloat(bank_balance)) {
                var supplier_due = document.getElementById('supplier_due').value;
                var subtractforCheck = supplier_due - amountCheckTK;
                $('#balanceForCheck').val(subtractforCheck.toFixed(2));
                $('#paid_by_check_warning').html('');	
            }
            else {
                $('#paid_by_check_warning').html('insufficient balance in the account!');
            }
        }
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
                $("#amountTkforCash").prop('required',true);
                $("#selectBank").prop('required',false);
                $("#amountTkForCheck").prop('required',false);
                
            }
            else if ($(this).val() == "cheque") {
                $("#cashForm").hide();
                $("#checkForm").show();
                $("#amountTkforCash").prop('required',false);
                $("#selectBank").prop('required',true);
                $("#amountTkForCheck").prop('required',true);
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
