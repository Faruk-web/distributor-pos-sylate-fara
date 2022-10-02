
@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/sweetalert.min.js') }}"></script>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Add Damage Stock</h4>
        </div>
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Brand Name</th>
                        <th>Current Stock</th>
                        <th>Action</th>
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
        <h5 class="modal-title" id="exampleModalLabel">Add Damage Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="post" action="{{route('branch.add.damage.product')}}">
          @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Unit</label>
                <input type="number" name="unit" class="form-control" id="number_of_unit" placeholder="Ex: Number of Unit" max="" required>
                <input type="hidden" name="pid" class="form-control" id="damage_product_id" value="">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Reason</label>
                    <textarea id="w3review" class="form-control" name="reason" rows="4" cols="50" required></textarea>
            </div>
        </div>
        <div class="text-right">
            <input type="submit" name="damage_unit" id="update_unit" value="Update" class="btn btn-success"/>
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('branch.damage.product.data') }}",
        columns: [
            {data: 'image', name: 'image'},
            {data: 'product_name', name: 'product_name'},
            {data: 'brand_name', name: 'brand_name'},
            {data: 'stock', name: 'stock'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "scrollY": "300px",
        "pageLength": 50,
        "ordering": false,
    });
    
  });

  function add_damage(pid, quantity) {
      if(quantity > 0) {
        $('#exampleModal').modal('show');
        $('#damage_product_id').val(pid);
        $('#number_of_unit').attr('max', quantity);
      }
      else {
        swal({
            title: "Error",
            text: "Not enough stock to damage.",
            icon: "error",
            button: "Ok",
        });
        var play = document.getElementById('error').play();
      }
  }

</script>
@endsection

