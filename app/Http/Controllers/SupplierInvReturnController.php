<?php

namespace App\Http\Controllers;

use App\Models\Supplier_inv_return;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Models\Supplier_return_product;
use DataTables;
use App\Models\Supplier;

class SupplierInvReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('supplier.return.product') == true){
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.stock_in.supplier_all_return_invoice', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function supplier_return_product_invoice_data(Request $request)
    {
        if ($request->ajax()) {
            $supplier_returned_invoices = supplier_inv_return::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($supplier_returned_invoices)
                ->addIndexColumn()
                ->addColumn('supplier_name', function($row){
                    return optional($row->supplier_name)->name."<br>Company Name: ".optional($row->supplier_company_name)->company_name;
                })
                ->addColumn('invoice', function($row){
                    return str_replace("_","/", $row->supp_invoice_id);
                })
                ->addColumn('date', function($row){
                    return date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->supp_invoice_id]).'" class="btn btn-primary btn-sm">Inv</a> <a target="_blank" href="'.route('supplier.returned.invoice.view', ['id'=>$row->id, 'how_many_times_edit'=>$row->how_many_times_edited]).'" class="btn btn-info btn-sm">Returned inv</a>';
                    return $info;
                })
                ->rawColumns(['supplier_name', 'action', 'invoice', 'date'])
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
     * @param  \App\Models\supplier_inv_return  $supplier_inv_return
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(User::checkPermission('supplier.return.product') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $supplier_returned_invoice_info = supplier_inv_return::where('id', $id)->where('shop_id', $shop_id)->first();
            if($supplier_returned_invoice_info) {
                $returned_products = Supplier_return_product::where('supp_invoice_id', $supplier_returned_invoice_info->supp_invoice_id)->where('how_many_times_edited', $supplier_returned_invoice_info->how_many_times_edited)->get();
                $pdf = PDF::loadView('cms.shop_admin.supplier.stock_in.view_returned_invoice', compact('shop_info', 'supplier_returned_invoice_info', 'wing', 'returned_products'));
                return $pdf->stream('supplier Returned invoice '.$supplier_returned_invoice_info->supp_invoice_id);
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
     * @param  \App\Models\supplier_inv_return  $supplier_inv_return
     * @return \Illuminate\Http\Response
     */
    public function edit(supplier_inv_return $supplier_inv_return)
    {
        //
    }
    
    
    public function supplier_direct_return() {
        if(User::checkPermission('supplier.return.product') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.stock_in.supplier_direct_return', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    public function search_supplier_for_direct_return(Request $request){
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $supplier_info = $request->supplier_info;
        
        $suppliers = DB::table('suppliers')
                ->where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($supplier_info) {
                    $query->where('phone', 'LIKE', '%'. $supplier_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $supplier_info. '%')
                        ->orWhere('company_name', 'LIKE', '%'. $supplier_info. '%');
                })
                ->get(['name', 'company_name', 'phone',  'code', 'id', 'address', 'balance']);
          
          if($suppliers->isNotEmpty() && $supplier_info != '') {
            foreach ($suppliers as $supplier) {
                $output.='<tr>'.
                '<td>'.$supplier->name.'</td>'.
                '<td>'.$supplier->company_name.'</td>'.
                '<td>'.$supplier->phone.'</td>'.
                '<td><button onclick="setSupplier(\''.$supplier->id.'\', \''.$supplier->name.'\', \''.$supplier->company_name.'\', \''.$supplier->phone.'\', \''.$supplier->code.'\', \''.$supplier->balance.'\', \''.$supplier->address.'\')" type="button" class="btn btn-success btn-rounded btn-sm">Select</button></td>'.
                '</tr>';
                }
                
        }
        else {
            $output.='<tr class="text-center"><td colspan="4">No Supplier Found<td></tr>';
        }
        return Response($output);
    }
    
    
    //Begin:: get products from barcode for supplier direct return
    public function get_product_info_from_barcode(Request $request) {
        $barcode = $request->barcode;
        $shop_id = Auth::user()->shop_id;
        $product = DB::table('products')->where('shop_id', $shop_id)->where('barCode', $barcode)->first();
        if(!empty($product->id)) {
            $sts = [
                'exist' => 'yes',
                'pid' => $product->id,
                'p_name' => $product->p_name,
                'purchase_price' => $product->purchase_price,
            ];
        }
        else {
            $sts = [
                'exist' => 'no',
            ];
        }
        return response()->json($sts);

    }
    
    public function get_products_search_by_title(Request $request) {
        $title = $request->title;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $products = DB::table('products')->where('shop_id', $shop_id)->where('p_name', 'like', '%' . $title . '%')->get();
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    $output .= '<li class="nav-item mb-1 p-1 rounded" onclick="setProduct(\''.$product->id.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\')" title="Add me">
                        <a class="nav-link d-flex justify-content-between align-items-center" id="product_text" href="javascript:void(0)">
                        <span class=""></span>'.$product->p_name.'/<small>'.optional($product)->barCode.'</small></a>
                        <span class="text-primary"><b>Brand:</b>  '.optional($brand_info)->brand_name.'</span>
                    </li>';
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        
        return response()->json($output);

    }
    
    
    public function supplier_direct_product_return_confirm(Request $request)
    {
        if(User::checkPermission('supplier.return.product') == true){
            $pid = $request->pid;
            if(!is_null($pid)) {
                $shop_id = Auth::user()->shop_id;
                $return_place = $request->return_place;
                $supplier_id = $request->supplier_id;
                $validated = $request->validate([
                    'supplier_id' => 'required',
                ]);
                
                $how_many_time_returns = DB::table('supplier_inv_returns')->where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $inv_count = optional($how_many_time_returns)->id + 1;
                $update_count = 0;
                $invoice_id = "SDR_".$shop_id."_".$inv_count;
                $current_time = Carbon::now();
    
                foreach($pid as $key => $item) {
                    $unit = $request->quantity[$key];
                    $price = $request->price[$key];
                    $total = $request->total[$key];
    
                    $p_data = array();
                    
                    $p_data['branch_id'] = $return_place[$key];
                    $p_data['product_id'] = $pid[$key];
                    $p_data['quantity'] = $unit;
                    $p_data['price'] = $price;
                    $p_data['total_price'] = $total;
                    $p_data['status'] = 0; // 0 means Out
                    $p_data['product_form'] = 'SUPP_R';
                    $p_data['invoice_id'] = $invoice_id;
                    $p_data['supplier_id'] = $supplier_id;
                    $p_data['note'] = $request->note;
                    $p_data['created_at'] = $current_time;
                    $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                    if($insert_product_trackers) {
                        if($return_place[$key] == 'g') {
                            $product_exist_quantity_check = DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->first(['G_current_stock']);
                            $current_quantity = $product_exist_quantity_check->G_current_stock;
                            $updateable_quantity = $current_quantity - $request->quantity[$key];
                            DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->update(['G_current_stock' => $updateable_quantity]);
                        }
                        else {
                            $branch_stock = DB::table('product_stocks')->where('branch_id', $return_place[$key])->where('pid', $pid[$key])->where('shop_id', $shop_id)->first();
                            $branch_current_quantity = $branch_stock->stock;
                            $branch_update_qty = $branch_current_quantity - $request->quantity[$key];
                            DB::table('product_stocks')->where(['branch_id'=>$return_place[$key], 'pid'=>$pid[$key]])->update(['stock' => $branch_update_qty]);
                        }
                        
                        DB::table('supplier_return_products')->insert(['shop_id' => $shop_id, 'supp_invoice_id'=>$invoice_id, 'how_many_times_edited'=>$update_count, 'product_id'=>$pid[$key], 'quantity'=>$unit, 'price'=>$price, 'total_price'=>$total, 'created_at'=>$current_time, 'updated_at'=>$return_place[$key]]);
                    }
                }
    
                $supplier_info = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->first(['balance']);
                $current_balance = $supplier_info->balance;
                $return_supplier = DB::table('supplier_inv_returns')->insert(['shop_id'=>$shop_id, 'supp_invoice_id'=>$invoice_id, 'supplier_id'=>$supplier_id, 'total_gross'=>$request->total_gross, 'supp_Due'=>$current_balance, 'note'=>$request->note, 'how_many_times_edited'=>$update_count, 'date'=>$current_time, 'created_at'=>$current_time]);
                if($return_supplier) {
                    $update_balance = $current_balance - $request->total_gross;
                    $supplier_balance_update = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->update(['balance'=>$update_balance]);
                    
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Direct Product Return to supplier. Invoice num '.$invoice_id.'', 'created_at' => $current_time]);
                    return Redirect()->route('supplier.all.returned.invoices')->with('success', 'Product Return Successfully done.');
            
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, Please try again.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'No Product Select');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    

    //End:: get products from barcode for supplier direct return
    
    //Start:: get products from barcode for supplier direct return New
    public function supplier_direct_return_new() {
        if(User::checkPermission('supplier.return.product') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.stock_in.supplier_direct_return_new', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function get_products_search_by_title_new(Request $request) {
        $title = $request->title;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        
        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where('products.shop_id', $shop_id)
                    ->where('product_stocks.stock', '>', 0)
                    ->select('products.p_name', 'products.p_brand', 'product_stocks.*', 'products.p_unit_type');
                    $products = $products->where('products.p_name', "like", "%".$title."%");
                    $products = $products->orderBy('lot_number', 'ASC');
                    $products = $products->paginate(30);
        
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    
                    $variation_name = '';
                    $variation_title = '';
                    if($product->variation_id != 0 && $product->variation_id != '') {
                        $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  '<span class="text-primary">('.optional($variation_info)->list_title.')</span>';
                        $variation_title = optional($variation_info)->list_title;
                    }
                    $unit_type_info = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product_text" onclick="myFunction(\''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\', \''.$product->id.'\')" title="Add me">
                        <h6 class="text-success">'.$product->p_name.' '.$variation_name.'</h6>
                        <span><b>Brand:</b> '.optional($brand_info)->brand_name.', <b class="text-danger">Lot Number:</b> '.$product->lot_number.', <b>Sales Price:</b> '.$product->sales_price.', <b>Discount:</b> '.$product->discount.'('.$product->discount_amount.'), <b>VAT:</b> '.$product->vat.'%</span>
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
    
    public function get_product_info_from_barcode_new(Request $request) {
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
                    ->where('products.shop_id', $shop_id)
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
                        $variation_info = DB::table('variation_lists')->where(['id'=>$product->variation_id])->first();
                        $variation_name =  '<span class="text-primary">('.optional($variation_info)->list_title.')</span>';
                        $variation_title = optional($variation_info)->list_title;
                    }
                    
                    $unit_type_info = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    
                    $product_output .= '<div class="col-md-4 p-1"><div class="nav-item mb-1 p-2 rounded border" id="product_text" onclick="myFunction(\''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\', \''.$product->id.'\')" title="Add me">
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
    
    public function supplier_direct_product_return_confirm_new(Request $request)
    {
        if(User::checkPermission('supplier.return.product') == true){
            $pid = $request->pid;
            
            if(!is_null($pid)) {
                $shop_id = Auth::user()->shop_id;
                $return_place = $request->return_place;
                $supplier_id = $request->supplier_id;
                $validated = $request->validate([
                    'supplier_id' => 'required',
                ]);
                
                $how_many_time_returns = DB::table('supplier_inv_returns')->where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $inv_count = optional($how_many_time_returns)->id + 1;
                $update_count = 0;
                $invoice_id = "SDR_".$shop_id."_".$inv_count;
                $current_time = Carbon::now();
                $sum = 0;
    
                foreach($pid as $key => $item) {
                    
                    $unit = $request->quantity[$key];
                    $price = $request->price[$key];
                    
                    $product_stocks_id = $request->product_stocks_id[$key];
                    $product_id = $pid[$key];
                    $item_stock_info = DB::table('product_stocks')->where('id', $product_stocks_id)->where('pid', $product_id)->first();
                    
                    if($unit > 0 && !is_null($item_stock_info)) {
                        $rest_unit = '';
                        $return_unit = '';
                        
                        if(optional($item_stock_info)->stock >= $unit) {
                            $rest_unit = optional($item_stock_info)->stock - $unit;
                            $return_unit = $unit;
                        }
                        else if($unit >= optional($item_stock_info)->stock) {
                            $rest_unit = 0;
                            $return_unit = optional($item_stock_info)->stock;
                        }
                        
                        if($rest_unit > 0) {
                            DB::table('product_stocks')->where('id', $item_stock_info->id)->update(['stock'=>$rest_unit]);
                        }
                        else if($rest_unit == 0) {
                            DB::table('product_stocks')->where('id', $item_stock_info->id)->delete();
                        }
                        
                        DB::table('product_trackers')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>optional($item_stock_info)->purchase_line_id, 'lot_number'=>optional($item_stock_info)->lot_number, 'purchase_price'=>optional($item_stock_info)->purchase_price, 'total_purchase_price'=>optional($item_stock_info)->purchase_price*$return_unit, 'sales_price'=>optional($item_stock_info)->sales_price, 'variation_id'=>optional($item_stock_info)->variation_id, 'branch_id'=>optional($item_stock_info)->branch_id, 'product_id'=>optional($item_stock_info)->pid, 'quantity'=>$return_unit, 'price'=>$price, 'discount'=>optional($item_stock_info)->discount, 'discount_amount'=>optional($item_stock_info)->discount_amount, 'vat'=>optional($item_stock_info)->vat, 'total_price'=>$return_unit*$price, 'status'=>0, 'product_form'=>'SUPP_R', 'invoice_id'=>$invoice_id, 'supplier_id'=>$supplier_id, 'created_at'=>$current_time]);
                        
                        $total = $price * $return_unit;
                        $sum = $sum + $total;
        
                        DB::table('supplier_return_products')->insert(['shop_id' => $shop_id, 'supp_invoice_id'=>$invoice_id, 'lot_number'=>optional($item_stock_info)->lot_number, 'how_many_times_edited'=>$update_count, 'product_id'=>$pid[$key], 'variation_id'=>optional($item_stock_info)->variation_id, 'quantity'=>$return_unit, 'price'=>$price, 'total_price'=>$total, 'created_at'=>$current_time]);
                        
                    }
                }
    
                $supplier_info = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->first(['balance']);
                $current_balance = $supplier_info->balance;
                $return_supplier = DB::table('supplier_inv_returns')->insert(['shop_id'=>$shop_id, 'supp_invoice_id'=>$invoice_id, 'supplier_id'=>$supplier_id, 'total_gross'=>$sum, 'supp_Due'=>$current_balance, 'note'=>$request->note, 'how_many_times_edited'=>$update_count, 'date'=>$current_time, 'created_at'=>$current_time]);
                if($return_supplier) {
                    $update_balance = $current_balance - $sum;
                    $supplier_balance_update = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->update(['balance'=>$update_balance]);
                    
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Direct Product Return to supplier. Invoice num '.$invoice_id.'', 'created_at' => $current_time]);
                    return Redirect()->route('supplier.all.returned.invoices')->with('success', 'Product Return Successfully done.');
            
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, Please try again.');
                }
                
                
            }
            else {
                return Redirect()->back()->with('error', 'No Product Select');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    
    
    
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supplier_inv_return  $supplier_inv_return
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, supplier_inv_return $supplier_inv_return)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supplier_inv_return  $supplier_inv_return
     * @return \Illuminate\Http\Response
     */
    public function destroy(supplier_inv_return $supplier_inv_return)
    {
        //
    }
}
