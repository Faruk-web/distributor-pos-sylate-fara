<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Shop_setting;
use DataTables;
use Mail;
use App\Mail\OrderMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    
    public function send_mail() {
        $invoice_id = 'S_20921605_6_118';
        //Mail::send(new OrderMail($invoice_id));
    }
    
    //Begin:: Dashboard
    public function Dashboard() {
        $user = Auth::user();
        if($user->active == 1) {
            $wing = 'main';
            return view('cms.dashboard', compact('user', 'wing'));
        }
        else {
            DB::table('moments_traffics')->insert(['shop_id' => $user->shop_id, 'user_id' => $user->id, 'info' => 'Want to logged in, but due to deactivation can not logged in.', 'created_at' => Carbon::now()]);
            return view('welcome');
        }
    }
    //End:: Dashboard

    //Begin:: Supplier Dashboard
    public function supplierDashboard() {
        $user = Auth::user();
        if($user->active == 1) {
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.dashboard.index', compact('user', 'wing'));
        }
        else {
            return view('welcome');
        }
    }
    //End:: Supplier Dashboard

    //Begin:: Godown Dashboard
    public function godownDashboard() {
        $user = Auth::user();
        if($user->active == 1) {
            $wing = 'godown';
            return view('cms.shop_admin.godown.dashboard.index', compact('user', 'wing'));
        }
        else {
            return view('welcome');
        }
    }
    //End:: Godown Dashboard

    //Begin:: Account & transaction Dashboard
    public function account_transaction_Dashboard() {
        $user = Auth::user();
        if($user->active == 1) {
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.dashboard.index', compact('user', 'wing'));
        }
        else {
            return view('welcome');
        }
    }
    //End:: Account & transaction Dashboard
    
    //Begin:: Account & transaction Dashboard
    public function support() {
        $user = Auth::user();
        if($user->active == 1) {
            $wing = 'main';
            return view('cms.support', compact('user', 'wing'));
        }
        else {
            return view('welcome');
        }
    }
    //End:: Account & transaction Dashboard
    
    

    
    //Begin:: Admin helper role and permission
    public function Admin_helper_role_and_permission() {
        if(User::checkPermission('admin.helper.role.permission') == true){
            $wing = 'main';
            $shop_id =  Auth::user()->shop_id;
            $roles = DB::table('roles')->where('shop_id', $shop_id)->where('which_roll', 'admin')->get();
            return view('cms.shop_admin.shop_roles', compact('roles', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Admin helper role and permission

    //Begin:: Admin Create helper role
    public function Admin_Create_helper_role(Request $request) {
        if(User::checkPermission('admin.helper.role.permission') == true){
            
            $role_name = Auth::user()->shop_id.'#'.$request->name;
            $check = DB::table('roles')->where('name', $role_name)->first();
            if(!empty($check->id)) {
                Alert::warning('Warning', 'This role is already exist!');
                return Redirect()->back();
            }
            else {
                $data = array();
                $data['name'] = $role_name;
                $data['which_roll'] = 'admin';
                $data['guard_name'] = 'web';
                $data['shop_id'] = Auth::user()->shop_id;
                $data['created_at'] = Carbon::now();

                $insert = DB::table('roles')->insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Admin Helper Role(role name: '.$request->name.')', 'created_at' => Carbon::now()]);
                    return Redirect()->back()->with('success', 'New role has been created.');
                }
                else {
                    return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
                }
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
        
    }
    //Begin:: Admin Create helper role

    //Begin:: Edit Admin helper role
    public function Edit_Admin_helper_role($id) {
        if(User::checkPermission('admin.helper.role.permission') == true){

            $role_info = DB::table('roles')->where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            if(!empty($role_info->id)) {
                $wing = 'main';
                return view('cms.shop_admin.edit_role', compact('role_info', 'wing'));
            }
            else {
                Alert::warning('Warning', 'Sorry! You can not access this role');
                return Redirect()->back();

            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
        
    }
    //Begin:: Edit Admin helper role

    //Begin:: Update Admin helper role
    public function Update_Admin_helper_role(Request $request, $id) {
        if(User::checkPermission('admin.helper.role.permission') == true){
            $role_name = Auth::user()->shop_id.'#'.$request->name;
            $check = DB::table('roles')->where('name', $role_name)->first();
            if(!empty($check->id)) {
                return Redirect()->back()->with('error', 'Sorry, This role is already exist!');
            }
            else {
                $data = array();
                $data['name'] = $role_name;
                $data['updated_at'] = Carbon::now();
                $update = DB::table('roles')->where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Admin Helper Role(role name: '.$request->name.')', 'created_at' => Carbon::now()]);
                    return Redirect()->route('admin.helper_role_permission')->with('success', 'Role has benn Updated.');
                }
                else {
                    return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
                }
                
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
        
    }
    //End:: Update Admin helper role

    //Begin:: Update Admin helper role Permission
    public function admin_helper_permission($id) {
        if(User::checkPermission('admin.helper.role.permission') == true){
            $role = Role::findById($id);
            $permissions = Permission::all();
            $permissionGroups = User::getPermissionGroupsForAdminHealperRole();
            $wing = 'main';
            return view('cms.shop_admin.admin_helper_role_permission', compact('permissions', 'permissionGroups', 'role', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Update Admin helper role Permission

    //Begin:: Set Permission to admin helper role
    public function set_permission_to_admin_helper_role() {
        $role_id = $_GET['roleID'];
        $permission_id = $_GET['permission_id'];
        
        $check = DB::table('role_has_permissions')->where('role_id', $role_id)->where('permission_id', $permission_id)->first();
        if(empty($check->role_id)) {
            $data = array();
            $data['role_id'] = $role_id;
            $data['permission_id'] = $permission_id;

            $insert = DB::table('role_has_permissions')->insert($data);

            if($insert) {
                \Artisan::call('permission:cache-reset');
                $sts = [
                    'status' => 'yes',
                    'reason' => 'Permission set successfully'
                ];
                return response()->json($sts);
            }
            else {
                $sts = [
                    'status' => 'no',
                    'reason' => 'Something is wrong, please try again.'
                ];
                return response()->json($sts);
            }
            
        }
        else {
            $sts = [
                'status' => 'no',
                'reason' => 'Permission is already exist, Please try another.'
            ];
            return response()->json($sts);
        }
        
    }
    //End:: Set Permission to admin helper role

    //Begin:: Delete Permission from role
    public function delete_permission_from_role() {
        $role_id = $_GET['roleID'];
        $permission_id = $_GET['permission_id'];
        
        $check = DB::table('role_has_permissions')->where('role_id', $role_id)->where('permission_id', $permission_id)->first();
        if(!empty($check->role_id)) {
            
            $delete = DB::table('role_has_permissions')->where('role_id', $role_id)->where('permission_id', $permission_id)->delete();
            if($delete) {
                \Artisan::call('permission:cache-reset');
                $sts = [
                    'status' => 'yes',
                    'reason' => 'Permission Delete successfully'
                ];
                return response()->json($sts);
            }
            else {
                $sts = [
                    'status' => 'no',
                    'reason' => 'Something is wrong, please try again.'
                ];
                return response()->json($sts);
            }
            
        }
        else {
            $sts = [
                'status' => 'no',
                'reason' => 'Permission is not exist, Please try another.'
            ];
            return response()->json($sts);
        }
        
    }
    //End:: Delete Permission from role


    //Begin:: pending shop owner shop owner 
    public function pending_shop() {
        if(Auth::user()->type == 'super_admin') {
            $pending_shop = User::where(['type'=>'owner', 'active'=>0])->orderBy('id', 'desc')->get();
            return view('cms.super_admin.pending_shop', compact('pending_shop'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function pending_shop_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'super_admin') {
            $shop_info = User::where(['type'=>'owner', 'active'=>0])->orderBy('id', 'desc')->get();
            return Datatables::of($shop_info)
                ->addIndexColumn()
                ->addColumn('shop_name', function($row){
                    return optional($row->shop_info)->shop_name;
                })
                ->addColumn('shop_code', function($row){
                    return optional($row->shop_info)->shop_code;
                })
                ->addColumn('renew_date', function($row){
                    $renew_date = optional($row->shop_info)->renew_date;
                    $renew_date_str = strtotime($renew_date);
                    $today = strtotime(date("Y-m-d"));
                    
                    if($today <= $renew_date_str && !empty($renew_date)) {
                        return date("d M, Y", strtotime($renew_date));
                    }
                    else if(empty($renew_date)) {
                        return '<b id="re_days">Renew Date Not Set</b>.';   
                    }
                    else {
                        return 'Expired in <b id="re_days">'.date("d M, Y", strtotime($renew_date)).'</b>.';   
                    }
                    
                })
                ->addColumn('action', function($row){
                    return '<a href="'.route('super.admin.activate.shop', ['user_id'=>optional($row)->id]).'" class="btn btn-rounded btn-success btn-sm">active</a> <a target="_blank" href="'.route('super.admin.shop.info', ['shop_id'=>optional($row->shop_info)->shop_code]).'" class="btn btn-rounded btn-info btn-sm">Info</a>';
                })
                
                ->rawColumns(['action', 'user_name', 'shop_name', 'shop_code', 'renew_date'])
                ->make(true);
        }
    }
    
    //End:: Pending shop owner 

    //Begin:: Pending to active Shop owner
    public function active_shop_owner($user_id) {
        if(Auth::user()->type == 'super_admin') {
            $user_info = User::where(['id'=>$user_id, 'active'=>0])->first();
            $active = User::where('shop_id', $user_info->shop_id)->update(['active'=>1]);
            if($active) {
                return Redirect()->route('super_admin.active.shop')->with('success', 'Shop and all user active successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //Begin:: Pending to active Shop owner

    //Begin:: Active shops
    public function active_shop() {
        if(Auth::user()->type == 'super_admin') {
            $actove_shop = User::where(['type'=>'owner', 'active'=>1])->orderBy('id', 'desc')->get();
            return view('cms.super_admin.active_shop', compact('actove_shop'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function active_shop_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'super_admin') {
            $shop_info = User::where(['type'=>'owner', 'active'=>1])->orderBy('id', 'desc')->get();
            return Datatables::of($shop_info)
                ->addIndexColumn()
                ->addColumn('shop_name', function($row){
                    return optional($row->shop_info)->shop_name;
                })
                ->addColumn('shop_code', function($row){
                    return optional($row->shop_info)->shop_code;
                })
                ->addColumn('renew_date', function($row){
                    $renew_date = optional($row->shop_info)->renew_date;
                    $renew_date_str = strtotime($renew_date);
                    $today = strtotime(date("Y-m-d"));
                    
                    if($today <= $renew_date_str && !empty($renew_date)) {
                        return date("d M, Y", strtotime($renew_date));
                    }
                    else if(empty($renew_date)) {
                        return '<b id="re_days">Renew Date Not Set</b>.';   
                    }
                    else {
                        return 'Expired in <b id="re_days">'.date("d M, Y", strtotime($renew_date)).'</b>.';   
                    }
                    
                })
                ->addColumn('action', function($row){
                    return '<a href="'.route('super.admin.deactive.shop', ['user_id'=>optional($row)->id]).'" class="btn btn-rounded btn-danger btn-sm">Deactive</a> <a target="_blank" href="'.route('super.admin.shop.info', ['shop_id'=>optional($row->shop_info)->shop_code]).'" class="btn btn-rounded btn-success btn-sm">Info</a>';
                })
                
                ->rawColumns(['action', 'user_name', 'shop_name', 'shop_code', 'renew_date'])
                ->make(true);
        }
    }
    
    
    //End:: Active shops

    //Begin:: Pending to active Shop owner
    public function deactive_shop_owner($user_id) {
        if(Auth::user()->type == 'super_admin') {
            $user_info = User::where(['id'=>$user_id, 'active'=>1])->first();
            $active = User::where('shop_id', $user_info->shop_id)->update(['active'=>0]);
            if($active) {
                return Redirect()->route('super_admin.pending.shop')->with('success', 'Shop and all user Deactive successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Pending to active Shop owner
    
    //Begin:: Shop Info
    public function super_admin_shop_info($shop_id){
        if(Auth::user()->type == 'super_admin') {
            $shop_info = Shop_setting::where('shop_code', $shop_id)->first();
            if(!empty(optional($shop_info)->id)) {
                return view('cms.super_admin.shop_info', compact('shop_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End::Shop Info
    
    
    
    

    //Begin:: my moments
    public function my_moments() {
        if(!empty(Auth::user()->shop_id)) {
            $wing = 'main';
            return view('cms.mymoments', compact('wing'));
        }
    }

    public function my_moments_date(Request $request)
    {
        if ($request->ajax()) {
            $moments = DB::table('moments_traffics')->where(['shop_id'=>Auth::user()->shop_id, 'user_id'=>Auth::user()->id])->orderBy('id', 'desc')->get(['created_at', 'info']);
            return Datatables::of($moments)
                ->addIndexColumn()
                ->addColumn('date', function($row){
                    return date('d-m-Y', strtotime(optional($row)->created_at));
                })
                ->rawColumns(['date'])
                ->make(true);
        }
    }
    //End: my moments

    

    //Begin:: Super Admin Resellers
    public function resellers() {
        if(Auth::user()->type == 'super_admin') {
            return view('cms.super_admin.resellers');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function resellers_data(Request $request)
    {
        if ($request->ajax() && Auth::user()->type == 'super_admin') {
            $user = DB::table('users')->where(['type'=>'reseller'])->orderBy('id', 'desc')->get();
            return Datatables::of($user)
                ->addIndexColumn()
                ->addColumn('active_status', function($row){
                    if($row->active == 1) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                    else {
                        return '<span class="badge badge-danger">Deactive</span>';  
                    }
                })
                ->addColumn('action', function($row){
                    return '<a href="'.route('super.admin.edit.reseller', ['id'=>optional($row)->id]).'" class="btn btn-rounded btn-primary btn-sm">Edit</a> <a target="_blank" href="'.route('super.admin.activate.shop', ['user_id'=>optional($row)->id]).'" class="btn btn-rounded btn-success btn-sm">Info</a>';
                })
                
                ->rawColumns(['action', 'active_status'])
                ->make(true);
        }
        
        
    }
    
    public function resellers_store(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);
        
        $data = array();
            $data['shop_id']='1111';
            $data['name']=$request->name;
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $data['type']='reseller';
            $data['active']= 1;
            $data['password']=Hash::make($request->password);

            $insert = DB::table('users')->insert($data);

            if($insert) {
                Alert::success('Success', 'Reseller Added Successfully.');
                return redirect()->back();
            }
            else {
                Alert::error('Error', 'Error occurred! Please try again.');
                return redirect()->back();
            }
    }
    
    

    public function edit_reseller($id) {
        if(Auth::user()->type == 'super_admin') {
            $user_info = DB::table('users')->where(['type'=>'reseller', 'id'=>$id])->first();
            return view('cms.super_admin.edit_reseller', compact('user_info'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function update_reseller(Request $request, $id) {
        if(Auth::user()->type == 'super_admin') {
            $validated = $request->validate([
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required|unique:users,phone,'.$id,
                'email' => 'required|unique:users,email,'.$id,
            ]);
            
            $data = array();
            if(!empty($request->password)) {
                $data['password']=Hash::make($request->password);
            }
            
            $data['name']=$request->name;
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $data['active']= $request->active;
            
            $update = DB::table('users')->where('id', $id)->update($data);
    
            if($update) {
                Alert::success('Success', 'Reseller Update Successfully.');
                return redirect()->route('super_admin.all.reseller');
            }
            else {
                Alert::error('Error', 'Error occurred! Please try again.');
                return redirect()->back();
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function registration_form_reseller(Request $request) {
        $id = $request->retoken;
        $user = User::where('id', $id)->first();
        if(optional($user)->type == 'reseller') {
            Session::put('referral_id', $user->id);
            return view('cms.super_admin.reseller.registration');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry wrong information!');
        }
    }
    
    
    //Begin::Reseller pending shop
    public function reseller_pending_shop() {
        if(Auth::user()->type == 'reseller') {
            return view('cms.super_admin.reseller.pending_shop');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function reseller_pending_shop_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'reseller') {
            $shop_info = DB::table('users')->join('shop_settings', 'users.shop_id', '=', 'shop_settings.shop_code')->where(['users.type'=>'owner', 'users.active'=>0])->where('shop_settings.reseller_id', Auth::user()->id)->select('users.*', 'shop_settings.shop_code', 'shop_settings.shop_name', 'shop_settings.renew_date')->orderBy('users.id', 'desc')->get();
            return Datatables::of($shop_info)
                ->addIndexColumn()
                ->addColumn('shop_name', function($row){
                    return optional($row)->shop_name;
                })
                ->addColumn('shop_code', function($row){
                    return optional($row)->shop_code;
                })
                ->addColumn('renew_date', function($row){
                    $renew_date = optional($row)->renew_date;
                    $renew_date_str = strtotime($renew_date);
                    $today = strtotime(date("Y-m-d"));
                    
                    if($today <= $renew_date_str && !empty($renew_date)) {
                        return date("d M, Y", strtotime($renew_date));
                    }
                    else if(empty($renew_date)) {
                        return '<b id="re_days">Renew Date Not Set</b>.';   
                    }
                    else {
                        return 'Expired in <b id="re_days">'.date("d M, Y", strtotime($renew_date)).'</b>.';   
                    }
                    
                })
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('reseller.shop.info', ['shop_id'=>optional($row)->shop_code]).'" class="btn btn-rounded btn-info btn-sm">Info</a>';
                })
                
                ->rawColumns(['action', 'user_name', 'shop_name', 'shop_code', 'renew_date'])
                ->make(true);
        }
    }
    
    //End:: Reseller Pending shop 
    
    //Begin::Reseller Active shop
    public function reseller_active_shop() {
        if(Auth::user()->type == 'reseller') {
            return view('cms.super_admin.reseller.active_shop');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function reseller_active_shop_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'reseller') {
            $shop_info = DB::table('users')->join('shop_settings', 'users.shop_id', '=', 'shop_settings.shop_code')->where(['users.type'=>'owner', 'users.active'=>1])->where('shop_settings.reseller_id', Auth::user()->id)->select('users.*', 'shop_settings.shop_code', 'shop_settings.shop_name', 'shop_settings.renew_date')->orderBy('users.id', 'desc')->get();
            return Datatables::of($shop_info)
                ->addIndexColumn()
                ->addColumn('shop_name', function($row){
                    return optional($row)->shop_name;
                })
                ->addColumn('shop_code', function($row){
                    return optional($row)->shop_code;
                })
                ->addColumn('renew_date', function($row){
                    $renew_date = optional($row)->renew_date;
                    $renew_date_str = strtotime($renew_date);
                    $today = strtotime(date("Y-m-d"));
                    
                    if($today <= $renew_date_str && !empty($renew_date)) {
                        return date("d M, Y", strtotime($renew_date));
                    }
                    else if(empty($renew_date)) {
                        return '<b id="re_days">Renew Date Not Set</b>.';   
                    }
                    else {
                        return 'Expired in <b id="re_days">'.date("d M, Y", strtotime($renew_date)).'</b>.';   
                    }
                    
                })
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('reseller.shop.info', ['shop_id'=>optional($row)->shop_code]).'" class="btn btn-rounded btn-info btn-sm">Info</a>';
                })
                
                ->rawColumns(['action', 'user_name', 'shop_name', 'shop_code', 'renew_date'])
                ->make(true);
        }
    }
    
    //End:: Reseller Pending shop 
    
    
    
    
    //Begin:: Reseller Shop Info
    public function reseller_shop_info($shop_id){
        if(Auth::user()->type == 'reseller') {
            $shop_info = Shop_setting::where('shop_code', $shop_id)->where('reseller_id', Auth::user()->id)->first();
            if(!empty(optional($shop_info)->id)) {
                return view('cms.super_admin.reseller.shop_info', compact('shop_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Reseller Shop Info
    
    

    

    















}
