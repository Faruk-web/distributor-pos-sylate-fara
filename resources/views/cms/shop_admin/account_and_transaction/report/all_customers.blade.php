
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
        <form action="{{route('admin.report.print.all.or.due.custoemrs')}}" method="post" target="_blank">
            @csrf
            <div class="row p-2">
                <div class="col-md-6"><h4 id="customer_type_title">All Customers</h4></div>
                <div class="col-md-6 text-right">
                    <div class="form-group">
                        <div class="form-check form-check-inline bg-success text-light" style="padding: 5px 10px; border-radius: 10px; margin-left: 10px;">
                            <input class="form-check-input" type="radio" name="customers_type" id="inlineRadio1" checked value="all" required="">
                            <label class="form-check-label" for="inlineRadio1">All Customers</label>
                        </div>
                        <div class="form-check form-check-inline bg-danger text-light" style="padding: 5px 10px; border-radius: 10px; margin-left: 10px;">
                            <input class="form-check-input" type="radio" name="customers_type" id="inlineRadio2" value="due">
                            <label class="form-check-label" for="inlineRadio2">Due Customers</label>
                        </div>
                        <div class="form-check form-check-inline text-light" style="padding: 5px 10px; border-radius: 10px; margin-left: 10px;">
                            <button type="submit" class="btn btn-primary btn-sm">Print</button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table" id="example">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>Code</th>
                        <th>Balance</th>
                        <th>Action</th>                        
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->


<script type="text/javascript">

$(document).ready(function () {

        get_data('all');

        $("input[type='radio']").change(function () {
            if ($(this).val() == "all") {
                get_data('all');
                $('#customer_type_title').text('All Customers');

                
            }
            else if ($(this).val() == "due") {
                get_data('due');
                $('#customer_type_title').text('Due Customers');
            }
        });
    });

  function get_data(customer_type) {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        "bDestroy": true,
        ajax: {
            "url": "/admin/customer-report-customer-info/"+customer_type,
        },
        columns: [
            {data: 'name', name: 'name'},
            {data: 'type', name: 'type'},
            {data: 'phone', name: 'phone'},
            {data: 'code', name: 'code'},
            {data: 'balance', name: 'balance'},
            {data: 'action', name: 'action'},
        ],
        "scrollY": "300px",
        "pageLength": 50,
        "ordering": false,
    });
  }

</script>


@endsection
