<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;

class CategoryController extends Controller
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
            $categories = category::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.category.all_categories', compact('categories', 'wing'));
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
        
        $validate = category::where('cat_name', $request->cat_name)->where('shop_id', Auth::user()->shop_id)->first();
        if(!empty($validate->id)) {
            Alert::warning('Warning', 'Sorry this Category is exist, please try again.');
            return Redirect()->back();
        }
        
        $data = array();
        $data['shop_id'] = Auth::user()->shop_id;
        $data['cat_name'] = $request->cat_name;
        $data['active'] = 1;
        $data['created_at'] = Carbon::now();
        
        $insert = DB::table('categories')->insert($data);
        if($insert) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Category(name: '.$request->cat_name.')', 'created_at' => Carbon::now()]);
            Alert::success('Success', 'New Category has been created.');
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
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $category_info = category::where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            return view('cms.shop_admin.category.edit_category', compact('category_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array();
        $data['cat_name'] = $request->cat_name;
        $data['updated_at'] = Carbon::now();
        
        $update = DB::table('categories')->where('id', $id)->update($data);
        if($update) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Category(name: '.$request->cat_name.')', 'created_at' => Carbon::now()]);
            Alert::success('Success', 'Category has been Updated.');
            return Redirect()->route('admin.product.categories');
        }
        else {
            Alert::warning('Warning', 'Something is wrong, please try again.');
            return Redirect()->back();
        }
    }
    
    
    public function upload_category_csv(Request $request)
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
                $cat_name = $getData[0];
                $brand_check = DB::table('categories')->where('shop_id', $shop_id)->where('cat_name', $cat_name)->first(['id']);
                if(empty($brand_check->id)) {
                    $data = array();
                    $data['shop_id'] = $shop_id;
                    $data['cat_name'] = $cat_name;
                    $data['active'] = 1;
                    $data['created_at'] = Carbon::now();
                    $insert = DB::table('categories')->insert($data);
                    if($insert) {
                        DB::table('moments_traffics')->insert(['shop_id' =>$shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Category Using CSV(Category name: '.$cat_name.')', 'created_at' => Carbon::now()]);
                        $success++;
                    }
                    else {
                        $error++;
                    }
                }
                $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
            }
            fclose($file);
            return Redirect()->back()->with('success', ''.$success.' Category Insert And '.$error.' Category can not insert.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function download_exist_categories()
    {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
    
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Backup Products categories.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $fields = array('Category Name');
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $categories = DB::table('categories')->where(['shop_id'=>$shop_id])->get(['cat_name']);
            foreach($categories as $category) {
                $lineData = array($category->cat_name);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }

    public function DeactiveCategory($id) {
        $data = array(
            'active' => 0,
        );
        $Q = category::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Deactive Product Category', 'created_at' => Carbon::now()]);
            Alert::success('Success', 'Category Deactive Successfully.');
            return redirect()->back();
        }
        else {
            Alert::error('Error', 'Error occurred! Please try again.');
            return redirect()->back();
        }
    }

    public function ActiveCategory($id) {
        $data = array(
            'active' => 1,
        );
        $Q = category::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Active Product Category', 'created_at' => Carbon::now()]);
            Alert::success('Success', 'Category Active Successfully.');
            return redirect()->back();
        }
        else {
            Alert::error('Error', 'Error occurred! Please try again.');
            return redirect()->back();
        }
    }

    
}
