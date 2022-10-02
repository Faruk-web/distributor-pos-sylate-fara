@extends('cms.master')
@section('body_content')
<!-- Page Content -->
<div class="content">

    <div class="block block-rounded">
        <div class="row p-4">
            <div class="col-md-8"><h4 class="">Product Variations</h4></div>
            <div class="col-md-4 text-right"><button type="button" class="btn btn-rounded btn-success btn-sm push" data-toggle="modal" data-target="#modal-block-fadein">Add New Variation</button></div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table width="100%" class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>SI</th>
                            <th>Variation Head</th>
                            <th width="45%">Variation Item List</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php( $i = 1 )
                        @foreach($variations as $variation)
                        <?php
                            $variation_lists = $variation->variation_lists;
                        ?>
                        <tr>
                            <td>{{$i}}</em></td>
                            <td>
                                <div class="fw-bold h3 text-success">{{$variation->title}}</div>
                                @if($variation->is_active == 1)
                                Status: <span class="badge badge-success">Active</span>
                                @else
                                Status: <span class="badge badge-danger">Deactive</span>
                                @endif
                            </td>
                            <td>
                                @if(count($variation_lists) > 0)
                                <div class="shadow rounded p-2 bg-light">
                                <table class="table">
                                  <thead>
                                    <tr class="bg-success text-light">
                                      <th scope="col">List Name</th>
                                      <th scope="col">Status</th>
                                      <th class="text-center">Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                     @foreach($variation_lists as $list)
                                    <tr>
                                      <td>{{$list->list_title}}</td>
                                      <td>
                                        @if($list->is_active == 1)
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Deactive</span>
                                        @endif
                                      </td>
                                      <td class="text-center"><a type="button" href="{{url('/admin/edit-variation-item/'.$list->id)}}" class="btn btn-sm btn-success btn-rounded">Edit</a></td>
                                    </tr>
                                    @endforeach
                                  </tbody>
                                </table>
                                </div>
                                @else
                                <div class="text-center">
                                    <h5 class="text-danger"><b>No Variation Item Found</b></h5>
                                </div>
                                @endif
                            </td>
                            <td width="20%">
                                <a type="button" href="{{url('/admin/edit-variation/'.$variation->id)}}" class="btn btn-sm btn-info">Edit</a>
                                <button type="button" data-toggle="modal" data-target="#variation_item_add" onclick="add_item_modal({{$variation->id}}, '{{$variation->title}}')" class="btn btn-sm btn-primary">Add Item</button>
                                
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

<!-- Fade In Block Modal -->
<div class="modal fade" id="modal-block-fadein" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
            <form action="{{route('store.product.variations')}}" id="form_2" method="post">
                @csrf
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-light">Add New Variation Head</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <div class="form-group">
                        <label for="example-text-input">Head Name</label>
                        <input type="text" class="form-control" id="" required name="title" placeholder="Ex: Color">
                    </div>
                </div>
                <div class="block-content block-content-full text-right border-top">
                    <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" onclick="form_submit(2)" id="submit_button_2">Submit</button>
                    <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_2">Processing....</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END Fade In Block Modal -->

<!-- Fade In Block Modal -->
<div class="modal fade" id="variation_item_add" tabindex="-1" role="dialog" aria-labelledby="modal-block-fadein" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
            <form action="{{route('store.variations.item')}}" id="form_1" method="post">
                @csrf
                <div class="block-header bg-success">
                    <h3 class="block-title text-light">Add New Variation Item</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content font-size-sm">
                    <div class="form-group">
                        <label for="example-text-input">Head Name: <b><span id="variation_head_title"></span></b></label>
                        <input type="hidden" id="variation_id" required name="variation_id">
                    </div>
                    <div class="form-group">
                        <label for="example-text-input">Item Name</label>
                        <input type="text" class="form-control" id="list_title" required name="list_title" placeholder="Ex: Green">
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


        
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // function form_submit(number) {
    //     if (document.getElementById("form_"+number).checkValidity()) { 
    //         $('#submit_button_'+number).hide();
    //         $('#processing_button_'+number).show();
    //     }
    //     else {
    //         Toastify({
    //             text: "Something is missing!",
    //             backgroundColor: "linear-gradient(to right, #6E32CF, #FFA300)",
    //             className: "error",
    //         }).showToast();
    //         var play = document.getElementById('error').play(); 
    //     }
    // }
    
    function add_item_modal(id, title) {
        $('#variation_head_title').text(title);
        $('#variation_id').val(id);
        $('#list_title').val('');
    }
    
    
</script>
        
        
@endsection
