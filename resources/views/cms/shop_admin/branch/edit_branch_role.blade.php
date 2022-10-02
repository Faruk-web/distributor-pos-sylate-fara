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
                    <form action="{{url('/admin/update-branch-user-role/'.$role_info->id)}}" method="post" id="form_1">
                    @csrf
                    <div class="form-group">
                            <label for="example-text-input-alt"><span class="text-danger">*</span> Role Name</label>
                            <input type="text" class="form-control form-control-alt" value='{{str_replace(Auth::user()->shop_id."#","", $role_info->name)}}' name="name" required>
                        </div>
                        <div class="form-group">
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
