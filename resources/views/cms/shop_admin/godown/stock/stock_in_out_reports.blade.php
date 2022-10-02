@extends('cms.master')
@section('body_content')

@include('cms.body.datatable_css')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Godown Stock In Out Reports</h4>
            <div class="block-options"></div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table id="example" class="display table table-bordered table-striped table-vcenter" style="width:100%">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Godown Current Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td><img src="{{asset(optional($product)->image)}}" class="rounded" width="50%"></td>
                                <td>{{$product->p_name}}</td>
                                <td>{{$product->G_current_stock}} {{optional($product->unit_type_name)->unit_name}}</td>
                                <td><a href="{{route('godown.stock.in.out.summery', ['id'=>$product->id, 'code'=>rand()])}}" class="btn btn-info btn-sm">Stock in out Summery</a></td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        
        <div class="d-flex justify-content-center">
            {!! $products->links() !!}
        </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->
@include('cms.body.dataTable_script')

@endsection
