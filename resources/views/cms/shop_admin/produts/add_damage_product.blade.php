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
    <div class="block-header">
            <h4 class="">Add Damage product</h4>
        </div>
        <div class="block-content">
            <div class="table-responsive">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Barcode</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->

<!-- Modal -->
<div class="modal fade" id="set_own_stock_modal" tabindex="-1" role="dialog" aria-labelledby="set_own_stock_modal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title text-light" id="set_own_stock_modal">Stock Update</h5>
        <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{route('admin.add.damage.product.confirm')}}" method="post" id="form_1">
            @csrf
            <input type="hidden" name="pid" value="" id="product_id">
        <div class="form-group">
            <label for="">Select Place</label>
            <select class="form-control" name="place" id="select_place">
            <option value="">-- Select --</option>
            <option value="G">Godown</option>
            @foreach($branches as $branch)
            <option value="{{$branch->id}}">{{$branch->branch_name}} [{{$branch->branch_address}}]</option>
            @endforeach
            </select>
        </div>
        <div id="place_output"></div>

        </form>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.add.damage.products.data') }}",
        columns: [
            {data: 'p_name', name: 'p_name'},
            {data: 'barCode', name: 'barCode'},
            {data: 'action', name: 'action'},
        ],
        "scrollY": "300px",
        "pageLength": 100,
        "ordering": false,
    });
    
  });


  function add_damage(pid) {
      $('#set_own_stock_modal').modal('show')
      $('#product_id').val(pid);
      $("#select_place").val("");
      $('#place_output').html('');
  }

  $('#select_place').change(function() {
    var pid = $('#product_id').val();
    var place = $(this).val();
        if(place != '' && pid != ''){
          $.ajax({
                url: "/admin/add-damage-product-info",
                type: "get",
                data: {
                    pid:pid,
                    place:place,
                },
                beforeSend: function(xhr) {
                    $('#place_output').html('<div style="padding: 30px; text-align: center;">Loading...<div>');
                },
                success: function(data) {
                    $('#place_output').html(data);
                },
            });
        }
        else {
            $('#place_output').html('');
        }

    });

 
$("form").bind("keypress", function (e) {
    if (e.keyCode == 13) {
        return false;
    }
});

function remove_cart_tr(generated_id) {
    console.log(generated_id);
    $('#cart_tr'+generated_id).remove();
}



</script>
@endsection


