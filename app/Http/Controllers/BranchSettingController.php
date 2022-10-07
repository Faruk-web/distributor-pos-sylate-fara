<?php

namespace App\Http\Controllers;
use App\Models\Branch_setting;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Product_stock;
use function PHPUnit\Framework\isNull;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\PointRedeemInfo;
use App\Models\Shop_setting;
use App\Models\Purchase_lines;
use App\Models\Area;


class BranchSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('branch') == true){
            $wing = 'main';
            $branches = branch_setting::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.branch.all_branch', compact('branches', 'wing'));
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
        if(User::checkPermission('branch') == true){
            $data = array();
            $data['shop_id'] = Auth::user()->shop_id;
            $data['branch_name'] = $request->branch_name;
            $data['branch_address'] = $request->branch_address;
            $data['branch_phone_1'] = $request->branch_phone_1;
            $data['branch_phone_2'] = $request->branch_phone_2;
            $data['branch_email'] = $request->branch_email;
            $data['vat_status'] = $request->vat_status;
            $data['vat_rate'] = $request->vat_rate;
            $data['discount_type'] = $request->discount_type;
            $data['online_sell_status'] = 'no';
            $data['sell_note'] = 'no'; //$request->sell_note;
            $data['others_charge'] = 'no'; //$request->others_charge;
            $data['sms_status'] = 'no'; //$request->sms_status;
            $data['print_by'] = $request->default_printer;
            
            $data['created_at'] = Carbon::now();
            
            $insert = DB::table('branch_settings')->insert($data);
            if($insert) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Add New Branch(Branch Name: '.$request->branch_name.')', 'created_at' => Carbon::now()]);
                Alert::success('Success', 'New Branch has been created.');
                return Redirect()->back();
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
     * @param  \App\Models\branch_setting  $branch_setting
     * @return \Illuminate\Http\Response
     */
    public function show(branch_setting $branch_setting)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\branch_setting  $branch_setting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('branch') == true){
            $wing = 'main';
            $branch_info = branch_setting::where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            return view('cms.shop_admin.branch.edit_branch', compact('branch_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\branch_setting  $branch_setting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('branch') == true){
            $data = array();
            $data['branch_name'] = $request->branch_name;
            $data['branch_address'] = $request->branch_address;
            $data['branch_phone_1'] = $request->branch_phone_1;
            $data['branch_phone_2'] = $request->branch_phone_2;
            $data['branch_email'] = $request->branch_email;
            $data['vat_status'] = $request->vat_status;
            $data['vat_rate'] = $request->vat_rate;
            $data['discount_type'] = $request->discount_type;
            $data['online_sell_status'] = 'no';
            $data['sell_note'] = 'no'; //$request->sell_note;
            $data['others_charge'] = 'no'; //$request->others_charge;
            $data['sms_status'] = 'no'; //$request->sms_status;
            $data['print_by'] = $request->default_printer;
            $data['updated_at'] = Carbon::now();
            
            $update = DB::table('branch_settings')->where('id', $id)->update($data);
            if($update) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Branch(Name: '.$request->branch_name.') Info', 'created_at' => Carbon::now()]);
                Alert::success('Success', 'Branch has been updated successfully.');
                return Redirect()->route('admin.all.branch');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\branch_setting  $branch_setting
     * @return \Illuminate\Http\Response
     */
    public function destroy(branch_setting $branch_setting)
    {
        //
    }

    //Begin:: Branch user role and permission
    public function Branch_role_and_permission() {
        if(User::checkPermission('branch.role.permission') == true){
            $wing = 'main';
            $roles = DB::table('roles')->where('shop_id', Auth::user()->shop_id)->where('which_roll', 'branch')->get();
            return view('cms.shop_admin.branch.branch_roles', compact('roles', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Branch user role and permission

    //Begin:: Create Branch user role
    public function Create_branch_role(Request $request) {
        if(User::checkPermission('branch.role.permission') == true){
            $role_name = Auth::user()->shop_id.'#'.$request->name;
            $check = DB::table('roles')->where('name', $role_name)->first();
            if(!empty($check->id)) {
                return Redirect()->back()->with('error', 'This role is already exist!');
            }
            else {
                $data = array();
                $data['name'] = $role_name;
                $data['which_roll'] = 'branch';
                $data['guard_name'] = 'web';
                $data['shop_id'] = Auth::user()->shop_id;
                $data['created_at'] = Carbon::now();

                $insert = DB::table('roles')->insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New Branch Role(role name: '.$request->name.')', 'created_at' => Carbon::now()]);
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
    //End:: Create Branch user role

    //Begin:: Edit Branch user role
    public function Edit_branch_user_role($id) {
        if(User::checkPermission('branch.role.permission') == true){
            $role_info = DB::table('roles')->where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            if(!empty($role_info->id)) {
                $wing = 'main';
                return view('cms.shop_admin.branch.edit_branch_role', compact('role_info', 'wing'));
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
    //Begin:: Edit Branch user role

    //Begin:: Update Branch user role
    public function Update_branch_user_role(Request $request, $id) {
        if(User::checkPermission('branch.role.permission') == true){
            $role_name = Auth::user()->shop_id.'#'.$request->name;
            $check = DB::table('roles')->where('name', $role_name)->first();
            if(!empty($check->id)) {
                Alert::warning('Warning', 'Sorry, This role is already exist!');
                return Redirect()->back();
            }
            else {
                $data = array();
                $data['name'] = $role_name;
                $data['updated_at'] = Carbon::now();
                $update = DB::table('roles')->where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Branch User Role(role name: '.$request->name.')', 'created_at' => Carbon::now()]);
                    return Redirect()->route('admin.branch.role')->with('success', 'Role has been Updated.');
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
    //Begin:: Update Branch user role

    //Begin:: Branch role Permission
    public function branch_helper_permission($id) {
        if(User::checkPermission('branch.role.permission') == true){
            $role = Role::findById($id);
            $permissions = Permission::all();
            $permissionGroups = User::getPermissionGroupsForBranchUser();
            $wing = 'main';
            return view('cms.shop_admin.branch.branch_user_role_permission', compact('permissions', 'permissionGroups', 'role', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        } 
    }
    //End:: Branch role Permission

    //Begin:: Branch Setting Index
    public function branch_setting_index() {
        if(User::checkPermission('branch.setting') == true){
            $branch_info = branch_setting::where('id', Auth::user()->branch_id)->first();
            $wing = 'main';
            return view('cms.branch.branch_info.setting', compact('branch_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Branch Setting Index

    //Begin:: Branch Setting Update
    public function branch_setting_update(Request $request) {
        if(User::checkPermission('branch.setting') == true){
            $data = array();
            $data['vat_status'] = $request->vat_status;
            $data['vat_rate'] = $request->vat_rate;
            $data['discount_type'] = $request->discount_type;
            $data['online_sell_status'] = $request->online_sell_status;
            $data['sell_note'] = $request->sell_note;
            $data['others_charge'] = $request->others_charge;
            $data['sms_status'] = $request->sms_status;
            $data['print_by'] = $request->default_printer;
            $data['updated_at'] = Carbon::now();

            $update = branch_setting::where('id', Auth::user()->branch_id)->update($data);
            if($update) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Updated Branch Settings', 'created_at' => Carbon::now()]);
                return Redirect()->back()->with('success', 'Setting update successfully.');
            }
            else {
                Redirect()->back()->with('error', 'Something is wrong, Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Branch Setting Update


    //Begin:: Branch Product Sell
    public function branch_sell($customer_code) {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $customer_info = Customer::where('code', $customer_code)->where('shop_id', $shop_id)->first();
            $branch_id = Auth::user()->branch_id;
            //return "hello";
            if(empty($branch_id)) {
                $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
                if(empty($branch_id)) { 
                    return Redirect()->route('admin.shop_setting')->with('error', 'Sorry! Please set default sell branch from settings.');
                }
            }
            
            $branch_info = Branch_setting::where('id', $branch_id)->first();
            if(!empty($customer_info->id)) {
                $categories = Category::where('shop_id', $shop_id)->where('active', 1)->get(['cat_name', 'id']);
                $delivery_man = DB::table('users')->where(['shop_id'=>$shop_id, 'type'=>'delivery_man', 'active'=>1])->where(function ($query) use ($branch_id) { $query->where('branch_id', '=', $branch_id)->orWhere('branch_id', '=', null); })->get(['name', 'id', 'phone']);
                $banks = DB::table('banks')->where('shop_id', $shop_id)->get(['bank_name', 'id', 'bank_branch']);
                return view('cms.branch.sell.pos', compact('customer_info', 'categories', 'delivery_man', 'banks', 'branch_info'));
            }
            else {
                $wing = 'main';
                return view('cms.branch.sell.product_sell', compact('customer_info', 'wing', 'branch_info'));
            } 
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }
    //End:: Branch Product Sell

    //Begin:: search customer for sell
    public function branch_search_customer(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $customer_info = $request->get('customer_info');
       
          $customers = DB::table('customers')
                ->where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($customer_info) {
                    $query->where('phone', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('code', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $customer_info. '%');
                })
                ->get(['name', 'address', 'phone', 'email', 'code']);
          
          
          if(!empty($customer_info)) {
              if(count($customers) > 0) {
                foreach ($customers as $customer) {
                    $output.='<tr>'.
                        '<td>'.$customer->name.'</td>'.
                        '<td>'.$customer->phone.'</td>'.
                        '<td>'.$customer->email.'</td>'.
                        '<td>'.$customer->address.'</td>'.
                        '<td>'.$customer->code.'</td>'.
                        '<td><a href="'.route('branch.sell', ['customer_code'=>$customer->code]).'" type="button" class="btn btn-primary btn-sm">Select</a></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h2>No Result Found</h2></td></tr>';
            }
            
        }
        
        return Response($output);
    }
    //End:: search customer for sell

    //Begin:: Check customer phone number
    public function branch_check_customer_phone(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $phone = $request->get('phone');
        $customers = Customer::where('shop_id', $shop_id)->where('phone', $phone)->first(['id', 'name', 'code']);
          if(empty($customers->id)) {
            $output.='<span class="text-success"><i class="fas fa-user-check"></i></span>';
          }
          elseif(!empty($customers->id)){
            $output.='<span class="text-danger">This number is exist as <span class="text-primary">'.$customers->name.', Code: '.$customers->code.'</span></span>';
          }
          return Response($output);
    }
    //End:: Check customer phone number

    //Begin:: Check customer Email
    public function branch_check_customer_email(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $email = $request->get('email');
        $customers = Customer::where('shop_id', $shop_id)->where('email', $email)->first(['id', 'name', 'code']);
          if(empty($customers->id)) {
            $output.='<span class="text-success"><i class="fas fa-user-check"></i></span>';
          }
          elseif(!empty($customers->id)){
            $output.='<span class="text-danger">This email is exist as <span class="text-primary">'.$customers->name.', Code: '.$customers->code.'</span></span>';
          }
          return Response($output);
    }
    //End:: Check customer Email

    //Begin:: Add New customer from branch sell page
    public function add_new_customer(Request $request) {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;

            $customers = DB::table('customers')
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();

            if(empty($customers->id)) {
                $customer_count = customer::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $up_count = $customer_count->id+1;

                $code = 'C'.$shop_id.'S'.$up_count;
                $data = array();
                $data['shop_id'] = $shop_id;
                $data['branch_id'] = Auth::user()->branch_id;
                $data['code'] = $code;
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['opening_bl'] = 0;
                $data['balance'] = 0;
                $data['created_at'] = Carbon::now();

                $insert = customer::insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Customer (Name: '.$request->name.', Phone: '.$phone.') Added', 'created_at' => Carbon::now()]);
                    return redirect()->route('branch.sell', ['customer_code'=>$code])->with('success', 'Customer is added, can sell now.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Customer is Exist, please try new.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Add New customer from branch sell page


    //Begin:: branch category to product brand search
    public function branch_category_to_brand_search(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $cat_id = $request->get('category_id');
        $products_query = Product::where('p_cat', $cat_id)->where('p_brand', '!=', '')->groupBy('p_brand')->get(['p_brand']);
        if($products_query != '[]') {
            $output='<option value="">Select Brand</option>';
            foreach($products_query as $item) {
                $output.='<option value="'.$item->p_brand.'">'.optional($item->brand_info)->brand_name.'</option>';
            }
        }
        else {
            $output.='<option value="">No Brand Found</option>';
        }
        
        return Response($output);
    }
    //End:: branch category to product brand search

    //Begin:: get products from barcode
    public function get_products_from_barcode(Request $request) {
        $barcode = $request->barcode;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
        }
        $product = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$branch_id, 'products.barCode'=>$barcode, 'products.active'=>1])
                    ->first(['products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock']);

        if(!empty($product->id)) {
            $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
            $sts = [
                'exist' => 'yes',
                'unit_name' => $unit_name->unit_name,
                'pid' => $product->id,
                'p_name' => $product->p_name,
                'discount' => $product->discount,
                'discount_amount' => $product->discount_amount,
                'barCode' => $product->barCode,
                'barCode' => $product->barCode,
                'selling_price' => $product->selling_price,
                'stock' => $product->stock,
                'vat_rate' => $product->vat_rate,
            ];
        }
        else {
            $sts = [
                'exist' => 'no',
            ];
        }
        return response()->json($sts);

    }
    //End:: get products from barcode

    //Begin:: branch Product Search into sell
    public function branch_product_search_into_sell(Request $request) {
        $output = '';
        $category_id = $request->category_id;
        $product_info = $request->product_info;
        $brand_id = $request->brand_id;
        $shop_id = Auth::user()->shop_id;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
        }
        $price = ENV('DEFAULT_CURRENCY');

        if(!empty($category_id) && empty($product_info) && empty($brand_id)) {
            //only Catgory id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);

            if(count($products) > 0) {
                foreach ($products as $product) {
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                    $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...<br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                }
            }
            else {
                $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
            }
        }
        elseif(empty($category_id) && empty($product_info) && !empty($brand_id)) {
           //only Brand id is exist
           $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                    ->where('product_stocks.stock', '>', 0)
                    ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                    ->paginate(27);

            if(count($products) > 0) {
                foreach ($products as $product) {
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                    $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                }
            }
            else {
                $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
            }

        }
        elseif(!empty($category_id) && empty($product_info) && !empty($brand_id)) {
                //Category with Brand id is exist
                $products = DB::table('products')
                            ->distinct()
                            ->leftJoin('product_stocks', function($join)
                                {
                                    $join->on('products.id', '=', 'product_stocks.pid');
                                })
                            ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                            ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                            ->paginate(27);

                if(count($products) > 0) {
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...<br \><span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(empty($category_id) && !empty($product_info) && empty($brand_id)) {
            //Only Product info is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(!empty($category_id) && !empty($product_info) && empty($brand_id)) {
            //Product info with category id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(empty($category_id) && !empty($product_info) && !empty($brand_id)) {
            //Product info with Brand id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(!empty($category_id) && !empty($product_info) && !empty($brand_id)) {
            //Product info with Brand and category id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(empty($category_id) && empty($product_info) && empty($brand_id)) {
            $products = DB::table('products')
                     ->distinct()
                     ->leftJoin('product_stocks', function($join)
                         {
                             $join->on('products.id', '=', 'product_stocks.pid');
                         })
                      ->where(['product_stocks.branch_id'=>$branch_id, 'products.shop_id'=>$shop_id, 'products.active'=>1])
                      ->where('product_stocks.stock', '>', 0)
                     ->select('products.id', 'products.p_name', 'products.p_description', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                     ->paginate(27);

            if(count($products) > 0) {
                foreach ($products as $product) {
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                    $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                }
            }
            else {
                $output = '<div class="h4 col-md-12 pt-5 text-center">-- No Products to display --</div>';
            }
        }
        
        return Response($output);
    }
    //End:: branch Product Search into sell


    //Begin:: Get Products from sell
    public function get_products_from_sell(Request $request) {
        $output = '';
        $category_id = $request->category_id;
        $product_info = $request->product_info;
        $brand_id = $request->brand_id;
        $shop_id = Auth::user()->shop_id;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
        }

        $price = ENV('DEFAULT_CURRENCY');

        if(!empty($category_id) && empty($product_info) && empty($brand_id)) {
            //only Catgory id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);

            if(count($products) > 0) {
                $status = 'yes';
                foreach ($products as $product) {
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                    $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                }
            }
            else {
                $status = 'no';
                $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
            }
        }
        elseif(empty($category_id) && empty($product_info) && !empty($brand_id)) {
           //only Brand id is exist
           $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                    ->where('product_stocks.stock', '>', 0)
                    ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                    ->paginate(27);

            if(count($products) > 0) {
                $status = 'yes';
                foreach ($products as $product) {
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                    $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                }
            }
            else {
                $status = 'no';
                $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
            }

        }
        elseif(!empty($category_id) && empty($product_info) && !empty($brand_id)) {
                //Category with Brand id is exist
                $products = DB::table('products')
                            ->distinct()
                            ->leftJoin('product_stocks', function($join)
                                {
                                    $join->on('products.id', '=', 'product_stocks.pid');
                                })
                            ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                            ->where('product_stocks.stock', '>', 0)
                            ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                            ->paginate(27);

                if(count($products) > 0) {
                    $status = 'yes';
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $status = 'no';
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(empty($category_id) && !empty($product_info) && empty($brand_id)) {
            //Only Product info is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    $status = 'yes';
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $status = 'no';
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(!empty($category_id) && !empty($product_info) && empty($brand_id)) {
            //Product info with category id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    $status = 'yes';
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $status = 'no';
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(empty($category_id) && !empty($product_info) && !empty($brand_id)) {
            //Product info with Brand id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    $status = 'yes';
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $status = 'no';
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(!empty($category_id) && !empty($product_info) && !empty($brand_id)) {
            //Product info with Brand and category id is exist
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('product_stocks', function($join)
                            {
                                $join->on('products.id', '=', 'product_stocks.pid');
                            })
                        ->where(['product_stocks.branch_id'=>$branch_id, 'products.p_cat'=>$category_id, 'products.p_brand'=>$brand_id, 'products.active'=>1])
                        ->where('product_stocks.stock', '>', 0)
                        ->where(function ($query) use ($product_info) {
                            $query->where('products.p_name', "like", "%" .$product_info. "%")
                                    ->orWhere('products.barCode', "like", "%" .$product_info. "%");
                        })
                        ->select('products.id', 'products.p_name', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                        ->paginate(27);
                
                if(count($products) > 0) {
                    $status = 'yes';
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                else {
                    $status = 'no';
                    $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
                }
        }
        elseif(empty($category_id) && empty($product_info) && empty($brand_id)) {
            $products = DB::table('products')
                     ->distinct()
                     ->leftJoin('product_stocks', function($join)
                         {
                             $join->on('products.id', '=', 'product_stocks.pid');
                         })
                      ->where(['product_stocks.branch_id'=>$branch_id, 'product_stocks.shop_id'=>$shop_id, 'products.active'=>1])
                      ->where('product_stocks.stock', '>', 0)
                     ->select('products.id', 'products.p_name', 'products.p_description', 'products.discount', 'products.discount_amount', 'products.image', 'products.barCode', 'products.p_unit_type', 'products.selling_price', 'products.vat_rate', 'products.vat_status', 'product_stocks.stock')
                     ->paginate(27);

            if(count($products) > 0) {
                $status = 'yes';
                if ($request->ajax()) {
                    foreach ($products as $product) {
                        $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $output.='<div  onclick="myFunction('.optional($product)->id.', \''.optional($product)->p_name.'\', \''.optional($product)->p_description.'\', '.(optional($product)->selling_price+0).', '.(optional($product)->stock+0).', \''.optional($unit_name)->unit_name.'\', \''.optional($product)->discount.'\', '.(optional($product)->discount_amount+0).', '.(optional($product)->vat_rate+0).')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 30).'...  <br \> <span class="p_n_qty">'.optional($product)->selling_price.' '.$price.', Qty: '.optional($product)->stock.' '.$unit_name->unit_name.'</span></span></div></div></div>';
                    }
                }
                
            }
            else {
                $status = 'no';
                $output = '<div class="h4 col-md-12 pt-5 text-center">-- No Products to display --</div>';
            }


        }

        $response = [
            'info' => $output,
            'status' => $status,
        ];
        
        return Response($response);
    }
    //End:: Get Products from sell
    


    //Begin:: select walking Customer
    public function select_walking_customer() {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $check = DB::table('customers')->where(['shop_id'=>$shop_id, 'code'=>$shop_id.'WALKING'])->first('code');
            if(!empty($check->code)) {
                return Redirect()->route('branch.sell', ['customer_code'=>$check->code]);
            }
            else {
                return Redirect()->back()->with('error', 'error occurred, please try again');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: select walking Customer


    //Begin:: Received Customer Due
    public function received_customer_due_index($customer_code) {
        if(User::checkPermission('branch.received.customer.due') == true){
            $customer_info = DB::table('customers')->where(['code'=>$customer_code, 'shop_id'=>Auth::user()->shop_id])->first();
            return view('cms.branch.take_due.take_customer_due', compact('customer_info'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    //Begin:: search customer for take due
    public function branch_search_customer_for_take_due(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $customer_info = $request->get('customer_info');
        //   $customers = Customer::where('shop_id', $shop_id)
        //   ->where('name', 'LIKE', '%'. $customer_info. '%')
        //   ->orWhere('phone', 'LIKE', '%'. $customer_info. '%')
        //   ->orWhere('code', 'LIKE', '%'. $customer_info. '%')
        //   ->where('active', 1)
        //   ->get(['name', 'address', 'phone', 'email', 'code', 'balance']);

          $customers = DB::table('customers')
                ->where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($customer_info) {
                    $query->where('phone', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('code', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $customer_info. '%');
                })
                ->get(['name', 'address', 'phone', 'email', 'code', 'balance']);
          
          
          if(!empty($customer_info)) {
              if(count($customers) > 0) {
                foreach ($customers as $customer) {
                    $output.='<tr>'.
                        '<td>'.$customer->name.'</td>'.
                        '<td>'.$customer->phone.'</td>'.
                        '<td>'.$customer->email.'</td>'.
                        '<td>'.$customer->address.'</td>'.
                        '<td>'.$customer->code.'</td>'.
                        '<td>'.$customer->balance.'</td>'.
                        '<td><a href="'.route('branch.take.customer.due', ['customer_code'=>$customer->code]).'" type="button" class="btn btn-success btn-sm">Select</a></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h2>No Result Found</h2></td></tr>';
            }
            
        }
        
        return Response($output);
    }
    //End:: search customer for sell

    //End:: Received Customer Due

    //Begin:: Due Customers
    public function branch_due_customers() {
        if(User::checkPermission('branch.reports') == true){
            $customer_list = DB::table('customers')->where('branch_id', Auth::user()->branch_id)->where('balance', '>', 0)->get(['name', 'email', 'phone', 'balance', 'address']);
            return view('cms.branch.report.due_customers', compact('customer_list'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Due Customers
    
    
    
    
    
    
    

    
    // Start ========================================================================================= Sell New =================== Sell New =======>

    //Begin:: Branch Product Sell
    public function branch_sell_new() {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $all_area = Area::where(['shop_id'=>$shop_id])->get();
            $all_sr = User::Where(['active'=> 1, 'type'=>'SR', 'shop_id'=>Auth::user()->shop_id])->orderBy('name', 'ASC')->get();
            
            $categories = Category::where('shop_id', $shop_id)->where('active', 1)->get(['cat_name', 'id']);
            $brands = Brand::where('shop_id', $shop_id)->where('active', 1)->get(['brand_name', 'id']);
            
            $banks = DB::table('banks')->where('shop_id', $shop_id)->get(['bank_name', 'id', 'bank_branch']);
            return view('cms.branch.sell.pos_new', compact('categories',  'banks', 'all_sr', 'brands', 'all_area'));
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }
    //End:: Branch Product Sell

    //Begin:: SR customer for sell
    public function branch_search_sr_for_sale(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $sr_info = $request->get('sr_info');
       
          $results = User::where('shop_id', '=', $shop_id)
                        ->where('active', 1)
                        ->where('type', 'SR')
                        ->where(function ($query) use ($sr_info) {
                            $query->where('phone', 'LIKE', '%'. $sr_info. '%')
                                ->orWhere('name', 'LIKE', '%'. $sr_info. '%');
                        })
                        ->limit(8)
                        ->get(['name', 'phone', 'id', 'sr_area_id']);
          
          if(!empty($sr_info)) {
              if(count($results) > 0) {
                foreach ($results as $sr) {
                    $output.='<tr>'.
                        '<td>'.$sr->name.'</td>'.
                        '<td>'.$sr->phone.'</td>'.
                        '<td>'.optional($sr->area_info)->name.'</td>'.
                        '<td><button type="button" onclick="select_sr('.optional($sr)->id.', \''.optional($sr)->name.'\', \''.optional($sr)->phone.'\', \''.optional($sr->area_info)->name.'\')" class="btn bg-success btn-sm rounded-pill p-2 text-light">Select</button></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h2>No SR Found!!!</h2></td></tr>';
            }
            
        }
        
        return Response($output);
    }

    
    
    //Begin:: search customer for sell
    public function branch_search_customer_new(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $customer_info = $request->get('customer_info');
        $area = $request->get('search_custoemr_area');
        
          $customers = Customer::where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($customer_info) {
                    $query->where('phone', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('code', 'LIKE', '%'. $customer_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $customer_info. '%');
                });
                
                if($area != 'all') {
                  $customers = $customers->where('area_id', $area);
                }
                $customers = $customers->limit(5);
                $customers = $customers->get(['name', 'phone', 'code', 'area_id']);
                
          if(!empty($customer_info)) {
              if(count($customers) > 0) {
                foreach ($customers as $customer) {
                    $output.='<tr>'.
                        '<td>'.$customer->name.'</td>'.
                        '<td>'.$customer->phone.'</td>'.
                        '<td>'.optional($customer->area_info)->name.'</td>'.
                        '<td><button type="button" onclick="search_customer_info(\''.optional($customer)->code.'\')" class="btn bg-success rounded-pill p-2 text-light">Select</button></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h4 class="fw-bold text-danger">No Customer Found!!!</h4></td></tr>';
            }
            
        }

        return Response($output);
    }

    public function search_customer_info_new(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $code = $request->code;
       
        $customers = Customer::where('shop_id', '=', $shop_id)->where('code', $code)->first();
        
        $output = [
                'name'=>optional($customers)->name,
                'phone'=>optional($customers)->phone,
                'code'=>optional($customers)->code,
                'address'=>optional($customers)->address,
                'area'=>optional($customers->area_info)->name,
                'balance'=>optional($customers)->balance,
            ];
            
        return Response($output);
    }
    //End:: search customer for sell
    
    //Begin:: Check customer phone number
    public function branch_check_customer_phone_new(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $phone = $request->get('phone');
        $customers = Customer::where('shop_id', $shop_id)->where('phone', $phone)->first(['id', 'name', 'code']);
          if(empty($customers->id)) {
            $output.='<span class="text-success"><i class="fas fa-user-check"></i></span>';
          }
          elseif(!empty($customers->id)){
            $output.='<span class="text-danger p-2">This number is exist as <span class="text-primary">'.$customers->name.', Code: '.$customers->code.' <a type="button" onclick="search_customer_info(\''.optional($customers)->code.'\')" class="bg-success rounded-pill pl-1 pr-1 text-light">Select</a></span></span>';
          }
          return Response($output);
    }
    //End:: Check customer phone number
    
    public function add_new_customer_into_pos_new(Request $request) {
        $output = '';
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            
            $name = $request->name;
            $phone = $request->phone;
            $shop_id = Auth::user()->shop_id;

            $customers = DB::table('customers')->where('shop_id', '=', $shop_id)->where('phone', '=', $phone)->first();

            if(empty($customers->id)) {
                $customer_count = customer::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $up_count = $customer_count->id+1;

                $code = 'C'.$shop_id.'S'.$up_count;
                $data = array();
                $data['shop_id'] = $shop_id;
                $data['branch_id'] = Auth::user()->branch_id;
                $data['code'] = $code;
                $data['name'] = $name;
                $data['phone'] = $phone;
                $data['opening_bl'] = 0;
                $data['balance'] = 0;
                $data['created_at'] = Carbon::now();
                $insert = customer::insert($data);
                
                if($insert) {
                    $output = [
                        'status'=>'yes',
                        'code'=>$code,
                    ];
                }
                else {
                    $output = [
                        'status'=>'no',
                        'msg'=>'Network Error, Please Try Again!!!',
                    ];
                }
            
            }
            else {
                $output = [
                    'status'=>'no',
                    'msg'=>'Customer is Exist!!!',
                ];
            }
        }
        else {
            $output = [
                    'status'=>'no',
                    'msg'=>'You have Not Permissio!!!',
                ];
        }
        return Response($output);
    }
    
    
    public function convert_point_to_tk_into_sell(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $code = $request->code;
        $customer = DB::table('customers')->where('shop_id', '=', $shop_id)->where('code', $code)->first();
        if(!is_null($customer)) {
            $shop_settings = Shop_setting::Where('shop_code', $shop_id)->first();
            if(optional($shop_settings)->is_active_customer_points == 'yes') {
                if($customer->wallets > 0) {
                    $wallet_balance = $customer->wallets * optional($shop_settings)->point_redeem_rate;
                    
                    $pointRedeemInfo = new PointRedeemInfo;
                    $pointRedeemInfo->shop_id = $shop_id;
                    $pointRedeemInfo->customer_id = $customer->id;
                    $pointRedeemInfo->point_redeem_rate = optional($shop_settings)->point_redeem_rate;
                    $pointRedeemInfo->customer_point = $customer->wallets;
                    $pointRedeemInfo->converted_wallet_amount = $wallet_balance;
                    $pointRedeemInfo->user_id = Auth::user()->id;
                    $pointRedeemInfo->created_at = Carbon::now();
                    $status = $pointRedeemInfo->save();
                    if($status) {
                        $new_bl = $customer->wallet_balance + $wallet_balance;
                        DB::table('customers')->where('shop_id', '=', $shop_id)->where('code', $code)->update(['wallets'=>0, 'wallet_balance'=>$new_bl]);
                        $output = [
                            'status'=>'yes',
                            'code'=> $customer->code,
                        ];
                    }
                    
                }
                else {
                    $output = [
                        'status'=>'no',
                        'msg'=>'Customer Point is empty!.'
                    ];
                }
            }
            else {
                $output = [
                    'status'=>'no',
                    'msg'=>'Customer Point system is Deactive!, Please Active from Shop Settings.'
                ];
            }
        }
        else {
            $output = [
                'status'=>'no',
                'msg'=>'customer is not exist!!!'
            ];
        }
        
        return Response($output);
    }
    
    
    
    //Begin:: branch Product Search into sell
    public function branch_product_search_into_sell_new(Request $request) {
        $output = '';
        $category_id = $request->category_id;
        $product_info = $request->product_info;
        $brand_id = $request->brand_id;
        $shop_id = Auth::user()->shop_id;
        $order_method = $request->order_method;
        $sr_id = $request->sr_id;
        
        $price = ENV('DEFAULT_CURRENCY');
        
        DB::statement("SET SQL_MODE=''");
        
        if($order_method == 'make_invoice') {
            $products = DB::table('products')->where('shop_id', $shop_id)->get(['p_name', 'discount', 'discount_amount', 'image', 'selling_price as sales_price', 'variation_id', 'id', 'vat_rate', 'p_unit_type']);

                        if(!empty($category_id)) {
                            $products = $products->where('p_cat', $category_id);
                        }
                        
                        if(!empty($brand_id)) {
                            $products = $products->where('p_brand', $brand_id);
                        }
                        
                        if(!empty($product_info)) {
                            $products = $products->where('p_name', "like", "%".$product_info."%");
                        }
                        
                        $products = $products->paginate(15);

        }
        else if($order_method == 'make_invoice_with_product_delivery') {
            $products = DB::table('products')
                        ->distinct()
                        ->leftJoin('s_r_stocks', function($join)
                            {
                                $join->on('products.id', '=', 's_r_stocks.pid');
                            })
                        ->where(['s_r_stocks.sr_id'=>$sr_id, 'products.active'=>1])
                        ->where('s_r_stocks.stock', '>', 0)
                        ->select('products.p_name', 's_r_stocks.discount', 's_r_stocks.discount_amount', 'products.image', 's_r_stocks.sales_price', 's_r_stocks.variation_id', 's_r_stocks.pid', 'products.vat_rate', 'products.p_unit_type', DB::raw('SUM(s_r_stocks.stock) as total_stock'))
                        ->groupBy(['s_r_stocks.pid', 's_r_stocks.sales_price', 's_r_stocks.variation_id', 's_r_stocks.discount', 's_r_stocks.discount_amount']);
                        
                        if(!empty($category_id)) {
                            $products = $products->where('products.p_cat', $category_id);
                        }
                        
                        if(!empty($brand_id)) {
                            $products = $products->where('products.p_brand', $brand_id);
                        }
                        
                        if(!empty($product_info)) {
                            $products = $products->where('products.p_name', "like", "%".$product_info."%");
                        }
                        
                        $products = $products->paginate(15);
        
        }
        
        
        $variation_name = '';
        $v_name = 'no';
        $discount_info = '';
        if(count($products) > 0) {
            $status = 'yes';
            foreach ($products as $product) {
                $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                if($product->discount != 'no') { $discount_info = '<br>Discount: '.$product->discount.' ('.$product->discount_amount.')'; } else { $discount_info = ''; }
                if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                if(!is_null($product->variation_id) && !empty($product->variation_id)) { $v_info = DB::table('variation_lists')->where('id', $product->variation_id)->first('list_title'); $variation_name = "<br><b>( ".optional($v_info)->list_title." )</b>"; $v_name = optional($v_info)->list_title; }
                
                $output.='<div onclick="add_to_cart(\''.optional($product)->pid.'\', \''.optional($product)->p_name.'\', \''.optional($product)->variation_id.'\', \''.$v_name.'\', \''.optional($product)->sales_price.'\', \''.optional($product)->discount.'\', \''.optional($product)->discount_amount.'\', \''.optional($product)->vat_rate.'\', \''.optional($product)->total_stock.'\', \''.optional($unit_name)->unit_name.'\')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 35).'...'.$variation_name.'<br \> <span class="p_n_qty">'.optional($product)->sales_price.' '.$price.' '.$discount_info.'</span></span></div></div></div>';
            }
        }
        else {
            $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
        }
        
        return Response($output);
    }
    //End:: branch Product Search into sell
    
    //Begin:: Get Products from sell // Scrool
    public function get_products_from_sell_new(Request $request) {
        $output = '';
        $status = '';
        $category_id = $request->category_id;
        $product_info = $request->product_info;
        $brand_id = $request->brand_id;
        $shop_id = Auth::user()->shop_id;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
        }

        $price = ENV('DEFAULT_CURRENCY');
        
        DB::statement("SET SQL_MODE=''");
        
        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$branch_id, 'products.active'=>1])
                    ->where('product_stocks.stock', '>', 0)
                    // ->select('products.id', 'products.p_name', 'product_stocks.discount', 'product_stocks.discount_amount', 'products.image', 'product_stocks.sales_price', 'product_stocks.variation_id', 'product_stocks.pid')
                    ->select('products.p_name', 'product_stocks.discount', 'product_stocks.discount_amount', 'products.image', 'product_stocks.sales_price', 'product_stocks.variation_id', 'product_stocks.pid', 'products.vat_rate', 'products.p_unit_type', DB::raw('SUM(product_stocks.stock) as total_stock'))
                    ->groupBy(['product_stocks.pid', 'product_stocks.sales_price', 'product_stocks.variation_id', 'product_stocks.discount', 'product_stocks.discount_amount']);
                        
                        
        if(!empty($category_id)) {
            $products = $products->where('products.p_cat', $category_id);
        }
        
        if(!empty($brand_id)) {
            $products = $products->where('products.p_brand', $brand_id);
        }
        
        if(!empty($product_info)) {
            $products = $products->where('products.p_name', "like", "%".$product_info."%");
        }
        
        $products = $products->paginate(15);
        
        $variation_name = '';
        $v_name = 'no';
        $discount_info = '';
        if(count($products) > 0) {
            $status = 'yes';
            foreach ($products as $product) {
                $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                if($product->discount != 'no') { $discount_info = '<br>Discount: '.$product->discount.' ('.$product->discount_amount.')'; } else { $discount_info = ''; }
                if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                if(!is_null($product->variation_id) && !empty($product->variation_id)) { $v_info = DB::table('variation_lists')->where('id', $product->variation_id)->first('list_title'); $variation_name = "<br><b>( ".optional($v_info)->list_title." )</b>"; $v_name = optional($v_info)->list_title; }
                
                $output.='<div onclick="add_to_cart(\''.optional($product)->pid.'\', \''.optional($product)->p_name.'\', \''.optional($product)->variation_id.'\', \''.$v_name.'\', \''.optional($product)->sales_price.'\', \''.optional($product)->discount.'\', \''.optional($product)->discount_amount.'\', \''.optional($product)->vat_rate.'\', \''.optional($product)->total_stock.'\', \''.optional($unit_name)->unit_name.'\')" title="'.optional($product)->p_name.'" class="col-md-4 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 35).'...'.$variation_name.'<br \> <span class="p_n_qty">'.optional($product)->sales_price.' '.$price.' '.$discount_info.'</span></span></div></div></div>';
            }
        }
        else {
            $output = '<div style="text-align: center" class="h4 col-md-12 p-5">-- No Products to display --</div>';
        }
        
        
        $response = [
            'info' => $output,
            'status' => $status,
        ];
        
        return Response($response);
    }
    //End:: Get Products from sell
    
    
    //Begin:: get_product_for_cart_into_sell_new
    public function get_product_for_cart_into_sell_new(Request $request) {
        $output = '';

        $pid = $request->pid;
        $sales_price = $request->sales_price;
        $variation_id = $request->variation_id;
        $discount = $request->discount;
        $discount_amount = $request->discount_amount;

        $shop_id = Auth::user()->shop_id;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
        }

        DB::statement("SET SQL_MODE=''");
        
        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$branch_id, 'products.active'=>1, 'product_stocks.pid'=>$pid, 'product_stocks.sales_price'=>$sales_price, 'product_stocks.variation_id'=>$variation_id, 'product_stocks.discount'=> $discount, 'product_stocks.discount_amount'=> $discount_amount])
                    ->where('product_stocks.stock', '>', 0)
                    ->select('products.p_name', 'product_stocks.discount', 'product_stocks.discount_amount', 'product_stocks.sales_price', 'product_stocks.variation_id', 'product_stocks.pid', 'products.vat_rate', 'products.p_unit_type', DB::raw('SUM(product_stocks.stock) as total_stock'));
                    
                   
        // if(!empty($variation_id) && $variation_id != '') {
        //     $products = $products->where('products.variation_id', $variation_id);
        // }
        
        // if(!empty($discount) && $discount != '') {
        //     $products = $products->where('products.discount', $discount);
        // }
        
        // if(!empty($discount_amount) && $discount_amount != '') {
        //     $products = $products->where('products.discount_amount', $discount_amount);
        // }
        
        
        $products = $products->get();
        
        $variation_name = 'no';
        $discount_info = '';
        if(count($products) > 0) {
            $status = 'yes';
            foreach ($products->take(1) as $product) {
                // if($product->discount != '' && $product->discount != 'no') { $discount_info = '<br>Discount: '.$product->discount.' ('.$product->discount_amount.')'; } else { $discount_info = ''; }
                if(!is_null($product->variation_id) && !empty($product->variation_id)) { $v_info = DB::table('variation_lists')->where('id', $product->variation_id)->first('list_title'); $variation_name = $v_info->list_title; }
                $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                $output = [
                        'status'=>'yes',
                        'pid'=>$product->pid,
                        'p_name'=>$product->p_name,
                        'sales_price'=>$product->sales_price,
                        'variation_id'=>$product->variation_id,
                        'variation_name'=>$variation_name,
                        'unit_name'=>optional($unit_name)->unit_name,
                        'vat_rate'=>$product->vat_rate,
                        'discount'=>$product->discount,
                        'discount_amount'=>$product->discount_amount,
                        'total_stock'=>$product->total_stock,
                    ];
            }
        }
        else {
            $output = [
                        'status'=>'no',
                    ];
        }
        
        return Response($output);
    }
    //End:: get_product_for_cart_into_sell_new
    
    
    //Begin:: get products from barcode
    public function get_products_from_barcode_new(Request $request) {
        $barcode = $request->barcode;
        $branch_id = Auth::user()->branch_id;
        if(empty($branch_id)) {
            $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
        }
        $variation_name = '';
        $product_info = '';
        $price = ENV('DEFAULT_CURRENCY');
        DB::statement("SET SQL_MODE=''");
        
        $products = DB::table('products')
                    ->distinct()
                    ->leftJoin('product_stocks', function($join)
                        {
                            $join->on('products.id', '=', 'product_stocks.pid');
                        })
                    ->where(['product_stocks.branch_id'=>$branch_id, 'products.barCode'=>$barcode, 'products.active'=>1])
                    ->where('product_stocks.stock', '>', 0)
                    ->select('products.p_name', 'products.image', 'product_stocks.discount', 'product_stocks.discount_amount', 'product_stocks.sales_price', 'product_stocks.variation_id', 'product_stocks.pid', 'products.vat_rate', 'products.p_unit_type', DB::raw('SUM(product_stocks.stock) as total_stock'))
                    ->groupBy(['product_stocks.pid', 'product_stocks.sales_price', 'product_stocks.variation_id', 'product_stocks.discount', 'product_stocks.discount_amount'])
                    ->get();
        
        if(count($products) > 0) {
            if(count($products) == 1) {
                foreach ($products->take(1) as $product) {
                    if(!is_null($product->variation_id) && !empty($product->variation_id)) { $v_info = DB::table('variation_lists')->where('id', $product->variation_id)->first('list_title'); $variation_name = $v_info->list_title; }
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    $sts = [
                        's_or_multiple'=>'s',
                        'exist'=>'yes',
                        'pid'=>$product->pid,
                        'p_name'=>$product->p_name,
                        'sales_price'=>$product->sales_price,
                        'variation_id'=>$product->variation_id,
                        'variation_name'=>$variation_name,
                        'unit_name'=>optional($unit_name)->unit_name,
                        'vat_rate'=>$product->vat_rate,
                        'discount'=>$product->discount,
                        'discount_amount'=>$product->discount_amount,
                        'stock'=>$product->total_stock,
                    ];
                }
            }
            else {
                $v_name = 'no';
                foreach ($products as $product) {
                    $unit_name = DB::table('unit_types')->where('id', $product->p_unit_type)->first(['unit_name']);
                    if($product->discount != 'no') { $discount_info = '<br>Discount: '.$product->discount.' ('.$product->discount_amount.')'; } else { $discount_info = ''; }
                    if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                    if(!is_null($product->variation_id) && !empty($product->variation_id)) { $v_info = DB::table('variation_lists')->where('id', $product->variation_id)->first('list_title'); $variation_name = "<br><b>( ".optional($v_info)->list_title." )</b>"; $v_name = optional($v_info)->list_title; }
                    
                    $product_info.='<div onclick="add_to_cart(\''.optional($product)->pid.'\', \''.optional($product)->p_name.'\', \''.optional($product)->variation_id.'\', \''.$v_name.'\', \''.optional($product)->sales_price.'\', \''.optional($product)->discount.'\', \''.optional($product)->discount_amount.'\', \''.optional($product)->vat_rate.'\', \''.optional($product)->total_stock.'\', \''.optional($unit_name)->unit_name.'\')" title="'.optional($product)->p_name.'" class="col-md-3 col-6" id="product_item"><div class="productCard"><div class="productThumb"><img class="img-fluid rounded" src="'.$img.'"></div><div class="productContent"><span>'.substr(optional($product)->p_name, 0, 35).'...'.$variation_name.'<br \> <span class="p_n_qty">'.optional($product)->sales_price.' '.$price.' '.$discount_info.'</span></span></div></div></div>';
                }
                
                $sts = [
                    'exist' => 'yes',
                    's_or_multiple'=>'m',
                    'product_info' => $product_info,
                ];
            }
        }
        else {
            $sts = ['exist' => 'no'];
        }

        return response()->json($sts);

    }
    //End:: get products from barcode
    
    
    //Begin:: multiple payment row add
    public function multiple_payment_row_add(Request $request) {
        $output = '';
        $type = $request->type;
        
        if($type == 'cash') {
            $output .= '<tr id="multiple_pay_tr_8888"><td><input type="hidden" name="multiple_pay_deposit_bank[]"><input type="hidden" name="multiple_pay_card_info[]"><input type="number" step=any name="multiple_pay_amount[]" class="form-control multiple_pay_input" required><input type="hidden" value="1" id="multiple_cash_payment"></td><td><input type="text" step=any name="multiple_pay_type_name[]" class="form-control" readonly value="cash"></td><td><div class="text-center"><i class="fas fa-trash-alt text-danger" onclick="remove_multiple_pay_tr(8888)"></i></div></td></tr>';
        }
        else if($type == 'card') {
            $shop_id = Auth::user()->shop_id;
            $banks = DB::table('banks')->where('shop_id', $shop_id)->get(['bank_name', 'id', 'bank_branch']);
            $rand = rand(00000, 999999999);
            $output .='<tr id="multiple_pay_tr_'.$rand.'">
                          <td><input type="number" step=any name="multiple_pay_amount[]" class="form-control multiple_pay_input" required><input type="hidden" value="1" id="multiple_card_payment_'.$rand.'"></td>
                          <td class="text-light bg-dark">
                              <input type="hidden" name="multiple_pay_type_name[]" value="card">
                              <div class="form-group">
                                <label>Card or Bank or Mobile Banking Info.</label>
                                <textarea id="" name="multiple_pay_card_info[]" class="form-control" rows="2" cols="50"></textarea>
                             </div>
                             <div class="form-group p-2">
                                <label>Diposit to</label>
                                <select class="form-control" name="multiple_pay_deposit_bank[]" required>
                                    <option value="">Select A bank</option>';
                                    foreach($banks as $bank) {
                                    $output .='<option value="'.$bank->id.'">'.$bank->bank_name.' ['.$bank->bank_branch.']</option>';
                                    }
                                $output .='</select>
                             </div>
                          </td>
                          <td><div class="text-center"><i class="fas fa-trash-alt text-danger" onclick="remove_multiple_pay_tr('.$rand.')"></i></div></td>
                        </tr>';
        }
       
        return Response($output);
    }
    
    
    
    public function new_command() {
        
        $data = Carbon::now();
        
        
        /*
        //Set purchase line and 
        $supp_to_branch = 'SUPP_TO_B';
        $SUPP_TO_G = 'SUPP_TO_G';
        $data = Carbon::now();
        
        //$product_trackers = DB::table('product_trackers')->where('purchase_price', null)->select('product_id', DB::raw('count(product_id) as total'))->groupBy('product_id')->limit(1000)->get();
        
        $product_info = DB::table('products')->orderBy('id', 'DESC')->limit(2000)->get(['purchase_price', 'selling_price', 'shop_id', 'id']);
        
        //return $product_info;
               
        foreach($product_info as $key=>$item) {
            //$product_info = DB::table('products')->where('id', $item->product_id)->first(['purchase_price', 'selling_price', 'shop_id']);
            
            $purchase_qty = DB::table('product_trackers')->where('product_id', $item->id)->where(function ($query) use ($supp_to_branch, $SUPP_TO_G) {
                    $query->where('product_form', $supp_to_branch)
                        ->orWhere('product_form', $SUPP_TO_G);
                })->sum('quantity');
                
            $check_purchase_lines = DB::table('purchase_lines')->where(['lot_number'=>1, 'product_id'=>$item->id])->first(['id', 'lot_number']);
                
            if(!empty(optional($item)->shop_id) && is_null($check_purchase_lines)) {
               
                $purchase_line = new Purchase_lines;
                $purchase_line->shop_id = optional($item)->shop_id;
                $purchase_line->invoice_id = 'Update Data';
                $purchase_line->product_id = $item->id;
                $purchase_line->purchase_price = optional($item)->purchase_price;
                $purchase_line->sales_price = optional($item)->selling_price;
                $purchase_line->discount = 'no';
                $purchase_line->discount_amount = 0;
                $purchase_line->vat = 0;
                $purchase_line->lot_number = 1;
                $purchase_line->variation_id = 0;
                $purchase_line->quantity = $purchase_qty;
                $purchase_line->date = $data;
                $purchase_line->created_at = $data;
                $purchase_line->save();
                
                DB::table('product_trackers')->where('product_id', $item->id)->update(['shop_id'=>optional($item)->shop_id, 'purchase_line_id'=>$purchase_line->id, 'lot_number'=>1, 'purchase_price'=>optional($item)->purchase_price, 'sales_price'=>optional($item)->sales_price]);
            }
            else {
                if(!is_null($check_purchase_lines)) {
                    DB::table('product_trackers')->where('product_id', $item->id)->update(['shop_id'=>optional($item)->shop_id, 'purchase_line_id'=>$check_purchase_lines->id, 'lot_number'=>$check_purchase_lines->lot_number, 'purchase_price'=>optional($item)->purchase_price, 'sales_price'=>optional($item)->sales_price]);
                }
            }
                
            //echo $key." ".optional($product_info)->shop_id."<br>";
        }
        
        //End Set purchase Line
        */
        
        /*
        //Start Godown stock update
        $products = DB::table('products')->where('G_current_stock', '>', 0)->get();
        
        foreach($products as $p) {
            
           $status = DB::table('product_stocks')->insert(['shop_id'=>$p->shop_id, 'branch_id'=>'G', 'pid'=>$p->id, 'variation_id'=>0, 'purchase_price'=>$p->purchase_price, 'sales_price'=>$p->selling_price, 'discount'=>'no', 'discount_amount'=>0, 'vat'=>0, 'stock'=>$p->G_current_stock , 'created_at'=>$data]);
           if($status) {
               DB::table('products')->where('id', $p->id)->update(['G_current_stock'=>0]);
           }
        }
        //End godown stock update
        */
        
        //Start Product Stock Set
        /*
        $stocks_products = DB::table('product_stocks')->where('purchase_line_id', null)->limit(500)->get(['pid', 'shop_id', 'id']);
        foreach($stocks_products as $ps) {
            $check_purchase_lines = DB::table('purchase_lines')->where(['lot_number'=>1, 'product_id'=>$ps->pid])->first(['id']);
            if(!is_null($check_purchase_lines)) {
                DB::table('product_stocks')->where('id', $ps->id)->update(['purchase_line_id'=>$check_purchase_lines->id]);
            }
            else {
                $product_info = DB::table('products')->where('id', $ps->pid)->first(['purchase_price', 'selling_price', 'shop_id']);
                
                if(!is_null($product_info)) {
                   $supp_to_branch = 'SUPP_TO_B';
                    $SUPP_TO_G = 'SUPP_TO_G';
                    $purchase_qty = DB::table('product_trackers')->where('product_id', $ps->pid)->where(function ($query) use ($supp_to_branch, $SUPP_TO_G) {
                        $query->where('product_form', $supp_to_branch)
                            ->orWhere('product_form', $SUPP_TO_G);
                    })->sum('quantity');
                    
                    
                    $purchase_line = new Purchase_lines;
                    $purchase_line->shop_id = optional($product_info)->shop_id;
                    $purchase_line->invoice_id = 'Update Data';
                    $purchase_line->product_id = $ps->pid;
                    $purchase_line->purchase_price = optional($product_info)->purchase_price;
                    $purchase_line->sales_price = optional($product_info)->selling_price;
                    $purchase_line->discount = 'no';
                    $purchase_line->discount_amount = 0;
                    $purchase_line->vat = 0;
                    $purchase_line->lot_number = 1;
                    $purchase_line->variation_id = 0;
                    $purchase_line->quantity = $purchase_qty;
                    $purchase_line->date = $data;
                    $purchase_line->created_at = $data;
                   $status = $purchase_line->save();
                   
                   if($status) {
                       DB::table('product_stocks')->where('id', $ps->id)->update(['purchase_line_id'=>$purchase_line->id]);
                   } 
                }
            }
        }
        */
        //End Product Stock Set
        
        /*
        //Start set product stock set purchase price
        $info = DB::table('product_stocks')->where('purchase_price', null)->limit(5000)->get();
        
        foreach($info as $key => $item) {
            $product_info = DB::table('products')->where('id', $item->pid)->first('purchase_price');
            $status = DB::table('product_stocks')->where('id', $item->id)->update(['purchase_price'=>optional($product_info)->purchase_price]);
            echo $key." / ".optional($product_info)->purchase_price."<br>";
        }
        //End set product stock set purchase price
        */
        
        /*
        //Start set product stock set selling price
        $info = DB::table('product_stocks')->where('sales_price', null)->limit(5000)->get();
        
        foreach($info as $key => $item) {
            $product_info = DB::table('products')->where('id', $item->pid)->first('selling_price');
            $status = DB::table('product_stocks')->where('id', $item->id)->update(['sales_price'=>optional($product_info)->selling_price]);
            echo $key." / ".optional($product_info)->selling_price."<br>";
        }
        //End set product stock set selling price
        */
        
        /*
        //Start set product Trackers set purchase price
        $info = DB::table('product_trackers')->where('shop_id', null)->limit(6000)->get(['product_id', 'id']);
        
        foreach($info as $key => $item) {
            $product_info = DB::table('products')->where('id', $item->product_id)->first(['purchase_price', 'selling_price', 'shop_id']);
            if(!is_null($product_info)) {
                $status = DB::table('product_trackers')->where('id', $item->id)->update(['shop_id'=>optional($product_info)->shop_id]);
                echo $key." / ".optional($product_info)->purchase_price."<br>";
            }
        }
        //End set product stock set purchase price
        */
        
        /*
         //Start ordered_products set purchase price
        $info = DB::table('order_return_porducts')->where('purchase_price', null)->limit(20000)->get(['product_id', 'id']);
        
        foreach($info as $key => $item) {
            $product_info = DB::table('products')->where('id', $item->product_id)->first(['purchase_price']);
            if(!is_null($product_info)) {
                $status = DB::table('order_return_porducts')->where('id', $item->id)->update(['purchase_price'=>optional($product_info)->purchase_price]);
                echo $key." / ".optional($product_info)->purchase_price."<br>";
            }
        }
        //End ordered_products set purchase price
        */
        
        /*
        //Start supplier_return_products set purchase price
        $info = DB::table('product_trackers')->where('total_purchase_price', 0)->limit(40000)->get(['purchase_price', 'quantity', 'id']);
       
        foreach($info as $key => $item) {
            DB::table('product_trackers')->where('id', $item->id)->update(['total_purchase_price'=>optional($item)->purchase_price*optional($item)->quantity]);
            echo $key."<br>";
        }
        */
        
        /*
        $info = DB::table('product_trackers')->where('total_purchase_price', 0)->limit(30000)->get(['quantity', 'product_id', 'id']);
       
        foreach($info as $key => $item) {
            $product_info = DB::table('products')->where('id', $item->product_id)->first(['purchase_price']);
            DB::table('product_trackers')->where('id', $item->id)->update(['purchase_price'=>optional($product_info)->purchase_price, 'total_purchase_price'=>optional($product_info)->purchase_price*optional($item)->quantity]);
            echo $key."<br>";
        }
        */
        //End supplier_return_products set purchase price
        
        
        /*
        //Start set discount same as products
        $info = DB::table('products')->where('shop_id', 220216806)->where('discount', '!=', 'no')->orderBy('id', 'DESC')->limit(1600)->get(['id', 'discount', 'discount_amount', 'vat_rate']);
        
        foreach($info as $key => $item) {
            $product_stocks = DB::table('product_stocks')->where('pid', $item->id)->first(['id']);
            if(!is_null($product_stocks)) {
                $discount_amount = optional($item)->discount_amount + 0;
                DB::table('product_stocks')->where('id', $product_stocks->id)->update(['discount'=>optional($item)->discount, 'discount_amount'=>$discount_amount, 'vat'=>optional($item)->vat_rate]);
                echo $key." / ".optional($item)->discount."<br>";
            }
        }
        //End set discount same as products
        */
        
        
        
        
        
        
        
        
    }
    
    



    














    

    
    

    









}
