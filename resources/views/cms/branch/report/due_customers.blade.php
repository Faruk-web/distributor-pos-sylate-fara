@extends('cms.master')
@section('body_content')
@include('cms.body.datatable_css')
@php( $currency = ENV('DEFAULT_CURRENCY'))
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">All Due Customers</h4>
            <div class="block-options"></div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table id="example" class="display table table-bordered table-striped table-vcenter" style="width:100%">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Due Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customer_list as $customer)
                            <tr>
                                <td>{{$customer->name}}</td>
                                <td>{{optional($customer)->phone}}</td>
                                <td>{{optional($customer)->email}}</td>
                                <td>{{optional($customer)->address}}</td>
                                <td class="text-danger">{{optional($customer)->balance." ".$currency}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>

<!-- END Page Content -->
<script type="text/javascript">
    $(document).ready(function () {
        $('#example').DataTable({
            "scrollY": "300px",
            "scrollCollapse": true,
            "info": true,
            "paging": false,
            "ordering": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
        $('#example1').DataTable();

    });

</script>
@endsection
