@extends('cms.master')
@section('body_content')

@include('cms.body.datatable_css')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="row p-2">
            <div class="col-md-4">
                <h4 class="">Product Suppliers</h4>
            </div>
             @if($user->hasPermissionTo('supplier.add') || $user->type == 'owner')
            <div class="col-md-3 text-right"><button type="button" class="btn btn-rounded btn-info btn-sm push" data-toggle="modal" data-target="#modal-block-fadein">Add New Supplier</button></div>
            <div class="col-md-2 text-right">
                <div class="dropdown push">
                    <button type="button" class="btn btn-light btn-sm dropdown-toggle" id="dropdown-content-rich-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bulk Upload</button>
                    <div class="dropdown-menu font-size-sm" aria-labelledby="dropdown-content-rich-primary" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
                        <form class="p-2" action="{{route('admin.upload.supplier.csv')}}" method="post" enctype="multipart/form-data" id="form_2">
                            @csrf
                            <div class="form-group">
                                <label for=""><span class="text-danger">*</span>CSV File</label>
                                <input type="file" name="csvFile" class="form-control" id="" required>
                            </div>
                            <div class="text-right">
                                <button type="submit"  class="btn btn-success btn-sm" onclick="form_submit(2)" id="submit_button_2">Save</button>
                                <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_2">Processing....</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-right">
                <a href="{{route('download.demo.file', ['file_name'=>'supplier-demo.csv'])}}" class="btn btn-rounded btn-primary btn-sm">Download Demo CSV</a>
                <a href="{{route('admin.download.exist.supplier')}}" class="btn btn-rounded btn-success btn-sm mt-1">Download Exist supplier</a>
            </div>
            @endif
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table id="example1" class="display table table-bordered table-striped table-vcenter" style="width:100%">
                    <thead>
                        <tr>
                            <th>Company Name</th>
                            <th>Supplier Name</th>
                            <th>Code</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Balance</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{$supplier->company_name}}</td>
                                <td>{{$supplier->name}}</td>
                                <td>{{$supplier->code}}</td>
                                <td>{{$supplier->phone}}</td>
                                <td>{{$supplier->address}}</td>
                                <td>{{number_format($supplier->balance, 2)}}</td>
                                <td>
                                    @if($supplier->active == 1)
                                        <a type="button" href="{{url('/supplier/deactive-supplier/'.$supplier->id)}}" class="btn btn-success btn-sm btn-rounded"><i class="fas fa-eye"></i></a>
                                    @else
                                        <a type="button" href="{{url('/supplier/active-supplier/'.$supplier->id)}}" class="btn btn-danger btn-sm btn-rounded"><i class="fas fa-eye-slash"></i></a>
                                    @endif
                                    <a class="btn btn-primary btn-sm btn-rounded" href="{{url('/supplier/edit-supplier/'.$supplier->id)}}"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-warning btn-sm btn-rounded" target="_blank" href="{{route('report.supplier.ledger.table', ['id'=>$supplier->id])}}">Ledger</i></a>
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

<!-- Fade In Block Modal -->
<div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                    <form action="{{route('suppliers.create.supplier')}}" method="post" id="form_1">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light">Add New Supplier</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input"> <span class="text-danger">*</span> Company Name</label>
                                        <input type="text" class="form-control" id="" value="{{ old('company_name') }}" required name="company_name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="example-text-input"><span class="text-danger">*</span>Supplier Name</label>
                                        <input type="text" class="form-control" value="{{ old('name') }}" id="" required name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"><span class="text-danger">*</span>Supplier Phone</label>
                                        <input type="text" class="form-control" value="{{ old('phone') }}" id="" required name="phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Supplier Email</label>
                                        <input type="text" class="form-control" value="{{ old('email') }}" id="" name="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input">Supplier address</label>
                                        <input type="text" class="form-control" value="{{ old('address') }}" id="" name="address">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="example-text-input"><span class="text-danger">*</span>Opening Balance</label>
                                        <input type="number" step=any class="form-control" value="0" id="" required name="opening_bl">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Submit</button>
                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Fade In Block Modal -->


@include('cms.body.dataTable_script')

@endsection
