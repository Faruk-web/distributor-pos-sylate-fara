@extends('cms.master')
@section('body_content')

@include('cms.body.datatable_css')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Product Supplier Reports</h4>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table id="example1" class="display table table-bordered table-striped table-vcenter" style="width:100%">
                    <thead>
                        <tr>
                            <th>Supplier Name</th>
                            <th>Company Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{$supplier->name}}</td>
                                <td>{{$supplier->company_name}}</td>
                                <td>{{$supplier->phone}}</td>
                                <td>{{$supplier->address}}</td>
                                <td>
                                    <a class="btn btn-warning btn-sm btn-rounded" href="{{url('/report/'.$supplier->id.'/supplier-ledger-table')}}">Ledger</a>
                                    <a class="btn btn-primary btn-sm btn-rounded" href="{{route('supplier.products.report', ['supplier_id'=>$supplier->id])}}">Product Report</a>
                                    <a target="_blank" class="btn btn-success btn-sm btn-rounded" href="{{route('supplier.grout.product.ledger', ['code'=>$supplier->code])}}">Product Ledger</a>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        
        <div class="d-flex justify-content-center">
            {!! $suppliers->links() !!}
        </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->
@include('cms.body.dataTable_script')

@endsection
