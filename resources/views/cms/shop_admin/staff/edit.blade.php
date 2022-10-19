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
                    <form action="{{url('/admin/update-staff/'.$staff_info->id)}}" method="post" id="form_1">
                    @csrf
                    <div class="block-content font-size-sm row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">Staff Sallery</label>
                                    <input type="text" class="form-control" id="" required name="sallery" value="{{optional($staff_info)->sallery}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group shadow p-3" id="">
                                    <label for="">Select Staff status</label>
                                    <select class="form-control" id="" name="is_employee" required>
                                        <option value="">-- Select One --</option>
                                        <option @if($staff_info->is_employee == 1) selected class="text-light bg-success" @endif value="1">yes</option>
                                        <option @if($staff_info->is_employee == 0) selected class="text-light bg-success" @endif value="0">no</option>
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
