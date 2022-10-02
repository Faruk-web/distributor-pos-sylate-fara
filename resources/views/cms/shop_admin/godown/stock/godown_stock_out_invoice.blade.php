<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Godown Stock Out Invoice | {{$godown_stock_out_invoice_info->invoice_id}}</title>
</head>
<style>
    @page {
        header: page-header;
        footer: page-footer;
        margin-top: 30mm;


    }

    body {
        font-family: 'examplefont', nikosh;
    }

    li {
        list-style: none;
        float: left;
        overflow: hidden;
    }

    p {
        font-size: 13px;
    }

    .customar_info {
        width: 100%;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    td,
    th {
        border: 1px solid black;
        text-align: left;
        padding: 5px;
        font-size: 13px;
    }

    .invoiceIDandDate {
        text-align: right;

    }

    .clientInfo {
        background-color: red;
    }

</style>

<body>
    <htmlpageheader name="page-header">
        <div>
            <table style="margin-top: 10px;">
            <tr>
                <td style="border: 0px solid white;">
                    <div>
                        <img src="{{asset(optional($shop_info)->shop_logo)}}" alt="">
                    </div>
                </td>
                <td style="text-align: right; border: 0px solid white;">
                    <div>
                    <p style="font-size: 13px; text-align: right; overflow: hidden;"><span style="font-size: 15px; font-weight: bold;">
                            {{$shop_info->shop_name}}</span><br>
                            {{$shop_info->address}},<br>
                            {{$shop_info->phone}}, </b><br>
                            {{$shop_info->email}}<br>
                            {{$shop_info->shop_website}}
                        </p>
                        </div>
                </td>
            </tr>
        </table>
        
            <hr style="border: 1px solid #81d4fa;">
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <table width="100%">
            <tr>
                <td width="5%" align="center" style="border: 0px solid white;">{PAGENO}/{nbpg}</td>
                <td width="90%" style="text-align: center; border: 0px solid white;">
                    <p style="font-size: 13px; text-align: center; font-family: Arial;">This Software Created by <b>FARA
                            IT Fusion</b>(www.faraitfusion.com)</p>
                </td>
                <td width="5%" style="text-align: right; border: 0px solid white;"></td>
            </tr>
        </table>
    </htmlpagefooter>
    @php($user_info = $godown_stock_out_invoice_info->user_info)
    <div>
        <table>
            <tr>
                <th style="border: 0px solid white;">
                    <div>
                        
                            <span style="font-size: 18px; font-weight: bold; color: #544AF4;">Godown Stock Out Invoice</span><br>
                            <p>
                            Supplier Name: {{$user_info->name}} (@if($user_info->type == 'owner') Admin @else {{str_replace($user_info->shop_id."#","", $user_info->getRoleNames())}}  @endif)<br>
                            Address: {{optional($user_info)->address}}<br>
                            Phone: {{optional($user_info)->phone}}<br>
                            Email: {{optional($user_info)->email}}<br>
                        </p>
                    </div>
                </th>
                <th style="text-align: right; border: 0px solid white;">
                    <p class="invoiceIDandDate" style="font-family: Arial;">
                            Invoice # {{str_replace("_","/", $godown_stock_out_invoice_info->invoice_id)}}
                        <br>Branch Name: {{$godown_stock_out_invoice_info->branch_info->branch_name}}
                        <br>Date: {{date('d M, Y', strtotime(optional($godown_stock_out_invoice_info)->date))}}</p>
                </th>
            </tr>
        </table>
    </div>
    <br />
    <div>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr style="text-align: right; background-color: #dddddd;">
                    <th scope="col" style="text-align: center;">SN</th>
                    <th width="50px" style="text-align: left;">Product Name</th>
                    <th style="text-align: center;">Lot Number</th>
                    <th scope="col" style="text-align: center;">Quantity</th>
                </tr>
            </thead>
            <tbody>
                @php($i = 1)
                @foreach($godown_stock_out_invoice_info->products as $product)
                <?php
                    $variation_name = '';
                    if($product->variation_id != 0 || $product->variation_id != '') {
                        $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  '('.optional($variation_info)->list_title.')';
                    }
                ?>
                <tr style="text-align: right;">
                    <th scope="row" style="text-align: center;">{{$i}}</th>
                    <td width="350px" style="text-align: left;">{{$product->product_info->p_name}} {{$variation_name}}</td>
                    <td style="text-align: center;">{{optional($product)->lot_number}}</td>
                    <td style="text-align: center;">{{$product->quantity}} {{$product->product_info->unit_type_name->unit_name}}</td>
                </tr>
                @php($i += 1)
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 8px; text-align: right;">
        
    </div>
    <div>
        <p><b>Note:</b></p>
        {{optional($godown_stock_out_invoice_info)->note}}
    </div>
</body>
</html>
