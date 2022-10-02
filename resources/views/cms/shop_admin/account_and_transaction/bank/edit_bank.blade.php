@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{url('/admin/account-transaction/'.$bank_info->id.'/update-bank')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input">Bank Name</label>
                                <input type="text" class="form-control" value="{{optional($bank_info)->bank_name}}" id="" required name="bank_name" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Account Number</label>
                                <input type="text" class="form-control" value="{{optional($bank_info)->account_no}}" id="" required name="account_no" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Account Type</label>
                                <input type="text" class="form-control" value="{{optional($bank_info)->account_type}}" id="" required name="account_type" >
                            </div>
                            <div class="form-group">
                                <label for="example-text-input">Branch Name</label>
                                <input type="text" class="form-control" value="{{optional($bank_info)->bank_branch}}" id="" required name="bank_branch" >
                            </div>
                            <!-- <div class="form-group">
                                <label for="example-text-input">Opening Balance</label>
                                <input type="number" class="form-control" value="{{optional($bank_info)->opening_bl}}" readonly id="" required name="opening_bl" step=any>
                            </div> -->
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Save</button>
                                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->
@endsection
