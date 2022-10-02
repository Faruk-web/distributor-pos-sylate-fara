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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DeliveryManController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.deliveryman') == true){
            $wing = 'main';
            $shop_id =  Auth::user()->shop_id;
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id','branch_name']);
            $delivery_mans = User::where('shop_id', $shop_id)->where('type', 'delivery_man')->get();
            return view('cms.shop_admin.deliveryman.all_delivery_man', compact('delivery_mans', 'wing', 'branches'));
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
        if(User::checkPermission('admin.deliveryman') == true){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|unique:users',
                'email' => 'required|unique:users',
                'password' => 'required|confirmed|min:8',
                
            ]);
        
            if ($validator->fails()) {
                Alert::error('Error', 'Error occurred!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = array();
            $data['shop_id']= Auth::user()->shop_id;
            $data['name']=$request->name;
            $data['branch_id']=$request->branch_id;
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $data['type']='delivery_man';
            $data['active']= 1;
            $data['password']=Hash::make($request->password);

            $insert = DB::table('users')->insert($data);

            if($insert) {
                return Redirect()->back()->with('success', 'Deliveryman or system added successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Error occurred! Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('admin.deliveryman') == true){
            $wing = 'main';
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id','branch_name']);
            $user_info = DB::table('users')->where(['id'=>$id, 'shop_id'=>Auth::user()->shop_id])->first();
            return view('cms.shop_admin.deliveryman.edit_delivery_man', compact('user_info', 'branches', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('admin.deliveryman') == true){
            $crm_info = User::find($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|unique:users,phone,'.$crm_info->id,
                'email' => 'required|max:255|unique:users,email,'.$crm_info->id,
                
            ]);
        
            if ($validator->fails()) {
                Alert::error('Error', 'Error occurred!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = array();
            $data['name']=$request->name;
            $data['branch_id']= $request->branch_id;
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $update_crm = User::where('id', $id)->update($data);

            if($update_crm) {
                return Redirect()->route('admin.all.deliveryman')->with('success', 'Deliveryman or system Update successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Error occurred! Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //Begin:: Deactive Delivery man
    public function deactiveDeliveryMan($id) {
        if(User::checkPermission('admin.deliveryman') == true){
            $Q = User::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update(['active'=>0]);
            if($Q) {
                Alert::success('Success', 'Deliveryman or system Deactive Successfully.');
                return redirect()->back();
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
    //End:: Deactive Delivery man

    //Begin:: active Delivery man
    public function activeDeliveryMan($id) {
        if(User::checkPermission('admin.deliveryman') == true){
            $Q = User::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update(['active'=>1]);
            if($Q) {
                Alert::success('Success', 'Deliveryman or system Active Successfully.');
                return redirect()->back();
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
    //End:: active Delivery man

    


}
