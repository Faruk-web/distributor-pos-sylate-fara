
@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<div class="content">
    <div class="block block-rounded">
        <div class="row p-2">
            <div class="col-md-6">
                <h4 class="">Resellers</h4>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#exampleModal">Add New Reseller</button>
            </div>
        </div>
        
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Status</th>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Reseller</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="registerForm" class="form-dark" method="POST" action="{{route('super.admin.store.reseller')}}">
            @csrf      
            <div class="mb-3 icon-group">
                <input type="text" class="form-control text-dark" name="name" id="fullName" required="" value="" placeholder="Full Name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="mb-3 icon-group">
                <input type="email" class="form-control text-dark" name="email" id="" required="" value="" placeholder="Email">
                @error('email')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
		  
		    <div class="mb-3 icon-group">
                <input type="text" maxlength="11" minlength="11" class="form-control text-dark" name="phone" required="" value="" placeholder="Phone (Ex: 01627382866)">
                @error('phone')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 icon-group">
                <textarea type="text" class="form-control text-dark" name="address" id="" required="" value="" row="30" col="5" placeholder="Address"></textarea>
                @error('address')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
		  
            <div class="mb-3 icon-group">
                <input type="text" class="form-control text-dark" name="password" id="loginPassword" required="" placeholder="Password (min 8 digit)">
                @error('password')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
		    <div class="mb-3 icon-group">
                <input type="text" class="form-control text-dark" name="password_confirmation" id="loginPassword" required="" placeholder="Confirm Password">
                @error('password_confirmation')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
		  				  
          <div class="d-grid my-4">
			    <button class="btn btn-danger btn-block" type="submit">Register</button>
		  </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- END Page Content -->

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('super.admin.resellers.data') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'email', name: 'email'},
            {data: 'address', name: 'address'},
            {data: 'active_status', name: 'active_status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
    
  });

</script>
@endsection




