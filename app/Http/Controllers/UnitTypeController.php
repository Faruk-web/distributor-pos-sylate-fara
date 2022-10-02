<?php

namespace App\Http\Controllers;

use App\Models\Unit_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class UnitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wing = 'main';
        $unit_types = unit_type::where('shop_id', Auth::user()->shop_id)->get();
        return view('cms.shop_admin.unit.all_unit_types', compact('unit_types', 'wing'));
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
    
    public function upload_unit_type_csv(Request $request)
    {
        
        if(User::checkPermission('admin.products') == true){ 
            $insert = '';
            $success = 0;
            $error = 0;
            $shop_id = Auth::user()->shop_id;
            $filename= $request->file; 
            $file = fopen($filename, "r");
            $i = 1;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                $name = $getData[0];
                $unit_type_check = DB::table('unit_types')->where('shop_id', $shop_id)->where('unit_name', $name)->first(['id']);
                if(empty($unit_type_check->id)) {
                    $data = array();
                    $data['shop_id'] = $shop_id;
                    $data['unit_name'] = $name;
                    $data['active'] = 1;
                    $data['created_at'] = Carbon::now();
                    $insert = DB::table('unit_types')->insert($data);
                    if($insert) {
                        DB::table('moments_traffics')->insert(['shop_id' =>$shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Unit Type Using CSV(Unit Type name: '.$name.')', 'created_at' => Carbon::now()]);
                        $success++;
                    }
                    else {
                        $error++;
                    }
                }
                $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
            }
            fclose($file);
            return Redirect()->back()->with('success', ''.$success.' Brand Insert And '.$error.' Brand can not insert.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function download_exist_unit_types()
    {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
    
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Backup Products Unit Types.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $fields = array('Unit Type Name');
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $types = DB::table('unit_types')->where(['shop_id'=>$shop_id])->get(['unit_name']);
            foreach($types as $type) {
                $lineData = array($type->unit_name);
                fputcsv($f, $lineData, $delimiter);  
            }
            
            //move back to beginning of file
            fseek($f, 0);
            
            //set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            
            //output all remaining data on a file pointer
            fpassthru($f);
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = unit_type::where('unit_name', $request->unit_name)->where('shop_id', Auth::user()->shop_id)->first();
        if(!empty($validate->id)) {
            Alert::warning('Warning', 'Sorry this Type of Unit is exist, please try again.');
            return Redirect()->back();
        }
        
        $data = array();
        $data['shop_id'] = Auth::user()->shop_id;
        $data['unit_name'] = $request->unit_name;
        $data['active'] = 1;
        $data['created_at'] = Carbon::now();
        
        $insert = DB::table('unit_types')->insert($data);
        if($insert) {
            Alert::success('Success', 'New Unit Type has been created.');
            return Redirect()->back();
        }
        else {
            Alert::warning('Warning', 'Something is wrong, please try again.');
            return Redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unit_type  $unit_type
     * @return \Illuminate\Http\Response
     */
    public function show(unit_type $unit_type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit_type  $unit_type
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $wing = 'main';
        $unit_type_info = unit_type::where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
        return view('cms.shop_admin.unit.edit_unit_type', compact('unit_type_info', 'wing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\unit_type  $unit_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['unit_name'] = $request->unit_name;
        $data['updated_at'] = Carbon::now();
        
        $update = DB::table('unit_types')->where('id', $id)->update($data);
        if($update) {
            Alert::success('Success', 'Unit Type has been Updated.');
            return Redirect()->route('admin.product.unit_types');
        }
        else {
            Alert::warning('Warning', 'Something is wrong, please try again.');
            return Redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unit_type  $unit_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(unit_type $unit_type)
    {
        //
    }

    public function DeactiveUnitType($id) {
        $data = array(
            'active' => 0,
        );
        $Q = unit_type::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            Alert::success('Success', 'Unit Type Deactive Successfully.');
            return redirect()->back();
        }
        else {
            Alert::error('Error', 'Error occurred! Please try again.');
            return redirect()->back();
        }
    }

    public function ActiveUnitType($id) {
        $data = array(
            'active' => 1,
        );
        $Q = unit_type::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            Alert::success('Success', 'Unit Type Active Successfully.');
            return redirect()->back();
        }
        else {
            Alert::error('Error', 'Error occurred! Please try again.');
            return redirect()->back();
        }
    }

    
}
