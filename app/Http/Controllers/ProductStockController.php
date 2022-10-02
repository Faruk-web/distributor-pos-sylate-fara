<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Product_stock;
use App\Models\ProductWithVariation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;


class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('branch.product.stock') == true){
            return view('cms.branch.products.branch_product_stock');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function product_stock_data(Request $request)
    {
        
        if ($request->ajax()) {
            $product_stocks = Product_stock::where('branch_id', Auth::user()->branch_id)->where('shop_id', Auth::user()->shop_id)->get();
            return Datatables::of($product_stocks)
                ->addIndexColumn()
                ->addColumn('product_name', function($row){
                    $info = optional($row->product_info)->p_name;
                    return $info;
                })
                ->addColumn('category_name', function($row){
                    $info = optional($row->product_info->category)->cat_name;
                    return $info;
                })
                ->addColumn('brand_name', function($row){
                    $info = optional($row->product_info->brand_info)->brand_name;
                    return $info;
                })
                ->addColumn('image', function($row){
                    $info =  '<img style="width: 50px;" src="'.asset(optional($row->product_info)->image).'" class="rounded">';
                    return $info;
                })
                ->addColumn('stock', function($row){
                    $info = $row->stock." ".$row->product_info->unit_type_name->unit_name;
                    return $info;
                })
                ->rawColumns(['product_name', 'category_name', 'brand_name', 'image', 'stock'])
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
     * @param  \App\Models\Product_stock  $product_stock
     * @return \Illuminate\Http\Response
     */
    public function show(Product_stock $product_stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product_stock  $product_stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Product_stock $product_stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product_stock  $product_stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product_stock $product_stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product_stock  $product_stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_stock $product_stock)
    {
        //
    }
    
    public function product_stock_summery($id) {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $product_info = Product::where(['id'=>$id, 'shop_id'=>$shop_id])->first();
            if(!empty($product_info->id)) {
                $wing = 'main';
                $branch_stock = Product_stock::where('pid', $product_info->id)->where('stock', '>', 0)->get(['branch_id', 'stock', 'pid', 'variation_id']);
                $tracking_summery = DB::table('product_trackers')->where('product_id', $product_info->id)->get(['total_price', 'quantity', 'product_form', 'id', 'status']);
                
                return view('cms.shop_admin.produts.products_summery', compact('wing', 'product_info', 'tracking_summery', 'branch_stock'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function product_stock_in_out_summery_data($pid)
    {
    
        $summery = DB::table('purchase_lines')->where('product_id', $pid)->orderBy('id', 'desc')->get();
        return Datatables::of($summery)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a type="button" target="_blank" href="'.url('/admin/view-product-lot-info/'.$row->id).'" class="btn btn-success btn-sm btn-rounded">View</a>';
            })
            ->addColumn('date', function($row){
                $variation_name = '';
                if($row->variation_id != 0 && $row->variation_id != '') {
                    $variation_info = DB::table('variation_lists')->where(['id'=>$row->variation_id])->first();
                    $variation_name =  '<br><small class="text-success">Variation: ('.optional($variation_info)->list_title.')</small>';
                }
                return date('d-m-Y', strtotime($row->date)).$variation_name;
            })
            ->addColumn('place', function($row){
                if($row->branch_id == 'G') { return 'Godown'; }
                else {
                    $branch_info = DB::table('branch_settings')->where('id', $row->branch_id)->first(['branch_name', 'branch_address']);
                    return optional($branch_info)->branch_name." (".optional($branch_info)->branch_address." )";
                }
            })
            
            ->rawColumns(['action', 'date', 'place'])
            ->make(true);
  
    }
    
    public function view_product_lot_info($id) {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $purchase_line_info = DB::table('purchase_lines')->where('id', $id)->where('shop_id', $shop_id)->first();
           
            if(!is_null($purchase_line_info)) {
                $wing = 'main';
                $product_info = Product::where(['id'=>$purchase_line_info->product_id, 'shop_id'=>$shop_id])->first();
                $branch_stock = Product_stock::where(['pid'=>$purchase_line_info->product_id, 'variation_id'=>$purchase_line_info->variation_id, 'lot_number'=>$purchase_line_info->lot_number])->where('stock', '>', 0)->get(['branch_id', 'stock', 'pid', 'variation_id']);
                $tracking_summery = DB::table('product_trackers')->where(['product_id'=>$purchase_line_info->product_id, 'variation_id'=>$purchase_line_info->variation_id, 'lot_number'=>$purchase_line_info->lot_number])->orderBy('id', 'DESC')->get();
                return view('cms.shop_admin.produts.product_lot_summery', compact('wing', 'purchase_line_info', 'product_info', 'tracking_summery', 'branch_stock'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function product_summery_data($pid)
    {
    
        $summery = DB::table('product_trackers')->where('product_id', $pid)->orderBy('id', 'desc')->get();
        return Datatables::of($summery)
            ->addIndexColumn()
            ->addColumn('summery', function($row){
                $info = '';
                if($row->product_form =='G') {
                    $info .='Stock In Godown To Shop. Inv #'.str_replace("_","/", $row->invoice_id).'';
                }
                else if($row->product_form =='S') {
                    $info .='Stock Out By Sell. <a href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" target="_blank" class="btn btn-rounded btn-outline-dark btn-sm">#'.str_replace("_","/", $row->invoice_id).'</a>';
                }
                else if($row->product_form =='OP') {
                    $info .='Opening Stock Set.';
                }
                else if($row->product_form =='OWS') {
                    $info .='Stock In by Own Supplier.';
                }
                else if($row->product_form =='SUPP_R') {
                    $info .='Stock Out To Supplier By Return Product. ';
                }
                else if($row->product_form =='DM') {
                    $info .='Stock Out By Damage.';
                }
                else if($row->product_form =='SUPP_TO_G') {
                    $info .='Stock In From Supplier To Godown. <a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-rounded btn-outline-dark btn-sm">#'.str_replace("_","/", $row->invoice_id).'</a>';
                }
                else if($row->product_form =='SUPP_TO_B') {
                    $info .='Stock In From Supplier To Branch. <a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-rounded btn-outline-dark btn-sm">#'.str_replace("_","/", $row->invoice_id).'</a>';
                }
                else if($row->product_form =='R') {
                    $info .='Stock In By Customer Return Product. Inv #'.str_replace("_","/", $row->invoice_id).'';
                }
                
                return $info;
            })
            ->addColumn('date', function($row){
                return date('d-m-Y', strtotime($row->created_at));
            })
            ->addColumn('in_or_out', function($row){
                if($row->status == 1) {
                    return '<span class="bg-success text-light p-1 rounded">In</span>';
                }
                else if($row->status == 0) {
                    return '<span class="bg-danger text-light p-1 rounded">Out</span>';
                }
                
            })
            
            ->rawColumns(['summery', 'date', 'in_or_out'])
            ->make(true);
  
    }
    
    public function product_stock_adjust($id) {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $product_info = Product::where(['id'=>$id, 'shop_id'=>$shop_id])->first();
            //$branch_stock = Product_stock::where(['pid' => $product_info->id, 'branch_id' => $branch_id, 'shop_id' => $shop_id])->get(['branch_id', 'stock', 'pid']);
            if(!is_null($product_info)) {
                
                $wing = 'main';
                $branch_stock = Product_stock::where('pid', $product_info->id)->get(['branch_id', 'stock', 'pid']);
                $tracking_summery = DB::table('product_trackers')->where('product_id', $product_info->id)->get(['total_price', 'quantity', 'product_form', 'id', 'status', 'product_id', 'branch_id']);
                
                // $db_current_total_stock = ($product_info->G_current_stock + 0);

                // $total_stock_in = $tracking_summery->filter(function($item) {
                //   return $item->product_form == 'SUPP_TO_G' || $item->product_form == 'SUPP_TO_B' || $item->product_form == 'OWS';
                // });
                
                // $total_sold = $tracking_summery->filter(function($item) {
                //   return $item->product_form == 'S';
                // });
                
                // $customer_return = $tracking_summery->filter(function($item) {
                //   return $item->product_form == 'R';
                // });
                
                // $supplier_return = $tracking_summery->filter(function($item) {
                //   return $item->product_form == 'SUPP_R';
                // });
                
                // $damage = $tracking_summery->filter(function($item) {
                //   return $item->product_form == 'DM';
                // });
                
                // $opening_stock = $tracking_summery->filter(function($item) {
                //   return $item->product_form == 'OP';
                // });
                
                // $branches_current_stock = $branch_stock->sum('stock');
                
                // $total_stock_in_price = $total_stock_in->sum('total_price') + $opening_stock->sum('total_price');
                // $total_stock_in_qty = $total_stock_in->sum('quantity') + $opening_stock->sum('quantity');
                
                
                // $calculuted_current_stock = $total_stock_in->sum('quantity') + $opening_stock->sum('quantity') -  $total_sold->sum('quantity') + $customer_return->sum('quantity') - $supplier_return->sum('quantity') - $damage->sum('quantity');
                
                // $db_current_total_stock = $db_current_total_stock + $branches_current_stock;
                
                return view('cms.shop_admin.produts.adjust_products_stock', compact('wing', 'product_info', 'tracking_summery', 'branch_stock'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    


}
