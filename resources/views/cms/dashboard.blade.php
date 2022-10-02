@extends('cms.master')
@section('body_content')
@if($user->type == 'super_admin')


@elseif($user->type == 'reseller')
@php
    $business = DB::table('users')->join('shop_settings', 'users.shop_id', '=', 'shop_settings.shop_code')->where(['users.type'=>'owner', 'users.active'=>0])->where('shop_settings.reseller_id', $user->id)->select('users.id', 'users.active')->get();

@endphp
<div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="row shadow rounded p-2 border">
                    <div class="col-md-12"><h4><b>Dashboard</b></h4></div>
                    <div class="col-12 col-md-3">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$business->count('id')}}</dt>
                                    <dd class="text-muted mb-0">Total Shop</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$business->where('active', 1)->count('id')}}</dt>
                                    <dd class="text-muted mb-0">Active Shop</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$business->where('active', 0)->count('id')}}</dt>
                                    <dd class="text-muted mb-0">Pending Shop</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-12">
                        <div class="block block-rounded d-flex flex-column border border-success p-3">
                            <class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">My Referal Link:</dt>
                                    <div class="row">
                                        <div class="col-md-10 col-12">
                                            <input type="text" value="{{route('reseller.referral.link', ['retoken'=>$user->id])}}" readonly class="form-control" id="myInput">
                                            <span class="p-1 text-success" style="display:none;" id="alarmmsg"></span>
                                        </div>
                                        <div class="col-md-2 col-12 text-right">
                                            <button type="button" onclick="copy_text()" class="btn btn-success btn-rounded">Copy</button>
                                        </div>
                                    </div>
                                </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copy_text() {
          var copyText = document.getElementById("myInput");
            copyText.select();
            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'Link Copied' : 'Wrong way, Please use ctrl + c';
                $("#alarmmsg").text(msg).show().delay(2000).fadeOut();
            } catch (err) {
                console.log('Oops, unable to copy');
            }        
            return false;
            
        }
    </script>

