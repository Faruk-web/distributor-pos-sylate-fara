<?php

namespace App\Http\Controllers;

use App\Models\BranchToBranchTransfer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch_setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;
use DataTables;

class BranchToBranchTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            return view('cms.shop_admin.produts.b_to_b_transfer_invoices', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function index_data(Request $request) {
        if ($request->ajax()) {
            $invoices = BranchToBranchTransfer::OrderBy('id', 'DESC')->get();
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="#" class="btn btn-primary btn-sm btn-rounded">Invoice</a>';
                })
                ->addColumn('invoice', function($row){
                    return "#".str_replace("_","/", $row->invoice_id);
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('sender_branch', function($row){
                    return optional($row->senderBranchInfo)->branch_name;
                })
                ->addColumn('receiver_branch', function($row){
                    return optional($row->receiverBranchInfo)->branch_name;
                })
                
                ->rawColumns(['action', 'invoice', 'sender_branch', 'receiver_branch'])
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
        if(User::checkPermission('admin.products') == true){
            $branches = Branch_setting::Where('shop_id', Auth::user()->shop_id)->get();
            $wing = 'main';
            return view('cms.shop_admin.produts.b_to_b_transfer', compact('wing', 'branches'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    
    public function get_products_search_by_title_into_branh_to_branch_transfer(Request $request) {
        $title = $request->title;
        $sender_branch = $request->sender_branch;
        $shop_id = Auth::user()->shop_id;
        $output = '';

        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$sender_branch, 'products.shop_id'=>$shop_id])
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
                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product_text" onclick="myFunction(\''.$product->id.'\', \''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\', \''.optional($product)->is_cartoon.'\', \''.optional($product)->cartoon_quantity.'\', \''.optional($product)->cartoon_amount.'\')" title="Add me">
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


    // SR Search
    public function get_products_search_by_title_into_sr_to_branch_transfer(Request $request) {
        $title = $request->title;
        $sr = $request->sr;
        $shop_id = Auth::user()->shop_id;
        $output = '';

        $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('s_r_stocks', function($join)
                            {
                                $join->on('products.id', '=', 's_r_stocks.pid');
                            })
                        ->where(['s_r_stocks.sr_id'=>$sr, 'products.shop_id'=>$shop_id])
                        ->where('s_r_stocks.stock', '>', 0)
                        ->select('products.p_name', 'products.p_brand', 's_r_stocks.*', 'products.p_unit_type');
                        $products = $products->where('products.p_name', "like", "%".$title."%");
                        $products = $products->orderBy('lot_number', 'ASC');
                        $products = $products->paginate(20);
                        // dd($products);
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
                        $output .= '<li class="nav-item mb-1 p-1 rounded" id="product_text" onclick="myFunction(\''.$product->id.'\', \''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\', \''.optional($product)->is_cartoon.'\', \''.optional($product)->cartoon_quantity.'\', \''.optional($product)->cartoon_amount.'\')" title="Add me">
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::checkPermission('admin.products') == true){
            
            $shop_id = Auth::user()->shop_id;
            
            $pid = $request->pid;
            $validated = $request->validate([
                'sender_branch' => 'required',
                'receiver_branch' => 'required',
            ]);
            
            if(is_null($pid)) {
                return Redirect()->back()->with('error', 'No Product Found!!!');
            }

            $current_time = Carbon::now();
            $branch_id = $request->branch_id;
            $sender_branch = $request->sender_branch;
            $receiver_branch = $request->receiver_branch;
            
            $count_total = BranchToBranchTransfer::where('shop_id', $shop_id)->count('id');
            $update_count = $count_total+1;
            $invoice_id="BTB"."_"."T"."_".$shop_id.'_'.$update_count;

            $date = date("Y-m-d", strtotime($request->date));

            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                $product_id = $pid[$key];
                $lot_number = $request->lot_number[$key];
                $variation_id = $request->variation_id[$key];
                $quantity = $request->quantity[$key];
                $cartoon_amount = $request->cartoon_amount[$key];
                $row_id = $request->row_id[$key];
                
                $check_product = DB::table('product_stocks')->where(['pid'=>$product_id, 'id'=>$row_id])->first();
                
                if(!is_null($check_product)) {
                    $db_stock = $check_product->stock;
                    if($db_stock >= $quantity) {
                        $rest_quantity = '';
                        $rest_cartoon_qty = '';
                        
                        $exist_check = DB::table('product_stocks')->where(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'branch_id'=>$receiver_branch, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'is_cartoon'=>$check_product->is_cartoon, 'cartoon_quantity'=>$check_product->cartoon_quantity])->first();
                        
                        if(!is_null($exist_check)) {
                            $update_quantity = $exist_check->stock + $quantity;
                            $update_cartoon_qty = $exist_check->cartoon_amount + $cartoon_amount;
                            DB::table('product_stocks')->where(['id'=>$exist_check->id, 'shop_id'=>$shop_id])->update(['stock'=>$update_quantity, 'cartoon_amount'=>$update_cartoon_qty]);
                            $rest_quantity = $db_stock - $quantity;
                            $rest_cartoon_qty = $check_product->cartoon_amount - $cartoon_amount;
                        }
                        else {
                            $insert = DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'branch_id'=>$receiver_branch, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'stock'=>$quantity, 'is_cartoon'=>$check_product->is_cartoon, 'cartoon_quantity'=>$check_product->cartoon_quantity, 'cartoon_amount'=>$cartoon_amount]);
                            $rest_cartoon_qty = $check_product->cartoon_amount - $cartoon_amount;
                            $rest_quantity = $db_stock - $quantity;
                        }
                        
                        if($rest_quantity == 0) {
                            DB::table('product_stocks')->where(['id'=>$check_product->id, 'shop_id'=>$shop_id])->delete();
                        }
                        else {
                            DB::table('product_stocks')->where(['id'=>$check_product->id, 'shop_id'=>$shop_id])->update(['stock'=>$rest_quantity, 'cartoon_amount'=>$rest_cartoon_qty]);
                        }
                        
                        $p_data = array();
                        $p_data['shop_id'] = $shop_id;
                        $p_data['purchase_line_id'] = $check_product->purchase_line_id;
                        $p_data['lot_number'] = $check_product->lot_number;
                        $p_data['purchase_price'] = $check_product->purchase_price;
                        $p_data['sales_price'] = $check_product->sales_price;
                        $p_data['variation_id'] = $check_product->variation_id;
                        $p_data['branch_id'] = $sender_branch;
                        $p_data['product_id'] = $product_id;
                        $p_data['quantity'] = $quantity;
                        $p_data['is_cartoon'] = $check_product->is_cartoon;
                        $p_data['cartoon_quantity'] = $check_product->cartoon_quantity;
                        $p_data['cartoon_amount'] = $cartoon_amount;
                        $p_data['price'] = 0;
                        $p_data['discount'] = $check_product->discount;
                        $p_data['discount_amount'] = $check_product->discount_amount;
                        $p_data['vat'] = $check_product->vat;
                        $p_data['total_price'] = 0;
                        $p_data['status'] = 1; // 1 means in // Goudown to branch in
                        $p_data['product_form'] = 'BTB';
                        $p_data['invoice_id'] = $invoice_id;
                        $p_data['note'] = $request->note;
                        $p_data['created_at'] = $date;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                    }
                    
                }
            }
            
            $insert = BranchToBranchTransfer::insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'invoice_id'=>$invoice_id, 'sender_branch_id'=>$sender_branch, 'receiver_branch_id'=>$receiver_branch, 'note'=>$request->note, 'date'=>$date, 'created_at'=>$current_time]);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock Out from Branch BY BTB Transfer. Invoice num '.$invoice_id, 'created_at' => $current_time]);
                return Redirect()->route('admin.products.btob.invoices')->with('success', 'Stock Out from Branch BY BTB Transfer Successfully done.');
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
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }
}
