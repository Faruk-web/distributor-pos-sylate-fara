@extends('cms.master')
@section('body_content')

<style>
    .my-custom-scrollbar {
        position: relative;
        height: 500px;
        overflow: auto;
    }
    .table-wrapper-scroll-y {
        display: block;
    }
</style>

<!-- Page Content -->
<div class="content">
    
    <div class="block block-rounded">
        <div class="row p-3">
            <div class="col-md-6">
                <h4 class="">Product Barcode</h4>
            </div>
            <div class="col-md-6 text-right">
                <button type="button" class="btn btn-primary push" data-toggle="modal" data-target="#modal-block-fadein">Print</button>
                <input type="text" class="form-control" id="searchInput" placeholder="Search by product name / Barcode">
            </div>
        </div>
        
        <form action="{{route('admin.print.barcode')}}" method="post" target="_blank" id="form_1">
        <div class="block-content">
            <div class="table-responsive my-custom-scrollbar table-wrapper-scroll-y">
                <table width="100%" class="table table-bordered table-striped table-vcenter" id="productTable">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Product Name</th>
                            <th>Barcode Num</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>@if(!empty($product->barCode))<input type="checkbox" style="height: 20px; width: 20px;" name="pid[]" value="{{$product->id}}" class="" id="">@endif</td>
                            <td>{{$product->p_name}}</em></td>
                            @if(!empty($product->barCode))
                                <td><p>{{$product->barCode}}</p></td>
                            @else
                                <td class="bg-danger text-light">
                                    Has No Barcode&#160;<a type="button" target="_blank" href="{{url('/admin/edit-product/'.$product->id)}}" class="btn btn-sm btn-success">বারকোড ক্রিয়েট</a>
                                </td>
                            @endif
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- END Full Table -->
</div>
<!-- END Page Content -->

<!-- Fade In Block Modal -->
<div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-rounded block-themed block-transparent mb-0">
                        @csrf
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title text-light"></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content font-size-sm">
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span>Printable Quantity</label>
                                <input type="number" class="form-control" id="" required name="print_quantity" placeholder="Ex: 20">
                            </div>
                            <div class="form-group">
                                <label for="example-text-input"><span class="text-danger">*</span>Choose Printers</label>
                                <select class="form-control" id="" name="printer_name">
                                    <option value="a4_4">A4 Page [ 4 Column ]</option>
                                    <option value="a4_5">A4 Page [ 5 Column ]</option>
                                    <option value="a4_6">A4 Page [ 6 Column ]</option>
                                    <option value="a4_7">A4 Page [ 7 Column ]</option>
                                    @foreach($printers as $printer)
                                    <option value="{{$printer->id}}">{{$printer->printer_name}} [Code: {{$printer->code}}, Width: {{$printer->page_width}}inch, Column: {{$printer->barcode_row}}]</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="row">
                                
                            <div class="form-group col-md-6">
                                    <label class="d-block"><span class="text-danger">*</span>Product Name</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="product_name_yes" name="product_name" value="yes" checked="">
                                        <label class="form-check-label" for="product_name_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="product_name_no" name="product_name" value="no">
                                        <label class="form-check-label" for="product_name_no">No</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="d-block"><span class="text-danger">*</span>Selling Price</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="selling_price_yes" name="selling_price" value="yes" checked="">
                                        <label class="form-check-label" for="selling_price_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" id="selling_price_no" name="selling_price" value="no">
                                        <label class="form-check-label" for="selling_price_no">No</label>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="block-content block-content-full text-right border-top">
                            <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" onclick="form_submit(1)" id="">Next</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Fade In Block Modal -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
$(document).ready(function(){
  $("#searchInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    console.log(value);
    $("#productTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
  

@endsection