@else
    @if($user->hasPermissionTo('admin.dashboard') || $user->type == 'owner')
        @php
            $currency = ENV('DEFAULT_CURRENCY');
            $shop_id = Auth::user()->shop_id;
            $sales = DB::table('orders')->where('shop_id', $shop_id)->get(['invoice_total', 'pre_due', 'paid_amount']);
            $invoice_total = $sales->sum('invoice_total');
            $invoice_total_pre_due = $sales->sum('pre_due');
            $invoice_instant_paid = $sales->sum('paid_amount');
            $due_received = DB::table('take_customer_dues')->where('shop_id', $shop_id)->sum('received_amount');
            
            $current_year_sales = DB::table('orders')->where('shop_id', $shop_id)->whereYear('date', \Carbon\Carbon::now()->year)->sum('total_gross');
            $current_month_sales = DB::table('orders')->where('shop_id', $shop_id)->whereYear('date', \Carbon\Carbon::now()->year)->whereMonth('date', \Carbon\Carbon::now()->month)->sum('total_gross');
            
            $customers = DB::table('customers')->where('shop_id', $shop_id)->get(['balance', 'id', 'opening_bl']);
            $customers_due = $customers->filter(function($item) { return $item->balance > 0; })->sum('balance');
            $due_customers = $customers->filter(function($item) { return $item->balance > 0; })->count('id');
            $total_customers = $customers->count('id');
            $customer_opening_bl = $customers->sum('opening_bl');
            
            $suppliers = DB::table('suppliers')->where('shop_id', $shop_id)->get(['balance', 'id', 'opening_bl']);
            $suppliers_due = $suppliers->filter(function($item) { return $item->balance > 0; })->sum('balance');
            $due_suppliers = $suppliers->filter(function($item) { return $item->balance > 0; })->count('id');
            $total_suppliers = $suppliers->count('id');
            
            $total_products = DB::table('products')->where('shop_id', $shop_id)->count('id');
            $cash_in_hand = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first('balance');
            $cash_at_banks = DB::table('banks')->where('shop_id', $shop_id)->sum('balance');
            
            
            $godown_products = DB::table('products')->where('shop_id', $shop_id)->where('G_current_stock', '>', 0)->get(['id', 'G_current_stock', 'purchase_price']);
            $total_godowns_product = $godown_products->count('id');
            $total_godowns_stock_value = 0;
            foreach($godown_products as $product) {
                $total_godowns_stock_value = $total_godowns_stock_value + ((($product->G_current_stock) + 0) * $product->purchase_price);
            }
            
            $total_opening_stock_value = DB::table('product_trackers')
                                        ->join('products', 'product_trackers.product_id', '=', 'products.id')
                                        ->where('products.shop_id', $shop_id)
                                        ->where('product_trackers.product_form', 'OP')
                                        ->select('product_trackers.total_price')
                                        ->sum('product_trackers.total_price');
            
            $j = 0;
        @endphp
    <style>
        #valueP {
            font-size: 20px;
            font-weight: bold;
            background-color: #343A40;
            border-radius: 10px;
            border: 2px solid #F50057;
            text-align: center;
        }
    
        .row.row-deck>div {
            display: inline;
        }
    
    </style>
    <div class="content">
        <div class="row">
            <div class="col-md-8">
                <div class="row shadow rounded p-2 border">
                    <div class="col-md-12"><h4><b>Sell & Customers</b></h4></div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($invoice_total-$invoice_total_pre_due, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Total Sales</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($invoice_instant_paid+$due_received, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Total Collections</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format(abs($customers_due-$customer_opening_bl), 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Sales Due</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($current_year_sales, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Current Year Sales</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($current_month_sales, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Current Month Sales</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$total_customers}}</dt>
                                    <dd class="text-muted mb-0">Total Customers</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$due_customers}}</dt>
                                    <dd class="text-muted mb-0">Due Customers</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($customers_due, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Customers Due</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($customer_opening_bl, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Opening Balance</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row shadow rounded p-2 border">
                    <div class="col-md-12"><h4><b>Products & Balance</b></h4></div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$total_products}}</dt>
                                    <dd class="text-muted mb-0">Total Products</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$total_godowns_product}}</dt>
                                    <dd class="text-muted mb-0">Godown Products</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($total_godowns_stock_value, 2)}}</dt>
                                    <dd class="text-muted mb-0">G Stock Value</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($total_opening_stock_value, 2)}}</dt>
                                    <dd class="text-muted mb-0">Opening Stock Value</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($cash_in_hand->balance, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Cash In Hand</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($cash_at_banks, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Cash At Bank</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row shadow rounded p-2 border">
                    <div class="col-md-12"><h4><b>Suppliers</b></h4></div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$total_suppliers}}</dt>
                                    <dd class="text-muted mb-0">Total Suppliers</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{$due_suppliers}}</dt>
                                    <dd class="text-muted mb-0">Due Suppliers</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($suppliers_due, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Suppliers Due</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header text-light bg-dark text-center" style="padding: 5px; font-weight: bold;">
                        <h2 style="font-weight: bold; color: #fff;">SALES</h2>
                        <p id="valueP">Last 7 Days</p>
                    </div>
                    <div class="card-body">
                        @while($j < 7) 
                            @php( $date = date('Y-m-d', strtotime('-'.$j.' days')))
                            @php( $sales = DB::table('orders')->where(['shop_id'=>$shop_id, 'date'=>$date])->sum('total_gross'))
                            <div class="row border-bottom mb-2">
                                <div class="col-md-6 col-12 text-center"><h6>{{date('d M, Y', strtotime($date))}}</h6></div>
                                <div class="col-md-6 col-12 text-center"><h6>{{number_format($sales, 2)." ".$currency}}</h6></div>
                            </div>
                            @php($j++)
                        @endwhile
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
                    <!--<div class="col-xl-12 d-flex flex-column">-->
                    <!--    <div class="block block-rounded flex-grow-1 d-flex flex-column">-->
                    <!--        <div class="block-header block-header-default">-->
                    <!--            <h3 class="block-title">Monthley Income & Expense Of {{date('Y')}}</h3>-->
                    <!--        </div>-->
                    <!--        <div class="block-content block-content-full flex-grow-1 d-flex align-items-center">-->
                    <!--            <canvas class="js-chartjs-earnings"></canvas>-->
                                 
                    <!--             <canvas id="canvas" height="280" width="600"></canvas>-->
                    <!--        </div>-->
                            
                    <!--    </div>-->
                    <!--</div>-->
                </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
        <script>
            var months = ['2015','2016','2017','2018','2019','2020', '2015','2016','2017','2018','2019','2020'];
            var income = ['201','2016','2017','2018','2019','2020'];
            var expense = ['201','2016','2017','2018','2019','2020'];
            
            var barChartData = {
                labels: months,
                datasets: [
                    {
                        label: 'Income',
                        backgroundColor: "#544AF4",
                        data: income
                    },
                    {
                        label: 'Expense',
                        backgroundColor: "#F50057",
                        data: expense
                    },
                ]
            };
            
            window.onload = function() {
                var ctx = document.getElementById("canvas").getContext("2d");
                window.myBar = new Chart(ctx, {
                    type: 'bar',
                    data: barChartData,
                    options: {
                        elements: {
                            rectangle: {
                                borderWidth: 2,
                                borderColor: '#c1c1c1',
                                borderSkipped: 'bottom'
                            }
                        },
                        responsive: true,
                        title: {
                            display: true,
                            text: ''
                        }
                    }
                });
            };
        </script>
    
    @elseif($user->type == 'branch_user' && $user->hasPermissionTo('branch.dashboard'))
        <?php
            $currency = ENV('DEFAULT_CURRENCY');
            $branch_id = Auth::user()->branch_id;
            $current_year_sales = DB::table('orders')->where('branch_id', $branch_id)->whereYear('date', \Carbon\Carbon::now()->year)->sum('total_gross');
            $current_month_sales = DB::table('orders')->where('branch_id', $branch_id)->whereYear('date', \Carbon\Carbon::now()->year)->whereMonth('date', \Carbon\Carbon::now()->month)->sum('total_gross');
            $customers_due = DB::table('customers')->where('branch_id', $branch_id)->where('balance', '>', 0)->sum('balance');
            $i = 0;
        ?>
    <style>
        #valueP {
            font-size: 20px;
            font-weight: bold;
            background-color: #343A40;
            border-radius: 10px;
            border: 2px solid #F50057;
            text-align: center;
        }
    
        .row.row-deck>div {
            display: inline;
        }
    
    </style>
    <div class="content">
        <div class="row row-deck">
            <div class="col-md-8">
                <div class="row row-deck">
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($current_year_sales, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Current Year Sales</dd>
                                </dl>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                <a class="font-w500 d-flex align-items-center" href="javascript:void(0)">
                                    View this year orders
                                    <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($current_month_sales, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Current Month Sales</dd>
                                </dl>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                <a class="font-w500 d-flex align-items-center" href="javascript:void(0)">
                                    View this month sales
                                    <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="block block-rounded d-flex flex-column border border-primary">
                            <div
                                class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                <dl class="mb-0">
                                    <dt class="font-size-h4 font-w700">{{number_format($customers_due, 2)." ".$currency}}</dt>
                                    <dd class="text-muted mb-0">Customers Due</dd>
                                </dl>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                <a class="font-w500 d-flex align-items-center" href="{{route('branch.due.customers')}}">
                                    View due customers
                                    <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-header text-light bg-dark text-center" style="padding: 5px; font-weight: bold;">
                        <h2 style="font-weight: bold; color: #fff;">SALES</h2>
                        <p id="valueP">Last 7 Days</p>
                    </div>
                    <div class="card-body">
                            @while($i < 7) 
                                @php( $date = date('Y-m-d', strtotime('-'.$i.' days')))
                                @php( $sales = DB::table('orders')->where(['branch_id'=>$branch_id, 'date'=>$date])->sum('total_gross'))
                                <div class="row border-bottom mb-2">
                                    <div class="col-md-6 col-12 text-center"><h6>{{date('d M, Y', strtotime($date))}}</h6></div>
                                    <div class="col-md-6 col-12 text-center"><h6>{{number_format($sales, 2)." ".$currency}}</h6></div>
                                </div>
                                @php($i++)
                            @endwhile
                    </div>
                </div>
            </div>
    
        </div>
    </div>
    
    @else
    
    @endif


@endif


@endsection
