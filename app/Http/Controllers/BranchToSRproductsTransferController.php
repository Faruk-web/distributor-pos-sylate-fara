<?php

namespace App\Http\Controllers;

use App\Models\BranchToSRproductsTransfer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch_setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;
use DataTables;
use App\Models\BranchToSrTransferedProducts;

class BranchToSRproductsTransferController extends Controller
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
            return view('cms.sr.stock_in.b_to_s_transfer_invoices', compact('wing'));

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function index_data(Request $request) {
        if ($request->ajax()) {
            $invoices = BranchToSRproductsTransfer::OrderBy('id', 'DESC')->get();
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
                ->addColumn('sr_name', function($row){
                    return optional($row->sr_info)->name;
                })
                
                ->rawColumns(['action', 'invoice', 'sender_branch', 'sr_name'])
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
            return view('cms.sr.stock_in.b_to_s_transfer', compact('wing', 'branches', 'all_sr'));
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
            
            $count_total = BranchToSRproductsTransfer::where('shop_id', $shop_id)->count('id');
            $update_count = $count_total+1;
            $invoice_id="BTSR"."_"."T"."_".$shop_id.'_'.$update_count;

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
                        
                        $exist_check = DB::table('s_r_stocks')->where(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'sr_id'=>$sr_id, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'cartoon_quantity'=>$check_product->cartoon_quantity])->first();
                        
                        if(!is_null($exist_check)) {
                            $update_quantity = $exist_check->stock + $quantity;
                            $update_cartoon_qty = $exist_check->cartoon_amount + $cartoon_amount;
                            DB::table('s_r_stocks')->where(['id'=>$exist_check->id, 'shop_id'=>$shop_id])->update(['stock'=>$update_quantity, 'cartoon_amount'=>$update_cartoon_qty]);
                            $rest_quantity = $db_stock - $quantity;
                            $rest_cartoon_qty = $check_product->cartoon_amount - $cartoon_amount;
                        }
                        else {
                            $insert = DB::table('s_r_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$check_product->purchase_line_id, 'lot_number'=>$check_product->lot_number, 'sr_id'=>$sr_id, 'pid'=>$check_product->pid,  'variation_id'=>$check_product->variation_id, 'purchase_price'=>$check_product->purchase_price, 'sales_price'=>$check_product->sales_price, 'discount'=>$check_product->discount, 'discount_amount'=>$check_product->discount_amount, 'vat'=>$check_product->vat, 'stock'=>$quantity, 'cartoon_quantity'=>$check_product->cartoon_quantity, 'cartoon_amount'=>$cartoon_amount]);
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
                        $p_data['cartoon_quantity'] = $check_product->cartoon_quantity;
                        $p_data['cartoon_amount'] = $cartoon_amount;
                        $p_data['price'] = 0;
                        $p_data['discount'] = $check_product->discount;
                        $p_data['discount_amount'] = $check_product->discount_amount;
                        $p_data['vat'] = $check_product->vat;
                        $p_data['total_price'] = 0;
                        $p_data['status'] = 1; // 1 means in // Goudown to branch in
                        $p_data['product_form'] = 'BTSR'; // Branch To SR
                        $p_data['invoice_id'] = $invoice_id;
                        $p_data['note'] = $request->note;
                        $p_data['created_at'] = $date;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);

                         $products = new BranchToSrTransferedProducts;
                         $products->invoice_id = $invoice_id;
                         $products->sr_id = $sr_id;
                         $products->purchase_line_id = $check_product->purchase_line_id;
                         $products->lot_number = $check_product->lot_number;
                         $products->purchase_price = $check_product->purchase_price;
                         $products->sales_price = $check_product->sales_price;
                         $products->pid = $product_id;
                         $products->variation_id = $check_product->variation_id;
                         $products->quantity = $quantity;
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
            
            $insert = BranchToSRproductsTransfer::insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'invoice_id'=>$invoice_id, 'sender_branch_id'=>$sender_branch, 'sr_id'=>$sr_id, 'note'=>$request->note, 'date'=>$date, 'created_at'=>$current_time]);
            if($insert) {
                
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock Out from Branch To SR Transfer. Invoice num '.$invoice_id, 'created_at' => $current_time]);
                return Redirect()->route('b.to.sr.transfer.index')->with('success', 'Stock Out from Branch To SR Transfer Successfully done.');
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
    public function show(BranchToSRproductsTransfer $branchToSRproductsTransfer)
    {
        //
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
