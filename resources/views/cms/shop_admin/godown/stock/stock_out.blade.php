@extends('cms.master')
@section('body_content')
<style>
    #result{height:550px;overflow:auto;overflow-x: hidden;}
    #product_text {font-size: 13px; cursor: cell; text-align: left; border: 1px solid #3F3D56;}
</style>
<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <div class="row">
                <div class="col-md-3">
                <h4><b>Godown Stock Out</b></h4>
                  <div class="shadow p-3">
                    <input type="text" class="form-control" autofocus="autofocus" placeholder="Product Name/Barcode" id="myInput" onkeyup="myFunctionR()">
                  </div>
                  <div class="card card-primary card-outline" id="#mydiv">
                        <div class="" id="result">
                            <ul class="nav nav-pills flex-column push" id="myUL">
                                @foreach($products as $product)
                                    @php($unit_type = $product->unit_type_name->unit_name)
                                    <li class="nav-item mb-1 p-1 rounded" @if($product->G_current_stock > 0) onclick="myFunction({{$product->id}},'{{$product->p_name}}', {{$product->G_current_stock}}, '{{$unit_type}}')" @else onclick="godown_stock_empty()" @endif title="Add me">
                                        <div id="product_text" class="rounded">
                                            <a class="nav-link d-flex justify-content-between align-items-center" href="javascript:void(0)">
                                            <span class=""></span>{{$product->p_name}} / {{optional($product)->barCode}}</a>
                                            <span class="text-primary"><b>G Stock:</b>  {{$product->G_current_stock}} {{$unit_type}}</span>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                <input type="hidden" name="" id="toggle_yes" value='1'>
                    <div class="" style="padding: 0px 2px;">
                        <div class="shadow border p-2">
                            <div class="table-responsive">
                                <form action="{{route('godown.stock.out.confirm')}}" method="post" id="form_1">
                                    @csrf
                                    <table id="mainTable" class="table editable-table table-bordered  table-sm mb-0">
                                        <thead>
                                            <tr style="background-color:#1769aa;color:#fff;">
                                        <th style="padding: 10px 7px;">Product Name</th>
                                        <th style="padding: 10px 7px;">Unit</th>
                                        <th style=" width: 23%;padding: 10px 7px;">Godown Stock</th>
                                        <th style="padding: 10px 7px;">Action</th>
                                
                                    </tr>
                                        </thead>
                                        <tbody id = "demo" class="demo"></tbody>
                                    </table>
                                    <hr class="bg-warning">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                            <label for="exampleInputEmail1">Please Confirm A Place</label>
                                                @foreach($branchs as $branch)
                                                <div class="form-check form-check-inline bg-primary"
                                                    style="padding: 5px 10px; border: 1px solid #F50057; border-radius: 10px;">
                                                    <input class="form-check-input" required type="radio" name="branch_id"
                                                        id="branch_{{$branch->id}}" value="{{$branch->id}}">
                                                    <label class="form-check-label text-light"
                                                        for="branch_{{$branch->id}}"><b>{{$branch->branch_name}}</b></label>
                                                </div>
                                                @endforeach
                                                @error('place')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="name" accesskey="U"><span class="text-danger">*</span>Note</label>
                                                <textarea id="" name="note" class="form-control" rows="4" cols="50">Note</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="name" accesskey="U"><span class="text-danger">*</span>Date</label>
                                                <input type="date" name="date" class="form-control" value="{{date('Y-m-d')}}" id="">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <a  data-toggle="modal" data-target="#exampleModalForSell" class="btn btn-primary" style="padding:3px 6px;">Submit</a>
                                    
                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModalForSell" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                        <div class="text-danger" style="text-align:center;">
                                                            <i class="fas fa-shopping-cart" style="font-size: 60px;"></i>
                                                        </div>
                                                        <div><h2 class="text-center font-bold">Are You Sure?</h2></div>
                                                        <div><p class="text-center">You will not be able to recover this content!</p></div>
                                                        <div class="row">
                                                            <div class="col-md-8 text-center"><button type="submit" name="sell" class="btn btn-primary" onclick="form_submit(1)" id="submit_button_1">Confirm Stock Transfer</button>
                                                            <button type="button" disabled class="btn btn-outline-success" style="display: none;" id="processing_button_1">Processing....</button>
                                                            
                                                            </div>
                                                            <div class="col-md-4 text-center"><button class="btn btn-danger" data-dismiss="modal">Cancel</button></div>
                                                                
                                                        </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

