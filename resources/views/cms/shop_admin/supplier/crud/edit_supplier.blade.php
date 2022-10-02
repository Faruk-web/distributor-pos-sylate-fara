@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
            <div class="block block-rounded d-flex flex-column">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{url('/supplier/update-supplier/'.$supplier_info->id)}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Update Company Info</h3>
                            <div class="block-options">
                                
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="row">
                                <div class="col-md-12 d-none">
                                    <div class="form-group">
                                        <label for="example-text-input"> <span class="text-danger">*</span> Company Name</label>
                                        <input type="text" class="form-control" id="" value="{{ $supplier_info->company_name }}" required name="company_name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input"><span class="text-danger">*</span>Company Name</label>
                                        <input type="text" class="form-control" value="{{ $supplier_info->name }}" id="" required name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"><span class="text-danger">*</span>Company Phone</label>
                                        <input type="text" class="form-control" value="{{ $supplier_info->phone }}" id="" required name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Company Email</label>
                                        <input type="text" class="form-control" value="{{ $supplier_info->email }}" id="" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Company address</label>
                                        <input type="text" class="form-control" value="{{ $supplier_info->address }}" id="" required name="address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"><span class="text-danger">*</span>Opening Balance</label>
                                        <input type="number" step=any class="form-control" value="{{ $supplier_info->opening_bl }}" readonly id="" name="opening_bl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
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
