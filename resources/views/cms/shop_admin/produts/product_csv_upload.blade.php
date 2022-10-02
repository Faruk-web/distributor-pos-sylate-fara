@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{route('admin.product.csv.upload.confirm')}}" method="post" enctype="multipart/form-data" id="form_1">
                        @csrf
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="filebutton">Select File</label>
                            <div class="col-md-12">
                                <input type="file" name="csvFile" id="file" class="input-large form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4">
                                <button type="submit" name="Import" class="btn btn-primary button-loading"
                                    data-loading-text="Loading..." onclick="form_submit(1)" id="submit_button_1">Upload</button>
                                    <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-center" style="padding: 20px; background-color: #F7F7F9; border-radius: 20px;">
                <i class="fa fa-question-circle text-info" aria-hidden="true" data-toggle="popover" data-placement="top" title="বাল্ক প্রোডাক্ট আপলোড সিস্টেম." data-content="This is example content. You can put a description or more info here."> Procedure</i>
                    <p style="margin-top:10px;"></p>
                    <a class="btn btn btn-info btn-lg btn-block" href="{{route('download.demo.file', ['file_name'=>'product-demo.csv'])}}">Product Demo CSV
                        Download</a> <br />
                   <a class="btn btn btn-success btn-lg btn-block" href="{{route('admin.download.exist.products')}}">Existing all Product CSV Download</a> <br />
                        
                </div>
            </div>
        </div>
    </div>
    

    <!-- END Full Table -->
</div>
<!-- END Page Content -->

@endsection
