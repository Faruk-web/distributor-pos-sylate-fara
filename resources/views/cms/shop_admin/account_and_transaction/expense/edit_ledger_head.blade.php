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
                    <h3><b>Update Ledger Head</b></h3>
                    <form action="{{url('/admin/update-ledger-head/'.$head_info->id.'')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span> Group</label>
                                <select name="group_id" class="form-control" id="" required>
                                    <option value="">-- Select Group --</option>
                                    @foreach($expenses_group as $group)
                                        <option @if($head_info->group_id == $group->id) selected class="bg-success text-light" @endif value="{{$group->id}}">{{$group->group_name}} [{{$group->group_under}}]</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span> Head Name</label>
                                <textarea name="head_name" id="" class="form-control" cols="30" rows="2" required>{{$head_info->head_name}}</textarea>
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
