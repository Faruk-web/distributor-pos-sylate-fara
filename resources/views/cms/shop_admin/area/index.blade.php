@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<!-- Page Content -->
<div class="content">

    <div class="block block-rounded">
        <div class="row p-2">
            <div class="col-md-4"><h4 class="">All Area</h4></div>
            <div class="col-md-3 text-center"><a href="{{route('admin.download.exist.brand')}}" class="d-none btn btn-rounded btn-success btn-sm">Download Exist Brand</a></div>
            <div class="col-md-3 text-center">
                <div class="dropdown push d-none">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Upload CSV</button>
                    <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-content-rich-primary" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
                        <form class="p-2 shadow rounded" action="{{route('admin.upload.brand.csv')}}" method="post" id="form_1" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for=""><span class="text-danger">*</span>Select File</label>
                                <input type="file" class="form-control" id="" name="file" required>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit"  class="btn btn-success btn-sm" onclick="form_submit(1)" id="submit_button_1">Save</button>
                                <button type="button" disabled class="btn btn-outline-success btn-sm" style="display: none;" id="processing_button_1">Processing....</button>
                            </div>
                        </form>
                        <div class="text-center p-2 shadow rounded">
                            <a href="{{route('download.demo.file', ['file_name'=>'brand-demo.csv'])}}" class="btn btn-rounded btn-success btn-sm">Download Demo Brand CSV</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2"><button type="button" class="btn btn-rounded btn-primary btn-sm push" data-toggle="modal" data-target="#modal-block-fadein">Add New Area</button></div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter data-table">
                    <thead>
                        <tr>
                            <th>Area Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        
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
            <form action="{{route('admin.create.area')}}" id="form_2" method="post">
                @csrf
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-light">Add New Area</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <div class="form-group">
                        <label for="example-text-input">Area Name</label>
                        <textarea name="name" class="form-control" id="" cols="30" rows="3" required></textarea>
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
        
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">
    $(function () {
      var table = $('.data-table').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('admin.all.area.data') }}",
          columns: [
              {data: 'name', name: 'name'},
              {data: 'action', name: 'action'},
          ],
          "scrollY": "300px",
          "pageLength": 100,
          "ordering": false,
      });
      
    });
  
</script>

<script>
    // function form_submit(number) {
    //     if (document.getElementById("form_"+number).checkValidity()) { 
    //         $('#submit_button_'+number).hide();
    //         $('#processing_button_'+number).show();
    //     }
    //     else {
    //         Toastify({
    //             text: "Something is missing!",
    //             backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
    //             className: "error",
    //         }).showToast();
    //         var play = document.getElementById('error').play(); 
    //     }
    // }
</script>
        
        
@endsection
