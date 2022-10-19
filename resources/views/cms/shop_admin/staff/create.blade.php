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
            <h4 class="">All User List</h4>
            <div class="block-options">
            
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
                            <th>SR Name</th>
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        
        <script type="text/javascript">
            $(function () {
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.all.staff.data') }}",
                columns: [
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
