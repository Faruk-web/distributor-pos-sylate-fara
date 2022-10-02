
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ asset('css/toastify.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Print Barcode</title>

<style>

    .barcode {
       
        /* padding: 1px; */
        margin-top: -0.1in !important;
        margin-bottom: 0.2in;
        width: 50%;
        float: left;
        text-align: center;
        margin-left: 0.2in;
        
    }
   
    .text-content {
        font-size: 12px;
    }

    .column_2 {
        margin-left: 0.2in;
    }

    /* optional  */

    .barcode_page {
        text-align: center !important;
    }

    .barcode_item {
        float: left;
        text-align: center !important;
    }

    .border_class {
        border: 1px solid #000000;
        border-radius: 5px;
    }

    /* new style  */
    /* .barcode_page {
        width: 0in !important;
        height: 100%;
        min-width: 0in !important;
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
        
    }

    .barcode_item {
        width: 100%;
        min-width: 0in !important;
        height: 0in !important;
        min-height: 0in !important;
        float: left;
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
    }

    .column1{
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
    }

    .column2{
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
    }

    .column3{
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
    }

    .column4{
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
    }

    .column5{
        margin-left: 0in !important;
        margin-right: 0in !important;
        margin-top: 0in !important;
        margin-bottom: 0in !important;
    }

    .barcode_image {
        min-height: 0in !important;
        max-height: 0in !important;
        height: 0in !important;
    }

    .barcode_text {
        font-size: 12px !important;
    } */
    



</style>

</head>

<body>
    <audio id="error" src="{{asset('backend/audio/error.mp3')}}" preload="auto"></audio>
      <audio id="success" src="{{asset('backend/audio/success.mp3')}}" preload="auto"></audio>
    <section>
        <form action="{{route('admin.product.print.test.barcode')}}" id="level_printer_form" method="get" target="_blank">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8 p-2">
                        <div class="shadow rounded p-2 ">
                            <a type="button" href="{{route('/')}}" class="btn btn-outline-info">🏠</a>
                            <button type="submit" class="btn btn-success">Test Print</button>
                        </div>
                        <div class="mt-1">
                            <small class="ml-5 page_width_show "></small>
                            <div id="parent_print">
                                <div class="barcode_page border" id="printableArea" style="height: 80vh;">

                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-md-4 p-2 mb-3">
                        <div class="shadow rounded mb-4 p-2" style="height: 90vh; overflow: auto; overflow-x: hidden;">
                            <h5 class="text-dark"><b>Page Setup For Barcode Print</b></h5><hr>
                            <div id="accordion">
                                <div class="card mb-2">
                                    <div class="card-header cursor-pointer" id="headingOne" data-toggle="collapse"  data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link">1) Page Info</button>
                                    </h5>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <small><b><span class="text-danger">*</span>Page Width(inch)</b></small>
                                                <input type="number" required step=any value="" class="form-control form-control-sm" name="page_width" id="page_width">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Page Margin Left(inch)</b></small>
                                                        <input type="number" value="" step=any class="form-control form-control-sm" name="page_margin_left" id="page_margin_left">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Page Margin Right(inch)</b></small>
                                                        <input type="number" value="" step=any class="form-control form-control-sm" name="page_margin_right" id="page_margin_right">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Page Margin Top(inch)</b></small>
                                                        <input type="number" value="" step=any class="form-control form-control-sm" name="page_margin_top" id="page_margin_top">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Page Margin Bottom(inch)</b></small>
                                                        <input type="number" value="" step=any class="form-control form-control-sm" name="page_margin_bottom" id="page_margin_bottom">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2">
                                    <div class="card-header" id="headingTwo"  data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed">
                                        2) Barcode Item
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                    <div class="card-body">
                                            <div class="form-group">
                                                <small><b><span class="text-danger">*</span>How many barcode in per row?</b></small>
                                                <select class="form-control form-control-sm" name="barcode_in_per_row" id="barcode_in_per_row" required>
                                                    <option value="0">Select</option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <div class="row rounded shadow mt-1 border">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b><span class="text-danger">*</span>Barcode Column Width(inch)</b></small>
                                                        <input type="number" step=any value="" required class="form-control form-control-sm" name="barcode_width" id="barcode_width">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b><span class="text-danger">*</span>Barcode Column Height(inch)</b></small>
                                                        <input type="number" step=any value="" required class="form-control form-control-sm" name="barcode_height" id="barcode_height">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row rounded shadow mt-3 border">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Barcode Column Margin Left(pixel)</b></small>
                                                        <input type="number" step=any value="" class="form-control form-control-sm" name="barcode_column_margin_left" id="barcode_column_margin_left">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Barcode Column Margin Right(pixel)</b></small>
                                                        <input type="number" step=any value="" class="form-control form-control-sm" name="barcode_column_margin_right" id="barcode_column_margin_right">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Barcode Column Margin Top(pixel)</b></small>
                                                        <input type="number" step=any value="" class="form-control form-control-sm" name="barcode_column_margin_top" id="barcode_column_margin_top">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <small><b>Barcode Column Margin Bottom(pixel)</b></small>
                                                        <input type="number" step=any value="" class="form-control form-control-sm" name="barcode_column_margin_bottom" id="barcode_column_margin_bottom">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2" id="additional_column_info">
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-2">
                                    <div class="card-header" id="headingThree"  data-toggle="collapse"  data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed">
                                        3) Others
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row rounded shadow mt-1 border">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <small><b><span class="text-danger">*</span>Barcode Image Height(inch) {default: 0.4}</b></small>
                                                    <input type="number" step=any required class="form-control form-control-sm" value="0.4" name="image_height" id="image_height">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <small><b><span class="text-danger">*</span>Text Size(px)</b></small>
                                                    <input type="number" step=any required class="form-control form-control-sm" value="12" name="text_size" id="text_size">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <div class="card mb-2">
                                    <div class="card-header" id="headingFour"  data-toggle="collapse"  data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <h5 class="mb-0">
                                        <button type="button" class="btn btn-link collapsed">
                                        4) Printer info & Save
                                        </button>
                                    </h5>
                                    </div>
                                    <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row  mt-1 mb-5">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <small><b><span class="text-danger">*</span>For Which Branch</b></small>
                                                    <select class="form-control" id="" name="branch_id">
                                                      <option value="all">All</option>
                                                      @foreach($branches as $branch)
                                                      <option value="{{$branch->id}}">{{$branch->branch_name}} [{{$branch->branch_address}}]</option>
                                                      @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <small><b><span class="text-danger">*</span>Printer Name</b></small>
                                                    <input type="text" step=any  class="form-control form-control-sm" name="printer_name" id="printer_name">
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <small><b><span class="text-danger">*</span>Code [Ex: 56576]</b></small>
                                                    <input type="number" step=any  class="form-control form-control-sm" name="code" id="code">
                                                </div>
                                                <div class="form-group">
                                                    <small><b>Note ( Optional )</b></small>
                                                    <textarea class="form-control" name="note" id="note" rows="2"></textarea>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group text-right">
                                                    <button type="button" id="save_form_button" class="btn btn-success">Save Settings</button>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                
                                
                                </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </form>
    </section>

    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <script src="{{ asset('js/toastify-js.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>



    
    <script>

        $( "#barcode_in_per_row" ).change(function() {
            
            var column_info =  $( "#barcode_in_per_row" ).val();
            if(column_info > 1) {
                var i = 1;
                var output = '';
                for(i; i <= column_info; i++) {
                    output += '<div class="row rounded shadow mt-3 border"><div class="col-md-12"><h5 class="text-success"><b>Column '+i+' Additional Style(Optional):</b></h5></div><div class="col-md-6"><div class="form-group"><small><b>Column '+i+' Margin Left(pixel)</b></small><input type="number" onkeyup="customControl()" step=any value="" class="form-control form-control-sm" name="margin_left_for_column'+i+'" id="margin_left_for_column'+i+'"></div></div><div class="col-md-6"><div class="form-group"><small><b>Column '+i+' Margin Right(pixel)</b></small><input type="number" onkeyup="customControl()" step=any value="" class="form-control form-control-sm"  name="margin_right_for_column'+i+'" id="margin_right_for_column'+i+'"></div></div><div class="col-md-6"><div class="form-group"><small><b>Column '+i+' Margin Top(pixel)</b></small><input type="number" onkeyup="customControl()" step=any value="" class="form-control form-control-sm" name="margin_top_for_column'+i+'" id="margin_top_for_column'+i+'"></div></div><div class="col-md-6"><div class="form-group"><small><b>Column '+i+' Margin Bottom(pixel)</b></small><input type="number" onkeyup="customControl()" step=any value="" class="form-control form-control-sm" name="margin_bottom_for_column'+i+'" id="margin_bottom_for_column'+i+'"></div></div></div>';
                }
                $('#additional_column_info').html(output);
            }
            else {
                $('#additional_column_info').html('');
            }

            if(column_info > 0) {
                var column_for_barcode = column_info * 2;
                var a = 1;
                var b = 1;
                var demoBarcode = '';
                for(a; a <= column_for_barcode; a++) {
                    // demoBarcode += '<div class="barcode_item column'+b+'"><span class="barcode_text">Potato 1kg</span><br><img class="barcode_image"  width="90%" src="data:image/png;base64,{{DNS1D::getBarcodePNG('124312312312', 'C128')}}"/><span class="barcode_text">price: 508.99 tk</span></div>';
                    demoBarcode += '<div class="barcode_item"><div class="border_class column'+b+'"><span class="barcode_text">Potato 1kg</span><br><img class="barcode_image"  width="90%" src="data:image/png;base64,{{DNS1D::getBarcodePNG('124312312312', 'C128')}}"/><br><span class="barcode_text">price: 508.99 tk</span></div></div>';
                    
                    if(b == column_info) {
                        b = 1;
                    }
                    else {
                        b++;
                    }
                }
                $('.barcode_page').html(demoBarcode);
            }
            else {
                $('.barcode_page').html('');
            }
            pageSetup();
        });

        $('input[type="number"]').keyup(function() {
            pageSetup();
        });

        function check_value(item) {
            if(item == '') {
                item = 0;
            }
            return item;
        }

        function customControl() {
            pageSetup();
        }


        function pageSetup() {

            var page_width = $('#page_width').val();
            var page_margin_left = $('#page_margin_left').val();
            var page_margin_right = $('#page_margin_right').val();
            var page_margin_top = $('#page_margin_top').val();
            var page_margin_bottom = $('#page_margin_bottom').val();

            $('.barcode_page').width(check_value(page_width)+'in');
            $('.page_width_show').text(check_value(page_width)+' inch');
            $('.barcode_page').css("max-width", check_value(page_width)+'in');
            $('.barcode_page').css("min-width", check_value(page_width)+'in');
            $('.barcode_page').css("margin-left", check_value(page_margin_left)+'in');
            $('.barcode_page').css("margin-right", check_value(page_margin_right)+'in');
            $('.barcode_page').css("margin-top", check_value(page_margin_top)+'in');
            $('.barcode_page').css("margin-bottom", check_value(page_margin_bottom)+'in');
            
            var barcode_in_per_row = $('#barcode_in_per_row').val();
            var barcode_width_in_percent = 100 / barcode_in_per_row;
            $('.barcode_item').css("width", parseInt(barcode_width_in_percent)+'%');
            var barcode_width = $('#barcode_width').val();
            var barcode_height = $('#barcode_height').val();
            $('.barcode_item').css("width", check_value(barcode_width)+'in');
            $('.barcode_item').css("min-width", check_value(barcode_width)+'in');
            $('.barcode_item').css("height", check_value(barcode_height)+'in');
            $('.barcode_item').css("min-height", check_value(barcode_height)+'in');

            var barcode_column_margin_left = $('#barcode_column_margin_left').val();
            var barcode_column_margin_right = $('#barcode_column_margin_right').val();
            var barcode_column_margin_top = $('#barcode_column_margin_top').val();
            var barcode_column_margin_bottom = $('#barcode_column_margin_bottom').val();
            $('.barcode_item').css("margin-left", check_value(barcode_column_margin_left)+'px');
            $('.barcode_item').css("margin-right", check_value(barcode_column_margin_right)+'px');
            $('.barcode_item').css("margin-top", check_value(barcode_column_margin_top)+'px');
            $('.barcode_item').css("margin-bottom", check_value(barcode_column_margin_bottom)+'px');
            
            
            // column 1 additional css 
            if($('#margin_left_for_column1').length > 0) {
                var margin_left_for_column1 = $('#margin_left_for_column1').val();
                var margin_right_for_column1 = $('#margin_right_for_column1').val();
                var margin_top_for_column1 = $('#margin_top_for_column1').val();
                var margin_bottom_for_column1 = $('#margin_bottom_for_column1').val();
                
                if(check_value(margin_left_for_column1) != 0) {
                    $('.column1').css("margin-left", check_value(margin_left_for_column1)+'px');
                }

                if(check_value(margin_right_for_column1) != 0) {
                    $('.column1').css("margin-right", check_value(margin_right_for_column1)+'px');
                }

                if(check_value(margin_top_for_column1) != 0) {
                    $('.column1').css("margin-top", check_value(margin_top_for_column1)+'px');
                }

                if(check_value(margin_bottom_for_column1) != 0) {
                    $('.column1').css("margin-bottom", check_value(margin_bottom_for_column1)+'px');
                }
            }

            // column 2 additional css 
            if($('#margin_left_for_column2').length > 0) {
                var margin_left_for_column2 = $('#margin_left_for_column2').val();
                var margin_right_for_column2 = $('#margin_right_for_column2').val();
                var margin_top_for_column2 = $('#margin_top_for_column2').val();
                var margin_bottom_for_column2 = $('#margin_bottom_for_column2').val();
                
                if(check_value(margin_left_for_column2) != 0) {
                    $('.column2').css("margin-left", check_value(margin_left_for_column2)+'px');
                }

                if(check_value(margin_right_for_column2) != 0) {
                    $('.column2').css("margin-right", check_value(margin_right_for_column2)+'px');
                }

                if(check_value(margin_top_for_column2) != 0) {
                    $('.column2').css("margin-top", check_value(margin_top_for_column2)+'px');
                }

                if(check_value(margin_bottom_for_column2) != 0) {
                    $('.column2').css("margin-bottom", check_value(margin_bottom_for_column2)+'px');
                }
            }

            // column 3 additional css 
            if($('#margin_left_for_column3').length > 0) {
                var margin_left_for_column3 = $('#margin_left_for_column3').val();
                var margin_right_for_column3 = $('#margin_right_for_column3').val();
                var margin_top_for_column3 = $('#margin_top_for_column3').val();
                var margin_bottom_for_column3 = $('#margin_bottom_for_column3').val();
                
                if(check_value(margin_left_for_column3) != 0) {
                    $('.column3').css("margin-left", check_value(margin_left_for_column3)+'px');
                }

                if(check_value(margin_right_for_column3) != 0) {
                    $('.column3').css("margin-right", check_value(margin_right_for_column3)+'px');
                }

                if(check_value(margin_top_for_column3) != 0) {
                    $('.column3').css("margin-top", check_value(margin_top_for_column3)+'px');
                }

                if(check_value(margin_bottom_for_column3) != 0) {
                    $('.column3').css("margin-bottom", check_value(margin_bottom_for_column3)+'px');
                }
            }

            // column 4 additional css 
            if($('#margin_left_for_column4').length > 0) {
                var margin_left_for_column4 = $('#margin_left_for_column4').val();
                var margin_right_for_column4 = $('#margin_right_for_column4').val();
                var margin_top_for_column4 = $('#margin_top_for_column4').val();
                var margin_bottom_for_column4 = $('#margin_bottom_for_column4').val();
                
                if(check_value(margin_left_for_column4) != 0) {
                    $('.column4').css("margin-left", check_value(margin_left_for_column4)+'px');
                }

                if(check_value(margin_right_for_column4) != 0) {
                    $('.column4').css("margin-right", check_value(margin_right_for_column4)+'px');
                }

                if(check_value(margin_top_for_column4) != 0) {
                    $('.column4').css("margin-top", check_value(margin_top_for_column4)+'px');
                }

                if(check_value(margin_bottom_for_column4) != 0) {
                    $('.column4').css("margin-bottom", check_value(margin_bottom_for_column4)+'px');
                }
            }

            // column 5 additional css 
            if($('#margin_left_for_column5').length > 0) {
                var margin_left_for_column5 = $('#margin_left_for_column5').val();
                var margin_right_for_column5 = $('#margin_right_for_column5').val();
                var margin_top_for_column5 = $('#margin_top_for_column5').val();
                var margin_bottom_for_column5 = $('#margin_bottom_for_column5').val();
                
                if(check_value(margin_left_for_column5) != 0) {
                    $('.column5').css("margin-left", check_value(margin_left_for_column5)+'px');
                }

                if(check_value(margin_right_for_column4) != 0) {
                    $('.column5').css("margin-right", check_value(margin_right_for_column5)+'px');
                }

                if(check_value(margin_top_for_column4) != 0) {
                    $('.column5').css("margin-top", check_value(margin_top_for_column5)+'px');
                }

                if(check_value(margin_bottom_for_column4) != 0) {
                    $('.column5').css("margin-bottom", check_value(margin_bottom_for_column5)+'px');
                }
            }

            var image_height = $('#image_height').val();
            $('.barcode_image').css("height", check_value(image_height)+'in');
            $('.barcode_image').css("min-height", check_value(image_height)+'in');
            $('.barcode_image').css("max-height", check_value(image_height)+'in');

            var text_size = $('#text_size').val();
            $('.barcode_text').css("font-size", check_value(text_size)+'px');
           
        }
        
        
        $(document).ready(function(){
            $('#save_form_button').click(function(e){
                if ((document.getElementById("level_printer_form").checkValidity()) && $('#printer_name').val() != '' && $('#code').val() != '') {
                  //e.preventDefault();
                  $.ajax({
                      url: "{{ route('admin.product.store.barcode.level.printer')}}",
                      method: 'post',
                      data: $('#level_printer_form').serialize(),
                      beforeSend: function() {
                        $('#save_form_button').html('Processing...');
                      },
                      success: function(response){
                          if(response.status == 'yes') {
                              $('#save_form_button').html('Complete');
                              window.location.href = "{{URL::to('/admin/product-barcode-level-printers')}}"
                          }
                          else {
                              $('#save_form_button').html('Submit');
                              Toastify({
                                text: "Error Occoured, Please Try Again.",
                                backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                                className: "error",
                            }).showToast();
                            document.getElementById('error').play();
                          }
                         
                      }
                  });
                }
                else {
                    Toastify({
                        text: "Please Fill Up Required Information.",
                        backgroundColor: "linear-gradient(to right, #F50057, #2F2E41)",
                        className: "error",
                    }).showToast();
                    document.getElementById('error').play();
                }
            });
        });
        
        
        
    </script>


</body>
</html>