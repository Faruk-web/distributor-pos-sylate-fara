<?php

    function check_value($item) {
        if($item == '') {
            $item = 0;
        }
        return $item;
    }

    $column_info = $_GET['barcode_in_per_row'];
    $barcode_width_in_percent = 100 / $column_info;

?>
<!DOCTYPE html>
<html>
<head>
<title>Test Print</title>
</head>
<style>
    body {
        width: <?php echo check_value($_GET['page_width']); ?>in !important;
        min-width:<?php echo check_value($_GET['page_width']); ?>in !important;
        max-width:<?php echo check_value($_GET['page_width']); ?>in !important;
        margin-left:<?php echo check_value($_GET['page_margin_left']); ?>in !important;
        margin-right:<?php echo check_value($_GET['page_margin_right']); ?>in !important;
        margin-top:<?php echo check_value($_GET['page_margin_top']); ?>in !important;
        margin-bottom:<?php echo check_value($_GET['page_margin_bottom']); ?>in !important;
    }

    .barcode_item {
        float: left;
        text-align: center !important;
        width:<?php echo $barcode_width_in_percent; ?>% !important;
        width: <?php echo check_value($_GET['barcode_width']); ?>in !important;
        min-width:<?php echo check_value($_GET['barcode_width']); ?>in !important;
        max-width:<?php echo check_value($_GET['barcode_width']); ?>in !important;
        height: <?php echo check_value($_GET['barcode_height']); ?>in !important;
        min-height:<?php echo check_value($_GET['barcode_height']); ?>in !important;
        max-height:<?php echo check_value($_GET['barcode_height']); ?>in !important;

        margin-left:<?php echo check_value($_GET['barcode_column_margin_left']); ?>px !important;
        margin-right:<?php echo check_value($_GET['barcode_column_margin_right']); ?>px !important;
        margin-top:<?php echo check_value($_GET['barcode_column_margin_top']); ?>px !important;
        margin-bottom:<?php echo check_value($_GET['barcode_column_margin_bottom']); ?>px !important;
        
    }

    .border_class {
        border: 1px solid #000000;
        border-radius: 5px;
    }

    .barcode_image {
        height:<?php echo check_value($_GET['image_height']); ?>in !important;
        min-height:<?php echo check_value($_GET['image_height']); ?>in !important;
        max-height:<?php echo check_value($_GET['image_height']); ?>in !important;
    }

    .barcode_text {
        font-size:<?php echo check_value($_GET['text_size']); ?>px !important;
    }

    
    @if(Request::has('margin_left_for_column1'))
        .column1 {
            @if(Request::input('margin_left_for_column1') != '')
                margin-left:<?php echo check_value($_GET['margin_left_for_column1']); ?>px !important;
            @endif
            @if(Request::input('margin_right_for_column1') != '')
                margin-right:<?php echo check_value($_GET['margin_right_for_column1']); ?>px !important;
            @endif
            @if(Request::input('margin_top_for_column1') != '')
                margin-top:<?php echo check_value($_GET['margin_top_for_column1']); ?>px !important;
            @endif
            @if(Request::input('margin_bottom_for_column1') != '')
                margin-bottom:<?php echo check_value($_GET['margin_bottom_for_column1']); ?>px !important;
            @endif
        }
    @endif

    @if(Request::has('margin_left_for_column2'))
        .column2 {
            @if(Request::input('margin_left_for_column2') != '')
                margin-left:<?php echo check_value($_GET['margin_left_for_column2']); ?>px !important;
            @endif
            @if(Request::input('margin_right_for_column2') != '')
                margin-right:<?php echo check_value($_GET['margin_right_for_column2']); ?>px !important;
            @endif
            @if(Request::input('margin_top_for_column2') != '')
                margin-top:<?php echo check_value($_GET['margin_top_for_column2']); ?>px !important;
            @endif
            @if(Request::input('margin_bottom_for_column2') != '')
                margin-bottom:<?php echo check_value($_GET['margin_bottom_for_column2']); ?>px !important;
            @endif
        }
    @endif

    @if(Request::has('margin_left_for_column3'))
        .column3 {
            @if(Request::input('margin_left_for_column3') != '')
                margin-left:<?php echo check_value($_GET['margin_left_for_column3']); ?>px !important;
            @endif
            @if(Request::input('margin_right_for_column3') != '')
                margin-right:<?php echo check_value($_GET['margin_right_for_column3']); ?>px !important;
            @endif
            @if(Request::input('margin_top_for_column3') != '')
                margin-top:<?php echo check_value($_GET['margin_top_for_column3']); ?>px !important;
            @endif
            @if(Request::input('margin_bottom_for_column3') != '')
                margin-bottom:<?php echo check_value($_GET['margin_bottom_for_column3']); ?>px !important;
            @endif
        }
    @endif

    @if(Request::has('margin_left_for_column4'))
        .column4 {
            @if(Request::input('margin_left_for_column4') != '')
                margin-left:<?php echo check_value($_GET['margin_left_for_column4']); ?>px !important;
            @endif
            @if(Request::input('margin_right_for_column4') != '')
                margin-right:<?php echo check_value($_GET['margin_right_for_column4']); ?>px !important;
            @endif
            @if(Request::input('margin_top_for_column4') != '')
                margin-top:<?php echo check_value($_GET['margin_top_for_column4']); ?>px !important;
            @endif
            @if(Request::input('margin_bottom_for_column4') != '')
                margin-bottom:<?php echo check_value($_GET['margin_bottom_for_column4']); ?>px !important;
            @endif
        }
    @endif

    @if(Request::has('margin_left_for_column5'))
        .column5 {
            @if(Request::input('margin_left_for_column5') != '')
                margin-left:<?php echo check_value($_GET['margin_left_for_column5']); ?>px !important;
            @endif
            @if(Request::input('margin_right_for_column5') != '')
                margin-right:<?php echo check_value($_GET['margin_right_for_column5']); ?>px !important;
            @endif
            @if(Request::input('margin_top_for_column5') != '')
                margin-top:<?php echo check_value($_GET['margin_top_for_column5']); ?>px !important;
            @endif
            @if(Request::input('margin_bottom_for_column5') != '')
                margin-bottom:<?php echo check_value($_GET['margin_bottom_for_column5']); ?>px !important;
            @endif
        }
    @endif

    

</style>
<body>
    <?php
        if($column_info > 0) {
            $column_for_barcode = $column_info * 2;
            $a = 1;
            $b = 1;
            $demoBarcode = '';
            for($a; $a <= $column_for_barcode; $a++) {
                echo '<div class="barcode_item"><div class="border_class column'.$b.'"><span class="barcode_text">Potato 1kg</span><br><img class="barcode_image"  width="90%" src="data:image/png;base64,'.DNS1D::getBarcodePNG('124312312312', 'C128').'"/><br><span class="barcode_text">price: 508.99 tk</span></div></div>';
                if($b == $column_info) {
                    $b = 1;
                }
                else {
                    $b++;
                }
            }
        }
    ?>
    
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="" crossorigin="anonymous"></script>
<script>
    window.onload = function () {
        window.print();
    }
</script>
    
</body>
</html>