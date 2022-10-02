<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Area;
use Illuminate\Support\Carbon;
use DataTables;


class crmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.crm') == true){  
            $wing = 'main';
            $roles = DB::table('roles')->where('shop_id', Auth::user()->shop_id)->get();
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id','branch_name']);

            $crms = DB::table('users')
                    ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                    ->select('users.*', 'model_has_roles.role_id')
                    ->where('users.shop_id', Auth::user()->shop_id)
                    ->where('users.type', '!=', 'owner')
                    ->get();
            
            return view('cms.shop_admin.crm.all_crm', compact('crms', 'roles', 'branches', 'wing'));
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
        if(User::checkPermission('admin.crm') == true){
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
            $data['type']=$request->type;
            $data['active']= 1;
            $data['password']=Hash::make($request->password);

            $insert = DB::table('users')->insert($data);

            if($insert) {
                $findUser = User::where('phone', $request->phone)->first();
                $role_data = array();
                $role_data['role_id'] = ($request->type == 'branch_user') ? $request->role_id : $request->admin_helper_role;
                $role_data['model_type'] = 'App\Models\User';
                $role_data['model_id'] = $findUser->id;
                $insert_role = DB::table('model_has_roles')->insert($role_data);

                if($insert_role) {
                    Alert::success('Success', 'CRM Added Successfully.');
                    return redirect()->back();
                }
                else {
                    Alert::error('Error', 'Error occurred! Please try again.');
                    return redirect()->back();
                }
                
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
    
    public function reset_crm_password(Request $request)
    {
        if(User::checkPermission('admin.crm') == true){
            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:8',
                
            ]);
        
            if ($validator->fails()) {
                Alert::error('Error', 'Error occurred!');
                return redirect()->back()->withErrors($validator)->withInput();
            }
            
            return Redirect()->back()->with('success', 'success');

            // $data = array();
            // $data['shop_id']= Auth::user()->shop_id;
            // $data['name']=$request->name;
            // $data['branch_id']=$request->branch_id;
            // $data['phone']=$request->phone;
            // $data['email']=$request->email;
            // $data['address']=$request->address;
            // $data['type']=$request->type;
            // $data['active']= 1;
            // $data['password']=Hash::make($request->password);

            // $insert = DB::table('users')->insert($data);

            // if($insert) {
                
                
            // }
            // else {
            //     return Redirect()->back()->with('error', 'Sorry you can not access this page');
            // }
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
        if(User::checkPermission('admin.crm') == true){
            $wing = 'main';
            $roles = DB::table('roles')->where('shop_id', Auth::user()->shop_id)->get();
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id','branch_name']);
            
            $user_info = DB::table('users')
                        ->join('model_has_roles', 'users.id', 'model_has_roles.model_id')
                        ->select('users.*', 'model_has_roles.role_id')
                        ->where('users.shop_id', Auth::user()->shop_id)
                        ->where('users.id', $id)
                        ->first();

            return view('cms.shop_admin.crm.edit_crm', compact('user_info', 'roles', 'branches', 'wing'));
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
        if(User::checkPermission('admin.crm') == true){
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
            $data['branch_id']= ($request->type == 'branch_user') ? $request->branch_id : null;
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $data['type']=$request->type;
            
            $update_crm = User::where('id', $id)->update($data);

            if($update_crm) {

                $role_data = array(
                    'role_id' => ($request->type == 'branch_user') ? $request->role_id : $request->admin_helper_role,
                );
                $update_role = DB::table('model_has_roles')->where('model_id', $id)->update($role_data);

                Alert::success('Success', 'CRM Update Successfully.');
                return redirect()->route('admin.crm');
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

    //Begin:: Deactive CRM
    public function DeactiveCRM($id) {
        if(User::checkPermission('admin.crm') == true){
            $data = array(
                'active' => 0,
            );
            $Q = User::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
            if($Q) {
                Alert::success('Success', 'CRM Deactive Successfully.');
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
    //End:: Deactive CRM

    //Begin:: Active CRM
    public function ActiveCRM($id) {
        if(User::checkPermission('admin.crm') == true){
            $data = array(
                'active' => 1,
            );

            $Q = User::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
            if($Q) {
                Alert::success('Success', 'CRM Active Successfully.');
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
    //End:: Active CRM

    // SR Start
    public function sr_index()
    {
        if(User::checkPermission('admin.sr') == true){  
            $wing = 'main';
            $areas = Area::all();
            return view('cms.shop_admin.sr.index', compact('areas', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function sr_store(Request $request)
    {
        if(User::checkPermission('admin.sr') == true){
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
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $data['sr_area_id']=$request->sr_area_id;
            $data['is_employee']=1;
            $data['email_verified_at']= Carbon::now();
            $data['type']='SR';
            $data['active']= 1;
            $data['password']=Hash::make($request->password);

            $insert = DB::table('users')->insert($data);

            if($insert) {
                Alert::success('Success', 'SR Added Successfully.');
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

    public function sr_index_data(Request $request) {
        if ($request->ajax()) {
            $area = User::orderBy('id', 'DESC')->Where('type', 'SR')->get();
            return Datatables::of($area)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('admin.edit.sr', ['id'=>$row->id]).'" class="btn btn-success btn-sm btn-rounded">edit</a>';
                })

                ->addColumn('area', function($row){
                    return optional(DB::table('areas')->where('id', $row->sr_area_id)->first())->name;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function sr_edit($id)
    {
        if(User::checkPermission('admin.sr') == true){
            $wing = 'main';
            $sr_info = User::find($id);
            if(is_null($sr_info)) {
                return Redirect()->back()->with('error', 'No SR found!!!');
            }
            $areas = Area::all();
            return view('cms.shop_admin.sr.edit', compact('sr_info', 'wing', 'areas'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function sr_update(Request $request, $id)
    {
        if(User::checkPermission('admin.sr') == true){
            $sr_info = User::find($id);
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => 'required|unique:users,phone,'.$sr_info->id,
                'email' => 'required|max:255|unique:users,email,'.$sr_info->id,
                
            ]);
        
            if ($validator->fails()) {
                Alert::error('Error', 'Error occurred!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = array();
            $data['name']=$request->name;
            $data['phone']=$request->phone;
            $data['email']=$request->email;
            $data['address']=$request->address;
            $data['sr_area_id']=$request->sr_area_id;
            
            $update_sr = User::where('id', $id)->update($data);

            if($update_sr) {
                Alert::success('Success', 'SR Info Update Successfully.');
                return redirect()->route('admin.all.sr');
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




    
}
