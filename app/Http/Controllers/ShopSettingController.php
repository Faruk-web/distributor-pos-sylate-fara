<?php

namespace App\Http\Controllers;

use App\Models\Shop_setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Tutorial;



class ShopSettingController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        if(User::checkPermission('admin.setting') == true) {
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $shop_info = shop_setting::where('shop_code', $shop_id)->first();
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id', 'branch_name', 'branch_address']);
            return view('cms.shop_admin.shop_setting', compact('shop_info', 'branches', 'wing'));
        }
        else{
            return Redirect()->back()->with('error', 'Sorry you can not access this page.');
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
        if(User::checkPermission('admin.setting') == true) {   
            $data = array();
            $shop_id = Auth::user()->shop_id;
            $shop_info = shop_setting::where('shop_code', $shop_id)->first();

            $logo = $request->file('shop_logo');
            if($logo){
                $name_gen = hexdec(uniqid()).".".$logo->getClientOriginalExtension();
                Image::make($logo)->resize(205, 65)->save('images/'.$name_gen);
                $last_img = 'images/'.$name_gen;
                $data['shop_logo'] = $last_img;
                if($shop_info->shop_logo && is_file(public_path($shop_info->shop_logo))){
                    unlink($shop_info->shop_logo);
                }
            }

            $data['shop_name'] = $request->shop_name;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['address'] = $request->address;
            $data['default_branch_id_for_sell'] = $request->default_branch_id_for_sell;
            $data['shop_website'] = $request->shop_website;
            $data['vat_type'] = $request->vat_type;
            
            if($shop_info != '[]') {
                DB::table('shop_settings')->where('shop_code', $shop_id)->update($data);
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Shop Setting Updated', 'created_at' => Carbon::now()]);
                return Redirect()->back()->with('success', 'Setting Updated Successfully');
            }
            else {
                // $data['created_at'] = Carbon::now();
                // $data['start_date'] = date('Y-m-d');
                // $data['shop_admin_id'] = $shop_id;
                // DB::table('shop_settings')->insert($data);
                // return Redirect()->back()->with('success', 'Setting Updated Successfully');
            }

        }
        else{
            return Redirect()->back()->with('error', 'Sorry you can not access this page.');
        }
        
        
    }

    public function admin_set_customer_points(Request $request) {
        if(User::checkPermission('admin.setting') == true) {   
            $data = array();
            $shop_id = Auth::user()->shop_id;
            $data['is_active_customer_points'] = $request->is_active_customer_points;
            $data['point_earn_rate'] = $request->point_earn_rate;
            $data['point_redeem_rate'] = $request->point_redeem_rate;
            $data['minimum_purchase_to_get_point'] = $request->minimum_purchase_to_get_point;
            DB::table('shop_settings')->where('shop_code', $shop_id)->update($data);
            return Redirect()->back()->with('success', 'Customer Points Settings Updated Successfully');
            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Shop Setting( Use Customer Points ) Updated', 'created_at' => Carbon::now()]);

        }
        else{
            return Redirect()->back()->with('error', 'Sorry you can not access this page.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shop_setting  $shop_setting
     * @return \Illuminate\Http\Response
     */
    public function show(shop_setting $shop_setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\shop_setting  $shop_setting
     * @return \Illuminate\Http\Response
     */
    public function edit(shop_setting $shop_setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shop_setting  $shop_setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, shop_setting $shop_setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shop_setting  $shop_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(shop_setting $shop_setting)
    {
        //
    }
    
    public function shop_login($code) {
        $shop_info = DB::table('shop_settings')->where('shop_code', $code)->first();
        if(!empty($shop_info->id)) {
            return view('auth.shop_login', compact('shop_info'));
        }
        else {
            return Redirect()->back();
        }
    }
    
    public function shop_admin_tutorials() {
        $tutorial = Tutorial::orderby('active', 'asc')->get();
        $wing = 'main';
        return view('cms.shop_admin.shop_tutorials', compact('tutorial', 'wing'));
    }
    
}