$(document).ready(function () {
    var toggle_yes = $('#toggle_yes').val();
    if (typeof (toggle_yes) != 'undefined' && toggle_yes != null) {
        SidebarColpase();
    }

});

function myFunctionR() {
    var input, filter, ul, li, a, x, txtValue;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName("li");
    for (x = 0; x < li.length; x++) {
        a = li[x].getElementsByTagName("a")[0];
        txtValue = a.textContent || a.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[x].style.display = "";
        } else {
            li[x].style.display = "none";
        }
    }
}
</script>


<script>

function godown_stock_empty() {
    swal({
        title: "Error",
        text: "Empty Stock",
        icon: "error",
        button: "Ok",
    });
}


var pname = [];

function deleteFromArray(productName){
    const index = pname.indexOf(productName);
    if (index > -1) {
      pname.splice(index, 1);
    }
}

function myFunction(id, name, godown_stock, unit_type) {
    var x = document.getElementsByClassName("quantity");
     if(pname.indexOf(name) !== -1){
        Toastify({
            text: name+ " Is Exist",
            backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
            className: "error",
        }).showToast();
     }
     else {
        $('#demo').append('<tr style="background-color:#F2F2F2;color: #000;"><td class="t_tittle" id = "t_tittle"><input type="hidden" name="pid[]" value="'+id+'"><input type="hidden" name="pname[]"  value="'+name+'"><strong class="pd-name">'+name+'</strong></td><td><input type="number" required style="width: 100px;" value = "" id="quantity" name="quantity[]" max="'+godown_stock+'" class="quantity" step=any> '+unit_type+'</td><td><input style="width: 100px;" type="number" value="'+godown_stock+'" id="godown_stock" name="godown_stock[]" class="godown_stock" readonly step=any> '+unit_type+'</td><td><button type="button" id="remove" name="remove" onclick="deleteRow(this)" class="btn btn-danger btn-sm remove btnSelect"><span class="glyphicon glyphicon-minus"></span><i class="fas fa-trash-alt"></i></button></td></tr>');
        pname.push(name);
        multiply();
    }
        
}

</script>


<script>
$(".addproduct").click(function(){
    multiply();

    $(".quantity").on("click change paste keyup cut select", function() {
        multiply();
    });

});


function multiply()
{
    var quantity = document.querySelectorAll(".quantity");
    var price = document.querySelectorAll(".unit");
    
    // Declare i and qty for "for" loop
    var i, qty = quantity.length;
    // Use "for" loop to iterate through NodeList
    for (i = 0; i < qty; i++) {
        a = Number(document.getElementsByClassName('quantity')[i].value);
        b = Number(document.getElementsByClassName('unit')[i].value);
        // Do the multiplication
        c = a+b;
        document.getElementsByClassName('total')[i].value=c.toFixed(2);
            
    }
}   

</script>

<!--This is for product delete-->
<script>

    $(document).ready(function(){

    $("#mainTable").on('click', '.btnSelect', function() {
    var currentRow = $(this).closest("tr");
    $(this).parents("tr").remove();
    var col2 = currentRow.find(".pd-name").html(); // get current row 2nd table cell TD value
    var ProDName = col2;
    deleteFromArray(ProDName);
    calculateSum();
    multiply();
    
    });
});

</script>


@endsection
