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
    tr td{
        font-size: 15px;
    }
</style>

<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="shadow border p-3">
            <div class="card rounded">
                <div class="card-body text-center">
                    <h3 class="text-light bg-primary p-2 rounded"><b>Suppliers Product stock Details</b></h3>
                    <div class="row">
                        <div class="col-md-6 text-left">
                            <p class="">
                                <b><i data-toggle="tooltip" title="Supplier Name" class="fas fa-id-badge bg-dark text-light rounded p-1"></i></b> {{$supplier_info->name}} <br />
                                <b><i data-toggle="tooltip" title="Supplier Phone Number" class="fas fa-phone-square bg-dark text-light rounded p-1"></i></b> {{$supplier_info->phone}} <br />
                                <b><i data-toggle="tooltip" title="Supplier Code" class="fab fa-cuttlefish bg-dark text-light rounded p-1"></i></b> {{$supplier_info->code}} <br />                                
                            </p>
                        </div>
                        <div class="col-md-6 text-left">
                            <p class="">
                                <b><i data-toggle="tooltip" title="Supplier Company Name" class="fas fa-building bg-dark text-light rounded p-1"></i></b> {{optional($supplier_info)->company_name}} <br />
                                <b><i data-toggle="tooltip" title="Supplier Email" class="fas fa-envelope-open-text bg-dark text-light rounded p-1"></i></b> {{optional($supplier_info)->email}} <br />
                                <b><i data-toggle="tooltip" title="Supplier Address" class="fas fa-map-marked-alt bg-dark text-light rounded p-1"></i></b> {{optional($supplier_info)->address}} <br />
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="" id="supplier_id" value="{{$supplier_info->id}}">
        <div class="block-content">
            <div class="table-responsive">
                <table class="display table table-bordered table-striped data-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-center">In/Out</th>
                            <th>Product Name</th>
                            <th>Qunatity</th>
                            <th>Purchase Price</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>

<script type="text/javascript">
  $(function () {
    var supplier_id = $('#supplier_id').val();
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "ajax": { 
            "url": "/supplier/supplier-product-reports-data/"+supplier_id,
        },
        columns: [
            {data: 'date', name: 'date'},
            {data: 'in_out', name: 'in_out'},
            {data: 'product_name', name: 'product_name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'price', name: 'price'},
        ],
        "scrollY": "300px",
        "pageLength": 50,
        "ordering": false,
    });
    
  });

</script>


@endsection




