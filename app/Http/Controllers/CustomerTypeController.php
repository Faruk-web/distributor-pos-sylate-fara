<?php

namespace App\Http\Controllers;

use App\Models\CustomerType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class CustomerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('others.customers') == true){
            $wing = 'main';
            $CustomerTypes = CustomerType::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->paginate(300);
            return view('cms.shop_admin.customers.customer_types', compact('CustomerTypes', 'wing'));
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
        if(User::checkPermission('others.customers') == true){
            $validate = CustomerType::where('type_name', $request->type_name)->where('shop_id', Auth::user()->shop_id)->first();
            if(!empty($validate->id)) {
                return Redirect()->back()->with('error', 'Sorry this Type Name is exist, please try again');
            }
            else {
                $data = array();
                $data['shop_id'] = Auth::user()->shop_id;
                $data['type_name'] = $request->type_name;
                $data['active'] = 1;
                $data['created_at'] = Carbon::now();
                $insert = DB::table('customer_types')->insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Customer Type(Type name: '.$request->type_name.')', 'created_at' => Carbon::now()]);
                    return redirect()->back()->with('success', 'New Brand has been created.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
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
     * @param  \App\Models\CustomerType  $customerType
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerType $customerType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomerType  $customerType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('others.customers') == true){
            $wing = 'main';
            $customer_type = CustomerType::where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            return view('cms.shop_admin.customers.edit_customer_types', compact('customer_type', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomerType  $customerType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('others.customers') == true){
            $data = array();
            $data['type_name'] = $request->type_name;
            $data['updated_at'] = Carbon::now();
            
            $update = CustomerType::where('id', $id)->update($data);
            if($update) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Customer Type(Type name: '.$request->type_name.')', 'created_at' => Carbon::now()]);
                return Redirect()->route('admin.all.customer.types')->with('success', 'Customer Type has been Updated.');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomerType  $customerType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerType $customerType)
    {
        //
    }

    public function deactiveCustomer_type($id) {
        
        $Q = CustomerType::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update(['active' => 0]);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Deactive Product Brand', 'created_at' => Carbon::now()]);
            return redirect()->back()->with('success', 'Customer Type Deactive Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    public function active_customer_type($id) {
        $Q = CustomerType::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update(['active' => 1]);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Deactive Product Brand', 'created_at' => Carbon::now()]);
            return redirect()->back()->with('success', 'Customer Type Activate Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }


}
