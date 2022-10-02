<?php

namespace App\Http\Controllers;

use App\Models\Godown_stock_out_invoice;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Product_tracker;

use PDF;

class GodownStockOutInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('godown.stock.out') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'godown';
            $godown_stock_out_invoies = Godown_stock_out_invoice::where('shop_id', $shop_id)->orderBy('id', 'desc')->paginate('350');
            return view('cms.shop_admin.godown.stock.stock_out_invoices', compact('godown_stock_out_invoies', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "This is Old Version, This version is not active!";
        if(User::checkPermission('godown.stock.out') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'godown';
            $branchs = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name']);
            $products = Product::where('shop_id', $shop_id)->where('active', 1)->where('G_current_stock', '>', 0)->get(['id', 'p_name', 'image', 'G_current_stock', 'barCode', 'p_unit_type']);
            return view('cms.shop_admin.godown.stock.stock_out', compact('products', 'wing', 'branchs'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function create_new()
    {
        if(User::checkPermission('godown.stock.out') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'godown';
            $branchs = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name']);
            return view('cms.shop_admin.godown.stock.stock_out_new', compact('wing', 'branchs'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function get_products_search_by_title_into_stock_out(Request $request) {
        $title = $request->title;
        $shop_id = Auth::user()->shop_id;
        $output = '';

        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>'G', 'products.shop_id'=>$shop_id])
                    ->where('product_stocks.stock', '>', 0)
                    ->select('products.p_name', 'products.p_brand', 'product_stocks.*', 'products.p_unit_type');
                    $products = $products->where('products.p_name', "like", "%".$title."%");
                    $products = $products->orderBy('lot_number', 'ASC');
                    $products = $products->paginate(20);
        
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    
                    $variation_name = '';
                    $variation_title = '';
                    if($product->variation_id != 0 && $product->variation_id != '') {
                        $variation_info = DB::table('product_variations')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  '<span class="text-primary">('.optional($variation_info)->title.')</span>';
                        $variation_title = optional($variation_info)->title;
                    }
                    $unit_type_info = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product_text" onclick="myFunction(\''.$product->id.'\', \''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\')" title="Add me">
                        <h6 class="text-success">'.$product->p_name.' '.$variation_name.'</h6>
                        <span><b>Brand:</b> '.optional($brand_info)->brand_name.', <b>Lot Number:</b> '.$product->lot_number.', <b>Sales Price:</b> '.$product->sales_price.', <b>Discount:</b> '.$product->discount.'('.$product->discount_amount.'), <b>VAT:</b> '.$product->vat.'%</span>
                        <br><span class="text-danger"><b>Stock Unit:</b> '.$product->stock.' '.optional($unit_type_info)->unit_name.'</span>
                    </li>';
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        return response()->json($output);

    }
    
    public function product_search_by_barcode_new(Request $request) {
        $barcode = $request->barcode;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $product_output = '';
        
        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>'G', 'products.shop_id'=>$shop_id])
                    ->where('product_stocks.stock', '>', 0)
                    ->where('products.barCode', '=', $barcode)
                    ->select('products.p_name', 'products.p_brand', 'product_stocks.*', 'products.p_unit_type');
                    $products = $products->orderBy('lot_number', 'ASC');
                    $products = $products->get();
        
        
        if( $barcode != '') {
            if($products->isNotEmpty()) {
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    
                    $variation_name = '';
                    $variation_title = '';
                    if($product->variation_id != 0 && $product->variation_id != '') {
                        $variation_info = DB::table('product_variations')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  '<span class="text-primary">('.optional($variation_info)->title.')</span>';
                        $variation_title = optional($variation_info)->title;
                    }
                    
                    $unit_type_info = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    
                    $product_output .= '<div class="col-md-4 p-1"><div class="nav-item mb-1 p-2 rounded" id="product_text" onclick="myFunction(\''.$product->id.'\', \''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\')" title="Add me">
                        <h6 class="text-success">'.$product->p_name.' '.$variation_name.'</h6>
                        <span><b>Brand:</b> '.optional($brand_info)->brand_name.', <b>Lot Number:</b> '.$product->lot_number.', <b>Sales Price:</b> '.$product->sales_price.', <b>Discount:</b> '.$product->discount.'('.$product->discount_amount.'), <b>VAT:</b> '.$product->vat.'%</span>
                        <br><span class="text-danger"><b>Stock Unit:</b> '.$product->stock.' '.optional($unit_type_info)->unit_name.'</span>
                    </div></div>';
                }
                
                $output = [
                    'exist' => 'yes',
                    'product_output'=>$product_output
                ];
            }
            else {
                $output = [
                    'exist' => 'no',
                ];
            }
        }
        
        return response()->json($output);
        
    }
    
    
    
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::checkPermission('godown.stock.out') == true){
            $shop_id = Auth::user()->shop_id;
            $pid = $request->pid;
            $validated = $request->validate([
                'branch_id' => 'required',
            ]);

            $current_time = Carbon::now();
            $branch_id = $request->branch_id;

            $count_total = DB::table('godown_stock_out_invoices')->where('shop_id', $shop_id)->count('id');
            $update_count = $count_total+1;
            $invoice_id="G"."_"."OUT"."_".$shop_id.'_'.$update_count;

            $date = date("Y-m-d", strtotime($request->date));

            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                
                //echo $pid[$key].'<br>';

                $p_data = array();
                $product_exist_quantity_check = DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->first(['G_current_stock']);
                $current_quantity = $product_exist_quantity_check->G_current_stock;
                $updateable_quantity = $current_quantity - $request->quantity[$key];
                
                $p_data['product_id'] = $pid[$key];
                $p_data['quantity'] = $unit;
                $p_data['price'] = 0;
                $p_data['branch_id'] = $branch_id;
                $p_data['total_price'] = 0;
                $p_data['status'] = 1; // 1 means in // Goudown to branch in
                $p_data['product_form'] = 'G';
                $p_data['invoice_id'] = $invoice_id;
                $p_data['note'] = $request->note;
                $p_data['created_at'] = $current_time;
                $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                
                if($insert_product_trackers) {
                    DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->update(['G_current_stock' => $updateable_quantity]);
                    
                    $product_exist_quantity_check = DB::table('product_stocks')->where('pid', $pid[$key])->where('branch_id', $branch_id)->first(['stock', 'id']);
                    if(!empty($product_exist_quantity_check->id)) {
                        $current_quantity = $product_exist_quantity_check->stock;
                        $updateable_quantity = $current_quantity + $request->quantity[$key];
                        DB::table('product_stocks')->where('branch_id', $branch_id)->where('pid', $pid[$key])->update(['stock' => $updateable_quantity, 'updated_at' => $current_time]);
                    }
                    else {
                        DB::table('product_stocks')->insert(['shop_id' => $shop_id, 'branch_id' => $branch_id, 'pid' => $pid[$key], 'stock' => $unit, 'created_at' => $current_time]);
                    }
                }
            }

            $insert = Godown_stock_out_invoice::insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'invoice_id'=>$invoice_id, 'branch_id'=>$branch_id, 'note'=>$request->note, 'date'=>$date, 'created_at'=>$current_time]);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock Out from Godown. Invoice num '.$invoice_id, 'created_at' => $current_time]);
                return Redirect()->route('godown.stock.out.invoices')->with('success', 'Stock Out from Godown Successfully done.');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry something is wrong, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function store_new(Request $request)
    {
        if(User::checkPermission('godown.stock.out') == true){
            
            
            $shop_id = Auth::user()->shop_id;
            
            $pid = $request->pid;
            $validated = $request->validate([
                'branch_id' => 'required',
            ]);
            
            if(is_null($pid)) {
                return Redirect()->back()->with('error', 'No Product Found!!!');
            }

            $current_time = Carbon::now();
            $branch_id = $request->branch_id;

            $count_total = DB::table('godown_stock_out_invoices')->where('shop_id', $shop_id)->count('id');
            $update_count = $count_total+1;
            $invoice_id="G"."_"."OUT"."_".$shop_id.'_'.$update_count;

            $date = date("Y-m-d", strtotime($request->date));

            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                $product_id = $pid[$key];
                $lot_number = $request->lot_number[$key];
                $variation_id = $request->variation_id[$key];
                $quantity = $request->quantity[$key];
                $row_id = $request->row_id[$key];
                
                $check_product = DB::table('product_stocks')->where(['pid'=>$product_id, 'id'=>$row_id])->first();
                
                
                if(!is_null($check_product)) {
                    $db_stock = $check_product->stock;
                    if($db_stock >= $quantity) {
                        $rest_quantity = '';
                        
                        $exist_check = DB::table('product_stocks')->where(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'branch_id'=>$branch_id, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat])->first();
                        
                        if(!is_null($exist_check)) {
                            $update_quantity = $exist_check->stock + $quantity;
                            DB::table('product_stocks')->where(['id'=>$exist_check->id, 'shop_id'=>$shop_id])->update(['stock'=>$update_quantity]);
                            $rest_quantity = $db_stock - $quantity;
                        }
                        else {
                            $insert = DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'branch_id'=>$branch_id, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'stock'=>$quantity]);
                            
                            $rest_quantity = $db_stock - $quantity;
                        }
                        
                        if($rest_quantity == 0) {
                            DB::table('product_stocks')->where(['id'=>$check_product->id, 'shop_id'=>$shop_id])->delete();
                        }
                        else {
                            DB::table('product_stocks')->where(['id'=>$check_product->id, 'shop_id'=>$shop_id])->update(['stock'=>$rest_quantity]);
                        }
                        
                        $p_data = array();
                        $p_data['shop_id'] = $shop_id;
                        $p_data['purchase_line_id'] = $check_product->purchase_line_id;
                        $p_data['lot_number'] = $check_product->lot_number;
                        $p_data['purchase_price'] = $check_product->purchase_price;
                        $p_data['sales_price'] = $check_product->sales_price;
                        $p_data['variation_id'] = $check_product->variation_id;
                        $p_data['branch_id'] = $branch_id;
                        $p_data['product_id'] = $product_id;
                        $p_data['quantity'] = $quantity;
                        $p_data['price'] = 0;
                        $p_data['discount'] = $check_product->discount;
                        $p_data['discount_amount'] = $check_product->discount_amount;
                        $p_data['vat'] = $check_product->vat;
                        $p_data['total_price'] = 0;
                        $p_data['status'] = 1; // 1 means in // Goudown to branch in
                        $p_data['product_form'] = 'G';
                        $p_data['invoice_id'] = $invoice_id;
                        $p_data['note'] = $request->note;
                        $p_data['created_at'] = $current_time;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                        
                    }
                    
                }
                
            }
            
            $insert = Godown_stock_out_invoice::insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'invoice_id'=>$invoice_id, 'branch_id'=>$branch_id, 'note'=>$request->note, 'date'=>$date, 'created_at'=>$current_time]);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock Out from Godown. Invoice num '.$invoice_id, 'created_at' => $current_time]);
                return Redirect()->route('godown.stock.out.invoices')->with('success', 'Stock Out from Godown Successfully done.');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry something is wrong, please try again.');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Godown_stock_out_invoice  $godown_stock_out_invoice
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_id)
    {
        if(User::checkPermission('godown.stock.out') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'godown';
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $godown_stock_out_invoice_info = Godown_stock_out_invoice::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($godown_stock_out_invoice_info) {
                $pdf = PDF::loadView('cms.shop_admin.godown.stock.godown_stock_out_invoice', compact('shop_info', 'godown_stock_out_invoice_info', 'wing'));
                return $pdf->stream('Godown stock out invoice '.$godown_stock_out_invoice_info->invoice_id);
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Godown_stock_out_invoice  $godown_stock_out_invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Godown_stock_out_invoice $godown_stock_out_invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Godown_stock_out_invoice  $godown_stock_out_invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Godown_stock_out_invoice $godown_stock_out_invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Godown_stock_out_invoice  $godown_stock_out_invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Godown_stock_out_invoice $godown_stock_out_invoice)
    {
        //
    }


    //Begin:: godown stock in out report
    public function godown_stock_in_out_report() {
        if(User::checkPermission('godown.stock.in.out.report') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'godown';
            $products = Product::where('shop_id', $shop_id)->where('active', 1)->select(['id', 'p_name', 'image', 'G_current_stock', 'p_unit_type'])->paginate('1000');
            return view('cms.shop_admin.godown.stock.stock_in_out_reports', compact('products', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: godown stock in out report
    
    
    //Begin:: godown stock in out ledger
    public function godown_stock_in_out_ledger() {
        if(User::checkPermission('godown.stock.in.out.report') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'godown';
            $products = Product::where('shop_id', $shop_id)->select(['id', 'p_name', 'G_current_stock', 'p_brand', 'p_unit_type'])->orderBy('p_name', 'ASC')->paginate(30);
            return view('cms.shop_admin.godown.stock.stock_in_out_ledger', compact('wing', 'products'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function godown_stock_in_out_ledger_data(Request $request) {
        if(User::checkPermission('godown.stock.in.out.report') == true){
            //$date_or_month = $request->date_or_month;
            $action = $request->action;
            $output = '';
            $shop_id = Auth::user()->shop_id;
            $i = 0;
            // date_default_timezone_set("Asia/Dhaka");
            // $business_starting_date = "2010-01-01 00:00:00";
            
            if($action == 'all') { // all godowns report
                
                $products = Product::where('shop_id', $shop_id)->limit(100)->get(['id', 'p_name', 'G_current_stock', 'p_brand', 'p_unit_type']);
                
                $output .= '<div class="row p-2 shadow rounded">
                                <div class="col-md-12">
                                    <h5><b></b></h5>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                              <th>SN.</th>
                                              <th width="25%">Product Info</th>
                                              <th width="25%">Stock In</th>
                                              <th width="25%">Stock Out</th>
                                              <th>Current Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            foreach($products as $product) {
                                                
                                                $unit_type = optional($product->unit_type_name)->unit_name;
                                                
                                                $tracking_summery = DB::table('product_trackers')->where('product_id', $product->id)->Where(function($query) {
                                                                        $query->where('product_form', 'SUPP_TO_G')
                                                                              ->orWhere('product_form', 'G')
                                                                              ->orWhere('product_form', 'DM')
                                                                              ->orWhere('product_form', 'SUPP_R');
                                                                    })->get();
                                                                    
                                                //$total_stock_in = $product_trackers->where('product_form', 'SUPP_TO_G')->count('quantity');
                                                
                                                $stock_in = $tracking_summery->filter(function($item) {
                                                                    return $item->product_form == 'SUPP_TO_G';
                                                                });
                                                $total_stock_in = $stock_in->sum('quantity');
                                                
                                                $direct_stock_out = $tracking_summery->filter(function($item) {
                                                                    return $item->product_form == 'G';
                                                                });
                                                                
                                                $damage_stock_out = $tracking_summery->filter(function($item) {
                                                                    return ($item->product_form == 'DM') && ($item->invoice_id == 'G');
                                                                });
                                                                
                                                $supplier_return_stock_out = $tracking_summery->filter(function($item) {
                                                                    return ($item->product_form == 'SUPP_R') && ($item->branch_id == 'g');
                                                                });
                                                                
                                                $total_direct_stock_out = $direct_stock_out->sum('quantity');
                                                $total_damage_stock_out = $damage_stock_out->sum('quantity');
                                                $total_supplier_return_stock_out = $supplier_return_stock_out->sum('quantity');
                                                
                                                                
                                                
                                                
                                                if($total_stock_in > 0) {
                                                $i++;
                                                $output .= '<tr>
                                                    <td>'.$i.'</td>
                                                    <td><p>'.$product->p_name.'<br><b>Brand:</b> '.optional($product->brand_info)->brand_name.'</p></td>
                                                    <td width="30%" ><span class="text-success"><b>'.$total_stock_in.' '.$unit_type.'</b></span><br>
                                                        <table class="table table-sm ledger_details" style="display: none;">
                                                              <thead>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                  <th>Invoice</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($stock_in as $in) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($in->created_at)).'</td>
                                                                        <td>'.$in->quantity.' '.$unit_type.'</td>
                                                                        <td>'.str_replace('_', '/', $in->invoice_id).'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>
                                                    </td>
                                                    <td width="30%" ><span class="text-danger"><b>'.($total_direct_stock_out + $total_damage_stock_out + $total_supplier_return_stock_out).' '.$unit_type.'</b></span><br><small>Branch Stock out: '.$total_direct_stock_out.'<br>Damage Stock out: '.$total_damage_stock_out.'<br>Supplier Return Stock out: '.$total_supplier_return_stock_out.'</small>';
                                                        if($total_direct_stock_out > 0) {
                                                            $output .= '<table class="table table-sm ledger_details" style="display: none;">
                                                              <thead>
                                                                <tr>
                                                                  <th class="text-center" colspan="3">Stock Out Into Branch</th>
                                                                </tr>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                  <th>Invoice</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($direct_stock_out as $stock_out) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($stock_out->created_at)).'</td>
                                                                        <td>'.$stock_out->quantity.' '.$unit_type.'</td>
                                                                        <td>'.str_replace('_', '/', $stock_out->invoice_id).'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>';
                                                        }
                                                        
                                                        if($total_damage_stock_out > 0) {
                                                            $output .= '<table class="table table-sm ledger_details" style="display: none;">
                                                              <thead>
                                                                <tr>
                                                                  <th class="text-center" colspan="3">Damage Stock Out</th>
                                                                </tr>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($damage_stock_out as $stock_out) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($stock_out->created_at)).'</td>
                                                                        <td>'.$stock_out->quantity.' '.$unit_type.'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>';
                                                        }
                                                        
                                                        if($total_supplier_return_stock_out > 0) {
                                                            $output .= '<table class="table table-sm ledger_details" style="display: none;">
                                                              <thead>
                                                                <tr>
                                                                  <th class="text-center" colspan="3">Supplier Return Stock Out</th>
                                                                </tr>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                  <th>Invoice</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($supplier_return_stock_out as $stock_out) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($stock_out->created_at)).'</td>
                                                                        <td>'.$stock_out->quantity.' '.$unit_type.'</td>
                                                                        <td>'.str_replace('_', '/', $stock_out->invoice_id).'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>';
                                                        }
                                                        
                                                    $output .= '</td>
                                                    
                                                    <td>'.optional($product)->G_current_stock.' '.$unit_type.'</td>
                                                </tr>';
                                                }
                                            }
                                        $output .= '</tbody>
                                    </table>
                                </div>';
                
            }
            else if($action == 'm') { // this is for all Expenses
                //find direct expenses
                $direct_expenses = DB::table('expense_groups')->where('group_name', 'direct expenses')->first(['id']);
                $direct_expense_id = $direct_expenses->id;
                
                //find indirect expenses
                $indirect_expenses = DB::table('expense_groups')->where('group_name', 'indirect expenses')->first(['id']);
                $indirect_expense_id = $indirect_expenses->id;
                $total_direct_expenses = 0;
                
               
                $total_expense = 0;
                
                $ledger_heads = DB::table('ledger__heads')->where('shop_id', $shop_id)->Where(function ($query) use ($direct_expense_id, $indirect_expense_id) {
                                                        $query->where('group_id', $direct_expense_id)
                                                            ->orWhere('group_id', $indirect_expense_id);
                                                    })->get();
                
               
                
                $output .= '<div class="row p-2 shadow rounded">
                                <div class="col-md-12">
                                    <h5><b>All Expenses Ledger</b></h5>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tbody>';
                                            foreach($ledger_heads as $head) {
                                                $group_expense = 0;
                                                $expense_transactions = DB::table('expense_transactions')->where(['ledger_head'=>$head->id, 'shop_id'=> $shop_id])->orderBy('created_at', 'asc')->get(['cash_or_cheque', 'amount', 'created_at', 'voucher_num']);
                                                if($expense_transactions != '[]') {
                                                $output .= '<tr>
                                                    <td><h3>'.$head->head_name.'</h3>
                                                    </td>
                                                    <td width="50%" class="expenses_details" style="display: none none;">
                                                    <table class="table">
                                                          <thead>
                                                            <tr>
                                                              <th>Date</th>
                                                              <th>VOUCHER NUM</th>
                                                              <th>AMOUNT</th>
                                                              <th>Action</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>';
                                                               
                                                                foreach($expense_transactions as $data) {
                                                                    $group_expense = $group_expense + $data->amount;
                                                                    $output .= '<tr>
                                                                      <td>'.date("d-m-Y", strtotime($data->created_at)).'</td>
                                                                      <td>#'.str_replace("_","/", $data->voucher_num).'</td>
                                                                      <td>'.number_format($data->amount, 2).'</td>
                                                                      <td><a target="_blank" href="'.route('admin.account.expenses.voucher.view', ['voucher_num'=>$data->voucher_num]).'" class="btn btn-success btn-rounded btn-sm"><i class="fas fa-eye"></i></a></td>
                                                                    </tr>';
                                                                }
                                                          $output .= '</tbody>
                                                        </table>
                                                       </td>
                                                    <td width="15%">'.number_format($group_expense, 2).'</td>
                                                </tr>';
                                                }
                                                $total_expense = $total_expense + $group_expense;
                                            }
                                        $output .= '</tbody>
                                    </table>
                                    <div class="col-md-12 text-right">
                                    <h5><b>Total Expense = </b>'.number_format($total_expense, 2).'</h5>
                                </div>
                                    
                                </div>';
            }
            
        }
        else {
            $output .= '<h1><b>Sorry You not able to access this data!</b></h1>';
        }
        return Response($output);
    }

    //End:: godown stock in out ledger
    
    
    
    

    //Begin:: godown stock in out summery of individual product
    public function godown_stock_in_out_summery_of_individual_product($pid) {
        if(User::checkPermission('godown.stock.in.out.report') == true){
            $shop_id = Auth::user()->shop_id;
            $product_info = Product::where('id', $pid)->where('shop_id', $shop_id)->first(['p_name', 'p_unit_type', 'image', 'id']);
            if(!is_null($product_info)) {
                $wing = 'godown';
                return view('cms.shop_admin.godown.stock.godown_product_stock_in_out_summery', compact('wing', 'product_info'));
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function godown_product_stock_in_out_summery_data(Request $request) {
        if(User::checkPermission('godown.stock.in.out.report') == true){
            //$date_or_month = $request->date_or_month;
            $action = $request->action;
            $output = '';
            $product_id = $request->product_id;
            $shop_id = Auth::user()->shop_id;
            $i = 0;
            // date_default_timezone_set("Asia/Dhaka");
            // $business_starting_date = "2010-01-01 00:00:00";
            
            if($action == 'all') { // all godowns report
                
                $product = Product::where('id', $product_id)->first(['id', 'p_name', 'G_current_stock', 'p_brand', 'p_unit_type']);
                $unit_type = optional($product->unit_type_name)->unit_name;
                                                
                $tracking_summery = DB::table('product_trackers')->where('product_id', $product->id)->Where(function($query) {
                                        $query->where('product_form', 'SUPP_TO_G')
                                              ->orWhere('product_form', 'G')
                                              ->orWhere('product_form', 'DM')
                                              ->orWhere('product_form', 'SUPP_R');
                                    })->get();
                                    
                //$total_stock_in = $product_trackers->where('product_form', 'SUPP_TO_G')->count('quantity');
                
                $stock_in = $tracking_summery->filter(function($item) {
                                    return $item->product_form == 'SUPP_TO_G';
                                });
                $total_stock_in = $stock_in->sum('quantity');
                
                $direct_stock_out = $tracking_summery->filter(function($item) {
                                    return $item->product_form == 'G';
                                });
                                
                $damage_stock_out = $tracking_summery->filter(function($item) {
                                    return ($item->product_form == 'DM') && ($item->invoice_id == 'G');
                                });
                                
                $supplier_return_stock_out = $tracking_summery->filter(function($item) {
                                    return ($item->product_form == 'SUPP_R') && ($item->branch_id == 'g');
                                });
                                
                $total_direct_stock_out = $direct_stock_out->sum('quantity');
                $total_damage_stock_out = $damage_stock_out->sum('quantity');
                $total_supplier_return_stock_out = $supplier_return_stock_out->sum('quantity');
                
                                
                
                
                $output .= '<div class="row p-2 shadow rounded">
                                <div class="col-md-4">
                                    <h5><b>Total Stock In:</b> '.$total_stock_in.' '.$unit_type.'</h5>
                                </div>
                                <div class="col-md-4">
                                    <b>Total Stock Out:</b> '.($total_direct_stock_out + $total_damage_stock_out + $total_supplier_return_stock_out).' '.$unit_type.'
                                    <br><small class="text-success border rounded p-1">Branch Stock out: '.$total_direct_stock_out.' '.$unit_type.'<br>Damage Stock out: '.$total_damage_stock_out.' '.$unit_type.'<br>Supplier Return Stock out: '.$total_supplier_return_stock_out.' '.$unit_type.'</small>
                                </div>
                                <div class="col-md-4">
                                    <h5><b>Current Stock:</b> '.$product->G_current_stock.' '.$unit_type.'</h5>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead class="text-center">
                                            <tr>
                                              <th width="50%">Stock In Summery</th>
                                              <th width="50%">Stock Out Summery</th>
                                            </tr>
                                        </thead>
                                        <tbody>';
                                            
                                                if($total_stock_in > 0) {
                                                $i++;
                                                $output .= '<tr>
                                                    <td width="50%" >
                                                        <table class="table table-sm ledger_details">
                                                              <thead>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                  <th>Invoice</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($stock_in as $in) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($in->created_at)).'</td>
                                                                        <td>'.$in->quantity.' '.$unit_type.'</td>
                                                                        <td>'.str_replace('_', '/', $in->invoice_id).'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>
                                                    </td>
                                                    <td width="50%" ><span class="text-danger">';
                                                        if($total_direct_stock_out > 0) {
                                                            $output .= '<table class="table table-sm ledger_details">
                                                              <thead>
                                                                <tr>
                                                                  <th class="text-center" colspan="3">Stock Out Into Branch</th>
                                                                </tr>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                  <th>Invoice</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($direct_stock_out as $stock_out) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($stock_out->created_at)).'</td>
                                                                        <td>'.$stock_out->quantity.' '.$unit_type.'</td>
                                                                        <td>'.str_replace('_', '/', $stock_out->invoice_id).'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>';
                                                        }
                                                        
                                                        if($total_damage_stock_out > 0) {
                                                            $output .= '<table class="table table-sm ledger_details">
                                                              <thead>
                                                                <tr>
                                                                  <th class="text-center" colspan="3">Damage Stock Out</th>
                                                                </tr>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($damage_stock_out as $stock_out) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($stock_out->created_at)).'</td>
                                                                        <td>'.$stock_out->quantity.' '.$unit_type.'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>';
                                                        }
                                                        
                                                        if($total_supplier_return_stock_out > 0) {
                                                            $output .= '<table class="table table-sm ledger_details">
                                                              <thead>
                                                                <tr>
                                                                  <th class="text-center" colspan="3">Supplier Return Stock Out</th>
                                                                </tr>
                                                                <tr>
                                                                  <th>Date</th>
                                                                  <th>Qty</th>
                                                                  <th>Invoice</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>';
                                                              foreach($supplier_return_stock_out as $stock_out) {
                                                                 $output .= '<tr>
                                                                        <td>'.date('d-m-Y', strtotime($stock_out->created_at)).'</td>
                                                                        <td>'.$stock_out->quantity.' '.$unit_type.'</td>
                                                                        <td>'.str_replace('_', '/', $stock_out->invoice_id).'</td>
                                                                 </tr>';
                                                              }
                                                              $output .= '</tbody>
                                                        </table>';
                                                        }
                                                        
                                                    $output .= '</td>
                                                </tr>';
                                                }
                                                else {
                                                    $output .= '<tr><td colspan="2" class="text-center"><h1>No Data Found!</h1></td></tr>';
                                                }
                                        $output .= '</tbody>
                                    </table>
                                </div>';
                
            }
            else if($action == 'm') { // this is for all Expenses
                //find direct expenses
                $direct_expenses = DB::table('expense_groups')->where('group_name', 'direct expenses')->first(['id']);
                $direct_expense_id = $direct_expenses->id;
                
                //find indirect expenses
                $indirect_expenses = DB::table('expense_groups')->where('group_name', 'indirect expenses')->first(['id']);
                $indirect_expense_id = $indirect_expenses->id;
                $total_direct_expenses = 0;
                
               
                $total_expense = 0;
                
                $ledger_heads = DB::table('ledger__heads')->where('shop_id', $shop_id)->Where(function ($query) use ($direct_expense_id, $indirect_expense_id) {
                                                        $query->where('group_id', $direct_expense_id)
                                                            ->orWhere('group_id', $indirect_expense_id);
                                                    })->get();
                
               
                
                $output .= '<div class="row p-2 shadow rounded">
                                <div class="col-md-12">
                                    <h5><b>All Expenses Ledger</b></h5>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tbody>';
                                            foreach($ledger_heads as $head) {
                                                $group_expense = 0;
                                                $expense_transactions = DB::table('expense_transactions')->where(['ledger_head'=>$head->id, 'shop_id'=> $shop_id])->orderBy('created_at', 'asc')->get(['cash_or_cheque', 'amount', 'created_at', 'voucher_num']);
                                                if($expense_transactions != '[]') {
                                                $output .= '<tr>
                                                    <td><h3>'.$head->head_name.'</h3>
                                                    </td>
                                                    <td width="50%" class="expenses_details" style="display: none none;">
                                                    <table class="table">
                                                          <thead>
                                                            <tr>
                                                              <th>Date</th>
                                                              <th>VOUCHER NUM</th>
                                                              <th>AMOUNT</th>
                                                              <th>Action</th>
                                                            </tr>
                                                          </thead>
                                                          <tbody>';
                                                               
                                                                foreach($expense_transactions as $data) {
                                                                    $group_expense = $group_expense + $data->amount;
                                                                    $output .= '<tr>
                                                                      <td>'.date("d-m-Y", strtotime($data->created_at)).'</td>
                                                                      <td>#'.str_replace("_","/", $data->voucher_num).'</td>
                                                                      <td>'.number_format($data->amount, 2).'</td>
                                                                      <td><a target="_blank" href="'.route('admin.account.expenses.voucher.view', ['voucher_num'=>$data->voucher_num]).'" class="btn btn-success btn-rounded btn-sm"><i class="fas fa-eye"></i></a></td>
                                                                    </tr>';
                                                                }
                                                          $output .= '</tbody>
                                                        </table>
                                                       </td>
                                                    <td width="15%">'.number_format($group_expense, 2).'</td>
                                                </tr>';
                                                }
                                                $total_expense = $total_expense + $group_expense;
                                            }
                                        $output .= '</tbody>
                                    </table>
                                    <div class="col-md-12 text-right">
                                    <h5><b>Total Expense = </b>'.number_format($total_expense, 2).'</h5>
                                </div>
                                    
                                </div>';
            }
            
        }
        else {
            $output .= '<h1><b>Sorry You not able to access this data!</b></h1>';
        }
        return Response($output);
    }
    
    
    //End:: godown stock in out summery of individual product

    

    
}
