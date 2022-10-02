@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{url('/admin/update-deliveryman/'.$user_info->id)}}" method="post" id="form_1">
                        @csrf
                        <div class="block-content font-size-sm row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">DeliveryMan or system Name</label>
                                    <input type="text" class="form-control" value="{{$user_info->name}}" id="" required name="name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">DeliveryMan or system Email</label>
                                    <input type="text" class="form-control" value="{{$user_info->email}}" id="" required name="email">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">DeliveryMan or system Address</label>
                                    <input type="text" class="form-control" value="{{$user_info->address}}" id="" required name="address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">DeliveryMan or system Phone Number</label>
                                    <input type="text" class="form-control" value="{{$user_info->phone}}" maxlength="11" minlength="11" required name="phone">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="d-block">For What</label>

                                    <div class="custom-control custom-radio custom-control-inline custom-control-success">
                                        <input type="radio" @if($user_info->branch_id == '') checked @endif class="custom-control-input" id="all_branch" value="" required name="branch_id">
                                        <label class="custom-control-label" for="all_branch">All Branch</label>
                                    </div>
                                    @foreach($branches as $branch)
                                    <div class="custom-control custom-radio custom-control-inline custom-control-info">
                                        <input type="radio" @if($user_info->branch_id == $branch->id) checked @endif class="custom-control-input" id="for_{{$branch->id}}_branch" value="{{$branch->id}}" name="branch_id">
                                        <label class="custom-control-label" for="for_{{$branch->id}}_branch">{{$branch->branch_name}}</label>
                                    </div>
                                    @endforeach
                                    
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success" onclick="form_submit(1)" id="submit_button_1">Save</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
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
