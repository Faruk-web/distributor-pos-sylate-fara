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
        <div class="block-header">
            <h4 class="">All Staff</h4>
            <div class="block-options">
                <button type="button" class="btn btn-rounded btn-success text-light" ><a class="text-light" href="{{route('admin.create')}}">All Non Staff Users</a></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-danger">
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                @endif
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter data-table">
                    <thead>
                        <tr>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Area</th>
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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{route('admin.store.sr')}}" method="post" id="form_1" enctype="multipart/form-data">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add Make Sure Staff</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm row">
                        <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">User Name</label>
                                    <select class="form-control" id="" name="sr_area_id" required>
                                        <option value="">-- Select One --</option>
                                        @foreach($users as $area)
                                            <option value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">User Type</label>
                                    <select class="form-control" id="" name="sr_area_id" required>
                                        <option value="">-- Select One --</option>
                                        @foreach($users as $area)
                                            <option value="{{$area->type}}">{{$area->type}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="example-text-input">User Phone</label>
                                    <select class="form-control" id="" name="sr_area_id" required>
                                        <option value="">-- Select One --</option>
                                        @foreach($users as $area)
                                            <option value="{{$area->phone}}">{{$area->phone }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-md-12">
                                <div class="form-group shadow p-3" id="">
                                    <label for="">Select Area</label>
                                    <select class="form-control" id="" name="sr_area_id" required>
                                        <option value="">-- Select One --</option>
                                        @foreach($areas as $area)
                                            <option value="{{$area->id}}">{{$area->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <a href="{{route('admin.create')}}" class="btn btn-alt-primary mr-1"> Close</a>
                            <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Fade In Block Modal -->

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        
        <script type="text/javascript">
            $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.staff.data') }}",
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'phone', name: 'phone'},
                    {data: 'type', name: 'type'},
                    {data: 'area', name: 'area'},
                    {data: 'action', name: 'action'},
                ],
                "scrollY": "300px",
                "pageLength": 100,
                "ordering": false,
            });
            
            });
        
        </script>
        <script>
            
            $("#confirm_password").on("change paste keyup cut select", function() {
                var password_matched = document.getElementById("password_matched");
                var password_not_matched = document.getElementById("password_not_matched");

                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();
                if(password == confirm_password && password != '') {
                    password_matched.classList.remove("d-none");
                    password_not_matched.classList.add("d-none");
                }
                else if(password == '' || confirm_password == ''){
                    password_matched.classList.add("d-none");
                    password_not_matched.classList.add("d-none");
                }
                else {
                    password_matched.classList.add("d-none");
                    password_not_matched.classList.remove("d-none");
                }
            });
            
            
            function reset_password(crm_name, id) {
                $('#password_reset_crm_id').val(id);
                $('#password_reset_crm_name').text(crm_name);
                
            }
        </script>
@endsection
