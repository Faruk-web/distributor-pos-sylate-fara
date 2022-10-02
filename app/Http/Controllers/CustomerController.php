<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use DataTables;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('branch.customers') == true){
            return view('cms.branch.customers.all_customer');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
        
    }

    public function customer_data(Request $request)
    {
        
        if ($request->ajax()) {
            $customers = customer::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<div class="dropdown"><button class="btn dropdown-toggle btn btn-info btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            if($row->active == 1) {
                                $info .= '<a type="button" href="'.route('branch.deactive.customer', ['id'=>$row->id]).'" class="dropdown-item bg-success">Active</a>';
                            }
                            else {
                                $info .= '<a type="button" href="'.route('branch.active.customer', ['id'=>$row->id]).'" class="dropdown-item bg-danger">Deactive</a>';
                            }
                            $info .= '<div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('branch.edit.customer', ['id'=>$row->id]).'">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('report.customer.ledger.table', ['code'=>$row->code]).'">Ledger</a>
                        </div>
                    </div>';
                    return $info;
                })
                
                ->rawColumns(['action'])
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
        if(User::checkPermission('branch.customers') == true){
            $customer_types = DB::table('customer_types')->where(['shop_id'=>Auth::user()->shop_id, 'active'=>1])->orderBy('id', 'desc')->get(['type_name', 'id']);
            return view('cms.branch.customers.add_customer', compact('customer_types'));
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
        if(User::checkPermission('branch.customers') == true){
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;

            $customers = DB::table('customers')
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();

            if(!$customers) {
                $customer_count = customer::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $up_count = optional($customer_count)->id+1;

                $code = 'C'.$shop_id.'S'.$up_count;
                $data = array();
                $data['shop_id'] = $shop_id;
                $data['branch_id'] = Auth::user()->branch_id;
                $data['code'] = $code;
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['customers_type_id'] = $request->customer_type;
                $data['is_comissioned'] = $request->comission_value;
                $data['opening_bl'] = $request->opening_bl;
                $data['balance'] = $request->opening_bl;
                $data['created_at'] = Carbon::now();

                $insert = customer::insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Customer (Name: '.$request->name.', Phone: '.$phone.') Added', 'created_at' => Carbon::now()]);
                    return redirect()->route('branch.all.customer')->with('success', 'New Customer Added Successfully.');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('branch.customers') == true){
            $shop_id = Auth::user()->shop_id;
            $customer_types = DB::table('customer_types')->where(['shop_id'=>$shop_id, 'active'=>1])->orderBy('id', 'desc')->get(['type_name', 'id']);
            $customer = customer::where('id', $id)->where('shop_id', $shop_id)->where('code', '!=', $shop_id.'WALKING')->first();
            if(!empty($customer->id)) {
                return view('cms.branch.customers.edit_customer', compact('customer', 'customer_types'));
            }
            else {
                return Redirect()->back()->with('error', 'Error Occoured! Please Try Again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('branch.customers') == true){
            
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;
            
            $customer = DB::table('customers')
                    ->where('id', '!=', $id)
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();

            if(!$customer) {
                $data = array();
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['customers_type_id'] = $request->customer_type;
                $data['is_comissioned'] = $request->comission_value;
                $data['updated_at'] = Carbon::now();

                $update = customer::where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Updated Customer(Name: '.$request->name.', Phone: '.$phone.') Info', 'created_at' => Carbon::now()]);
                    return redirect()->route('branch.all.customer')->with('success', 'Customer Info Update Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Phone is Exist, please try new.');
            }

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(customer $customer)
    {
        //
    }

    public function DeactiveCustomer($id) {

        if(User::checkPermission('branch.customers') == true){
            $data = array(
            'active' => 0,
            );

            $Q = customer::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
            if($Q) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Deactivate Customer', 'created_at' => Carbon::now()]);
                return redirect()->back()->with('success', 'Customer Deactive Successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Something is wrong, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }

    public function ActiveCustomer($id) {

        if(User::checkPermission('branch.customers') == true){
            $data = array(
            'active' => 1,
            );
            $Q = customer::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
            if($Q) {
                DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Activate Customer', 'created_at' => Carbon::now()]);
                return redirect()->back()->with('success', 'Customer Deactive Successfully.');
            }
            else {
                return Redirect()->back()->with('error', 'Something is wrong, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }

    //Begin:: Admin customers
    public function admin_customers() {
        if(User::checkPermission('others.customers') == true){
            $wing = 'main';
            return view('cms.shop_admin.customers.all_customers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_customers_data(Request $request)
    {
        
        if ($request->ajax()) {
            $customers = customer::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<div class="dropdown"><button class="btn dropdown-toggle btn btn-primary btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                            if($row->active == 1) {
                                $info .= '<a type="button" href="'.route('branch.deactive.customer', ['id'=>$row->id]).'" class="dropdown-item bg-success">Active</a>';
                            }
                            else {
                                $info .= '<a type="button" href="'.route('branch.active.customer', ['id'=>$row->id]).'" class="dropdown-item bg-danger">Deactive</a>';
                            }
                            $info .= '<div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('admin.edit.customer', ['id'=>$row->id]).'">Edit</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('report.customer.ledger.table', ['code'=>$row->code]).'">Ledger</a>
                            <a target="_blank" class="dropdown-item" href="'.route('customer.sold.product.ledger', ['code'=>$row->code]).'">Sold Product Ledger(<span class="text-danger">New<span>)</a>
                        </div>
                    </div>';
                    return $info;
                })
                ->addColumn('branch_name', function($row){
                    return optional($row->branch_name)->branch_name;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    
    public function admin_download_exist_customers()
    {
        if(User::checkPermission('others.customers') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
    
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Backup Customers.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $fields = array('Customer Name', 'phone(without 0)', 'Email', 'Address', 'Balance');
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $customers = customer::where('shop_id', $shop_id)->get();
            foreach($customers as $customer) {
                $lineData = array($customer->name, $customer->phone, $customer->email, $customer->address, $customer->balance);
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

    public function admin_create_customer()
    {
        if(User::checkPermission('others.customers') == true){
            $wing = 'main';
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id', 'branch_name', 'branch_address']);
            $customer_types = DB::table('customer_types')->where(['shop_id'=>Auth::user()->shop_id, 'active'=>1])->orderBy('id', 'desc')->get(['type_name', 'id']);
            return view('cms.shop_admin.customers.add_customers', compact('customer_types', 'wing', 'branches'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
        
    }



    public function admin_create_customer_confirm(Request $request)
    {
        if(User::checkPermission('others.customers') == true){
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;
            
            $customers = DB::table('customers')
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();
                    
            if(!$customers) {
                $customer_count = customer::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $up_count = optional($customer_count)->id+1;

                $code = 'C'.$shop_id.'S'.$up_count;
                $data = array();
                $data['shop_id'] = $shop_id;
                $data['branch_id'] = $request->branch_id;
                $data['code'] = $code;
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['customers_type_id'] = $request->customer_type;
                $data['is_comissioned'] = $request->comission_value;
                $data['opening_bl'] = $request->opening_bl;
                $data['balance'] = $request->opening_bl;
                $data['created_at'] = Carbon::now();

                $insert = customer::insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Customer (Name: '.$request->name.', Phone: '.$phone.') Added', 'created_at' => Carbon::now()]);
                    return redirect()->route('admin.customers')->with('success', 'New Customer Added Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Customer / Phone Number is Exist, please try new.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
  
    }

    public function upload_customer_csv_confirm(Request $request) {
        if(User::checkPermission('others.customers') == true){ 
            $insert = '';
            $success = 0;
            $error = 0;
            $shop_id = Auth::user()->shop_id;
            $filename= $request->csvFile; 
            $file = fopen($filename, "r");
            $i = 1;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $name = $getData[0];
                $phone_without_zero = $getData[1];
                $email = $getData[2];
                $address =$getData[3];
                $balance = $getData[4];

                $phone = "0".$phone_without_zero;
                
                
                $customers = DB::table('customers')
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();

                if(is_null($customers) && $phone_without_zero != '') {
                    $customer_count = customer::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                    $up_count = optional($customer_count)->id+1;
    
                    $code = 'C'.$shop_id.'S'.$up_count;
                    $data = array();
                    $data['shop_id'] = $shop_id;
                    $data['branch_id'] = $request->branch_id;
                    $data['code'] = $code;
                    $data['name'] = $name;
                    $data['phone'] = $phone;
                    $data['email'] = $email;
                    $data['address'] = $address;
                    $data['opening_bl'] = $balance;
                    $data['balance'] = $balance;
                    $data['created_at'] = Carbon::now();
    
                    $insert = customer::insert($data);
                    if($insert) {
                        DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Customer (Name: '.$request->name.', Phone: '.$phone.') Added', 'created_at' => Carbon::now()]);
                        $success++;
                    }
                    else {
                        $error++;
                    }
                
                }
                else {
                    $error++;
                }
            $ss= substr(str_shuffle($getData[0]),0, 4).rand(0,3);
            }
            fclose($file);
            return Redirect()->route('admin.customers')->with('success', ''.$success.' Customer Add And '.$error.' Customer can not insert.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    
    public function admin_edit_customer($id) {
        if(User::checkPermission('others.customers') == true){
            $wing = 'main';
            $shop_id = Auth::user()->shop_id;
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->get(['id', 'branch_name', 'branch_address']);
            $customer_types = DB::table('customer_types')->where(['shop_id'=>$shop_id, 'active'=>1])->orderBy('id', 'desc')->get(['type_name', 'id']);
            $customer = customer::where('id', $id)->where('shop_id', $shop_id)->where('code', '!=', $shop_id.'WALKING')->first();
            if(!empty($customer->id)) {
                return view('cms.shop_admin.customers.edit_customers', compact('customer', 'customer_types', 'wing', 'branches'));
            }
            else {
                return Redirect()->back()->with('error', 'Error Occoured! Please Try Again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_update_customer(Request $request, $id)
    {
        if(User::checkPermission('others.customers') == true){
            
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;
            
            $customer = DB::table('customers')
                    ->where('id', '!=', $id)
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();
                    
            if(!$customer) {
                $data = array();
                $data['name'] = $request->name;
                $data['branch_id'] = $request->branch_id;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['customers_type_id'] = $request->customer_type;
                $data['is_comissioned'] = $request->comission_value;
                $data['updated_at'] = Carbon::now();

                $update = customer::where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Updated Customer(Name: '.$request->name.', Phone: '.$phone.') Info', 'created_at' => Carbon::now()]);
                    return redirect()->route('admin.customers')->with('success', 'Customer Info Update Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Phone is Exist, please try new.');
            }

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Admin customers
    
    

    
    


}
