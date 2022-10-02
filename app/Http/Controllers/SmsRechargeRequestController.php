<?php

namespace App\Http\Controllers;

use App\Models\Sms_recharge_request;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Sms;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class SmsRechargeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.sms.panel') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $shop_settings = DB::table('shop_settings')->where('shop_code', $shop_id)->first(['sms_limit']);
            $sms_settings = DB::table('s_m_s_settings')->first(['non_masking_price']);
            $total_purchase = DB::table('sms_recharge_requests')->where(['shop_id'=>$shop_id, 'is_approved'=>'approved'])->sum('rechargeable_amount');
            $sms_histories = DB::table('sms_histories')->where('shop_id', $shop_id)->get(['created_at', 'id']);
            $total_sent = DB::table('sms_histories')->where('shop_id', $shop_id)->count('id');
            $yearly_sent = DB::table('sms_histories')->where('shop_id', $shop_id)->whereYear('created_at', Carbon::now()->year)->count('id');
            $monthly_sent = DB::table('sms_histories')->where('shop_id', $shop_id)->whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count('id');
            $daily_sent = DB::table('sms_histories')->where('shop_id', $shop_id)->whereDate('created_at', Carbon::today())->count('id');
            return view('cms.shop_admin.sms.dashboard', compact('wing', 'shop_settings', 'sms_settings', 'total_purchase', 'total_sent', 'yearly_sent', 'monthly_sent', 'daily_sent'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function shop_admin_recharge_requests_data(Request $request) {
        
        if ($request->ajax()) {
            $pending_requests = Sms_recharge_request::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($pending_requests)
                ->addIndexColumn()
                ->addColumn('user_name', function($row){
                    if($row->user_id == 'admin') {
                        return "Admin";
                    }
                    else {
                        return $row->user_info->name." [".$row->user_info->email."]";
                    }
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['user_name', 'date'])
                ->make(true);
        }
    }
    
    public function sms_settings()
    {
        if(User::checkPermission('admin.sms.panel') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $sms_settings = Sms::where('shop_id', $shop_id)->first();
            return view('cms.shop_admin.sms.settings', compact('wing', 'sms_settings'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function store_sms_settings(Request $request)
    {
        if(User::checkPermission('admin.sms.panel') == true){
            
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $sms_settings = Sms::where('shop_id', $shop_id)->first();
            
            if(is_null($sms_settings)) {
                $sms_settings = new Sms;
                $sms_settings->shop_id = $shop_id;
            }
            
            $sms_settings->message = $request->sms_text;
            $save_info = $sms_settings->save();
            if($save_info) {
                return Redirect()->route('admin.sms.settings')->with('success', 'SMS Method Saved Successfully!');
            }
            else {
                return Redirect()->back()->with('error', 'Error Occoured! Please Try Again.');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    
    
    
    
    public function pending_recharge_requests()
    {
        if(Auth::user()->type == 'super_admin') {
           return view('cms.super_admin.sms.pending_recharge_request');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function pending_recharge_requests_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'super_admin') {
            $pending_requests = Sms_recharge_request::where('is_approved', 'pending')->get();
            return Datatables::of($pending_requests)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('super.admin.change.sms.request.status', ['id'=>$row->id]).'" class="btn btn-primary btn-sm">action</a>';
                })
                ->addColumn('user_name', function($row){
                    if($row->user_id == 'admin') {
                        return "Admin";
                    }
                    else {
                        return $row->user_info->name." [".$row->user_info->email."]";
                    }
                })
                ->addColumn('shop_name', function($row){
                    return $row->shop_info->shop_name." [".$row->shop_info->shop_code."]";
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['action', 'user_name', 'shop_name', 'date'])
                ->make(true);
        }
    }
    
    public function approved_recharge_requests()
    {
        if(Auth::user()->type == 'super_admin') {
           return view('cms.super_admin.sms.approved_recharge_request');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function approved_recharge_requests_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'super_admin') {
            $requests = Sms_recharge_request::where('is_approved', 'approved')->orderBy('id', 'desc')->get();
            return Datatables::of($requests)
                ->addIndexColumn()
                ->addColumn('user_name', function($row){
                    if($row->user_id == 'admin') {
                        return "Admin";
                    }
                    else {
                        return $row->user_info->name." [".$row->user_info->email."]";
                    }
                })
                ->addColumn('shop_name', function($row){
                    return $row->shop_info->shop_name." [".$row->shop_info->shop_code."]";
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['action', 'user_name', 'shop_name', 'date'])
                ->make(true);
        }
    }
    
    
    public function super_admin_change_recharge_request_status($id) {
        if(Auth::user()->type == 'super_admin') {
           $info = Sms_recharge_request::where('id', $id)->first();
           return view('cms.super_admin.sms.change_pending_recharge_status', compact('info'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function super_admin_update_recharge_request_status(Request $request) {
        if(Auth::user()->type == 'super_admin') {
           $info = Sms_recharge_request::where('id', $request->rechargeable_amount_id)->first();
           if(!empty($info->id)) {
               if($info->is_approved != 'approved') {
                   $business_current_balance = $info->shop_info->sms_limit;
                   $update_balance = $business_current_balance + abs($info->rechargeable_amount);
                   $update_balace_q = DB::table('shop_settings')->where('shop_code', $info->shop_id)->update(['sms_limit'=>$update_balance]);
                   if($update_balace_q) {
                       $update_approved = Sms_recharge_request::where('id', $info->id)->update(['is_approved'=>'approved']);
                       if($update_approved) {
                           return Redirect()->route('super_admin.sms.approved.recharge.requests')->with('success', 'Recharge Request Approved Successfully');
                       }
                       else {
                           return Redirect()->back()->with('error', 'Sorry you can not access this page');
                       }
                   }
                   else {
                       return Redirect()->back()->with('error', 'Sorry you can not access this page');
                   }
               }
               else {
                   return Redirect()->back()->with('error', 'Sorry you can not access this page');
               }
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
        if(User::checkPermission('admin.sms.panel') == true){
            $per_sms_price = DB::table('s_m_s_settings')->first(['non_masking_price'])->non_masking_price;
            $data = array();
            $data['shop_id'] = Auth::user()->shop_id;
            $data['user_id'] = Auth::user()->id;
            $data['rechargeable_amount'] = $request->rechargeable_amount;
            $data['per_sms_price'] = $per_sms_price;
            $data['is_approved'] = 'pending';
            $data['created_at'] = Carbon::now();
            $insert = DB::table('sms_recharge_requests')->insert($data);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added SMS Recharge Request(Amount: '.$request->rechargeable_amount.')', 'created_at' => Carbon::now()]);
                return redirect()->back()->with('success', 'Request Sent Successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Something is wrong, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sms_recharge_request  $sms_recharge_request
     * @return \Illuminate\Http\Response
     */
    public function show(Sms_recharge_request $sms_recharge_request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sms_recharge_request  $sms_recharge_request
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms_recharge_request $sms_recharge_request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sms_recharge_request  $sms_recharge_request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms_recharge_request $sms_recharge_request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sms_recharge_request  $sms_recharge_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sms_recharge_request $sms_recharge_request)
    {
        //
    }
}
