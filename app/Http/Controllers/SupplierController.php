<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Supplier_invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Product_tracker;
use DataTables;
use App\Models\Expense_group;
use App\Models\Ledger_Head;
use App\Models\Product;
use App\Models\Expense_transaction;
use App\Models\ProductWithVariation;
use App\Models\Purchase_lines;
use App\Models\Supplier_inv_return;
use App\Models\Supplier_payment;



class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('supplier.view.and.edit') == true){
            $wing = 'supplier';
            $user = Auth::user();
            $suppliers = supplier::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->paginate(1000);
            return view('cms.shop_admin.supplier.crud.all_supplier', compact('suppliers', 'wing', 'user'));
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
        if(User::checkPermission('supplier.add') == true){
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;
            
            
            $suppliers = DB::table('suppliers')
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();

            if(!$suppliers) {
                $supplier_count = supplier::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                $up_count = optional($supplier_count)->id+1;

                $code = 'S'.$shop_id.'S'.$up_count;
                $data = array();
                $data['shop_id'] = $shop_id;
                $data['code'] = $code;
                $data['company_name'] = $request->company_name;
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['opening_bl'] = $request->opening_bl;
                $data['balance'] = $request->opening_bl;
                $data['created_at'] = Carbon::now();

                $insert = supplier::insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Added New supplier, Supplier name: '.$request->name.', Phone: '.$phone.'', 'created_at' => Carbon::now()]);
                    $wing = 'supplier';
                    return redirect()->route('suppliers.all')->with('success', 'New Supplier Added Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Supplier is Exist, please try new.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function upload_supplier_csv_confirm(Request $request) {
        if(User::checkPermission('supplier.add') == true){ 
            $insert = '';
            $success = 0;
            $error = 0;
            $shop_id = Auth::user()->shop_id;
            $filename= $request->csvFile; 
            $file = fopen($filename, "r");
            $i = 1;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

                $company_name = $getData[0];
                $name = $getData[1];
                $phone_without_zero = $getData[2];
                $email = $getData[3];
                $address =$getData[4];
                $balance = $getData[5];

                $phone = "0".$phone_without_zero;
                $suppliers = DB::table('suppliers')
                            ->where('shop_id', '=', $shop_id)
                            ->where('phone', '=', $phone)
                            ->first();

                if(!$suppliers && $phone_without_zero != '' && $company_name != '') {
                    
                    $supplier_count = supplier::where('shop_id', $shop_id)->orderBy('id', 'DESC')->first('id');
                    $up_count = optional($supplier_count)->id+1;
    
                    $code = 'S'.$shop_id.'S'.$up_count;
                    $data = array();
                    $data['shop_id'] = $shop_id;
                    $data['code'] = $code;
                    $data['company_name'] = $company_name;
                    $data['name'] = $name;
                    $data['phone'] = $phone;
                    $data['email'] = $email;
                    $data['address'] = $address;
                    $data['opening_bl'] = $balance;
                    $data['balance'] = $balance;
                    $data['created_at'] = Carbon::now();
                    $insert = supplier::insert($data);
                    if($insert) {
                        DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Supplier (Name: '.$request->name.', Phone: '.$phone.') Added', 'created_at' => Carbon::now()]);
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
            return Redirect()->route('suppliers.all')->with('success', ''.$success.' Supplier Add And '.$error.' Supplier can not insert.');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function admin_download_exist_supplier()
    {
        if(User::checkPermission('others.customers') == true){
            $shop_id = Auth::user()->shop_id;
            $delimiter = ",";
            //For Instant Date and Time
            date_default_timezone_set("Asia/Dhaka");
            $dateAndTimeForFname = date("l, jS \of F Y");
            $filename = $dateAndTimeForFname." Backup Suppliers.csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
            $fields = array('Company Name', 'Supplier Name', 'phone(without 0)', 'Email', 'Address', 'Balance');
            fputcsv($f, $fields, $delimiter);
            
            //output each row of the data, format line as csv and write to file pointer
            $suppliers = supplier::where('shop_id', $shop_id)->get();
            foreach($suppliers as $supplier) {
                $lineData = array($supplier->company_name, $supplier->name, $supplier->phone, $supplier->email, $supplier->address, $supplier->balance);
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
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        if(User::checkPermission('supplier.view.and.edit') == true){
            $wing = 'supplier';
            $supplier_info = supplier::where('id', $id)->where('shop_id', Auth::user()->shop_id)->first();
            return view('cms.shop_admin.supplier.crud.edit_supplier', compact('supplier_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('supplier.view.and.edit') == true){
            
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;
            
            if(is_null($email)) {
                $email = 'nullemail';
            }
            
            $suppliers = DB::table('suppliers')
                    ->where('id', '!=', $id)
                    ->where('shop_id', '=', $shop_id)
                    ->where('phone', '=', $phone)
                    ->first();
                    
            $email = $request->email;
            if(!$suppliers) {
                $data = array();
                $data['company_name'] = $request->company_name;
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['updated_at'] = Carbon::now();

                $update = supplier::where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update supplier, Supplier name: '.$request->name.', Phone: '.$phone.'', 'created_at' => Carbon::now()]);
                    return redirect()->route('suppliers.all')->with('success', 'Supplier Info Update Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Email or Phone is Exist, please try new.');
            }

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(supplier $supplier)
    {
        //
    }

    public function deactiveSupplier($id) {
        $data = array(
            'active' => 0,
        );
        $Q = supplier::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Deactivate Supplier', 'created_at' => Carbon::now()]);
            return redirect()->back()->with('success', 'Supplier Deactive Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    public function activeSupplier($id) {
        $data = array(
            'active' => 1,
        );
        $Q = supplier::where('id', $id)->where('shop_id', Auth::user()->shop_id)->update($data);
        if($Q) {
            DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' => 'Activate Supplier', 'created_at' => Carbon::now()]);
            return redirect()->back()->with('success', 'Supplier Active Successfully.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    //Begin:: Suppliers stock in
    public function supplier_stock_in($code) {
        return "This is old Version Purchase";
        if(User::checkPermission('supplier.stock.in') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            
            $supplier_info = supplier::where('code', $code)->where('shop_id', $shop_id)->first();
            if($supplier_info) {
                $net_cash = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                $branchs = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name']);
                //$products = DB::table('products')->where('shop_id', $shop_id)->where('active', 1)->get(['id', 'p_name', 'image', 'purchase_price', 'barCode']);
                return view('cms.shop_admin.supplier.stock_in.stock_in', compact('supplier_info', 'wing', 'branchs', 'net_cash'));
            }
            else {
                $suppliers = supplier::where('shop_id', $shop_id)->where('active', 1)->get(['code', 'company_name', 'name', 'id']);
                return view('cms.shop_admin.supplier.stock_in.stock_in', compact('suppliers', 'supplier_info', 'wing'));
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Suppliers stock in
    
    
    

    //Begin:: Suppliers stock in
    
    public function supplier_product_purchase_search_barcode(Request $request) {
        $barcode = $request->barcode;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $product = DB::table('products')->where(['shop_id' => $shop_id, 'barCode' => $barcode])->first();
        if(!is_null($product)) {
            $output = [
                'exist' => 'yes',
                'pid' => $product->id,
                'p_name' => $product->p_name,
                'purchase_price' => $product->purchase_price,
            ];
        }
        else {
            $output = [
                'exist' => 'no',
            ];
        }
        return response()->json($output);
    }

    public function get_products_search_by_title_into_purchase(Request $request) {
        $title = $request->title;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $products = DB::table('products')->where('shop_id', $shop_id)->where('p_name', 'like', '%' . $title . '%')->limit(20)->get();
        
        if( $title != '') {
            if($products->isNotEmpty()) {
                foreach($products as $product) {
                    $brand_info = DB::table('brands')->where('id', $product->p_brand)->first(['brand_name']);
                    $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', 0)" title="Add me">
                        <a class="nav-link d-flex justify-content-between align-items-center" id="product_text" href="javascript:void(0)">
                        <span class=""></span>'.$product->p_name.'/<small>'.optional($product)->barCode.'</small></a>
                        <span class="text-primary"><b>Brand:</b>  '.optional($brand_info)->brand_name.'</span>
                    </li>';
                }
            }
            else {
                $output .= '<li class="nav-item mb-1 p-3 rounded text-center"><p class="text-danger">No Product Found!</p></li>';
            }
        }
        return response()->json($output);

    }
    
    
    
    public function supplier_stock_in_confirm(Request $request) {
        if(User::checkPermission('supplier.stock.in') == true){
            $shop_id = Auth::user()->shop_id;
            $pid = $request->pid;
            $supplier_id = $request->supplier_id;
            $supplier_info = Supplier::where('id', $supplier_id)->where('shop_id', $shop_id)->first();
            $validated = $request->validate([
                'paid' => 'required',
                'supp_voucher_num' => 'required',
                'place' => 'required',
                'supplier_id' => 'required',
            ]);

            if(!is_null($supplier_info) && !is_null($pid) ) {
                $supplier_id = $supplier_info->id;
                $supplier_balance = $supplier_info->balance;
                $date = date("Y-m-d", strtotime($request->date));
                $current_time = $date;
                $count_total = DB::table('supplier_invoices')->where('shop_id', $shop_id)->count('id');
                $update_count = $count_total+1;
    
                //This is for others charge
                // $others_crg = $request->others_crg;
                // if($others_crg > 0) {
                //     $expenses_group = Expense_group::where('group_name', 'direct expenses')->first();
                //     $ledger_head = Ledger_Head::where(['shop_id' => $shop_id, 'group_id' => $expenses_group->id, 'head_name' => 'product purchase other charges'])->first();
                //     if(!is_null($ledger_head)) {
    
                //     }
                //     else {
                //         $new_ledger_head = new Ledger_Head;
                //         $new_ledger_head->shop_id = $shop_id;
                //         $new_ledger_head->group_id = $expenses_group->id;
                //         $new_ledger_head->head_name = 'product purchase other charges';
                //         $new_ledger_head->is_edit = 0;
                //         $new_ledger_head->created_at = Carbon::now();
                //         $new_ledger_head->save();
                //     }
                // }
                //This is for others charge End
    
                $discount_amount = $request->total_discount_amount;
                if($discount_amount == '') {
                    $discount_amount = 0;
                }
                $totalGross = $request->total_gross;
                
                if($totalGross != 0) {
                    $discount_cost = $discount_amount/$totalGross;
                }
                else {
                    $discount_cost = 0;
                }
                
    
                $sendingPlace = $request->place;
                
                $invoice_id = '';
                $place = '';
                $new_total_gross = 0;
    
                if($sendingPlace == 'SUPP_TO_G') {
                    $invoice_id = 'STG_'.$shop_id.'_'.$update_count;
                    $place = 'SUPP_TO_G';
                    foreach($pid as $key => $item) {
    
                        $unit = $request->quantity[$key];
                        $purchasingP = $request->price[$key];
                        $totalP = $request->total[$key];
    
                        //discount charge start
                        if($discount_amount > 0) {
                            $indvidual_item_value = $totalP * $discount_cost;
                            $totalP = number_format((float)$totalP - $indvidual_item_value, 2, '.', '');
                            $purchasingP = $totalP / $unit;
                        }
                        //discount charge End

                        $new_total_gross = $new_total_gross + $totalP;
    
                        $p_data = array();
                        $product_exist_quantity_check = DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->first(['G_current_stock']);
                        $current_quantity = $product_exist_quantity_check->G_current_stock;
                        $updateable_quantity = $current_quantity + $request->quantity[$key];
                        
                        $p_data['product_id'] = $pid[$key];
                        $p_data['quantity'] = $unit;
                        $p_data['price'] = $purchasingP;
                        $p_data['total_price'] = $totalP;
                        $p_data['status'] = 1; // 1 means in
                        $p_data['product_form'] = $place;
                        $p_data['invoice_id'] = $invoice_id;
                        $p_data['supplier_id'] = $supplier_id;
                        $p_data['note'] = $request->note;
                        $p_data['created_at'] = $current_time;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                        
                        if($insert_product_trackers) {
                            DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->update(['G_current_stock' => $updateable_quantity]);
                        }
                    }
                }
                else {
                    $invoice_id = 'STB_'.$shop_id.'_'.$update_count;
                    $place = 'SUPP_TO_B';
                    foreach($pid as $key => $item) {
    
                        $unit = $request->quantity[$key];
                        $purchasingP = $request->price[$key];
                        $totalP = $request->total[$key];
    
                        //discount charge start
                        if($discount_amount > 0) {
                            $indvidual_item_value = $totalP * $discount_cost;
                            $totalP = number_format((float)$totalP - $indvidual_item_value, 2, '.', '');
                            $purchasingP = $totalP / $unit;
                        }
                        //discount charge End

                        $new_total_gross = $new_total_gross + $totalP;
    
                        $p_data = array();
                        $product_exist_quantity_check = DB::table('product_stocks')->where('pid', $pid[$key])->where('branch_id', $sendingPlace)->first(['stock', 'id']);
                        if(!empty($product_exist_quantity_check->id)) {
                            $current_quantity = $product_exist_quantity_check->stock;
                            $updateable_quantity = $current_quantity + $request->quantity[$key];
                            DB::table('product_stocks')->where('branch_id', $sendingPlace)->where('pid', $pid[$key])->update(['stock' => $updateable_quantity, 'updated_at' => $current_time]);
                        }
                        else {
                            DB::table('product_stocks')->insert(['shop_id' => $shop_id, 'branch_id' => $sendingPlace, 'pid' => $pid[$key], 'stock' => $unit, 'created_at' => $current_time]);
                        }
                        
                        $p_data['product_id'] = $pid[$key];
                        $p_data['quantity'] = $unit;
                        $p_data['price'] = $purchasingP;
                        $p_data['total_price'] = $totalP;
                        $p_data['status'] = 1; // 1 means in
                        $p_data['product_form'] = $place;
                        $p_data['branch_id'] = $sendingPlace;
                        $p_data['supplier_id'] = $supplier_id;
                        $p_data['invoice_id'] = $invoice_id;
                        $p_data['note'] = $request->note;
                        $p_data['created_at'] = $current_time;
                        $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                        
                    }
    
                }
    
                $inv_data = array();
                $inv_data['shop_id'] = $shop_id;
                $inv_data['supp_invoice_id'] = $invoice_id;
                $inv_data['supplier_id'] = $supplier_id;
                $inv_data['total_gross'] = $new_total_gross;
                $inv_data['pre_due'] = $supplier_balance;
                $inv_data['others_crg'] = 0;
                $inv_data['discount_status'] = $request->supplier_discount;
                $inv_data['discount_rate'] = $request->discountAmount;
                $inv_data['total_discount_amount'] = $request->total_discount_amount;
                $inv_data['paid'] = $request->paid;
                $inv_data['note'] = $request->note;
                $inv_data['supp_voucher_num'] = $request->supp_voucher_num;
                $inv_data['place'] = $place;
                $inv_data['branch_id'] = ($place == 'SUPP_TO_B' ? $sendingPlace : '');
                $inv_data['date'] = $date;
                $inv_data['created_at'] = $current_time;
    
                DB::table('supplier_invoices')->insert($inv_data);
                if($request->paid > 0) {
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'SIP', 'track'=>$supplier_id, 'refference'=>$invoice_id, 'amount'=>$request->paid, 'creadit_or_debit'=>'DR', 'note'=>'Supplier Invoice Instant Payment, Invoice Num: # '.str_replace("_","/", $invoice_id).'', 'created_at'=>Carbon::now()]);
                }
                $supplier_new_balance = ($supplier_balance + $new_total_gross) - $request->paid;
                DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->update(['balance' => $supplier_new_balance]);
                
                $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                $rest_balance = ($net_balance->balance) - ($request->paid);
                $update_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance' => $rest_balance]);
                
                // if($update_balance) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock In from supplier. Invoice num # '.str_replace("_","/", $invoice_id), 'created_at' => $current_time]);
                    return Redirect()->route('supplier.stock.in.invoices')->with('success', 'Stock in from Supplier Successfully done.');
                // }
    
            }
            else {
                return Redirect()->back()->with('error', 'Error Occoured! Please Try Again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Suppliers stock in


    //Begin:: supplier search for stock in
    public function supplier_search(Request $request){
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $supplier_info = $request->get('supplier_info');
        
        $suppliers = DB::table('suppliers')
                ->where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($supplier_info) {
                    $query->where('phone', 'LIKE', '%'. $supplier_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $supplier_info. '%')
                        ->orWhere('company_name', 'LIKE', '%'. $supplier_info. '%');
                })
                ->get(['name', 'company_name', 'phone', 'email', 'code']);
          
          if($supplier_info) {
            foreach ($suppliers as $supplier) {
                $output.='<tr>'.
                '<td>'.$supplier->name.'</td>'.
                '<td>'.$supplier->company_name.'</td>'.
                '<td>'.$supplier->phone.'</td>'.
                '<td>'.$supplier->email.'</td>'.
                '<td><a href="/supplier/'.$supplier->code.'/stock-in-new" type="button" class="btn btn-primary btn-rounded btn-sm">Select</a></td>'.
                '</tr>';
                }
                return Response($output);
        }
    }
    //End:: supplier search for stock in


    //Begin:: Suppliers Reports
    public function supplier_report_all() {
        if(User::checkPermission('supplier.report') == true){
            $wing = 'supplier';
            $user = Auth::user();
            $suppliers = supplier::where('shop_id', $user->shop_id)->orderBy('id', 'desc')->paginate(300);
            return view('cms.shop_admin.supplier.report.all_supplier_reports', compact('suppliers', 'wing', 'user'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    //Begin:: supplier sold products ledger
    public function supplier_grout_product_ledger($code) {
        if(User::checkPermission('supplier.report') == true){
            $wing = 'main';
            $supplier_info = Supplier::where('code', $code)->where('shop_id', Auth::user()->shop_id)->first();
            if(!is_null($supplier_info)) {
                $orders = Supplier_invoice::where(['shop_id'=>Auth::user()->shop_id, 'supplier_id'=>$supplier_info->id])->get(['supp_invoice_id', 'id']);
                return view('cms.shop_admin.supplier.report.supplier_product_ledger', compact('orders', 'wing', 'supplier_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: supplier sold products ledger
    

    public function supplier_product_report($supplier_id) {
        if(User::checkPermission('supplier.report') == true){
            $wing = 'supplier';
            $supplier_info = supplier::where('id', $supplier_id)->first();
            $product_tracking_info = Product_tracker::where('supplier_id', $supplier_id)->orderBy('id', 'desc')->paginate(400);
            return view('cms.shop_admin.supplier.report.supplier_product_reports', compact('supplier_info', 'wing', 'product_tracking_info'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function supplier_product_report_data($supplier_id)
    {
        
        $product_tracking_info = Product_tracker::where('supplier_id', $supplier_id)->orderBy('id', 'desc')->get();
        return Datatables::of($product_tracking_info)
            ->addIndexColumn()
            ->addColumn('date', function($row){
                return date('d-m-Y', strtotime($row->created_at));
            })
            ->addColumn('in_out', function($row){
                $info = '';
                if($row->product_form == 'SUPP_R'){
                    $info .= '<span class="bg-danger text-light p-2">Out</span>';
                }
                else {
                    $info .= '<span class="bg-success text-light p-2">In</span>';
                }
                return $info;
            })
            ->addColumn('product_name', function($row){
                return $row->product_info->p_name;
            })
            ->addColumn('quantity', function($row){
                return $row->quantity." ".optional($row->product_info->unit_type_name)->unit_name;
            })
            ->rawColumns(['quantity', 'product_name', 'in_out', 'date'])
            ->make(true);
        
    }


    public function supplier_table_ledger() {
        if(User::checkPermission('supplier.table.ledger') == true){
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.report.supplier_table_ledger', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    public function supplier_table_ledger_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $type = $request->type;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $currency = ENV('DEFAULT_CURRENCY');
        date_default_timezone_set("Asia/Dhaka");
        
        if($type == 'all') { // this is for all data
            $suppliers = supplier::where('shop_id', Auth::user()->shop_id)->get();
            
            $output .= '<table id="" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Supplier Info</th>
                                <th>Invoice Total</th>
                                <th>Instant Paid</th>
                                <th>Others Paid</th>
                                <th>Return Products</th>
                                <th>Calculated Balance</th>
                                <th>DB Balance</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach($suppliers as $supplier){
                                
                                $inv_total = Supplier::invoice_total_sum($supplier->id);
                                $instant_paid = Supplier::instant_paid($supplier->id);
                                $product_return = Supplier::supplier_product_return($supplier->id);
                                $others_paid = Supplier::supplier_others_paid($supplier->code);
                                $current_balance = $inv_total - $instant_paid - $others_paid - $product_return;
                                
                                $output .= '<tr>
                                    <td><b>Name: </b>'.$supplier->name.' '.$supplier->id.'<br /><b>C Name: </b>'.$supplier->company_name.'<br /><b>Phone: </b>'.$supplier->phone.'</td>
                                    <td>'.number_format($inv_total, 2).' '.$currency.'</td>
                                    <td>'.number_format($instant_paid, 2).' '.$currency.'</td>
                                    <td>'.number_format($others_paid, 2).' '.$currency.'</td>
                                    <td>'.number_format($product_return, 2).' '.$currency.'</td>
                                    <td>'.number_format($current_balance, 2).' '.$currency.'</td>
                                    <td>'.number_format($supplier->balance, 2).' '.$currency.'</td>
                                </tr>';
                            }
                        $output .= '</tbody>
                        <tfoot>
                        </tfoot>
                    </table>';
                    
                        
        }
        else if($type == 'date_wise' && !empty($first_date) && $last_date != 0) { // this is for date wise
            $first_date_number = strtotime($first_date);
            $last_date_number = strtotime($last_date);
            
            $suppliers = supplier::where('shop_id', Auth::user()->shop_id)->get();
            
            $output .= '<table id="" class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center mb-0 bg-dark" colspan="7"><h4 class="text-light mb-0">'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' Suppliers Ledger Table</h4></th>
                            </tr>
                            <tr>
                                <th>Supplier Info</th>
                                <th>Invoice Total</th>
                                <th>Instant Paid</th>
                                <th>Others Paid</th>
                                <th>Return Products</th>
                            </tr>
                        </thead>
                        <tbody>';
                            foreach($suppliers as $supplier){
                                
                                $inv_total = Supplier_invoice::where('supplier_id', $supplier->id)->whereBetween('date', [$first_date, $last_date])->sum('total_gross');
                                $instant_paid = Supplier_invoice::where('supplier_id', $supplier->id)->whereBetween('date', [$first_date, $last_date])->sum('paid');
                                $product_return = Supplier_inv_return::where('supplier_id', $supplier->id)->whereBetween('date', [$first_date, $last_date])->sum('total_gross');
                                $others_paid = Supplier_payment::where('supplier_code', $supplier->code)->whereBetween('created_at', [$first_date, $last_date])->sum('paid');
                                
                                //$current_balance = $inv_total - $instant_paid - $others_paid - $product_return;
                                $output .= '<tr>
                                    <td><b>Name: </b>'.$supplier->name.' '.$supplier->id.'<br /><b>C Name: </b>'.$supplier->company_name.'<br /><b>Phone: </b>'.$supplier->phone.'</td>
                                    <td>'.number_format($inv_total, 2).' '.$currency.'</td>
                                    <td>'.number_format($instant_paid, 2).' '.$currency.'</td>
                                    <td>'.number_format($others_paid, 2).' '.$currency.'</td>
                                    <td>'.number_format($product_return, 2).' '.$currency.'</td>
                                </tr>';
                            }
                        $output .= '</tbody>
                        <tfoot>
                        </tfoot>
                    </table>';
            
            
        }
        
        return Response($output);
    }
    
    
    
    // From here Updated info is start -------------------------------------------------------------------------------------------------------------------------------------------------->
    
    //Begin:: Suppliers stock in New
    public function supplier_stock_in_new($code) {
        if(User::checkPermission('supplier.stock.in') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            
            $supplier_info = supplier::where('code', $code)->where('shop_id', $shop_id)->first();
            if($supplier_info) {
                $net_cash = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                $branchs = DB::table('branch_settings')->where('shop_id', $shop_id)->get(['id', 'branch_name', 'branch_address']);
                return view('cms.shop_admin.supplier.stock_in.stock_in_new', compact('supplier_info', 'wing', 'branchs', 'net_cash'));
            }
            else {
                $suppliers = supplier::where('shop_id', $shop_id)->where('active', 1)->get(['code', 'company_name', 'name', 'id']);
                return view('cms.shop_admin.supplier.stock_in.stock_in_new', compact('suppliers', 'supplier_info', 'wing'));
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Suppliers stock in New
    
    
    public function get_products_search_by_title_into_purchase_new(Request $request) {
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
                                $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$variation->purchase_price.'\', \''.$variation->selling_price.'\', \''.$product->vat_status.'\', \''.$vat_rate.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.optional($variation->variation_list_info)->list_title.'\',\''.$variation->variation_list_id.'\', \''.$product->is_cartoon.'\', \''.$product->cartoon_quantity.'\')" title="Add me">
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
                        $output .= '<li class="nav-item mb-1 p-1 rounded" id="product-item" onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$product->purchase_price.'\', \''.$product->selling_price.'\', \''.$product->vat_status.'\', \''.$vat_rate.'\', \''.$product->discount.'\', \''.$product->discount_amount.'\', \''.$type.'\', 0, \''.$product->is_cartoon.'\', \''.$product->cartoon_quantity.'\')" title="Add me">
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
    
    
    public function supplier_product_purchase_search_barcode_new(Request $request) {
        $barcode = $request->barcode;
        $shop_id = Auth::user()->shop_id;
        $output = '';
        $variation_output = '';
        $product = DB::table('products')->where(['shop_id' => $shop_id, 'barCode' => $barcode])->first();
        if(!is_null($product)) {
            $gloval_vat_status = Auth::user()->shop_info->vat_type;
            if($product->is_variable == 'variable') {
                $p_with_variation = ProductWithVariation::Where('pid', $product->id)->where('is_active', 1)->get();
                if($p_with_variation->isNotEmpty()) {
                    foreach($p_with_variation as $variation) {
                        if($gloval_vat_status == 'individual_product_vat') { $vat_rate = $product->vat_rate; }else { $vat_rate = 0; }
                        if(!empty(optional($product)->image)){ $img = asset(optional($product)->image); } else { $img = asset('images/product/noimage.png'); }
                        $variation_output .= '<div class="col-md-3 col-3 p-1"  onclick="myFunction(\''.$product->id.'\', \''.$product->p_name.'\', \''.$variation->purchase_price.'\', \''.$variation->selling_price.'\', \''.optional($product)->vat_status.'\', \''.$vat_rate.'\', \''.optional($product)->discount.'\', \''.optional($product)->discount_amount.'\', \''.optional($variation->variation_list_info)->list_title.'\',\''.$variation->variation_list_id.'\')" title="Add me">
                              <div class="card coursor_plus">
                                  <img class="card-img-top" src="'.$img.'" alt="Card image cap">
                                  <div class="card-body pb-1 pt-2 text-center" style="padding: 4px !important;">
                                      <p><b>'.$product->p_name.' <span class="text-success">('.optional($variation->variation_list_info)->list_title.')</span></b></p>
                                  </div>
                              </div>
                          </div>
                        ';
                    }
                }
                else {
                    $variation_output .='<div class="p-5"><h2 class="fw-bold text-danger">No Variation Found!!!</h2></div>';
                }
                $output = [
                    'exist' => 'yes',
                    'type'=> 'variable',
                    'variation_output'=>$variation_output
                ];
            }
            else {
                if($gloval_vat_status == 'individual_product_vat') { $vat_rate = $product->vat_rate; }else { $vat_rate = 0; }
                $output = [
                    'exist' => 'yes',
                    'type'=> 'simple',
                    'pid' => optional($product)->id,
                    'p_name' => optional($product)->p_name,
                    'purchase_price' => optional($product)->purchase_price,
                    'selling_price' => optional($product)->selling_price,
                    'vat_status' => optional($product)->vat_status,
                    'vat_rate' => $vat_rate,
                    'discount' => optional($product)->discount,
                    'discount_rate' => optional($product)->discount_amount,
                ];
            }
            
        }
        else {
            $output = [
                'exist' => 'no',
            ];
        }
        return response()->json($output);
    }
    
    
    
    public function supplier_stock_in_confirm_new(Request $request) {
        if(User::checkPermission('supplier.stock.in') == true){
            
            $shop_id = Auth::user()->shop_id;
            $pid = $request->pid;
            $supplier_id = $request->supplier_id;
            $supplier_info = Supplier::where('id', $supplier_id)->where('shop_id', $shop_id)->first();
            $validated = $request->validate([
                'paid' => 'required',
                'supp_voucher_num' => 'required',
                'place' => 'required',
                'supplier_id' => 'required',
            ]);
            
            if(is_null($supplier_info) || is_null($pid) ) { 
                return Redirect()->back()->with('error', 'Please Select Supplier or Check cart is empty or not!!!');
            }
            
            $supplier_id = $supplier_info->id;
            $supplier_balance = $supplier_info->balance;
            $date = date("Y-m-d", strtotime($request->date));
            $current_time = $date;
            $count_total = DB::table('supplier_invoices')->where('shop_id', $shop_id)->count('id');
            $update_count = $count_total+1;


            $global_discount_amount = $request->total_discount_amount;
            
            if($global_discount_amount == '') {
                $global_discount_amount = 0;
            }
            
            $totalGross = $request->total_gross;
            
            
            if($totalGross != 0) {
                $discount_cost = $global_discount_amount/$totalGross;
            }
            else {
                $discount_cost = 0;
            }
            

            $sendingPlace = $request->place;
            
            $invoice_id = '';
            $place = '';
            $destination_place = '';
            $new_total_gross = 0;
            
            if($sendingPlace == 'SUPP_TO_G') {
                $invoice_id = 'STG_'.$shop_id.'_'.$update_count;
                $place = 'SUPP_TO_G';
                $destination_place = 'G';
            }
            else {
                $invoice_id = 'STB_'.$shop_id.'_'.$update_count;
                $place = 'SUPP_TO_B';
                $destination_place = $sendingPlace;
            }
            
            foreach($pid as $key => $item) {

                $unit = $request->quantity[$key];
                $purchasingP = $request->price[$key];
                $sales_price = $request->sales_price[$key];
                $is_cartoon = $request->is_cartoon[$key];
                $cartoon_quantity = $request->cartoon_quantity[$key];
                $cartoon_amount = $request->cartoon_amount[$key];
                $variation_id = $request->variation_id[$key];
                $discount  = $request->p_discount[$key];
                $discount_amount   = $request->discount_amount[$key];
                $vat  = $request->vat[$key];
                
                $product_id = $pid[$key];
                
                $totalP = $unit * $purchasingP;
                $new_total_gross = $new_total_gross + $totalP;
                
                
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
                $purchase_line->is_cartoon = $is_cartoon;
                $purchase_line->cartoon_quantity = $cartoon_quantity;
                $purchase_line->cartoon_amount = $cartoon_amount;
                
                $purchase_line->date = $date;
                $purchase_line->created_at = Carbon::now();
                $purchase_line->save();
                
                $purchase_line_id = $purchase_line->id;
                
                DB::table('product_stocks')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$purchase_line_id, 'lot_number'=>$lot_number, 'branch_id'=>$destination_place, 'pid'=>$product_id, 'variation_id'=>$variation_id, 'purchase_price'=>$purchasingP, 'sales_price'=>$sales_price, 'discount'=>$discount, 'discount_amount'=>$discount_amount, 'vat'=>$vat, 'stock'=>$unit,  'is_cartoon'=>$is_cartoon, 'cartoon_quantity'=>$cartoon_quantity, 'cartoon_amount'=>$cartoon_amount, 'created_at'=>$current_time]);
                
                $p_data = array();
                $p_data['shop_id'] = $shop_id;
                $p_data['lot_number'] = $lot_number;
                $p_data['purchase_line_id'] = $purchase_line_id;
                $p_data['purchase_price'] = $purchasingP;
                $p_data['total_purchase_price'] = $purchasingP*$unit;
                $p_data['sales_price'] = $sales_price;
                $p_data['variation_id'] = $variation_id;
                $p_data['product_id'] = $product_id;
                $p_data['quantity'] = $unit;
                $p_data['is_cartoon'] = $is_cartoon;
                $p_data['cartoon_quantity'] = $cartoon_quantity;
                $p_data['cartoon_amount'] = $cartoon_amount;
                $p_data['price'] = $purchasingP;
                $p_data['discount'] = $discount;
                $p_data['discount_amount'] = $discount_amount;
                $p_data['vat'] = $vat;
                $p_data['total_price'] = $totalP;
                $p_data['status'] = 1; // 1 means in
                $p_data['product_form'] = $place;
                $p_data['branch_id'] = $destination_place;
                $p_data['supplier_id'] = $supplier_id;
                $p_data['invoice_id'] = $invoice_id;
                $p_data['note'] = $request->note;
                $p_data['created_at'] = $current_time;
                $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                    
            }
            
            $new_total_gross = $new_total_gross - $global_discount_amount;

            $inv_data = array();
            $inv_data['shop_id'] = $shop_id;
            $inv_data['supp_invoice_id'] = $invoice_id;
            $inv_data['supplier_id'] = $supplier_id;
            $inv_data['total_gross'] = $new_total_gross;
            $inv_data['pre_due'] = $supplier_balance;
            $inv_data['others_crg'] = 0;
            $inv_data['discount_status'] = $request->supplier_discount;
            $inv_data['discount_rate'] = $request->discountAmount;
            $inv_data['total_discount_amount'] = $request->total_discount_amount;
            $inv_data['paid'] = $request->paid;
            $inv_data['note'] = $request->note;
            $inv_data['supp_voucher_num'] = $request->supp_voucher_num;
            $inv_data['place'] = $place;
            $inv_data['branch_id'] = ($place == 'SUPP_TO_B' ? $sendingPlace : 'G');
            $inv_data['date'] = $date;
            $inv_data['created_at'] = $current_time;

            DB::table('supplier_invoices')->insert($inv_data);
            if($request->paid > 0) {
                DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'SIP', 'track'=>$supplier_id, 'refference'=>$invoice_id, 'amount'=>$request->paid, 'creadit_or_debit'=>'DR', 'note'=>'Supplier Invoice Instant Payment, Invoice Num: # '.str_replace("_","/", $invoice_id).'', 'created_at'=>Carbon::now()]);
            }
            
            $supplier_new_balance = ($supplier_balance + $new_total_gross) - $request->paid;
            DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->update(['balance' => $supplier_new_balance]);
            
            $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
            $rest_balance = ($net_balance->balance) - ($request->paid);
            $update_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance' => $rest_balance]);
            
            // if($update_balance) {
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Stock In from supplier. Invoice num # '.str_replace("_","/", $invoice_id), 'created_at' => $current_time]);
                return Redirect()->route('supplier.stock.in.invoices')->with('success', 'Stock in from Supplier Successfully done.');
            // }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Suppliers stock in

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    


    


}
