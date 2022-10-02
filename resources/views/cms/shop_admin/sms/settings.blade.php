@extends('cms.master')
@section('body_content')

<!-- Page Content -->

<div class="p-2">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row" id="lender_body">
                <div class="col-md-8">
                    <!-- loan paid div Start -->
                    <div class="row p-1" id="loan_paid_div">
                        <div class="col-md-12 p-3 shadow rounded">
                            <h4 class="p-1 rounded"><b>Bill SMS Format</b></h4>
                            <form method="POST" action="{{route('admin.store.sms.settings')}}" class="p-3" id="form_1">
                                @csrf
                              <div class="form-group">
                                <label for=""><span class="text-danger">*</span>SMS Text</label>
                                <textarea class="form-control" id="" name="sms_text" required rows="8">{{optional($sms_settings)->message}}</textarea>
                              </div>
                              <div class="form-check text-right">
                                <button type="submit"  onclick="form_submit(1)" id="submit_button_1" class="btn btn-success btn-rounded">Save</button>
                                <button type="button" disabled="" class="btn btn-outline-success btn-rounded" style="display: none;" id="processing_button_1">Processing....</button>
                              </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-1">
                    <div class="lender_info rounded shadow mb-3">
                        <div class="block block-rounded mb-3">
                            <div class="block-header block-header-default">
                                <h3 class="block-title bg-primary p-2 text-light rounded">Dynamic Components:</h3>
                            </div>
                            <div class="block-content text-muted text-justify pb-3">
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Customer Name</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="customer_name" name="" value="customer_name" readonly>
                                    <div class="input-group-append">
                                        <button type="button" onclick="copy_component('customer_name')" class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Previous Due</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="previous_due" name="" value="previous_due" readonly>
                                    <div class="input-group-append">
                                        <button type="button" onclick="copy_component('previous_due')"  class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Today's Bill</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="todays_bill" name="" value="todays_bill" readonly>
                                    <div class="input-group-append">
                                        <button type="button" onclick="copy_component('todays_bill')" class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Total Bill</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="total_bill" name="" value="total_bill" readonly>
                                    <div class="input-group-append">
                                        <button type="button" onclick="copy_component('total_bill')"  class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Paid</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="paid" name="" value="todays_paid" readonly>
                                    <div class="input-group-append">
                                        <button type="button" onclick="copy_component('paid')"  class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Invoice Num.</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="invoice_number" name="" value="invoice_number" readonly>
                                    <div class="input-group-append">
                                        <button type="button" onclick="copy_component('invoice_number')"  class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                <div class="input-group pb-2">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-alt-primary btn-sm">Current Balance</button>
                                    </div>
                                    <input type="text" class="form-control form-control-alt" id="current_balance" name="" value="current_balance" readonly>
                                    <div class="input-group-append">
                                        <button type="button"  onclick="copy_component('current_balance')"  class="btn btn-dark btn-sm">Copy</button>
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- END Full Table -->
</div>

<!-- END Page Content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
    referrerpolicy="no-referrer"></script>

<script>

    function copy_component(info) {
        var value_of_info = $('#'+info).val();
        var sampleTextarea = document.createElement("textarea");
        document.body.appendChild(sampleTextarea);
        sampleTextarea.value = value_of_info; //save main text in it
        sampleTextarea.select(); //select textarea contenrs
        document.execCommand("copy");
        document.body.removeChild(sampleTextarea);
        
        Toastify({
            text: "Copied",
            backgroundColor: "linear-gradient(to right, #269E70, #00BFA6)",
            className: "success",
        }).showToast();
    }
    
</script>
<!--This Script for show and hide cash or Cheque in Received End-->

@endsection
