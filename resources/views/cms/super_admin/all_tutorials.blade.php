@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Tutorials</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-primary push" data-toggle="modal" data-target="#modal-block-fadein">Add New Tutorial</button>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th width="10%">Video</th>
                            <th>SI.</th>
                            <th>Title</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tutorial as $tutorial)
                        <tr>
                            <td><iframe src="{{optional($tutorial)->link}}"></iframe></td>
                            <td>{{$tutorial->active}}</td>
                            <td>{{$tutorial->title}}</em></td>
                            <td width="25%">
                                <a type="button" href="{{url('/super-admin/edit-tutorial/'.$tutorial->id)}}" class="btn btn-sm btn-info" data-toggle="tooltip" title="Edit"><i class="fa fa-fw fa-pencil-alt"></i></a>
                                
                            </td>
                        </tr>
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
                    <form action="{{route('super.admin.create.tutorial')}}" method="post">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New Tutorial</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span>Tutorial Title</label>
                                <input type="text" class="form-control" id="" required name="title">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span>Link</label>
                                <input type="text" class="form-control" id="" required name="link" placeholder="Ex: https://youtu.be/QYboVbasG2w">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span>Serial Number</label>
                                <input type="number" class="form-control" id="" required name="serial_num">
                            </div>
                            
                        </div>
                        
                        
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Fade In Block Modal -->
@endsection
