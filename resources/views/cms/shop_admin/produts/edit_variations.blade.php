@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">
    <!-- Overview -->
    <div class="row">
    <div class="col-sm-12 col-xl-12 col-md-12">
            <!-- Pending Orders -->
            <div class="block block-rounded d-flex flex-column">
                <div
                    class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                    <div class="col-lg-12 col-xl-12">
                    <form action="{{route('update.product.variations', optional($variation_info)->id)}}" id="form_2" method="post">
                    @csrf
                    <div class="block-header bg-primary-dark rounded">
                        <h3 class="block-title text-light">Edit Variation</h3>
                        
                    </div>
                    <div class="block-content font-size-sm">
                        <div class="form-group">
                            <label for="example-text-input">Head Name</label>
                            <input type="text" class="form-control" id="" required name="title" value="{{optional($variation_info)->title}}">
                        </div>
                        <div class="form-group">
                            <label for="example-text-input">Is Active</label>
                            <select class="form-control" id="" name="is_active">
                              <option @if(optional($variation_info)->is_active == 1) selected class="text-light bg-success" @endif value="1">Active</option>
                              <option @if(optional($variation_info)->is_active == 0) selected class="text-light bg-success" @endif value="0">Deactive</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="submit" class="btn btn-primary" onclick="form_submit(2)" id="submit_button_2">Update</button>
                        <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_2">Processing....</button>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Overview -->

</div>
<!-- END Page Content -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<script>
  
 $("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});
 
</script>


@endsection
