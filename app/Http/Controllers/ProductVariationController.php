<?php

namespace App\Http\Controllers;

use App\Models\ProductVariation;
use App\Models\VariationList;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Auth;

class ProductVariationController extends Controller
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
            $shop_id = Auth::user()->shop_id;
            $variations = ProductVariation::where('shop_id', $shop_id)->orderBy('id', 'DESC')->get();
            return view('cms.shop_admin.produts.variations', compact('wing', 'variations'));
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
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $variation = ProductVariation::where('shop_id', $shop_id)->where('title', $request->title)->first();
            if(is_null($variation)) {
                $variation = new ProductVariation;
                $variation->shop_id = $shop_id;
                $variation->title = $request->title;
                $variation->save();
                return Redirect()->route('admin.product.variations')->with('success', 'New Variation Head is added.');
            }
            else {
                return Redirect()->back()->with('error', 'This Head is already exist!!!');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function store_variation_item(Request $request)
    {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $variation_item = VariationList::where(['shop_id'=> $shop_id, 'list_title'=>$request->list_title])->first();
            if(is_null($variation_item)) {
                $variation_item = new VariationList;
                $variation_item->shop_id = $shop_id;
                $variation_item->variation_id = $request->variation_id;
                $variation_item->list_title = $request->list_title;
                $variation_item->save();
                return Redirect()->route('admin.product.variations')->with('success', 'New Variation Item is added.');
            }
            else {
                return Redirect()->back()->with('error', 'This Variation Item is already exist!!!');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariation $productVariation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $variation_info = ProductVariation::where('shop_id', $shop_id)->where('id', $id)->first();
            if(!is_null($variation_info)) {
                return view('cms.shop_admin.produts.edit_variations', compact('wing', 'variation_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page!!!');
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
     * @param  \App\Models\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $check = ProductVariation::where('shop_id', $shop_id)->where('title', $request->title)->where('id', '!=', $id)->first();
            if(is_null($check)) {
                $variation_info = ProductVariation::where('shop_id', $shop_id)->where('id', $id)->first();
                $variation_info->title = $request->title;
                $variation_info->is_active = $request->is_active;
                $variation_info->update();
                return Redirect()->route('admin.product.variations')->with('success', 'Variation Updated.');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry VARIATION is exist!!!');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    public function edit_item($id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $variation_item_info = VariationList::where('shop_id', $shop_id)->where('id', $id)->first();
            if(!is_null($variation_item_info)) {
                return view('cms.shop_admin.produts.edit_variation_item', compact('wing', 'variation_item_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page!!!');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function update_item(Request $request, $id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $check = VariationList::where('shop_id', $shop_id)->where('list_title', $request->list_title)->where('id', '!=', $id)->first();
            if(is_null($check)) {
                $variation_item_info = VariationList::where('shop_id', $shop_id)->where('id', $id)->first();
                $variation_item_info->list_title = $request->list_title;
                $variation_item_info->is_active = $request->is_active;
                $variation_item_info->update();
                return Redirect()->route('admin.product.variations')->with('success', 'Variation Item Updated.');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry VARIATION Item is exist!!!');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductVariation  $productVariation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariation $productVariation)
    {
        //
    }
}
