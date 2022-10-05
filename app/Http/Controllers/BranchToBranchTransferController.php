<?php

namespace App\Http\Controllers;

use App\Models\BranchToBranchTransfer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch_setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BranchToBranchTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product_text" onclick="myFunction(\''.$product->id.'\', \''.$product->pid.'\', \''.$product->variation_id.'\', \''.$variation_title.'\', \''.$product->purchase_line_id.'\', \''.$product->lot_number.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->sales_price.'\', \''.$product->vat.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$product->stock.'\', \''.optional($unit_type_info)->unit_name.'\', \''.optional($product)->cartoon_quantity.'\', \''.optional($product)->cartoon_amount.'\')" title="Add me">
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
        //
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
