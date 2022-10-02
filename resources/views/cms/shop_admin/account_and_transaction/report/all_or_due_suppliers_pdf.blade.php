@php
if($supplier_type == 'all') {
    $type = 'All';
}
else if($supplier_type == 'due') {
    $type = 'Due';
}

@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$type}} Supplier Report</title>
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
                <td width="70%" align="left" style="border: 0px solid white;">{PAGENO}/{nbpg} [ {{$type}} Supplier Report ] : {{date('d M, Y')}}</td>
                <td width="30%" style="text-align: center; border: 0px solid white;">
                    <p style="font-size: 13px; text-align: center; font-family: Arial;">Powered By <b>FARA IT Fusion</b></p>
                </td>
                
            </tr>
        </table>
    </htmlpagefooter>
    @php( $currency = ENV('DEFAULT_CURRENCY'))
    <div>
        <table>
            <tr>
                <th style="border: 0px solid white;">
                    <div>
                        <p>Print Date: {{date('d M, Y')}}</p>
                    </div>
                </th>
                <th style="text-align: right; border: 0px solid white;">
                    <p class="invoiceIDandDate" style="font-family: Arial;"></p>
                </th>
            </tr>
        </table>
    </div>
    <br />
    <div>
        <div>
            <table class="table">
                <thead>
                <tr><td colspan="6" align="center"><h3>{{$type}} Supplier Report</h3></td></tr>
                    <tr>
                        <th>Name</th>
                        <th>Company Name</th>
                        <th>Phone</th>
                        <th>Code</th>
                        <th>Address</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{$supplier->name}}</td>
                        <td>{{optional($supplier)->company_name}}</td>
                        <td>{{$supplier->phone}}</td>
                        <td>{{$supplier->code}}</td>
                        <td>{{optional($supplier)->address}}</td>
                        <td>{{optional($supplier)->balance}} {{$currency}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    
</body>
</html>
