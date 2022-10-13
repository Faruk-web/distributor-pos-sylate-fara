<?php

namespace App\Http\Controllers;

use App\Models\BranchToSRproductsTransfer;
use App\Models\SrToBranchTransferProducts;
use App\Models\SrToBranchTransfer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch_setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;
use DataTables;
use App\Models\BranchToSrTransferedProducts;
use App\Models\SRStocks;

class SrToBranchTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.branch.to.sr.transfer.products') == true){
            $wing = 'main';
            return view('cms.br.stock_in.s_to_b_transfer_invoices', compact('wing'));

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function index_data(Request $request) {
        if ($request->ajax()) {
            $invoices = SrToBranchTransfer::OrderBy('id', 'DESC')->get();
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
                ->addColumn('branch', function($row){
                    return optional($row->senderBranchInfo)->branch_name;
                })
                ->addColumn('sr_name', function($row){
                    return optional($row->sr_info)->name." [".optional($row->sr_info->area_info)->name." ]";
                })
                
                ->rawColumns(['action', 'invoice', 'branch', 'sr_name'])
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
        if(User::checkPermission('admin.branch.to.sr.transfer.products') == true){
            $branches = Branch_setting::Where('shop_id', Auth::user()->shop_id)->get();
            $all_sr = User::Where(['active'=> 1, 'type'=>'SR'])->orderBy('name', 'ASC')->get();
            $wing = 'main';
            return view('cms.br.stock_in.s_to_b_transfer', compact('wing', 'branches', 'all_sr'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::checkPermission('admin.branch.to.sr.transfer.products') == true){
            
            $shop_id = Auth::user()->shop_id;
            
            $pid = $request->pid;
            $validated = $request->validate([
                'sender_branch' => 'required',
                'sr' => 'required',
            ]);
            
            if(is_null($pid)) {
                return Redirect()->back()->with('error', 'No Product Found!!!');
            }

            $current_time = Carbon::now();
            $sender_branch = $request->sender_branch;
            $sr_id = $request->sr;
            
            $count_total = SrToBranchTransfer::where('shop_id', $shop_id)->count('id');
            $update_count = $count_total+1;
            $invoice_id="SRTB"."_"."T"."_".$shop_id.'_'.$update_count;

            $date = date("Y-m-d", strtotime($request->date));

            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                $product_id = $pid[$key];
                $lot_number = $request->lot_number[$key];
                $variation_id = $request->variation_id[$key];
                $quantity = $request->quantity[$key];
                $cartoon_amount = $request->cartoon_amount[$key];
                $row_id = $request->row_id[$key];
                
                $check_product = DB::table('s_r_stocks')->where(['pid'=>$product_id, 'id'=>$row_id])->first();
                
                if(!is_null($check_product)) {
                    $db_stock = $check_product->stock;
                    if($db_stock >= $quantity) {
                        $rest_quantity = '';
                        $rest_cartoon_qty = '';
                        
                        $exist_check = DB::table('product_stocks')->where(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'branch_id'=>$sender_branch, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'is_cartoon'=>$check_product->is_cartoon, 'cartoon_quantity'=>$check_product->cartoon_quantity])->first();
                        
                        if(!is_null($exist_check)) {
                            $update_quantity = $exist_check->stock + $quantity;
                            $update_cartoon_qty = $exist_check->cartoon_amount + $cartoon_amount;
                            DB::table('product_stocks')->where(['id'=>$exist_check->id, 'shop_id'=>$shop_id])->update(['stock'=>$update_quantity, 'cartoon_amount'=>$update_cartoon_qty]);
                            $rest_quantity = $db_stock - $quantity;
                            $rest_cartoon_qty = $check_product->cartoon_amount - $cartoon_amount;
                        }
                        else {
                            $insert = DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'branch_id'=>$sender_branch, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'stock'=>$quantity, 'is_cartoon'=>$check_product->is_cartoon, 'cartoon_quantity'=>$check_product->cartoon_quantity, 'cartoon_amount'=>$cartoon_amount]);
                            $rest_cartoon_qty = $check_product->cartoon_amount - $cartoon_amount;
                            $rest_quantity = $db_stock - $quantity;
                        }
                        
                        if($rest_quantity == 0) {
                            DB::table('s_r_stocks')->where(['id'=>$check_product->id, 'shop_id'=>$shop_id])->delete();
                        }
                        else {
                            DB::table('s_r_stocks')->where(['id'=>$check_product->id, 'shop_id'=>$shop_id])->update(['stock'=>$rest_quantity, 'cartoon_amount'=>$rest_cartoon_qty]);
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
                        $p_data['product_form'] = 'SRTB'; // SR to Branch Transfer
                        $p_data['invoice_id'] = $invoice_id;
                        $p_data['note'] = $request->note;
                        $p_data['created_at'] = $date;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);

                         $products = new SrToBranchTransferProducts;
                         $products->invoice_id = $invoice_id;
                         $products->sr_id = $sr_id;
                         $products->purchase_line_id = $check_product->purchase_line_id;
                         $products->lot_number = $check_product->lot_number;
                         $products->purchase_price = $check_product->purchase_price;
                         $products->sales_price = $check_product->sales_price;
                         $products->pid = $product_id;
                         $products->variation_id = $check_product->variation_id;
                         $products->quantity = $quantity;
                         $products->is_cartoon = $check_product->is_cartoon;
                         $products->cartoon_quantity = $check_product->cartoon_quantity;
                         $products->cartoon_amount = $cartoon_amount;
                         $products->discount = $check_product->discount;
                         $products->discount_amount = $check_product->discount_amount;
                         $products->vat_amount = $check_product->vat;
                         $products->date = $date;
                         $products->save();
                         
                    }
                    
                }
            }
            
            $insert = SrToBranchTransfer::insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'invoice_id'=>$invoice_id, 'sender_sr_id'=>$sender_branch, 'branch_id'=>$sr_id, 'note'=>$request->note, 'date'=>$date, 'created_at'=>$current_time]);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock Out from SR To Branch Transfer (SRTB). Invoice num '.$invoice_id, 'created_at' => $current_time]);
                return Redirect()->route('sr.to.br.transfer.index')->with('success', 'Stock Out from SR To Branch Transfer Successfully done.');
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
     * @param  \App\Models\BranchToSRproductsTransfer  $branchToSRproductsTransfer
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if(User::checkPermission('admin.branch.to.sr.transfer.products') == true){
            $all_sr = User::Where(['active'=> 1, 'type'=>'SR', 'shop_id'=>Auth::user()->shop_id])->orderBy('name', 'ASC')->get();
            $brands = DB::table('brands')->where('shop_id', Auth::user()->shop_id)->get();
            $wing = 'main';
            return view('cms.sr.stock_in.sr_stocks', compact('wing', 'all_sr', 'brands'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    
    public function stock_data(Request $request, $place, $brand)
    {
        if ($request->ajax()) {
            $shop_id = Auth::user()->shop_id;
            
            if($brand == 'all') {
                $products = DB::table('s_r_stocks')->join('products', 's_r_stocks.pid', '=', 'products.id')->where('s_r_stocks.stock', '>', 0)->where('s_r_stocks.sr_id', $place)->select('s_r_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type', 'products.barCode')->get();
            }
            else {
                $products = DB::table('s_r_stocks')->join('products', 's_r_stocks.pid', '=', 'products.id')->where('s_r_stocks.stock', '>', 0)->where('s_r_stocks.sr_id', $place)->where('products.p_brand', $brand)->select('s_r_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type', 'products.barCode')->get();
            }
            
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('stock', function($row){
                    $unit_type = DB::table('unit_types')->where('id', $row->p_unit_type)->first('unit_name');
                    return (optional($row)->stock + 0)." ".optional($unit_type)->unit_name;
                })
                ->addColumn('product_name', function($row){
                    $v_name = '';
                    if($row->variation_id != 0 && $row->variation_id != '') { $vinfo = DB::table('variation_lists')->where(['id'=>$row->variation_id])->first(); $v_name =  '<span class="text-success">('.optional($vinfo)->list_title.')</span>'; }
                    return $row->p_name.$v_name."<br><small class='text-primary'><b>Lot: </b>".$row->lot_number.", <b>Sales Price: </b>".number_format($row->sales_price, 2)."TK, <b>Discount: </b>".$row->discount."(".$row->discount_amount."), <b>VAT: </b>".$row->vat."%";
                })
                ->addColumn('action', function($row){
                    return 'Comming soon<a type="button" href="'.url('/stock/change-product-stock-info/'.$row->id).'" class="d-none btn btn-success btn-sm" ><i class="fas fa-sync text-light"></i></a>';
                })
                
                ->rawColumns(['product_name', 'stock', 'action'])
                ->make(true);
        }
    }

    public function stock_data_value(Request $request)
    {
        $place = $request->place;
        $brand = $request->brand;
        $shop_id = Auth::user()->shop_id;
        $total = 0;
        
        if($brand == 'all') {
            $products_stocks = SRStocks::where('sr_id', $place)->where('stock', '>', 0)->get(['purchase_price', 'stock']);
        }
        else {
            $products_stocks = DB::table('s_r_stocks')->join('products', 's_r_stocks.pid', '=', 'products.id')->where('s_r_stocks.stock', '>', 0)->where('s_r_stocks.sr_id', $place)->where('products.p_brand', $brand)->select('s_r_stocks.purchase_price', 's_r_stocks.stock')->get();
        }

        foreach($products_stocks->chunk(100) as $row) {
            foreach($row as $product) {
                $total = $total + ((($product->purchase_price) + 0) * (($product->stock) + 0));
            }
        }
        return Response()->json('Stock Value By Purchase Price: '.number_format($total, 2));
          
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchToSRproductsTransfer  $branchToSRproductsTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchToSRproductsTransfer $branchToSRproductsTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchToSRproductsTransfer  $branchToSRproductsTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchToSRproductsTransfer $branchToSRproductsTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchToSRproductsTransfer  $branchToSRproductsTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchToSRproductsTransfer $branchToSRproductsTransfer)
    {
        //
    }
}
