@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h4 class="">Barcode Printers</h4>
            <div class="block-options">
                <a class="btn btn-rounded btn-success push" href="{{route('admin.product.add.barcode.level.printer')}}">Add New Printer</a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Printer Name</th>
                            <th>Code</th>
                            <th>Branch Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($printers as $printer)
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>{{$printer->printer_name}}</em></td>
                            <td>{{$printer->code}}</em></td>
                            <td>{{$printer->branch_id}}</em></td>
                            <td width="25%">
                                <a type="button" href="{{route('admin.product.edit.barcode.level.printer', ['id' => $printer->id])}}" class="btn btn-sm btn-info"><i class="fa fa-fw fa-pencil-alt"></i></a>
                            </td>
                        </tr>
                        @php( $i += 1 )
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->
@endsection
