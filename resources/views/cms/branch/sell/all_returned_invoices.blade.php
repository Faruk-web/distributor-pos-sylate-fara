
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
            <h4 class="">Returned Invoices</h4>
        </div>
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>CUSTOMER NAME</th>
                        <th>CUSTOMER PHONE</th>
                        <th>INV NUM.</th>
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
<!-- END Page Content -->

<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('branch.returned.invoices.data') }}",
        columns: [
            {data: 'date', name: 'date'},
            {data: 'customer_name', name: 'customer_name'},
            {data: 'customer_phone', name: 'customer_phone'},
            {data: 'invoice_num', name: 'invoice_num'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
    
  });

</script>
@endsection

