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
                    <form action="{{url('/admin/update-sr/'.$sr_info->id)}}" method="post" id="form_1">
                    @csrf
                    <div class="block-content font-size-sm row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">SR Name</label>
                                    <input type="text" class="form-control" id="" required name="name" value="{{optional($sr_info)->name}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">SR Email</label>
                                    <input type="text" class="form-control" id="" required name="email" value="{{optional($sr_info)->email}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">SR Address</label>
                                    <input type="text" class="form-control" id="" required name="address" value="{{optional($sr_info)->address}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">SR Phone Number</label>
                                    <input type="text" class="form-control" maxlength="11" minlength="11" required name="phone" value="{{optional($sr_info)->phone}}">
                                </div>
                            </div>
                            {{--
                            <div class="col-md-6 d-none">
                                <div class="form-group">
                                    <label for="example-text-input">Password (min: 8)</label>
                                    <input type="password" class="form-control" id="password" required name="password" value="12345678">
                                </div>
                            </div>
                            <div class="col-md-6 d-none">
                                <div class="form-group">
                                    <label for="example-text-input">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" required name="password_confirmation" value="12345678">
                                    <span class="text-danger d-none" id="password_not_matched">Password Not Matched</span>
                                    <span class="text-success d-none" id="password_matched">Password Matched</span>
                                </div>
                            </div>
                            --}}
                            <div class="col-md-12">
                                <div class="form-group shadow p-3" id="">
                                    <label for="">Select Area</label>
                                    <select class="form-control" id="" name="sr_area_id" required>
                                        <option value="">-- Select One --</option>
                                        @foreach($areas as $area)
                                            <option @if($area->id == optional($sr_info)->sr_area_id) selected class="bg-success text-light" @endif value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
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
</div>
<!-- END Page Content -->
@endsection
