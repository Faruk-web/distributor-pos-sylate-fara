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
                    <h3><b>Update Loan Person</b></h3>
                    <form action="{{url('/admin/edit-loan-person/'.$loan_person->id.'')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input">Name</label>
                                <input type="text" class="form-control" id="" value="{{$loan_person->name}}" required name="name" >
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Phone</label>
                                        <input type="text" class="form-control" id="" value="{{$loan_person->phone}}" required name="phone" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Email</label>
                                        <input type="text" class="form-control" id="" value="{{optional($loan_person)->email}}" name="email" >
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Address</label>
                                        <input type="text" class="form-control" id="" value="{{optional($loan_person)->address}}" name="address" >
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Opening Balance</label>
                                        <input type="number" class="form-control" value="{{optional($loan_person)->opening_balance}}" readonly name="opening_balance" step=any>
                                    </div>
                                </div> -->
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Update</button>
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
