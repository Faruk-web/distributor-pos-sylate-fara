@extends('cms.master')
@section('body_content')
@include('cms.body.datatable_css')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Godown Stock Out invoices</h4>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table id="example" class="display table table-bordered table-striped table-vcenter" style="width:100%">
                    <thead>
                        <tr>
                            <th>Branch Name</th>
                            <th>Inv Num.</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($godown_stock_out_invoies as $invoice)
                            <tr>
                                <td>{{optional($invoice->branch_info)->branch_name}}</td>
                                <td>{{str_replace("_","/", $invoice->invoice_id)}}</td>
                                <td>{{date('d M, Y', strtotime($invoice->date))}}</td>
                                <td><a target="_blank" href="{{route('godown.stock.out.view.invoice', ['invoice_id'=>$invoice->invoice_id])}}" class="btn btn-primary btn-sm">Invoice</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>
        
        <div class="d-flex justify-content-center">
            {!! $godown_stock_out_invoies->links() !!}
        </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->
@include('cms.body.dataTable_script')
@endsection
