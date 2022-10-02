@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="row p-2">
            <div class="col-md-4"><h4 class="">Product Unit Types</h4></div>
            <div class="col-md-3 text-center"><a href="{{route('admin.download.exist.unit.types')}}" class="btn btn-rounded btn-success btn-sm">Download Exist Unit Types</a></div>
            <div class="col-md-3 text-center">
                <div class="dropdown push">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload CSV</button>
                    <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-content-rich-primary" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
                        <form class="p-2 shadow rounded" action="{{route('admin.upload.unit.type.csv')}}" method="post" enctype="multipart/form-data" id="form_1">
                            @csrf
                            <div class="form-group">
                                <label for=""><span class="text-danger">*</span>Select File</label>
                                <input type="file" class="form-control" id="" name="file" required>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"  class="btn btn-success btn-sm" onclick="form_submit(1)" id="submit_button_1">Save</button>
                                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                            </div>
                        </form>
                        <div class="text-center p-2 shadow rounded">
                            <a href="{{route('download.demo.file', ['file_name'=>'unit-type-demo.csv'])}}" class="btn btn-rounded btn-success btn-sm">Download Demo Unit Types CSV</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 text-right"><button type="button" class="btn btn-rounded btn-info btn-sm push" data-toggle="modal" data-target="#modal-block-fadein">Add New</button></div>
        </div>
        
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Type Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($unit_types as $type)
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>{{$type->unit_name}}</em></td>
                            <td width="25%">
                                <a type="button" href="{{url('/admin/edit-unit-type/'.$type->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                @if($type->active == 1)
                                    <a type="button" href="{{url('/admin/deactive-unit-type/'.$type->id)}}" class="btn btn-sm btn-success" data-toggle="tooltip" title="Unit Type is active now, click to deactive">Active</a>
                                @else
                                    <a type="button" href="{{url('/admin/active-unit-type/'.$type->id)}}" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Unit Type is deactive now, click to active">Deactive</a>
                                @endif
                            </td>
                        </tr>
                        @php( $i += 1 )
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<!-- Fade In Block Modal -->
<div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{route('admin.create.unit-type')}}" method="post" id="form_2">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New Unit Type</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input">Unit Type Name</label>
                                <input type="text" class="form-control" id="" required name="unit_name" placeholder="Ex: kg">
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="form_submit(2)" id="submit_button_2">Submit</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_2">Processing....</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Fade In Block Modal -->
@endsection
