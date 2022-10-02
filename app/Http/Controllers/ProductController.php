<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\BarcodePrinters;
use App\Models\Product_stock;
use Image;
use DataTables;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Picqer;
use PDF;
use App\Models\ProductVariation;
use App\Models\ProductWithVariation;
use App\Models\Purchase_lines;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            return view('cms.shop_admin.produts.all_products', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function all_product_data(Request $request)
    {
        if ($request->ajax()) {
            $products = DB::table('products')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get(['p_brand', 'id', 'image', 'p_name', 'active', 'barCode']);
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '';
                    if($row->active == 1) {
                            $info .= '<a type="button" href="'.url('/admin/deactive-product/'.$row->id).'" class="btn btn-success btn-sm" ><i class="fas fa-eye"></i></a> ';
                        }
                        else {
                            $info .= '<a type="button" href="'.url('/admin/active-product/'.$row->id).'" class="btn btn-danger btn-sm"><i class="fas fa-eye-slash"></i></a> ';
                        }
                        $info .= '<a class="dbtn btn-primary btn-sm" href="'.url('/admin/edit-product/'.$row->id).'"><i class="fas fa-edit"></i></a>
                        <a class="btn btn-info btn-sm" href="'.route('admin.product.stock.summery', ['id'=>$row->id]).'">Summery</a>';
                    return $info;
                })
                ->addColumn('image', function($row){
                    return '<img src="'.asset(optional($row)->image).'" style="width: 50px;" class="rounded" >';
                })
                ->addColumn('brand', function($row){
                    $brand = DB::table('brands')->where('id', $row->p_brand)->first('brand_name');
                    return optional($brand)->brand_name;
                })
                
                ->rawColumns(['action', 'image', 'brand'])
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
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $categories = DB::table('categories')->where('shop_id', $shop_id)->where('active', 1)->get();
            $brands = DB::table('brands')->where('shop_id', $shop_id)->where('active', 1)->get();
            $unit_types = DB::table('unit_types')->where('shop_id', $shop_id)->where('active', 1)->get();
            $variations = ProductVariation::where('shop_id', $shop_id)->orderBy('id', 'DESC')->get();
            
            return view('cms.shop_admin.produts.add_product', compact('categories', 'brands', 'unit_types', 'wing', 'variations'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function Check_barcode() {
        $output = '';
        $code = $_GET['code'];
        $check = DB::table('products')->where('shop_id', Auth::user()->shop_id)->where('barCode', $code)->where('barCode', '!=', '')->first(['p_name', 'id']);

        if(empty($check->id)) {
            $res = [
                'exist' => 'yes',
            ];
        }
        else {
            $res = [
                'exist' => 'no',
                'product' => $check->p_name,
            ];
        }
        return response()->json($res); 
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
            $validate = product::where('p_name', $request->p_name)->where('shop_id', Auth::user()->shop_id)->first();
            if(!empty($validate->id)) {
                Alert::warning('Warning', 'Sorry this Product is exist, please try again.');
                return Redirect()->back();
            }
            
            $data = new Product;
            
            $image = $request->file('image');
            if(!empty($image)){
                $name_gen = hexdec(uniqid()).".".$image->getClientOriginalExtension();
                Image::make($image)->resize(80, 80)->save('images/product/'.$name_gen);
                $last_img = 'images/product/'.$name_gen;
                $data->image = $last_img;
            }

            $data->shop_id = Auth::user()->shop_id;
            $data->p_name = $request->p_name;
            $data->p_brand = $request->p_brand;
            $data->p_cat = $request->p_cat;
            $data->p_unit_type = $request->p_unit_type;
            $data->vat_status = $request->vat_status;
            $data->vat_rate = $request->vat_rate;
            $data->discount = $request->discount;
            $data->discount_amount = $request->discount_amount;
            $data->purchase_price = $request->purchase_price;
            $data->selling_price = $request->selling_price;
            $data->p_description = $request->p_description;
            $data->barCode = $request->barCode;
            $data->p_description = $request->p_description;
            $data->is_cartoon = $request->is_cartoon;
            $data->cartoon_quantity = $request->cartoon_quantity;
            $data->cartoon_purchase_price = $request->cartoon_purchase_price;
            $data->cartoon_sales_price = $request->cartoon_sales_price;
            $data->is_variable = 'simple';
            $data->active = 1;
            $data->created_at = Carbon::now();
            $insert = $data->save();
            
            if($insert) {
                
                // if(!is_null($request->variation_id) && $request->type == 'variable') {
                //     $variation_id = $request->variation_id;
                //     foreach($variation_id as $key => $item) {
                //         $variation = new ProductWithVariation;
                //         $variation->shop_id = Auth::user()->shop_id;
                //         $variation->pid = $data->id;
                //         $variation->variation_list_id = $request->variation_id[$key];
                //         $variation->purchase_price = $request->variation_purchase_price[$key];
                //         $variation->selling_price = $request->variation_sell_price[$key];
                //         $variation->save();
                //     }
                // }
                
                
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Product, Product name: '.$request->p_name.'', 'created_at' => Carbon::now()]);
                Alert::success('Success', 'New Product has been created.');
                return Redirect()->route('admin.product.all');
            }
            else {
                Alert::warning('Warning', 'Something is wrong, please try again.');
                return Redirect()->back();
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $categories = DB::table('categories')->where('shop_id', $shop_id)->where('active', 1)->get();
            $brands = DB::table('brands')->where('shop_id', $shop_id)->where('active', 1)->get();
            $unit_types = DB::table('unit_types')->where('shop_id', $shop_id)->where('active', 1)->get();
            $product_info = product::where('id', $id)->where('shop_id', $shop_id)->first();
            $wing = 'main';
            $variations = ProductVariation::where('shop_id', $shop_id)->orderBy('id', 'DESC')->get();
            $product_with_variations = ProductWithVariation::Where('pid', optional($product_info)->id)->get();
            return view('cms.shop_admin.produts.edit_product', compact('categories', 'brands', 'unit_types', 'product_info', 'wing', 'variations', 'product_with_variations'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('admin.products') == true){

            $validate = product::where('p_name', $request->p_name)->where('shop_id', Auth::user()->shop_id)->where('id', '!=', $id)->first();
            if(!empty($validate->id)) {
                Alert::warning('Warning', 'Sorry this Product is exist, please try again.');
                return Redirect()->back();
            }
            
            $data = array();
            $image = $request->file('image');
            $old_image = $request->old_image;
            if(!empty($image)){
                $name_gen = hexdec(uniqid()).".".$image->getClientOriginalExtension();
                Image::make($image)->resize(80, 80)->save('images/product/'.$name_gen);
                $last_img = 'images/product/'.$name_gen;
                $data['image'] = $last_img;
                if($old_image && is_file(public_path($old_image))){
                    unlink($old_image);
                }
            }

            $data['p_name'] = $request->p_name;
            $data['p_brand'] = $request->p_brand;
            $data['p_cat'] = $request->p_cat;
            $data['p_unit_type'] = $request->p_unit_type;
            $data['vat_status'] = $request->vat_status;
            $data['vat_rate'] = $request->vat_rate;
            $data['discount'] = $request->discount;
            $data['discount_amount'] = $request->discount_amount;
            $data['purchase_price'] = $request->purchase_price;
            $data['selling_price'] = $request->selling_price;
            $data['p_description'] = $request->p_description;
            $data['is_cartoon'] = $request->is_cartoon;
            $data['cartoon_quantity'] = $request->cartoon_quantity;
            $data['cartoon_purchase_price'] = $request->cartoon_purchase_price;
            $data['cartoon_sales_price'] = $request->cartoon_sales_price;
            $data['is_variable'] = 'simple';
            // $data['is_variable'] = $request->type;

            if(!empty($request->barCode)) {
                $data['barCode'] = $request->barCode;
            }
            $data['p_description'] = $request->p_description;
            $data['updated_at'] = Carbon::now();
            
            $update = DB::table('products')->where('id', $id)->update($data);
            if($update) {
                
                // if(!is_null($request->variation_id) && $request->type == 'variable') {
                //     $variation_id = $request->variation_id;
                //     foreach($variation_id as $key => $item) {
                //         $variation_id = $request->variation_id[$key];
                //         $check_exist_variation = ProductWithVariation::Where(['pid' => $id, 'variation_list_id' =>$variation_id])->first();
                //         if(!is_null($check_exist_variation)) {
                //             $variation = $check_exist_variation;
                //             $variation->is_active = $request->is_active[$key];
                //         }
                //         else {
                //             $variation = new ProductWithVariation;
                //             $variation->shop_id = Auth::user()->shop_id;
                //             $variation->pid = $id;
                //             $variation->variation_list_id = $request->variation_id[$key];
                //         }
                        
                //         $variation->purchase_price = $request->variation_purchase_price[$key];
                //         $variation->selling_price = $request->variation_sell_price[$key];
                //         $variation->save();
                //     }
                // }
                
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Product, Product name: '.$request->p_name.'', 'created_at' => Carbon::now()]);
                Alert::success('Success', 'New Product has been Updated.');
                return Redirect()->route('admin.product.all');
            }
            else {
                Alert::warning('Warning', 'Something is wrong, please try again.');
                return Redirect()->back();
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function admin_download_exist_products()
    {
        if(User::checkPermission('admin.products') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
    
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Backup Products.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $fields = array('Product Name', 'Product Brand', 'Product Category', 'Product Unit Type', 'Product Purchase Price', 'Product Selling Price', 'product barcode', 'vat status(yes/no)', 'vat rate(Ex: 10)', 'Discount Status( flat/percent/no)', 'Discount Rate(Only Number)');
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $products = Product::where(['shop_id'=>$shop_id])->get();
            foreach($products as $product) {
                $lineData = array($product->p_name, optional($product->brand_info)->brand_name, optional($product->category)->cat_name, optional($product->unit_type_name)->unit_name,  optional($product)->purchase_price, optional($product)->selling_price, optional($product)->barCode, optional($product)->vat_status, optional($product)->vat_rate, optional($product)->discount, optional($product)->discount_amount);
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
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        //
    }

    public function DeactiveProduct($id) {
        if(User::checkPermission('admin.products') == true){
            $data = array(
                'active' => 0,
            );
            $Q = product::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
            if($Q) {
                Alert::success('Success', 'Product Deactive Successfully.');
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

    public function ActiveProduct($id) {
        if(User::checkPermission('admin.products') == true){   
            $data = array(
                'active' => 1,
            );
            $Q = product::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
            if($Q) {
                Alert::success('Success', 'Product Active Successfully.');
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

    //Begin::product Barcode
    public function Barcode(){
        if(User::checkPermission('admin.products') == true){  
            $wing = 'main';
            $printers = BarcodePrinters::where('shop_id', Auth::user()->shop_id)->where('is_active', 1)->orderBy('id', 'DESC')->get(['printer_name', 'id', 'code', 'page_width', 'barcode_row']);
            $products = product::where('shop_id', Auth::user()->shop_id)->where('barCode', '!=', '')->orderBy('id', 'desc')->get(['id', 'barCode', 'p_name']);
            return view('cms.shop_admin.produts.product_barcode', compact('products', 'wing', 'printers'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End::product Barcode

    //Begin::product Barcode Print
    public function PrintBarcode(Request $request){
        if(User::checkPermission('admin.products') == true){

            $printer_name = $request->printer_name;
            $product_name = $request->product_name;
            $selling_price = $request->selling_price;
            $pid = $request->pid;
            $print_quantity = $request->print_quantity;
            $wing = 'main';
            if($request->has('pid') > 0) {
                return view('cms.shop_admin.produts.print_barcode', compact('print_quantity', 'pid', 'wing', 'printer_name', 'product_name', 'selling_price'));
            }
            else {
                return Redirect()->back()->with('error', 'Please Select Products.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End::product Barcode Print

    //Begin::product CSV Upload
    public function csvUpload(){
        if(User::checkPermission('admin.products') == true){  
            $wing = 'main';
            return view('cms.shop_admin.produts.product_csv_upload', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End::product CSV Upload

    //Begin::product CSV Upload confirm
    public function csvUpload_confirm(Request $request){
        if(User::checkPermission('admin.products') == true){ 
            $insert = '';
            $success = 0;
            $error = 0;
            $shop_id = Auth::user()->shop_id;
            $filename= $request->csvFile; 
            $file = fopen($filename, "r");
            $i = 1;
            while (($getData = fgetcsv($file, 200000, ",")) !== FALSE) {

                $p_name = $getData[0];
                $product_brand = $getData[1];
                $product_cat = $getData[2];
                $product_unit_type =$getData[3];
                $product_purchase_price = $getData[4];
                $product_selling_price = $getData[5];
                $is_cartoon = $getData[6];
                $cartoon_quantity = $getData[7];
                $cartoon_purchase_price = $getData[8];
                $cartoon_sales_price = $getData[9];
                
                $p_barcode = $getData[10];
                $vat_status = $getData[11];
                $vat_rate = $getData[12];
                $discount_status = $getData[13];
                $discount_rate = $getData[14];
                

                $product_check = DB::table('products')->where('shop_id', $shop_id)->where('p_name', $p_name)->first(['id']);
                $brand_check = DB::table('brands')->where('shop_id', $shop_id)->where('brand_name', $product_brand)->first(['id']);
                $cat_check = DB::table('categories')->where('shop_id', $shop_id)->where('cat_name', $product_cat)->first(['id']);
                $unit_type_check = DB::table('unit_types')->where('shop_id', $shop_id)->where('unit_name', $product_unit_type)->first(['id']);


                if(is_null($product_check) && !is_null($cat_check) && !is_null($unit_type_check) && !is_null($product_purchase_price) && !is_null($product_selling_price)) {

                    //echo $i.")".$p_name."<br>";
                    
                    $data = array();

                    if(!empty($brand_check->id)) {
                        $data['p_brand'] = $brand_check->id;
                    }

                    if($vat_status == '') {
                        $vat_status = 'no';
                        $vat_rate = 0;
                    }

                    if($discount_status == '') {
                        $discount_status = 'no';
                        $discount_rate = 0;
                    }
                    
                    $data['shop_id'] = $shop_id;
                    $data['p_name'] = $p_name;
                    $data['p_cat'] = $cat_check->id;
                    $data['p_unit_type'] = $unit_type_check->id;
                    $data['purchase_price'] = str_replace(",","", $product_purchase_price);
                    $data['selling_price'] = str_replace(",","", $product_selling_price);
                    $data['barCode'] = $p_barcode;
                    $data['vat_status'] = $vat_status;
                    $data['vat_rate'] = $vat_rate;
                    $data['discount'] = $discount_status;
                    $data['discount_amount'] = $discount_rate;
                    $data['is_cartoon'] = $is_cartoon;
                    $data['cartoon_quantity'] = $cartoon_quantity;
                    $data['cartoon_purchase_price'] = $cartoon_purchase_price;
                    $data['cartoon_sales_price'] = $cartoon_sales_price;
                    $data['active'] = 1;
                    $data['created_at'] = Carbon::now();
                    
                    $insert = DB::table('products')->insert($data);
                    if($insert) {
                        DB::table('moments_traffics')->insert(['shop_id' =>$shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added Product Using CSV(product name: '.$p_name.')', 'created_at' => Carbon::now()]);
                        $success++;
                    }
                    else {
                        $error++;
                    }
                    $i++;
                }

            $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
            
            
            }
            fclose($file);
            return Redirect()->route('admin.product.all')->with('success', ''.$success.' Product Insert And '.$error.' Product can not insert.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    
    }
    //End::product CSV Upload confirm

    //Begin:: Branch and Godown product Stock
    public function branch_and_godown_product_stock() {
        if(User::checkPermission('admin.branch.product.stock') == true){
            $wing = 'main';
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get();
            $brands = DB::table('brands')->where('shop_id', Auth::user()->shop_id)->get();
            $categories = DB::table('categories')->where('shop_id', Auth::user()->shop_id)->get();
            
            return view('cms.shop_admin.produts.product_stock_report', compact('wing', 'branches', 'brands', 'categories'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function branch_and_godown_product_stock_data(Request $request, $place, $active_or_empty)
    {
        if ($request->ajax()) {
            $shop_id = Auth::user()->shop_id;
            
            if($active_or_empty == 'active') {
                if($place == 'godown') {
                    $products = DB::table('product_stocks')->join('products', 'product_stocks.pid', '=', 'products.id')->where('product_stocks.stock', '>', 0)->where(['product_stocks.branch_id'=>'G', 'product_stocks.shop_id'=>$shop_id])->select('product_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type', 'products.barCode')->get();
                }
                else {
                    $products = DB::table('product_stocks')->join('products', 'product_stocks.pid', '=', 'products.id')->where('product_stocks.stock', '>', 0)->where('product_stocks.branch_id', $place)->select('product_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type', 'products.barCode')->get();
                }
            }
            elseif($active_or_empty == 'empty') {
                if($place == 'godown') {
                    $products = DB::table('products')->where(['shop_id'=>$shop_id, 'active'=>1])->where('G_current_stock', '<=', 0)->get(['p_name', 'p_unit_type', 'p_brand', 'G_current_stock', 'id', 'barCode', 'purchase_price', 'selling_price']);
                }
                else {
                    $products = DB::table('product_stocks')->join('products', 'product_stocks.pid', '=', 'products.id')->where('product_stocks.stock', '<=', 0)->where('product_stocks.branch_id', $place)->select('product_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type', 'products.barCode')->get();
                }
            }

            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('stock', function($row){
                    $unit_type = DB::table('unit_types')->where('id', $row->p_unit_type)->first('unit_name');
                    return (optional($row)->stock + 0)." ".optional($unit_type)->unit_name;
                })
                ->addColumn('product_name', function($row){
                    $v_name = '';
                    if($row->variation_id != 0 && $row->variation_id != '') { $vinfo = DB::table('variation_lists')->where(['id'=>$row->variation_id])->first(); $v_name =  '<span class="text-success">('.optional($vinfo)->list_title.')</span>'; }
                    return $row->p_name.$v_name."<br><small class='text-primary'><b>Lot: </b>".$row->lot_number.", <b>Sales Price: </b>".number_format($row->sales_price, 2)."TK, <b>Discount: </b>".$row->discount."(".$row->discount_amount."), <b>VAT: </b>".$row->vat."%";
                })
                ->addColumn('action', function($row){
                    return '<a type="button" href="'.url('/stock/change-product-stock-info/'.$row->id).'" class="btn btn-success btn-sm" ><i class="fas fa-sync text-light"></i></a>';
                })
                
                ->rawColumns(['product_name', 'stock', 'action'])
                ->make(true);
        }
    }
    
    
    
    public function branch_and_godown_product_stock_value(Request $request)
    {
        $place = $request->place;
        $shop_id = Auth::user()->shop_id;
        $total = 0;
        
        if($place == 'godown') {
             
            $branch_products = Product_stock::where('branch_id', 'G')->where('shop_id', $shop_id)->where('stock', '>', 0)->get(['purchase_price', 'stock']);
            
            foreach($branch_products->chunk(100) as $row) {
                foreach($row as $product) {
                    $total = $total + ((($product->purchase_price) + 0) * (($product->stock) + 0));
                }
            }
            
            return Response()->json('Stock Value By Purchase Price: '.number_format($total, 2));
        }
        else {
            
            // $branch_products = Product_stock::select(DB::raw('SUM(product_trackers.quantity) as total_qty'), DB::raw('SUM(product_trackers.total_price) as total_price'))
            //                   ->leftJoin('product_trackers', 'product_trackers.product_id', '=', 'product_stocks.pid')
            //                   ->where('product_stocks.branch_id', $place)
            //                   ->get();
                              
            // $branch_products = DB::table("product_stocks")
            //           ->select("product_stocks.pid",
            //                     DB::raw("(SELECT SUM(product_trackers.quantity) FROM product_trackers WHERE product_trackers.product_id = product_stocks.pid GROUP BY product_trackers.product_id) as purchase_qty"),
            //                     DB::raw("(SELECT SUM(product_trackers.total_price) FROM product_trackers WHERE product_trackers.product_id = product_stocks.pid GROUP BY product_trackers.product_id) as purchase_total_price"))
            //           ->where('product_stocks.branch_id', $place)
            //           ->get();
                              
                              
            $branch_products = Product_stock::where('branch_id', $place)->where('stock', '>', 0)->get(['purchase_price', 'stock']);
            foreach($branch_products->chunk(100) as $row) {
                foreach($row as $product) {
                    $total = $total + ((($product->purchase_price) + 0) * (($product->stock) + 0));
                }
            }
            return Response()->json('Stock Value By Purchase Price: '.number_format($total, 2));
        }
          
    }
    
    

    public function branch_and_godown_product_stock_data_print(Request $request) {
        if(User::checkPermission('admin.branch.product.stock') == true){
            $place = $request->place;
            $active_or_empty = $request->active_or_empty_stock;
            $wing = "main";
            
            $shop_id = Auth::user()->shop_id;
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            
            if($active_or_empty == 'active') {
                if($place == 'godown') {
                    $updated_place_name = 'Godown';
                    //$products = DB::table('products')->where(['shop_id'=>$shop_id, 'active'=>1])->where('G_current_stock', '>', 0)->get(['p_name', 'p_unit_type', 'p_brand', 'G_current_stock', 'purchase_price', 'id']);
                    $products = DB::table('product_stocks')->join('products', 'product_stocks.pid', '=', 'products.id')->where('product_stocks.stock', '>', 0)->where('product_stocks.branch_id', 'G')->Where('product_stocks.shop_id', $shop_id)->select('product_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type')->get();
                }
                else {
                    $branch_info = DB::table('branch_settings')->where('id', $place)->first(['branch_name', 'branch_address', 'branch_phone_1']);
                    $updated_place_name = optional($branch_info)->branch_name;
                    $products = DB::table('product_stocks')->join('products', 'product_stocks.pid', '=', 'products.id')->where('product_stocks.stock', '>', 0)->where('product_stocks.branch_id', $place)->select('product_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type')->get();
                }
            }
            elseif($active_or_empty == 'empty') {
                if($place == 'godown') {
                    $updated_place_name = 'Godown';
                    $products = DB::table('products')->where(['shop_id'=>$shop_id, 'active'=>1])->where('G_current_stock', '<=', 0)->get(['p_name', 'p_unit_type', 'p_brand', 'G_current_stock', 'purchase_price', 'id']);
                }
                else {
                    $branch_info = DB::table('branch_settings')->where('id', $place)->first(['branch_name', 'branch_address', 'branch_phone_1']);
                    $updated_place_name = optional($branch_info)->branch_name;
                    $products = DB::table('product_stocks')->join('products', 'product_stocks.pid', '=', 'products.id')->where('product_stocks.stock', '<=', 0)->where('product_stocks.branch_id', $place)->select('product_stocks.*', 'products.p_name', 'products.p_brand', 'products.p_unit_type')->get();
                }
            }
            
            return view('cms.shop_admin.produts.stock_info_print', compact('shop_info', 'products', 'active_or_empty', 'updated_place_name', 'updated_place_name', 'place', 'wing'));
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    //End:: Branch and Godown product Stock
    
    //Begin:: Change Stock Info
    public function change_stock_info($id) {
        if(User::checkPermission('admin.branch.product.stock') == true){
            $wing = 'main';
            $stock_info = DB::table('product_stocks')->where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            if(!is_null($stock_info)) {
                $product_info = DB::table('products')->where('id', $stock_info->pid)->first();
                $unit_type = DB::table('unit_types')->where('id', $product_info->p_unit_type)->first('unit_name');
                if($stock_info->branch_id == 'G') {
                    $place = "Godown";
                }
                else {
                    $branch_info = DB::table('branch_settings')->where('id', $stock_info->branch_id)->first(['branch_name', 'branch_address']);
                    $place = optional($branch_info)->branch_name.", ".optional($branch_info)->branch_address;
                }
                return view('cms.shop_admin.produts.change_product_stock_info', compact('wing', 'stock_info', 'product_info', 'place', 'unit_type'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function change_stock_info_confirm(Request $request) {
        if(User::checkPermission('admin.branch.product.stock') == true){
            $stock_id = $request->stock_id;
            $stock_info = DB::table('product_stocks')->where('id', $stock_id)->where('shop_id', Auth::user()->shop_id)->first();
            if(!is_null($stock_info)) {
                $status = DB::table('product_stocks')->where('id', $stock_info->id)->update(['sales_price'=>$request->sales_price, 'discount'=>$request->discount, 'discount_amount'=>($request->discount_amount + 0)]);
                if($status) {
                    return Redirect()->route('admin.branch.product.stock')->with('success', 'Product Stock Info Changed.');
                }
                else {
                    return Redirect()->route('admin.branch.product.stock')->with('error', 'No change Found!');
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
    
    

    //Begin:: Set Opening and own stock
    public function set_opening_and_own_stock() {
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            /*
            $product1 = DB::table('product_with_variations')
                    ->distinct()
                    ->leftJoin('products', function($join)
                        {
                            $join->on('products.id', '=', 'product_with_variations.pid');
                        })
                    ->where(['products.shop_id'=>Auth::user()->shop_id, 'product_with_variations.is_active'=>1])
                    ->select(['product_with_variations.purchase_price', 'product_with_variations.selling_price', 'product_with_variations.sku', 'products.discount', 'products.discount_amount', 'products.vat_rate'])
                    ->get();
            
            $product2 = DB::table('products')->where('shop_id', Auth::user()->shop_id)->limit(10)->get(['discount', 'discount_amount', 'vat_rate', 'selling_price', 'purchase_price']);
            $finalResult = $product1->merge($product2);
            */
            $branchs = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name']);
            return view('cms.shop_admin.produts.set_own_stock', compact('wing', 'branchs'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function get_products_search_by_title_into_opening_stock_new(Request $request) {
        $title = $request->title;
        $stock_place = $request->stock_place;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $products = Product::where('shop_id', $shop_id)->where('p_name', 'like', '%' . $title . '%')->limit(15)->get();
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                $gloval_vat_status = Auth::user()->shop_info->vat_type;
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    if($product->is_variable == 'variable') {
                        $p_with_variation = ProductWithVariation::Where('pid', $product->id)->where('is_active', 1)->get();
                        if($p_with_variation->isNotEmpty()) {
                            foreach($p_with_variation as $variation) {
                                if($gloval_vat_status == 'individual_product_vat') { $vat_rate = $product->vat_rate; }else { $vat_rate = 0; }
                                $check = DB::table('product_trackers')->where(['product_id'=>$product->id, 'variation_id'=>$variation->variation_list_id, 'branch_id'=>$stock_place, 'product_form'=>'OP'])->first(['id']);
                                if(is_null($check)) {
                                        $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$variation->purchase_price.'\', \''.$variation->selling_price.'\', \''.$product->vat_status.'\', \''.$vat_rate.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.optional($variation->variation_list_info)->list_title.'\',\''.$variation->variation_list_id.'\')" title="Add me">
                                        <a class="nav-link" id="product_text" href="javascript:void(0)">
                                        <span></span>'.$product->p_name.' <small class="text-success">('.optional($variation->variation_list_info)->list_title.')</small></a>
                                        <div class="list-group-item d-flex justify-content-between">
                                            <small class="text-primary">Br. '.optional($brand_info)->brand_name.'</small>
                                            <small class="text-primary">'.optional($product)->is_variable.'</small>
                                        </div>
                                    </li>';
                                }
                                else {
                                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" title="Add me">
                                        <a class="nav-link" id="product_text" href="javascript:void(0)">
                                        <span></span>'.$product->p_name.' <small class="text-success">('.optional($variation->variation_list_info)->list_title.')</small></a>
                                        <div class="list-group-item text-center">
                                            <h6 class="fw-bold text-danger bg-dark rounded p-1">This Product is already added.</h6>
                                        </div>
                                    </li>';
                                }
                            }
                        }
                    }
                    else {
                        if($gloval_vat_status == 'individual_product_vat') { $vat_rate = $product->vat_rate; }else { $vat_rate = 0; }
                        $type = 'simple';
                        $check = DB::table('product_trackers')->where(['product_id'=>$product->id, 'variation_id'=>0, 'branch_id'=>$stock_place, 'product_form'=>'OP'])->first(['id']);
                        if(is_null($check)) {
                                $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->selling_price.'\', \''.$product->vat_status.'\', \''.$vat_rate.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$type.'\', 0)" title="Add me">
                            <a class="nav-link" id="product_text" href="javascript:void(0)">
                            <span></span>'.$product->p_name.'</small></a>
                            <div class="list-group-item d-flex justify-content-between">
                                <small class="text-primary">Br. '.optional($brand_info)->brand_name.'</small>
                                <small class="text-primary">'.optional($product)->is_variable.'</small>
                            </div>
                            
                        </li>';
                        }
                        else {
                            $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" title="Add me">
                            <a class="nav-link" id="product_text" href="javascript:void(0)">
                            <span></span>'.$product->p_name.'</small></a>
                            <div class="list-group-item text-center">
                                <h6 class="fw-bold text-danger bg-dark rounded p-1">This Product is already added.</h6>
                            </div>
                        </li>';
                        }
                    }
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        return response()->json($output);
    }
    

    //Begin:: Set Opening stock
    public function set_opening_stock_new() {
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $branchs = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name', 'branch_address']);
            return view('cms.shop_admin.produts.set_own_and_opening_stock', compact('wing', 'branchs'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function get_products_search_by_title_into_own_stock_new(Request $request) {
        $title = $request->title;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $products = Product::where('shop_id', $shop_id)->where('p_name', 'like', '%' . $title . '%')->limit(15)->get();
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                $gloval_vat_status = Auth::user()->shop_info->vat_type;
                
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    
                    if($product->is_variable == 'variable') {
                        $p_with_variation = ProductWithVariation::Where('pid', $product->id)->where('is_active', 1)->get();
                        if($p_with_variation->isNotEmpty()) {
                            foreach($p_with_variation as $variation) {
                                if($gloval_vat_status == 'individual_product_vat') { $vat_rate = $product->vat_rate; }else { $vat_rate = 0; }
                                $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$variation->purchase_price.'\', \''.$variation->selling_price.'\', \''.$product->vat_status.'\', \''.$vat_rate.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.optional($variation->variation_list_info)->list_title.'\',\''.$variation->variation_list_id.'\')" title="Add me">
                                    <a class="nav-link" id="product_text" href="javascript:void(0)">
                                    <span class=""></span>'.$product->p_name.' <small class="text-success">('.optional($variation->variation_list_info)->list_title.')</small></a>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <small class="text-primary">Br. '.optional($brand_info)->brand_name.'</small>
                                        <small class="text-primary">'.optional($product)->is_variable.'</small>
                                    </div>
                                </li>';
                            }
                        }
                    }
                    else {
                        if($gloval_vat_status == 'individual_product_vat') { $vat_rate = $product->vat_rate; }else { $vat_rate = 0; }
                        $type = 'simple';
                        $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->selling_price.'\', \''.$product->vat_status.'\', \''.$vat_rate.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$type.'\', 0)" title="Add me">
                        <a class="nav-link" id="product_text" href="javascript:void(0)">
                        <span class=""></span>'.$product->p_name.'</small></a>
                        <div class="list-group-item d-flex justify-content-between">
                            <small class="text-primary">Br. '.optional($brand_info)->brand_name.'</small>
                            <small class="text-primary">'.optional($product)->is_variable.'</small>
                        </div>
                        
                    </li>';
                    }
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        return response()->json($output);

    }
    

    public function set_opening_and_own_stock_data(Request $request)
    {
        if ($request->ajax()) {
            $products = product::where('shop_id', Auth::user()->shop_id)->where('active', 1)->get(['p_name', 'id', 'image', 'barCode', 'is_variable']);
            
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" class="dbtn btn-primary btn-sm" href="'.url('/admin/edit-product/'.$row->id).'"><i class="fas fa-edit"></i></a> <a onclick="set_opening_stock('.$row->id.')" href="javascript:void(0)" class="btn btn-info btn-sm">Opening stock</a>';
                    return $info;
                })
                ->addColumn('image', function($row){
                    $info = '<img src="'.asset(optional($row)->image).'" style="width: 50px;" class="rounded" >';
                    return $info;
                })
                
                ->rawColumns(['image', 'action'])
                ->make(true);
        }
    }


    public function set_own_stock(Request $request) {
        
        $pid = $request->pid;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $branches = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['branch_name', 'id']);
        $product_info = Product::Where('id', $pid)->where('shop_id', $shop_id)->first(['p_name', 'id', 'purchase_price', 'selling_price', 'vat_rate', 'discount', 'discount_amount', 'is_variable']);
        $flat = '';
        $percent = '';
        $no = '';
        if($product_info->discount == 'no') {
            $no = 'selected';
        }
        else if($product_info->discount == 'flat') {
            $flat = 'selected';
        }
        else if($product_info->discount == 'percent') {
            $percent = 'selected';
        }
        
        $output .='<div>
                    <div class="form-group">
                        <label for="" class="text-justify">এই পদ্ধতিতে স্টক যুক্ত সাপ্লাইয়ারের সাথে কোন সম্পর্ক নেই। যারা সাপ্লাইয়ার এর হিসাব সংরক্ষণ করতে চান তাদেরকে অবশ্যই সাপ্লাইয়ার শাখা থেকেই পন্য যুক্ত করতে হবে। <a href="'.route('admin.supplier.wing').'">সাপ্লাইয়ার শাখা</a></label>
                    </div>
                    <label class="text-success">'.$product_info->p_name.'</label>
                    <form method="post" action="'.route('set.own.stock.confirm').'">
                        '.csrf_field().'
                        <div class="row">';
                            if($product_info->is_variable == 'variable') {
                                $product_with_variations = ProductWithVariation::Where('pid', optional($product_info)->id)->get();
                                
                            }
                            else {
                                $output .='<input type="hidden" name="variation_id" value="0">';
                            }
                            $output .='<div class="col-md-4">
                                <div class="form-group">
                                    <label for=""><span class="text-danger">*</span>Quantity</label>
                                    <input type="number" name="unit" class="form-control" step="any" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Purchase Price</label>
                                    <input type="number" name="purchase_price" class="form-control" value="'.$product_info->purchase_price.'" step="any" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Sales Price</label>
                                    <input type="number" name="sales_price" class="form-control" value="'.$product_info->selling_price.'" step="any" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Discount</label>
                                    <select class="form-control" id="discount" name="discount">
                                        <option '.$no.' value="no">No</option>
                                        <option '.$flat.' value="flat">Flat</option>
                                        <option '.$percent.' value="percent">Percent</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Discount Amount</label>
                                    <input type="number" name="discount_amount" class="form-control" value="'.($product_info->discount_amount+0).'" step="any" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="place"><span class="text-danger">*</span>Stock Update Place</label>
                            <select class="form-control" name="place" required>
                            <option value="">-- Select Place --</option>
                            <option value="G">Godown</option>';
                            foreach($branches as $branch) {
                            $output .='<option value="'.$branch->id.'">'.$branch->branch_name.'</option>';
                            }
                        $output .='</select>
                        </div>
                        <div class="form-group">
                            <label for="note">*Note</label>
                            <textarea class="form-control" name="note" rows="2"></textarea>
                        </div>
                        <div class="card-footer text-right">
                            <input type="hidden" name="pid" class="form-control" id="" value="'.$product_info->id.'">
                            <button type="submit"  class="btn btn-success">Submit</button>
                        </div>
                        </form>
                        </div>';

        return response()->json($output); 

    }


    public function set_own_stock_confirm(Request $request) {
        
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $shop_id = Auth::user()->shop_id;
           
            $pid = $request->pid;
            
            if(is_null($pid) ) { 
                return Redirect()->back()->with('error', 'No Product Found!!!');
            }
            
            $destination_place = $request->place;
            $invoice_id = 'OWN_STOCK';
            $date = $request->date;
            
            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                $purchasingP = $request->price[$key];
                $sales_price = $request->sales_price[$key];
                $variation_id = $request->variation_id[$key];
                $discount  = $request->p_discount[$key];
                $discount_amount   = $request->discount_amount[$key];
                $vat  = $request->vat[$key];
                
                $product_id = $pid[$key];
                
                $totalP = $unit * $purchasingP;
                
                $purchase_line_count = Purchase_lines::where(['shop_id'=>$shop_id, 'product_id'=>$product_id])->count('id');
                $lot_number = $purchase_line_count + 1;
                
                $purchase_line = new Purchase_lines;
                $purchase_line->shop_id = $shop_id;
                $purchase_line->branch_id = $destination_place;
                $purchase_line->invoice_id = $invoice_id;
                $purchase_line->product_id = $product_id;
                $purchase_line->purchase_price = $purchasingP;
                $purchase_line->sales_price = $sales_price;
                $purchase_line->discount = $discount;
                $purchase_line->discount_amount = $discount_amount;
                $purchase_line->vat = $vat;
                $purchase_line->lot_number = $lot_number;
                $purchase_line->variation_id = $variation_id;
                $purchase_line->quantity = $unit;
                $purchase_line->date = $date;
                $purchase_line->created_at = Carbon::now();
                $purchase_line->save();
                
                $purchase_line_id = $purchase_line->id;
                
                DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$purchase_line_id, 'lot_number'=>$lot_number, 'branch_id'=>$destination_place, 'pid'=>$product_id, 'variation_id'=>$variation_id, 'purchase_price'=>$purchasingP, 'sales_price'=>$sales_price, 'discount'=>$discount, 'discount_amount'=>$discount_amount, 'vat'=>$vat, 'stock'=>$unit, 'created_at'=>$date]);
                
                $p_data = array();
                $p_data['shop_id'] = $shop_id;
                $p_data['lot_number'] = $lot_number;
                $p_data['purchase_line_id'] = $purchase_line_id;
                $p_data['purchase_price'] = $purchasingP;
                $p_data['total_purchase_price'] = $totalP;
                $p_data['sales_price'] = $sales_price;
                $p_data['variation_id'] = $variation_id;
                $p_data['product_id'] = $product_id;
                $p_data['quantity'] = $unit;
                $p_data['price'] = $purchasingP;
                $p_data['discount'] = $discount;
                $p_data['discount_amount'] = $discount_amount;
                $p_data['vat'] = $vat;
                $p_data['total_price'] = $totalP;
                $p_data['status'] = 1; // 1 means in
                $p_data['product_form'] = 'OWS';
                $p_data['branch_id'] = $destination_place;
                $p_data['invoice_id'] = $invoice_id;
                $p_data['note'] = $request->note;
                $p_data['created_at'] = $date;
                $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                    
            }
            
            return Redirect()->route('admin.branch.product.stock')->with('success', 'Own stock update successfully.');

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }

    public function set_opening_stock(Request $request) {
        $pid = $request->pid;
        $shop_id = Auth::user()->shop_id;
        $output = '';

        $branches = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['branch_name', 'id']);
        $product_info = DB::table('products')->where('id', $pid)->where('shop_id', $shop_id)->first(['p_name', 'id', 'purchase_price']);
        $check_godown_opening_stock_of_this_product = DB::table('product_trackers')->where('product_id', $pid)->where('invoice_id', 'G')->where('product_form', 'OP')->first('id');
        $output .='<div>
                    <label class="text-success">'.$product_info->p_name.'</label>
                    <form method="post" action="'.route('set.opening.stock.confirm').'">
                        '.csrf_field().'
                        <div class="form-group">
                            <label for="exampleInputEmail1">Quantity</label>
                            <input type="number" name="unit" class="form-control" step="any" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Purchase Price</label>
                            <input type="number" name="purchase_price" class="form-control" value="'.$product_info->purchase_price.'" step="any" required>
                        </div>
                        <div class="form-group">
                            <label for="place">Opening Stock Place</label>
                            <select class="form-control" name="place" required>
                            <option value="">-- Select Place --</option>';
                            if(empty($check_godown_opening_stock_of_this_product->id)) {
                                $output .='<option value="G">Godown</option>';
                            }
                            foreach($branches as $branch) {
                                $check_branch_opening_stock = DB::table('product_trackers')->where('product_id', $pid)->where('branch_id', $branch->id)->where('product_form', 'OP')->first('id');
                                if(empty($check_branch_opening_stock->id)) {
                                    $output .='<option value="'.$branch->id.'">'.$branch->branch_name.'</option>';
                                }
                            }
                        $output .='</select>
                        </div>
                        <div class="card-footer text-right">
                            <input type="hidden" name="pid" class="form-control" id="" value="'.$product_info->id.'">
                            <button type="submit"  class="btn btn-success">Submit</button>
                        </div>
                        </form>
                        </div>';

        return response()->json($output); 

    }

    public function set_opening_stock_confirm(Request $request) {
        
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            
            $pid = $request->pid;
            //$place = $request->place;
            $destination_place = $request->place;
            $shop_id = Auth::user()->shop_id;
            if(is_null($pid) && is_null($destination_place)) { 
                return Redirect()->back()->with('error', 'No Product Found!!!');
            }
            
            $invoice_id = 'OPENING_STOCK';
            $date = $request->date;
            
            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                $purchasingP = $request->price[$key];
                $sales_price = $request->sales_price[$key];
                $variation_id = $request->variation_id[$key];
                $discount  = $request->p_discount[$key];
                $discount_amount   = $request->discount_amount[$key];
                $vat  = $request->vat[$key];
                $product_id = $pid[$key];
                
                $check = DB::table('product_trackers')->where(['product_id'=>$product_id, 'variation_id'=>$variation_id, 'branch_id'=>$destination_place, 'product_form'=>'OP'])->first(['id']);
                
                if(is_null($check)) {
                    
                    $totalP = $unit * $purchasingP;
                    $purchase_line_count = Purchase_lines::where(['shop_id'=>$shop_id, 'product_id'=>$product_id])->count('id');
                    $lot_number = $purchase_line_count + 1;
                    
                    $purchase_line = new Purchase_lines;
                    $purchase_line->shop_id = $shop_id;
                    $purchase_line->branch_id = $destination_place;
                    $purchase_line->invoice_id = $invoice_id;
                    $purchase_line->product_id = $product_id;
                    $purchase_line->purchase_price = $purchasingP;
                    $purchase_line->sales_price = $sales_price;
                    $purchase_line->discount = $discount;
                    $purchase_line->discount_amount = $discount_amount;
                    $purchase_line->vat = $vat;
                    $purchase_line->lot_number = $lot_number;
                    $purchase_line->variation_id = $variation_id;
                    $purchase_line->quantity = $unit;
                    $purchase_line->date = $date;
                    $purchase_line->created_at = Carbon::now();
                    $purchase_line->save();
                    
                    $purchase_line_id = $purchase_line->id;
                    
                    DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$purchase_line_id, 'lot_number'=>$lot_number, 'branch_id'=>$destination_place, 'pid'=>$product_id, 'variation_id'=>$variation_id, 'purchase_price'=>$purchasingP, 'sales_price'=>$sales_price, 'discount'=>$discount, 'discount_amount'=>$discount_amount, 'vat'=>$vat, 'stock'=>$unit, 'created_at'=>$date]);
                    
                    $p_data = array();
                    $p_data['shop_id'] = $shop_id;
                    $p_data['lot_number'] = $lot_number;
                    $p_data['purchase_line_id'] = $purchase_line_id;
                    $p_data['purchase_price'] = $purchasingP;
                    $p_data['total_purchase_price'] = $totalP;
                    $p_data['sales_price'] = $sales_price;
                    $p_data['variation_id'] = $variation_id;
                    $p_data['product_id'] = $product_id;
                    $p_data['quantity'] = $unit;
                    $p_data['price'] = $purchasingP;
                    $p_data['discount'] = $discount;
                    $p_data['discount_amount'] = $discount_amount;
                    $p_data['vat'] = $vat;
                    $p_data['total_price'] = $totalP;
                    $p_data['status'] = 1; // 1 means in
                    $p_data['product_form'] = 'OP';
                    $p_data['branch_id'] = $destination_place;
                    $p_data['invoice_id'] = $invoice_id;
                    $p_data['note'] = $request->note;
                    $p_data['created_at'] = $date;
                    $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                }
                
            }
            
            return Redirect()->route('admin.branch.product.stock')->with('success', 'Opening stock update successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }
    //End:: Set Opening and own stock

    //Begin:: update own stock using csv
    public function download_csv_for_set_own_stock() {

        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
    
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Product for Update own stock.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $branches = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name']);
            $fields = array('Product Name', 'Product id',  'Purchase Price', 'Godown stock');
            foreach($branches as $branch){ 
                array_push($fields, $branch->branch_name);
            }
            //set column headers
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $products = DB::table('products')->where(['shop_id'=>$shop_id, 'active'=>1])->get(['id', 'p_name', 'purchase_price']);
            foreach($products as $product) {
                $lineData = array($product->p_name, $product->id, $product->purchase_price, 0);
                foreach($branches as $branch){ 
                    array_push($lineData, 0);
                }
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


    public function admin_update_own_stock_by_csv_confirm(Request $request) {
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $success = 0;
            $error = 0;
            $shop_id = Auth::user()->shop_id;
            $filename= $request->csvFile; 
            $file = fopen($filename, "r");
            $i = 4;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $pid = $getData[1];
                $purchase_price = $getData[2];
                $godown_stock = $getData[3];
                $numcols = count($getData);
                $j = $numcols;
                $data[] = $getData;
                $product_check = DB::table('products')->where('shop_id', $shop_id)->where('id', $pid)->first(['id', 'G_current_stock']);

                if(!empty($product_check->id)) {

                    //for Godown stock update
                    if($godown_stock != 0 && $godown_stock != '') {
                        $updated_stock = $product_check->G_current_stock + $godown_stock;
                        $update_stock = DB::table('products')->where(['id'=>$pid, 'shop_id'=>$shop_id])->update(['G_current_stock'=>$updated_stock]);
                        if($update_stock) {
                            $total_price = $godown_stock*$purchase_price;
                            $insert_product_trackers = DB::table('product_trackers')->insert(['product_id'=>$pid, 'quantity'=>$godown_stock, 'price'=>$purchase_price, 'total_price'=>$total_price, 'status'=>1, 'product_form'=>'OWS', 'invoice_id'=>'000', 'created_at'=>Carbon::now()]);
                            if($insert_product_trackers) {
                                $success++;
                                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Own Stock', 'created_at' => Carbon::now()]);
                            }
                            else {
                                $error++;
                            }
                        }
                    }

                    //for branch
                    for($i = 4; $i < $j; $i++) {
                        $unit = $getData[$i];
                        $branch_name = $data[0][$i];
                        if($unit != 0 && $unit != '') {
                            $branch_info = DB::table('branch_settings')->where(['branch_name'=>$branch_name, 'shop_id'=>$shop_id])->first('id');
                            if(!empty($branch_info->id)) {
                                $branch_current_stock = DB::table('product_stocks')->where(['pid'=>$pid, 'branch_id'=>$branch_info->id])->first(['stock', 'id']);
                                if(!empty(optional($branch_current_stock)->id)) {
                                    $updated_stock = $branch_current_stock->stock+0 + $unit;
                                    $update_stock = DB::table('product_stocks')->where(['pid'=>$pid, 'branch_id'=>$branch_info->id])->update(['stock'=>$updated_stock]);
                                }
                                else {
                                    $update_stock = DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'branch_id'=>$branch_info->id, 'pid'=>$pid, 'stock'=>$unit, 'created_at'=>Carbon::now()]);
                                }
                                if($update_stock) {
                                    $total_price = $unit*$purchase_price;
                                    $insert_product_trackers = DB::table('product_trackers')->insert(['product_id'=>$pid, 'branch_id'=>$branch_info->id, 'quantity'=>$unit, 'price'=>$purchase_price, 'total_price'=>$total_price, 'status'=>1, 'product_form'=>'OWS', 'invoice_id'=>'000', 'created_at'=>Carbon::now()]);
                                    if($insert_product_trackers) {
                                        $success++;
                                        DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Own Stock', 'created_at' => Carbon::now()]);
                                    }
                                    else {
                                        $error++;
                                    }
                                }
                            }
                        }
                        
                    }
                }

            $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
            $i = 4; 
            }
            
            fclose($file);
            return Redirect()->back()->with('success', 'CSV Upload with '.$success.' Success And '.$error.' Error.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: update own stock using csv


    //Begin:: Set own stock using CSV
    public function admin_download_opening_stock_csv(Request $request) {
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $place = $request->place;
            if($place == 'G') {
                $shop_id = Auth::user()->shop_id;
                $delimiter = ",";
        
                //For Instant Date and Time
                $filename = date('d-m-Y')." Product for Set Godown Opening stock.csv";
                
                //create a file pointer
                $f = fopen('php://memory', 'w');
                $fields = array('Product Name', 'Product id',  'Purchase Price', 'Godown');
                fputcsv($f, $fields, $delimiter);
                
                //output each row of the data, format line as csv and write to file pointer
                $products = DB::table('products')->where(['shop_id'=>$shop_id, 'active'=>1])->get(['id', 'p_name', 'purchase_price']);
                foreach($products as $product) {
                    $check_opening_stock = DB::table('product_trackers')->where(['product_id'=>$product->id, 'product_form'=>'OP', 'invoice_id'=>'G'])->first('id');
                    if(empty($check_opening_stock->id)) {
                        $lineData = array($product->p_name, $product->id, $product->purchase_price, 0);
                        fputcsv($f, $lineData, $delimiter);
                    }
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
                $shop_id = Auth::user()->shop_id;
                $delimiter = ",";
                $branch = DB::table('branch_settings')->where(['shop_id'=>$shop_id, 'id'=>$place])->first(['id', 'branch_name']);
                //For Instant Date and Time
                $filename = date('d-m-Y')." Product for Set ".$branch->branch_name." Opening stock.csv";
                
                //create a file pointer
                $f = fopen('php://memory', 'w');
                $fields = array('Product Name', 'Product id',  'Purchase Price');
                array_push($fields, $branch->branch_name);
                
                //set column headers
                fputcsv($f, $fields, $delimiter);
                
                //output each row of the data, format line as csv and write to file pointer
                $products = DB::table('products')->where(['shop_id'=>$shop_id, 'active'=>1])->get(['id', 'p_name', 'purchase_price']);
                foreach($products as $product) {
                    $check_opening_stock = DB::table('product_trackers')->where(['product_id'=>$product->id, 'product_form'=>'OP', 'branch_id'=>$branch->id])->first('id');
                    if(empty($check_opening_stock->id)) {
                        $lineData = array($product->p_name, $product->id, $product->purchase_price, 0);
                        fputcsv($f, $lineData, $delimiter);
                    }
                }
                
                //move back to beginning of file
                fseek($f, 0);
                //set headers to download file rather than displayed
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $filename . '";');
                
                //output all remaining data on a file pointer
                fpassthru($f);
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function admin_opening_stock_csv_upload_confirm(Request $request) {
        if(User::checkPermission('admin.set.opening.and.own.stock') == true){
            $success = 0;
            $error = 0;
            $shop_id = Auth::user()->shop_id;
            $filename= $request->opening_stock_csv_file; 
            $file = fopen($filename, "r");
            $i = 4;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $pid = $getData[1];
                $purchase_price = $getData[2];
                $unit = $getData[3];

                $data[] = $getData;
                $product_check = DB::table('products')->where('shop_id', $shop_id)->where('id', $pid)->first(['id', 'G_current_stock', 'p_name']);
                if(!is_null($unit)) {
                    if(!empty($product_check->id)) {
                        $place = $data[0][3];
                        // check and set product godown opening stock
                        if($place == 'Godown') {
                            $check_opening_stock = DB::table('product_trackers')->where(['product_id'=>$pid, 'product_form'=>'OP', 'invoice_id'=>'G'])->first('id');
                            if(empty($check_opening_stock->id)) {
                                $updated_stock = ($product_check->G_current_stock+0) + $unit;
                                $update_stock = DB::table('products')->where(['id'=>$pid, 'shop_id'=>$shop_id])->update(['G_current_stock'=>$updated_stock]);
                                if($update_stock) {
                                    $total_price = $unit*$purchase_price;
                                    $insert_product_trackers = DB::table('product_trackers')->insert(['product_id'=>$pid, 'quantity'=>$unit, 'price'=>$purchase_price, 'total_price'=>$total_price, 'status'=>1, 'product_form'=>'OP', 'invoice_id'=>'G', 'created_at'=>Carbon::now()]);
                                    if($insert_product_trackers) {
                                        $success++;
                                        DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' =>'Set Godown Opening Stock(Product Name: '.$product_check->p_name.', Unit: '.$unit.' )', 'created_at' => Carbon::now()]);
                                    }
                                    else {
                                        $error++;
                                    }
                                }
                            }
                        }
                        else {
                            // check and set product Branch opening stock
                            $branch_info = DB::table('branch_settings')->where(['branch_name'=>$place, 'shop_id'=>$shop_id])->first(['id', 'branch_name']);
                            $check_opening_stock = DB::table('product_trackers')->where(['product_id'=>$pid, 'product_form'=>'OP', 'branch_id'=>optional($branch_info)->id])->first('id');
                            if(!empty($branch_info->id) && empty(optional($check_opening_stock)->id)) {
                                $branch_current_stock = DB::table('product_stocks')->where(['pid'=>$pid, 'branch_id'=>$branch_info->id])->first(['stock', 'id']);
                                if(!empty(optional($branch_current_stock)->id)) {
                                    $updated_stock = $branch_current_stock->stock + $unit;
                                    $update_stock = DB::table('product_stocks')->where(['pid'=>$pid, 'branch_id'=>$branch_info->id])->update(['stock'=>$updated_stock]);
                                }
                                else {
                                    $update_stock = DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'branch_id'=>$branch_info->id, 'pid'=>$pid, 'stock'=>$unit, 'created_at'=>Carbon::now()]);
                                }

                                if($update_stock) {
                                    $total_price = $unit*$purchase_price;
                                    $insert_product_trackers = DB::table('product_trackers')->insert(['product_id'=>$pid, 'branch_id'=>$branch_info->id, 'quantity'=>$unit, 'price'=>$purchase_price, 'total_price'=>$total_price, 'status'=>1, 'product_form'=>'OP', 'invoice_id'=>'000', 'created_at'=>Carbon::now()]);
                                    $success++;
                                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' =>'Set '.$branch_info->branch_name.' Opening Stock(Product Name: '.$product_check->p_name.', Unit: '.$unit.' )', 'created_at' => Carbon::now()]);
                                }
                                else {
                                    $error++;
                                }
                            }
                        }
                    }

                }

            $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
            }
            
            fclose($file);
            return Redirect()->back()->with('success', 'CSV Upload with '.$success.' Success And '.$error.' Error.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Set own stock using CSV


    //Products Ledger table
    public function products_ledger_table() {
        if(User::checkPermission('admin.product.ledger.table') == true){
            $wing = 'main';
            $products = Product::where('shop_id', Auth::user()->shop_id)->select(['id', 'p_name', 'p_brand', 'G_current_stock', 'p_unit_type'])->orderBy('id', 'desc')->paginate(50);
            return view('cms.shop_admin.produts.products_ledger_table', compact('wing', 'products'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function test_png_barcode_generator_can_generate_code_128_barcode()
    {
        // $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        // $generator->useGd();
        // $generated = $generator->getBarcode('081231723897', $generator::TYPE_CODE_128);

        // $this->assertEquals('PNG', substr($generated, 1, 3));
        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
        echo '<img src="data:image/png;base64,' .base64_encode($generator->getBarcode('081gfhfgh230', $generator::TYPE_CODE_128)) . '">';
    }


    

    

    

    


    

    
}
