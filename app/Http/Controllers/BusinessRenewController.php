<?php

namespace App\Http\Controllers;

use App\Models\BusinessRenew;
use App\Models\Shop_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BusinessRenewController extends Controller
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
        if(Auth::user()->type == 'super_admin') {
            $shop_id = $request->shop_id;
            $shop_info = Shop_setting::where('shop_code', $shop_id)->first();
            if(!empty($request->renew_date) && !empty($shop_info->id)) {
                $insert = BusinessRenew::insert(['shop_id'=>$shop_id, 'renew_by'=>Auth::user()->id, 'renew_date'=>$request->renew_date, 'created_at'=>Carbon::now()]);
                if($insert) {
                    Shop_setting::where('shop_code', $shop_id)->update(['renew_date'=>$request->renew_date]);
                    return Redirect()->back()->with('success', 'Successfully Set Renew Date.');
                }
                else {
                    return Redirect()->back()->with('error', 'Error occoured, please try again.');
                }
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BusinessRenew  $businessRenew
     * @return \Illuminate\Http\Response
     */
    public function show(BusinessRenew $businessRenew)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BusinessRenew  $businessRenew
     * @return \Illuminate\Http\Response
     */
    public function edit(BusinessRenew $businessRenew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BusinessRenew  $businessRenew
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BusinessRenew $businessRenew)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BusinessRenew  $businessRenew
     * @return \Illuminate\Http\Response
     */
    public function destroy(BusinessRenew $businessRenew)
    {
        //
    }
}
