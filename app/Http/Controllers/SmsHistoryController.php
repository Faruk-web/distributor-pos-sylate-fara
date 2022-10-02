<?php

namespace App\Http\Controllers;

use App\Models\Sms_history;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\SMS_settings;

class SmsHistoryController extends Controller
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
           return view('cms.shop_admin.sms.send_sms', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function customer_data(Request $request) {
        if ($request->ajax()) {
            $info = Customer::where(['shop_id'=>Auth::user()->shop_id, 'active' => 1])->orderBy('id', 'desc')->get(['name', 'id', 'phone']);
            return Datatables::of($info)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<button type="button" onclick="add_to_contact_store(\''.$row->name.'\',\''.$row->phone.'\')" class="btn btn-outline-primary btn-sm btn-rounded">Select</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function supplier_data(Request $request) {
        if ($request->ajax()) {
            $info = Supplier::where(['shop_id'=>Auth::user()->shop_id, 'active' => 1])->orderBy('id', 'desc')->get(['name', 'id', 'phone', 'company_name']);
            return Datatables::of($info)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<button type="button" onclick="add_to_contact_store(\''.$row->name.'\',\''.$row->phone.'\')" class="btn btn-outline-success btn-sm btn-rounded">Select</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function check_sms_count($sms_length) {
        
        $sms_count_number = $sms_length / 67;
        $sms_count = 1;
        if($sms_count_number > 15) {
            $sms_count = 16;
        }
        else if($sms_count_number > 14) {
            $sms_count = 15;
        }
        else if($sms_count_number > 13) {
            $sms_count = 14;
        }
        else if($sms_count_number > 12) {
            $sms_count = 13;
        }
        else if($sms_count_number > 11) {
            $sms_count = 12;
        }
        else if($sms_count_number > 10) {
            $sms_count = 11;
        }
        else if($sms_count_number > 9) {
            $sms_count = 10;
        }
        else if($sms_count_number > 8) {
            $sms_count = 9;
        }
        else if($sms_count_number > 7) {
            $sms_count = 8;
        }
        else if($sms_count_number > 6) {
            $sms_count = 7;
        }
        else if($sms_count_number > 5) {
            $sms_count = 6;
        }
        else if($sms_count_number > 4) {
            $sms_count = 5;
        }
        else if($sms_count_number > 3) {
            $sms_count = 4;
        }
        else if($sms_count_number > 2) {
            $sms_count = 3;
        }
        else if($sms_count_number > 1) {
            $sms_count = 2;
        }
        else if($sms_count_number > 0) {
            $sms_count = 1;
        }
        
        return $sms_count;
        
    }
    
    
    
    public function send_single_sms(Request $request) {
        if(User::checkPermission('admin.sms.panel') == true){
           $output = '';
           $contacts_output = '';
           $phones = $request->phone;
           $shop_id = Auth::user()->shop_id;
           
           if(!is_null($phones) ) {
               foreach($phones as $key => $phone) {
                   
                    $shop_settings = DB::table('shop_settings')->where('shop_code', $shop_id)->first(['sms_active_status', 'sms_limit', 'shop_name']);
                    $sms_settings = DB::table('s_m_s_settings')->first(['non_masking_price', 'masking_price']);
                    $sms_text = $request->sms_text;
                    $sms_length = strlen($sms_text);
                    $sms_count = $this->check_sms_count($sms_length);
                    $sms_cost = $sms_count * $sms_settings->non_masking_price;
                    
                    if($shop_settings->sms_limit >= $sms_cost) {
                        $msg = $sms_text;
                        $phone_num = $phone;
                        $send_sms = SMS_settings::send_sms($msg, $phone_num);
                        if($send_sms != '1002' || $send_sms != '1003' || $send_sms != '1004' || $send_sms != '1005' || $send_sms != '1006' || $send_sms != '1007' || $send_sms != '1008' || $send_sms != '1009' || $send_sms != '1010' || $send_sms != '1011' || $send_sms != '1012' || $send_sms != '1013' || $send_sms != '1014') {
                            $update_sms_balance = Auth::user()->shop_info->sms_limit - $sms_cost;
                            DB::table('shop_settings')->where('shop_code', $shop_id)->update(['sms_limit'=>$update_sms_balance]);
                            DB::table('sms_histories')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'length'=>$sms_length, 'sms_count'=>$sms_count, 'send_to'=>'custom', 'phone_number'=>$phone, 'info'=>$msg, 'created_at'=>Carbon::now()]);
                            
                            $contacts_output .= '<tr>
                                            <td>'.$phone.'</td>
                                            <td><span class="badge badge-success">Successfully Sent</span></td>
                                        </tr>';
                            
                        }
                        else {
                            $contacts_output .= '<tr>
                                            <td>'.$phone.'</td>
                                            <td><span class="badge badge-danger">can not Send Due to Network Error</span></td>
                                        </tr>';
                        }
                    }
                    else {
                        $contacts_output .= '<tr>
                                            <td>'.$phone.'</td>
                                            <td><span class="badge badge-danger">can not Send Due to insufficient balance</span></td>
                                        </tr>';
                    }
               }
               
               $output = [
                    'status' => 'yes',
                    'output' => $contacts_output,
                ];
                return Response($output);
           }
           else {
               $output = [
                    'status' => 'no',
                    'reason' => 'No Contacts Selected!',
                ];
                return Response($output);
           }
          
        }
        else {
            $output = [
                'status' => 'no',
                'reason' => 'You have not access to do this!',
            ];
            return Response($output);
        }
        //return Response($output);
    }
    
    
    
    
    
    
    
    public function shop_admin_sms_histories_data(Request $request) {
        
        if ($request->ajax()) {
            $info = Sms_history::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            return Datatables::of($info)
                ->addIndexColumn()
                ->addColumn('user_name', function($row){
                    return $row->user_info->name." [".$row->user_info->phone."]";
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['user_name', 'date'])
                ->make(true);
        }
    }
    
    
    public function super_admin_sms_history()
    {
        if(Auth::user()->type == 'super_admin'){
           return view('cms.super_admin.sms.super_admin_sms_history');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function super_admin_sms_history_data(Request $request) {
        
        if ($request->ajax() && Auth::user()->type == 'super_admin') {
            $info = Sms_history::orderBy('id', 'desc')->get();
            return Datatables::of($info)
                ->addIndexColumn()
                ->addColumn('user_name', function($row){
                    return $row->user_info->name." [".$row->user_info->phone."]";
                })
                ->addColumn('shop_info', function($row){
                    return $row->shop_info->shop_name." [".$row->shop_info->shop_code."]";
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['user_name', 'date', 'shop_info'])
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
     * @param  \App\Models\Sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function show(Sms_history $sms_history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function edit(Sms_history $sms_history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sms_history $sms_history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sms_history  $sms_history
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sms_history $sms_history)
    {
        //
    }
}
