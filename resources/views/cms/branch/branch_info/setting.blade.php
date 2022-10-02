@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
        <h3>Branch Setting.</h3>
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{url('/branch/update-branch-setting')}}" method="post" id="form_1">
                    @csrf
                    <div class="block-content font-size-sm row">
                        @if(optional(Auth::user()->shop_info)->vat_type == 'total_vat')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Vat Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="vat_status_yes" @if(optional($branch_info)->vat_status == 'yes') checked @endif value="yes" checked required name="vat_status">
                                        <label class="custom-control-label" for="vat_status_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" @if(optional($branch_info)->vat_status == 'no') checked @endif id="vat_status_no" value="no" name="vat_status">
                                        <label class="custom-control-label" for="vat_status_no">No</label>
                                    </div>
                                </div>
                                <div class="form-group" id="vat_rate_parent_div">
                                    <label for="">Vat Rate (set value if Vat Status yes)</label>
                                    <input type="number" class="form-control" id="vat_rate" value="{{optional($branch_info)->vat_rate}}" placeholder="Vat Rate" name="vat_rate" step=any>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="vat_status" value="no">
                        @endif
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="discount_type">Discount Type</label>
                                    <select class="form-control" id="discount_type" name="discount_type" required>
                                        <option @if(optional($branch_info)->discount_type == 'no') selected @endif value="no">No</option>
                                        <option @if(optional($branch_info)->discount_type == 'percent') selected @endif value="percent">Percent</option>
                                        <option @if(optional($branch_info)->discount_type == 'tk') selected @endif value="tk">Tk</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Online Sell Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" @if(optional($branch_info)->online_sell_status == 'yes') checked @endif class="custom-control-input" id="online_sell_status_yes" value="yes" required name="online_sell_status">
                                        <label class="custom-control-label" for="online_sell_status_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="online_sell_status_no" value="no" @if(optional($branch_info)->online_sell_status == 'no') checked @endif name="online_sell_status">
                                        <label class="custom-control-label" for="online_sell_status_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Sell Note Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="sell_note_yes" value="yes" required @if(optional($branch_info)->sell_note == 'yes') checked @endif name="sell_note">
                                        <label class="custom-control-label" for="sell_note_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="sell_note_no" value="no" @if(optional($branch_info)->sell_note == 'no') checked @endif name="sell_note">
                                        <label class="custom-control-label" for="sell_note_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Others Charge Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="others_charge_yes" value="yes" required @if(optional($branch_info)->others_charge == 'yes') checked @endif name="others_charge">
                                        <label class="custom-control-label" for="others_charge_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="others_charge_no" value="no" @if(optional($branch_info)->others_charge == 'no') checked @endif name="others_charge">
                                        <label class="custom-control-label" for="others_charge_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="d-block">Send SMS Status</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="sms_status_yes" value="yes" required @if(optional($branch_info)->sms_status == 'yes') checked @endif name="sms_status">
                                        <label class="custom-control-label" for="sms_status_yes">Yes</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="sms_status_no" value="no" @if(optional($branch_info)->sms_status == 'no') checked @endif name="sms_status">
                                        <label class="custom-control-label" for="sms_status_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Default Printer</label>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="default_printer_pos" value="pos" required @if(optional($branch_info)->print_by == 'pos') checked @endif name="default_printer">
                                        <label class="custom-control-label" for="default_printer_pos">POS</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="default_printer_general" value="general" @if(optional($branch_info)->print_by == 'general') checked @endif name="default_printer">
                                        <label class="custom-control-label" for="default_printer_general">General</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" class="custom-control-input" id="default_printer_half_page" value="half_page" @if(optional($branch_info)->print_by == 'half_page') checked @endif name="default_printer">
                                        <label class="custom-control-label" for="default_printer_half_page">Half Page</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline custom-control-danger">
                                        <input type="radio" class="custom-control-input" id="default_printer_no" value="no" @if(optional($branch_info)->print_by == 'no') checked @endif name="default_printer">
                                        <label class="custom-control-label" for="default_printer_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Save</button>
                                    <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Overview -->

</div>
<!-- END Page Content -->
@endsection
