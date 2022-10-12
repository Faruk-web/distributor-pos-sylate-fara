<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_return_porduct;
use App\Models\Ordered_product;
use App\Models\Return_order;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Purchase_lines;
use App\Models\Area;
use App\Models\SRStocks;
use App\Models\Customer;
use PDF;


class ReturnOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            $wing = 'main';

            $all_area = Area::where(['shop_id'=>Auth::user()->shop_id])->get();
            $all_sr = User::Where(['active'=> 1, 'type'=>'SR'])->orderBy('name', 'ASC')->get();
            return view('cms.branch.sell.return_customer_product', compact('wing', 'all_sr', 'all_area'));
            //return view('cms.branch.sell.all_invoice_for_return', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function ajax_search(Request $request) {
        if ($request->ajax()) {
            
            $branch_id = Auth::user()->branch_id;
            if(!empty($branch_id)) {
                $orders = Order::where(['branch_id'=>$branch_id,'shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['invoice_id', 'customer_id', 'date']);
            }
            else {
                $orders = Order::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['invoice_id', 'customer_id', 'date']);
            }
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-primary btn-sm">Invoice</a> <a href="'.route('branch.return.invoice.product.new', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-danger btn-sm">Return</a>';
                    return $actionBtn;
                })
                ->addColumn('customer_name', function($row){
                    return optional($row->customer_info)->name." [".optional($row->customer_info)->phone."]";
                })
                ->addColumn('invoice_num', function($row){
                    return "#".str_replace("_","/", $row->invoice_id);
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->rawColumns(['action', 'customer_name'])
                ->make(true);
        }
    }

    //Begin:: search customer for sell
    public function search_customer(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $customer_info = $request->get('customer_info');
        $area = $request->get('search_custoemr_area');
        
          $customers = Customer::where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($customer_info) {
                    $query->where('phone', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('code', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $customer_info. '%');
                });
                
                if($area != 'all') {
                  $customers = $customers->where('area_id', $area);
                }
                $customers = $customers->limit(5);
                $customers = $customers->get(['name', 'phone', 'code', 'area_id', 'id']);
                
          if(!empty($customer_info)) {
              if(count($customers) > 0) {
                foreach ($customers as $customer) {
                    $output.='<tr>'.
                        '<td>'.$customer->name.'</td>'.
                        '<td>'.$customer->phone.'</td>'.
                        '<td>'.optional($customer->area_info)->name.'</td>'.
                        '<td><button type="button" onclick="select_customer(\''.optional($customer)->id.'\', \''.optional($customer)->name.'\', \''.optional($customer)->phone.'\', \''.optional($customer->area_info)->name.'\')" class="btn bg-success rounded-pill p-2 text-light">Select</button></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h4 class="fw-bold text-danger">No Customer Found!!!</h4></td></tr>';
            }
            
        }

        return Response($output);
    }

    public function products_search_by_title_in_customer_return(Request $request) {
        $title = $request->title;
        $customer_id = $request->customer_id;
        $shop_id = Auth::user()->shop_id;
        $output = '';

        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_trackers', function($join)
                        {
                            $join->on('products.id', '=', 'product_trackers.product_id');
                        })
                    ->where(['product_trackers.supplier_id'=>$customer_id, 'product_trackers.shop_id'=>$shop_id, 'product_trackers.product_form'=>'S'])
                    ->select('products.p_name', 'products.p_brand', 'product_trackers.*', 'products.p_unit_type');
                    $products = $products->where('products.p_name', "like", "%".$title."%");
                    $products = $products->orderBy('id', 'DESC');
                    $products = $products->paginate(50);
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    $cartoon_info = '';
                    $variation_name = '';
                    $variation_title = '';
                    if($product->cartoon_amount > 0) {
                        $cartoon_info = $product->cartoon_amount." Cartoon";
                    }
                    if($product->variation_id != 0 && $product->variation_id != '') {
                        $variation_info = DB::table('product_variations')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  '<span class="text-primary">('.optional($variation_info)->title.')</span>';
                        $variation_title = optional($variation_info)->title;
                    }
                    $unit_type_info = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product_text" onclick="myFunction(\''.$product->id.'\', \''.$product->product_id.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->quantity.'\', \''.optional($unit_type_info)->unit_name.'\', \''.optional($product)->is_cartoon.'\', \''.optional($product)->cartoon_quantity.'\', \''.optional($product)->cartoon_amount.'\', \''.str_replace("_","/", $product->invoice_id).'\')" title="Add me">
                        <h6 class="text-success">'.$product->p_name.' '.$variation_name.'</h6>
                        <span><b>Brand:</b> '.optional($brand_info)->brand_name.', <b>Lot Number:</b> '.$product->lot_number.', <b>Sales Price:</b> '.$product->sales_price.', <b>Discount:</b> '.$product->discount.'('.$product->discount_amount.'), <b>VAT:</b> '.$product->vat.'%</span>
                        <br><span class="text-danger"><b>Sold Unit:</b> '.$product->quantity.' '.optional($unit_type_info)->unit_name.', '.$cartoon_info.'</span>
                        <br><span class="text-primary"><b>Invoice # </b>'.str_replace("_","/", $product->invoice_id).'</span>
                        
                    </li>';
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        return response()->json($output);

    }

    public function returned_product_invoices()
    {
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            $wing = 'main';
            return view('cms.branch.sell.all_returned_invoices', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function returned_product_invoices_data(Request $request) {
        if ($request->ajax()) {
            $branch_id = Auth::user()->branch_id;
            if(!empty($branch_id)) {
                $returned_invoices = Return_order::where(['branch_id'=>Auth::user()->branch_id])->orderBy('id', 'desc')->get();
            }
            else {
                $returned_invoices = Return_order::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            }
            
            return Datatables::of($returned_invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-primary btn-sm">Main Inv</a> <a target="_blank" href="'.route('view.product.returned.invoice', ['invoice_id'=>$row->invoice_id, 'current_return_times'=>$row->return_current_times]).'" class="btn btn-info btn-sm">R Inv</a>';
                    return $actionBtn;
                })
                ->addColumn('customer_name', function($row){
                    $actionBtn = $row->customer_info->name." [".$row->customer_info->code."]";
                    return $actionBtn;
                })
                ->addColumn('customer_phone', function($row){
                    $actionBtn = $row->customer_info->phone;
                    return $actionBtn;
                })
                ->addColumn('invoice_num', function($row){
                    return "#".str_replace("_","/", $row->invoice_id);
                })
                ->addColumn('date', function($row){
                    $info = date("d M, Y", strtotime($row->date));
                    return $info;
                })
                ->rawColumns(['action', 'customer_name', 'customer_phone'])
                ->make(true);
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\return_order  $return_order
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_id, $current_return_times)
    {
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            $shop_id = Auth::user()->shop_id;
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $invoice_info = Return_order::where('invoice_id', $invoice_id)->where('return_current_times', $current_return_times)->first();
            if($invoice_info) {
                $products = Order_return_porduct::where(['invoice_id'=>$invoice_id, 'how_many_times_edited'=>$current_return_times])->get();
                $pdf = PDF::loadView('cms.branch.sell.view_product_returned_invoice', compact('shop_info', 'invoice_info', 'products'));
                return $pdf->stream('Customer Returned Invoice'.$invoice_info->invoice_id);
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\return_order  $return_order
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice_id)
    {
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            return 'This is old version.';
            $shop_id = Auth::user()->shop_id;
            $wing = 'main';
            $invoice = Order::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($invoice) {
                $branch_id = Auth::user()->branch_id;
                if(empty($branch_id)) {
                    $branch_id = Auth::user()->shop_info->default_branch_id_for_sell;
                    if(empty($branch_id)) {
                        return Redirect()->back()->with('error', 'Set Default Branch from Shop Settings.');
                    }
                }
                $how_many_time_returns = DB::table('return_orders')->where('invoice_id', $invoice_id)->count('id');
                return view('cms.branch.sell.return_invoice_product', compact('invoice', 'how_many_time_returns', 'wing', 'branch_id'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function edit_new($invoice_id)
    {
        
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'main';
            $invoice = Order::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($invoice) {
                /*
                $branch_id = Auth::user()->branch_id;
                if(empty($branch_id)) {
                    $branch_id = Auth::user()->shop_info->default_branch_id_for_sell;

                    if(empty($branch_id)) {
                        return Redirect()->back()->with('error', 'Set Default Branch from Shop Settings.');
                    }
                }
                */
                $how_many_time_returns = DB::table('return_orders')->where('invoice_id', $invoice_id)->count('id');
                return view('cms.branch.sell.return_invoice_product_new', compact('invoice', 'how_many_time_returns', 'wing'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function beanch_exchange_status_new(Request $request) {
        $output = '';
        $pid = $request->pid;
        $variation_id = $request->variation_id;
        
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell;
        }

        $stock_info = DB::table('product_stocks')->where(['branch_id'=>$branch_id, 'pid'=>$pid, 'variation_id'=>$variation_id])->sum('stock');
        if($stock_info > 0) {
            $output = [
                    'status'=>'yes',
                    'stock'=>$stock_info,
                ];
        }
        else {
            $output = [
                    'status'=>'no',
                ];
        }
        
        return Response($output);
    }
    
    
    
    
    public function beanch_exchange_status(Request $request) {
        $output = '';
        $pid = $request->pid;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell;
        }
        $stock_info = DB::table('product_stocks')->where(['branch_id'=>$branch_id, 'pid'=>$pid])->first(['stock']);
        if($stock_info->stock > 0) {
            $output = [
                    'status'=>'yes',
                    'stock'=>$stock_info->stock,
                ];
        }
        else {
            $output = [
                    'status'=>'no',
                ];
        }
        
        return Response($output);
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\return_order  $return_order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return "This is old Returning System, Please use new Returning System.";
        
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            if($request->pid != '') {
                $shop_id = Auth::user()->shop_id;
                $pid = $request->pid;
                $return_or_exchange = $request->return_or_exchange;
                
                $branch_id = Auth::user()->branch_id;
                
                if(empty($branch_id)) {
                    $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
                }
                $customer_id = $request->customer_id;
                $invoice_id = $request->invoice_id;
                $validated = $request->validate([
                    'invoice_id' => 'required',
                    'customer_id' => 'required',
                    'paid' => 'required',
                ]);
                $how_many_time_returns = DB::table('return_orders')->where('invoice_id', $invoice_id)->count('id');
                $update_count = $how_many_time_returns+1;
                $current_time = Carbon::now();

                foreach($pid as $key => $item) {
                    $return_or_exchange_info = explode(",", $return_or_exchange[$key]);
                    $what_to_do = $return_or_exchange_info[0];
                    
                    $unit = $request->quantity[$key];
                    $price = $request->price[$key];
                    $total = $request->total[$key];
                    $discount_percent = $request->disCP[$key];
                    $flat_discount = $request->disC_flat[$key];
                    $vat = $request->individual_product_vat[$key];
                    
                    //$previous_returned = DB::table('order_return_porducts')->where('product_id', $product->product_info->id)->where('invoice_id', $invoice->invoice_id)->sum('quantity');
                    //$rest_quantity = $product->quantity-$previous_returned;
                    
                    $p_data = array();
                    
                    $p_data['branch_id'] = $branch_id;
                    $p_data['product_id'] = $pid[$key];
                    $p_data['quantity'] = $unit;
                    $p_data['price'] = $price;
                    $p_data['total_price'] = $total;
                    $p_data['status'] = 1; // 1 means in
                    $p_data['product_form'] = 'R'; // R means return
                    $p_data['invoice_id'] = $invoice_id;
                    $p_data['note'] = $request->note;
                    $p_data['created_at'] = $current_time;
                    $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                    
                    if($insert_product_trackers) {
                        $product_exist_quantity_check = DB::table('product_stocks')->where('pid', $pid[$key])->where('branch_id', $branch_id)->first(['stock']);
                        $current_quantity = $product_exist_quantity_check->stock;
                        $updateable_quantity = $current_quantity + $unit;
                        
                        DB::table('product_stocks')->where('pid', $pid[$key])->where('branch_id', $branch_id)->update(['stock' => $updateable_quantity]);
                        DB::table('order_return_porducts')->insert(['invoice_id'=>$invoice_id, 'how_many_times_edited'=>$update_count, 'product_id'=>$pid[$key], 'quantity'=>$unit, 'price'=>$price, 'discount'=>$discount_percent, 'discount_amount'=>$flat_discount, 'vat'=>$vat, 'total_price'=>$total, 'created_at'=>$current_time, 'updated_at'=>$what_to_do]);
                    }
                }

                if(!empty($request->discount_Tk)) {
                    $global_discount = 'tk';
                    $global_discount_rate = $request->discount_tk_price;
                }
                else if(!empty($request->discount_Percent)) {
                    $global_discount = 'percent';
                    $global_discount_rate = $request->discount_Percent;
                }
                else {
                    $global_discount = 'no';
                    $global_discount_rate = 0;
                }
                $customer_info = DB::table('customers')->where('id', $customer_id)->where('shop_id', $shop_id)->first(['balance']);
                $current_due = $customer_info->balance + 0;
                $total_payable_with_customer_due = $current_due - $request->total_payable;
                $customer_current_due = $request->paid + $total_payable_with_customer_due;
                

                $return_customer = DB::table('return_orders')->insert(['shop_id'=>$shop_id, 'branch_id'=>$branch_id, 'invoice_id'=>$invoice_id, 'return_current_times'=>$update_count, 'customer_id'=>$customer_id, 'total_gross'=>$request->subtotal, 'vat_status'=>$request->vat, 'discount_status'=>$global_discount, 'discount_rate'=>$global_discount_rate,  'others_crg'=>$request->only_others_crg_tk,  'fine'=>$request->extra_fine_tk,  'refundAbleAmount'=>$request->total_payable,  'currentDue'=>$current_due,  'paid'=>$request->paid, 'date'=>$current_time, 'created_at'=>$current_time]);
                if($return_customer) {
                    $current_balance = $current_due;
                    $update_balance = $customer_current_due;
                    if($request->paid > 0) {
                        DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'branch_id'=>Auth::user()->branch_id, 'added_by'=>Auth::user()->id, 'for_what'=>'CPR', 'track'=>$customer_id, 'refference'=>$invoice_id, 'amount'=>$request->paid, 'creadit_or_debit'=>'DR', 'note'=>'Customer Product Return. Invoice Num. #'.str_replace("_","/", $invoice_id).'', 'created_at'=>Carbon::now()]);
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance - $request->paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        DB::table('cash_flows')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'branch_id'=>$branch_id, 'account'=>'cash', 'credit_or_debit'=>'DR', 'description'=>'Customer return products, Invoice num '.$invoice_id.' Current Returnable times '.$update_count.'', 'balance'=>$request->paid, 'created_at'=>$current_time]);
                    }
                    DB::table('customers')->where('id', $customer_id)->where('shop_id', $shop_id)->update(['balance'=>$update_balance]);
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Customer Return Product. Invoice num #'.str_replace("_","/", $invoice_id).' Current Returnable times '.$update_count.'', 'created_at' => $current_time]);
                    return Redirect()->route('view.product.returned.invoice', ['invoice_id'=>$invoice_id, 'current_return_times'=>$update_count])->with('success', 'Product Return Successfully done.');
            
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, Please try again.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Sorry has no product to return.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function update_new(Request $request)
    {
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            
            if($request->pid != '') {
                $shop_id = Auth::user()->shop_id;
                
                $pid = $request->pid;
                $return_or_exchange = $request->return_or_exchange;
                
                $branch_id = Auth::user()->branch_id;
                
                if(empty($branch_id)) {
                    $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
                }
                
                $customer_id = $request->customer_id;
                $invoice_id = $request->invoice_id;
                $invoice_info = DB::table('orders')->where(['invoice_id'=>$invoice_id, 'shop_id'=>$shop_id])->first(['branch_id', 'customer_id', 'vat', 'discount_status', 'discount_rate']);
                
                $validated = $request->validate([
                    'invoice_id' => 'required',
                    'customer_id' => 'required',
                    'paid' => 'required',
                ]);
                
                $how_many_time_returns = DB::table('return_orders')->where('invoice_id', $invoice_id)->count('id');
                $update_count = $how_many_time_returns+1;
                $current_time = Carbon::now();
                
                $total_gross = 0;

                foreach($pid as $key => $item) {
                    $sum = 0;
                    $return_or_exchange = $request->return_or_exchange[$key];
                    $what_to_do = $return_or_exchange;
                    $product_id = $pid[$key];
                    $variation_id = $request->variation_id[$key];
                    $unit = $request->quantity[$key];
                    $price = $request->price[$key];
                    $total = $request->total[$key];
                    $discount_percent = $request->disCP[$key];
                    $flat_discount = $request->disC_flat[$key];
                    
                    $ordered_product_id = $request->ordered_product_id[$key];
                    $discount_amount = $request->discount_amount[$key];
                    $vat = $request->individual_product_vat[$key];
                    
                    $ordered_product_info = DB::table('ordered_products')->where(['product_id'=>$product_id, 'invoice_id'=>$invoice_id, 'id'=>$ordered_product_id])->first();
                    
                    $previous_returned = DB::table('order_return_porducts')->where(['product_id'=>$product_id, 'invoice_id'=>$invoice_id, 'variation_id'=>$ordered_product_info->variation_id, 'price'=>$ordered_product_info->price, 'discount'=>$ordered_product_info->discount, 'discount_amount'=>$ordered_product_info->discount_amount, 'vat'=>$ordered_product_info->vat_amount])->sum('quantity');
                    
                    $rest_quantity = optional($ordered_product_info)->quantity - $previous_returned;
                    
                    if($rest_quantity > 0) {
                        
                        if($return_or_exchange == 'r') {
                            $price = $ordered_product_info->price;
                            
                            $trackers_info = DB::table('product_trackers')->where(['product_id'=>$product_id, 'variation_id'=>$ordered_product_info->variation_id, 'invoice_id'=>$invoice_id, 'product_form'=>'S'])->get();
                            
                                if(count($trackers_info) > 0) {
                                    
                                    $sold_unit = $unit;
                                    $total_count = 0;
                                    
                                    foreach($trackers_info as $item_t) {
                                        
                                        $check = DB::table('product_trackers')->where(['shop_id'=>$shop_id, 'product_id'=>$item_t->product_id, 'variation_id'=>$item_t->variation_id, 'purchase_line_id'=>$item_t->purchase_line_id, 'lot_number'=>$item_t->lot_number, 'product_form'=>'R', 'invoice_id'=>$item_t->invoice_id])->sum('quantity');
                                        
                                        $db_minus_unit = 0;
                                        $db_stock = $item_t->quantity - $check;
                                        
                                        if($sold_unit != 0 && $db_stock > 0) {
                                            
                                            if($sold_unit >= $db_stock) {
                                               $sold_unit = $sold_unit - $db_stock;
                                               $db_minus_unit = $db_stock;
                                            }
                                            else if($db_stock >= $sold_unit) {
                                              $db_minus_unit = $sold_unit;
                                              $sold_unit = $sold_unit - $sold_unit;
                                            }
                                           
                                               $total_count = $total_count + $db_minus_unit;
                                               $sum_for_item = $db_minus_unit * $item_t->sales_price;
                                               
                                               
                                               if($item_t->discount == 'flat') {
                                                   $t_discount = $item_t->discount_amount * $db_minus_unit;
                                                   $total_price = $sum_for_item - $t_discount;
                                                   $discount_in_tk = $t_discount;
                                               }
                                               else if($item_t->discount == 'percent') {
                                                   $discountParcent_amount_tk = ($item_t->discount_amount * $sum_for_item)/100;
                                                   
                                                   $total_price = $sum_for_item - $discountParcent_amount_tk;
                                                  
                                                   $discount_in_tk = $discountParcent_amount_tk;
                                               }
                                               else {
                                                   $total_price = $sum_for_item;
                                                   $discount_in_tk = 0;
                                               }
                                               
                                               if($item_t->vat > 0) {
                                                  $vat_price = $total_price * $item_t->vat / 100;
                                               }
                                               else {
                                                   $vat_price = 0;
                                               }
                                               
                                               $total_price = $total_price + $vat_price;
                                               
                                               
                                               if($invoice_info->branch_id == $branch_id) {
                                                   
                                                   $product_stocks_check = DB::table('product_stocks')->where(['shop_id'=>$shop_id, 'purchase_line_id'=>$item_t->purchase_line_id, 'lot_number'=>$item_t->lot_number, 'branch_id'=>$branch_id, 'pid'=>$product_id, 'variation_id'=>$item_t->variation_id])->first();
                                                   
                                                   if(!is_null($product_stocks_check)) {
                                                       $current_stock_item = optional($product_stocks_check)->stock;
                                                       $update_stock_item = $current_stock_item + $db_minus_unit;
                                                       DB::table('product_stocks')->where(['shop_id'=>$shop_id, 'id'=>$product_stocks_check->id])->update(['stock'=>$update_stock_item]);
                                                   }
                                                   else {
                                                       DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$item_t->purchase_line_id, 'lot_number'=>$item_t->lot_number, 'branch_id'=>$branch_id, 'pid'=>$product_id, 'variation_id'=>$item_t->variation_id, 'purchase_price'=>$item_t->purchase_price, 'sales_price'=>$item_t->sales_price, 'discount'=>$item_t->discount, 'discount_amount'=>$item_t->discount_amount, 'vat'=>$item_t->vat, 'stock'=>$db_minus_unit, 'created_at'=>$current_time]);
                                                   }
                                                   
                                               }
                                               else {
                                                    $branch_info = DB::table('branch_settings')->where(['id'=>$invoice_info->branch_id, 'shop_id'=>$shop_id])->first(['branch_name', 'branch_address']);
                                                    $note = "This Lot is returned from ".optional($branch_info)->branch_name.", [ ".optional($branch_info)->branch_address." ]";
                                                    $purchase_line_count = Purchase_lines::where(['shop_id'=>$shop_id, 'product_id'=>$product_id])->count('id');
                                                    $lot_number = $purchase_line_count + 1;
                                                    
                                                    $purchase_line = new Purchase_lines;
                                                    $purchase_line->shop_id = $shop_id;
                                                    $purchase_line->branch_id = $branch_id;
                                                    $purchase_line->invoice_id = $invoice_id;
                                                    $purchase_line->product_id = $product_id;
                                                    $purchase_line->purchase_price = $item_t->purchase_price;
                                                    $purchase_line->sales_price = $item_t->sales_price;
                                                    $purchase_line->discount = $item_t->discount;
                                                    $purchase_line->discount_amount = $item_t->discount_amount;
                                                    $purchase_line->vat = $item_t->vat;
                                                    $purchase_line->lot_number = $lot_number;
                                                    $purchase_line->variation_id = $item_t->variation_id;
                                                    $purchase_line->quantity = $db_minus_unit;
                                                    $purchase_line->date = $current_time;
                                                    $purchase_line->note = $note;
                                                    $purchase_line->created_at = $current_time;
                                                    $purchase_line->save();
                                                    
                                                    $purchase_line_id = $purchase_line->id;
                                                    
                                                    DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$purchase_line_id, 'lot_number'=>$lot_number, 'branch_id'=>$branch_id, 'pid'=>$product_id, 'variation_id'=>$item_t->variation_id, 'purchase_price'=>$item_t->purchase_price, 'sales_price'=>$item_t->sales_price, 'discount'=>$item_t->discount, 'discount_amount'=>$item_t->discount_amount, 'vat'=>$item_t->vat, 'stock'=>$db_minus_unit, 'created_at'=>$current_time]);
                                    
                                                    $p_data = array();
                                                    $p_data['shop_id'] = $shop_id;
                                                    $p_data['lot_number'] = $lot_number;
                                                    $p_data['purchase_line_id'] = $purchase_line_id;
                                                    $p_data['purchase_price'] = $item_t->purchase_price;
                                                    $p_data['sales_price'] = $item_t->sales_price;
                                                    $p_data['variation_id'] = $item_t->variation_id;
                                                    $p_data['product_id'] = $product_id;
                                                    $p_data['quantity'] = $db_minus_unit;
                                                    $p_data['price'] = $item_t->purchase_price;
                                                    $p_data['discount'] = $item_t->discount;
                                                    $p_data['discount_amount'] = $item_t->discount_amount;
                                                    $p_data['vat'] = $item_t->vat;
                                                    $p_data['total_price'] = $total_price;
                                                    $p_data['status'] = 1; // 1 means in
                                                    $p_data['product_form'] = 'BRTB';
                                                    $p_data['branch_id'] = $branch_id;
                                                    $p_data['invoice_id'] = $invoice_id;
                                                    $p_data['note'] = $note;
                                                    $p_data['created_at'] = $current_time;
                                                    $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                                                    
                                               }
                                               
                                               DB::table('product_trackers')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$item_t->purchase_line_id, 'lot_number'=>$item_t->lot_number, 'purchase_price'=>$item_t->purchase_price, 'sales_price'=>$price, 'variation_id'=>$item_t->variation_id, 'branch_id'=>$branch_id, 'product_id'=>$product_id, 'quantity'=>$db_minus_unit, 'price'=>$price, 'discount'=>$item_t->discount, 'discount_amount'=>$item_t->discount_amount, 'discount_in_tk'=>$discount_in_tk, 'vat'=>$item_t->vat, 'vat_in_tk'=>$vat_price, 'total_price'=>$total_price, 'status'=>1, 'product_form'=>'R', 'invoice_id'=>$invoice_id, 'created_at'=>$current_time]);
                                           
                                        }
                                    }
                                    
                                    
                                    $sum = $total_count * $price;
                                    
                                
                                    if(optional($ordered_product_info)->discount == 'flat' || optional($ordered_product_info)->discount == 'tk') {
                                        $sum = $sum - (optional($ordered_product_info)->discount_amount * $unit);
                                    }
                                    else if(optional($ordered_product_info)->discount == 'percent') {
                                        $discountParcent_amount_tk = (optional($ordered_product_info)->discount_amount * $sum)/100;
                                        $sum = $sum - $discountParcent_amount_tk;
                                    }
                                    
                                    if(optional($ordered_product_info)->vat_amount > 0) {
                                        $vat_tk = $sum * optional($ordered_product_info)->vat_amount / 100;
                                        $sum = $sum + $vat_tk;
                                    }
                                
                                    $total_gross = $total_gross + $sum;
                                    
                                    DB::table('order_return_porducts')->insert(['invoice_id'=>$invoice_id, 'return_or_exchange'=>'r', 'how_many_times_edited'=>$update_count, 'product_id'=>$product_id, 'variation_id'=>$ordered_product_info->variation_id, 'quantity'=>$total_count, 'price'=>$price, 'discount'=>$ordered_product_info->discount, 'discount_amount'=>$ordered_product_info->discount_amount, 'vat'=>$ordered_product_info->vat_amount, 'total_price'=>$sum, 'created_at'=>$current_time]);
                                    
                                }
                              
                        }
                        else if($return_or_exchange == 'e') {
                            DB::table('order_return_porducts')->insert(['invoice_id'=>$invoice_id, 'return_or_exchange'=>'e', 'how_many_times_edited'=>$update_count, 'product_id'=>$product_id, 'variation_id'=>$ordered_product_info->variation_id, 'quantity'=>$unit, 'price'=>$price, 'discount'=>$ordered_product_info->discount, 'discount_amount'=>$ordered_product_info->discount_amount, 'vat'=>$ordered_product_info->vat_amount, 'total_price'=>0, 'created_at'=>$current_time]);
                        }
                    }
                }
                
                
                $customer_info = DB::table('customers')->where('id', $customer_id)->where('shop_id', $shop_id)->first(['balance', 'code', 'id', 'wallet_balance', 'wallets']);
                $total_payable = $total_gross;
                
                if(!empty($request->discount_Tk)) {
                    $global_discount = 'tk';
                    $global_discount_rate = $request->discount_tk_price;
                    $total_payable = $total_payable - $global_discount_rate;
                }
                else if(!empty($request->discount_Percent)) {
                    $global_discount = 'percent';
                    $global_discount_rate = $request->discount_Percent;
                    $discountParcentTk = ($global_discount_rate * $total_payable)/100;
                    $total_payable = $total_payable - $discountParcentTk;
                }
                else {
                    $global_discount = 'no';
                    $global_discount_rate = 0;
                }
                
                if(!empty($request->vat)) {
                    $vat = $request->vat;
                    $vat_tk = $total_payable * $vat / 100;
                    $total_payable = $total_payable + $vat_tk;
                }
                else {
                    $vat = 0;
                }
                
                if(!empty($request->only_others_crg)) {
                    $total_payable = $total_payable + $request->only_others_crg;
                }
                
                if($request->invoice_wallet_point > 0) {
                     $previous_point = $customer_info->wallets+0;
                     $update_wallets_point = $previous_point - $request->invoice_wallet_point;
                     DB::table('customers')->where('id', $customer_info->id)->update(['wallets'=>$update_wallets_point]);
                }
                
                if(!empty($request->extra_fine_tk)) {
                    $total_payable = $total_payable - $request->extra_fine_tk;
                }
                
                $current_due = $customer_info->balance + 0;
                $total_payable_with_customer_due = $current_due - $total_payable;
                
                if($customer_info->code == $shop_id.'WALKING') {
                    $paid = $total_payable;
                    $customer_current_due = 0;
                }
                else {
                    $paid = $request->paid;
                    $customer_current_due = $paid + $total_payable_with_customer_due;
                }
                
                $return_customer = DB::table('return_orders')->insert(['shop_id'=>$shop_id, 'branch_id'=>$branch_id, 'invoice_id'=>$invoice_id, 'return_current_times'=>$update_count, 'customer_id'=>$customer_id, 'total_gross'=>$total_gross, 'vat_status'=>$request->vat, 'discount_status'=>$global_discount, 'discount_rate'=>$global_discount_rate,  'others_crg'=>$request->only_others_crg_tk,  'fine'=>$request->extra_fine_tk,  'refundAbleAmount'=>$request->total_payable,  'currentDue'=>$current_due,  'paid'=>$paid, 'date'=>$current_time, 'created_at'=>$current_time]);
                
                if($return_customer) {
                    $current_balance = $current_due;
                    $update_balance = $customer_current_due;
                    if($paid > 0) {
                        DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'branch_id'=>Auth::user()->branch_id, 'added_by'=>Auth::user()->id, 'for_what'=>'CPR', 'track'=>$customer_id, 'refference'=>$invoice_id, 'amount'=>$paid, 'creadit_or_debit'=>'DR', 'note'=>'Customer Product Return. Invoice Num. #'.str_replace("_","/", $invoice_id).'', 'created_at'=>Carbon::now()]);
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance - $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        DB::table('cash_flows')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'branch_id'=>$branch_id, 'account'=>'cash', 'credit_or_debit'=>'DR', 'description'=>'Customer return products, Invoice num '.$invoice_id.' Current Returnable times '.$update_count.'', 'balance'=>$paid, 'created_at'=>$current_time]);
                    }
                    DB::table('customers')->where('id', $customer_id)->where('shop_id', $shop_id)->update(['balance'=>$update_balance]);
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Customer Return Product. Invoice num #'.str_replace("_","/", $invoice_id).' Current Returnable times '.$update_count.'', 'created_at' => $current_time]);
                    return Redirect()->route('branch.customer.returned.invoices')->with('success', 'Product Return Successfully done.');
            
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, Please try again.');
                }
                
            }
            else {
                return Redirect()->back()->with('error', 'Sorry has no product to return.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function confirm_direct_return_to_customer(Request $request) {
        if(User::checkMultiplePermission(['branch.return.product', 'others.returns.refund']) == true){
            if($request->pid != '') {
                $shop_id = Auth::user()->shop_id;
                $pid = $request->pid;
                $return_or_exchange = $request->return_or_exchange;
                $sr_id = $request->sr;
                $total_gross = 0;
                $date = $request->date;
                $customer_id = $request->customer_id;
                $customer_info = DB::table('customers')->where('id', $customer_id)->where('shop_id', $shop_id)->first(['balance', 'code', 'id', 'wallet_balance', 'wallets']);

                foreach($pid as $key => $item) {
                   
                    $return_or_exchange = $request->return_or_exchange[$key];
                    $row_id = $request->row_id[$key];
                    $product_id = $pid[$key];
                    $unit = $request->quantity[$key];
                    $cartoon_amount = $request->cartoon_amount[$key];
                    
                    $trackers_info = DB::table('product_trackers')->where(['id'=>$row_id, 'shop_id'=> $shop_id])->first();
                    
                    if($return_or_exchange == 'r') {
                        
                        $check_sr_stocks = SRStocks::where(['shop_id'=>$shop_id, 'purchase_line_id'=>$trackers_info->purchase_line_id, 'lot_number'=>$trackers_info->lot_number, 'sr_id'=>$sr_id, 'pid'=>$product_id, 'variation_id'=>$trackers_info->variation_id, 'is_cartoon'=>$trackers_info->is_cartoon, 'cartoon_quantity'=>$trackers_info->cartoon_quantity])->first();
                                                
                        if(!is_null($check_sr_stocks)) {
                            $current_stock_item = optional($check_sr_stocks)->stock;
                            $update_stock_item = $current_stock_item + $unit;

                            $update_sr_stock = $check_sr_stocks;
                            $update_sr_stock->stock = $update_stock_item;

                            if($trackers_info->is_cartoon == 1) {
                                $update_sr_stock->cartoon_amount = optional($check_sr_stocks)->cartoon_amount + $cartoon_amount;
                            }

                            $update_sr_stock->update();

                        }
                        else {
                            $insert = DB::table('s_r_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$trackers_info->purchase_line_id, 'lot_number'=>$trackers_info->lot_number, 'sr_id'=>$sr_id, 'pid'=>$pid,  'variation_id'=>$trackers_info->variation_id, 'purchase_price'=>$trackers_info->purchase_price, 'sales_price'=>$trackers_info->sales_price, 'discount'=>$trackers_info->discount, 'discount_amount'=>$trackers_info->discount_amount, 'vat'=>$trackers_info->vat, 'stock'=>$unit, 'is_cartoon'=>$trackers_info->is_cartoon, 'cartoon_quantity'=>$trackers_info->cartoon_quantity, 'cartoon_amount'=>$cartoon_amount]);
                        }

                        $total_price = $unit * $trackers_info->price;
                        $total_gross = $total_gross + $total_price;

                        $p_data = array();
                        $p_data['shop_id'] = $shop_id;
                        $p_data['lot_number'] = $trackers_info->lot_number;
                        $p_data['purchase_line_id'] = $trackers_info->purchase_line_id;
                        $p_data['purchase_price'] = $trackers_info->purchase_price;
                        $p_data['total_purchase_price'] = $trackers_info->purchase_price * $unit;
                        $p_data['sales_price'] = $trackers_info->sales_price;
                        $p_data['variation_id'] = $trackers_info->variation_id;
                        $p_data['product_id'] = $product_id;
                        $p_data['quantity'] = $unit;
                        $p_data['price'] = $trackers_info->purchase_price;
                        $p_data['discount'] = $trackers_info->discount;
                        $p_data['discount_amount'] = $trackers_info->discount_amount;
                        $p_data['vat'] = $trackers_info->vat;
                        $p_data['total_price'] = $total_price;
                        $p_data['status'] = 1; // 1 means in
                        $p_data['product_form'] = 'R';
                        $p_data['branch_id'] = $sr_id;
                        $p_data['invoice_id'] = $trackers_info->invoice_id;
                        $p_data['note'] = "Return To Customers";
                        $p_data['created_at'] = $date;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);

                        DB::table('order_return_porducts')->insert(['invoice_id'=>$trackers_info->invoice_id, 'return_or_exchange'=>'r', 'how_many_times_edited'=>0, 'product_id'=>$product_id, 'variation_id'=>$trackers_info->variation_id, 'quantity'=>$unit, 'price'=>$trackers_info->price, 'discount'=>$trackers_info->discount, 'discount_amount'=>$trackers_info->discount_amount, 'vat'=>$trackers_info->vat_amount, 'total_price'=>$total_price, 'created_at'=>$date]);
                            
                    }
                    else if($return_or_exchange == 'e') {
                        DB::table('order_return_porducts')->insert(['invoice_id'=>$invoice_id, 'return_or_exchange'=>'e', 'how_many_times_edited'=>$update_count, 'product_id'=>$product_id, 'variation_id'=>$ordered_product_info->variation_id, 'quantity'=>$unit, 'price'=>$price, 'discount'=>$ordered_product_info->discount, 'discount_amount'=>$ordered_product_info->discount_amount, 'vat'=>$ordered_product_info->vat_amount, 'total_price'=>0, 'created_at'=>$current_time]);
                    }
                }

                $return_customer = DB::table('return_orders')->insert(['shop_id'=>$shop_id, 'branch_id'=>$branch_id, 'invoice_id'=>$invoice_id, 'return_current_times'=>$update_count, 'customer_id'=>$customer_id, 'total_gross'=>$total_gross, 'vat_status'=>$request->vat, 'discount_status'=>$global_discount, 'discount_rate'=>$global_discount_rate,  'others_crg'=>$request->only_others_crg_tk,  'fine'=>$request->extra_fine_tk,  'refundAbleAmount'=>$request->total_payable,  'currentDue'=>$current_due,  'paid'=>0, 'date'=>$date, 'created_at'=>$date]);


            }
            else {
                return Redirect()->back()->with('error', 'Sorry has no product to return.');
            }

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\return_order  $return_order
     * @return \Illuminate\Http\Response
     */
    public function destroy(return_order $return_order)
    {
        //
    }
}
