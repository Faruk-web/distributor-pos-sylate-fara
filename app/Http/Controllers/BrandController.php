<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use PHPUnit\Framework\TestCase;


class BrandController extends Controller
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
            $brands = brand::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.brand.all_brand', compact('brands', 'wing'));
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
            $validate = brand::where('brand_name', $request->brand_name)->where('shop_id', Auth::user()->shop_id)->first();
            if(!empty($validate->id)) {
                return Redirect()->back()->with('error', 'Sorry this Brand is exist, please try again');
            }
            
            $data = array();
            $data['shop_id'] = Auth::user()->shop_id;
            $data['brand_name'] = $request->brand_name;
            $data['active'] = 1;
            $data['created_at'] = Carbon::now();
            
            $insert = DB::table('brands')->insert($data);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Product Brand(Brand name: '.$request->brand_name.')', 'created_at' => Carbon::now()]);
                return redirect()->back()->with('success', 'New Brand has been created.');
            }
            else {
                return Redirect()->back()->with('error', 'Something is wrong, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function upload_brand_csv(Request $request)
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
                $brand_name = $getData[0];
                $brand_check = DB::table('brands')->where('shop_id', $shop_id)->where('brand_name', $brand_name)->first(['id']);
                if(empty($brand_check->id)) {
                    $data = array();
                    $data['shop_id'] = $shop_id;
                    $data['brand_name'] = $brand_name;
                    $data['active'] = 1;
                    $data['created_at'] = Carbon::now();
                    $insert = DB::table('brands')->insert($data);
                    if($insert) {
                        DB::table('moments_traffics')->insert(['shop_id' =>$shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Brand Using CSV(Brand name: '.$brand_name.')', 'created_at' => Carbon::now()]);
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
    
    public function download_exist_brand()
    {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
    
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Backup Products Brands.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $fields = array('Brand Name');
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $barnds = DB::table('brands')->where(['shop_id'=>$shop_id, 'active'=>1])->get(['brand_name']);
            foreach($barnds as $brand) {
                $lineData = array($brand->brand_name);
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
     * Display the specified resource.
     *
     * @param  \App\Models\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $brand_info = brand::where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            return view('cms.shop_admin.brand.edit_brand', compact('brand_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('admin.products') == true){
            $data = array();
            $data['brand_name'] = $request->brand_name;
            $data['updated_at'] = Carbon::now();
            
            $update = DB::table('brands')->where('id', $id)->update($data);
            if($update) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Product Brand(Brand name: '.$request->brand_name.')', 'created_at' => Carbon::now()]);
                return Redirect()->route('admin.product.brands')->with('success', 'Brand has been Updated.');
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
     * @param  \App\Models\brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(brand $brand)
    {
        //
    }

    public function DeactiveBrand($id) {
        $data = array(
            'active' => 0,
        );
        $Q = brand::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Deactive Product Brand', 'created_at' => Carbon::now()]);
            return redirect()->back()->with('success', 'Brand Deactive Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    public function ActiveBrand($id) {
        $data = array(
            'active' => 1,
        );
        $Q = brand::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Active Product Brand', 'created_at' => Carbon::now()]);
            return redirect()->back()->with('success', 'Brand Active Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    
}
