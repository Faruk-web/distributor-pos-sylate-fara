
@extends('cms.master')
@section('body_content')

<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>
    .reason_text {
        font-size: 11px;
        color: red;
    }
    tr td{
        font-size: 11px;
    }
</style>
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">All Damaged Products</h4>
        </div>
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Place</th>
                        <th>Product Name</th>
                        
                        <th>Damaged Stock</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
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
        ajax: "{{ route('admin.all.damaged.product.data') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'place', name: 'place'},
            {data: 'product_name', name: 'product_name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'reason', name: 'reason'},
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
    
  });

</script>
@endsection

