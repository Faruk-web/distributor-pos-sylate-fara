<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\SMS_settings;
use PDF;
use DataTables;
use Illuminate\Http\Response;
use Mail;
use App\Mail\OrderMail;
use App\Models\Product_stock;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $wing = 'main';
            return view('cms.branch.sell.sold_invoices', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        } 
    }


    public function order_datatable_info(Request $request) {
        if ($request->ajax()) {
            $branch_id = Auth::user()->branch_id;
            if(!empty($branch_id)) {
                $orders = Order::where(['branch_id'=>$branch_id,'shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['invoice_id', 'date', 'created_at']);
            }
            else {
                $orders = Order::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['invoice_id', 'date', 'created_at']);
            }
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('invoice.pos.print', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-info btn-sm btn-rounded">POS</a> <a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-primary btn-sm btn-rounded">Invoice</a> <a target="_blank" href="'.route('view.sold.invoice.in.half.page', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-danger btn-sm btn-rounded">Half Page</a>';
                })
                ->addColumn('invoice_num', function($row){
                    return "#".str_replace("_","/", $row->invoice_id);
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('inv_created_date', function($row){
                    return date("d-m-Y h:i:s A", strtotime($row->created_at));
                })
                
                ->rawColumns(['action', 'invoice_num', 'inv_created_date'])
                ->make(true);
        }
    }
    
    public function sold_invoices_full_info()
    {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $wing = 'main';
            return view('cms.branch.sell.sold_invoices_full_info', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        } 
    }
    
    
    public function sold_invoices_full_info_data(Request $request) {
        if ($request->ajax()) {
            $branch_id = Auth::user()->branch_id;
            if(!empty($branch_id)) {
                $orders = Order::where(['branch_id'=>$branch_id,'shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['invoice_id', 'customer_id', 'date', 'created_at', 'crm_id']);
            }
            else {
                $orders = Order::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['invoice_id', 'customer_id', 'date', 'created_at', 'crm_id']);
            }
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('invoice.pos.print', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-info btn-sm btn-rounded">POS</a> <a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-primary btn-sm btn-rounded">Invoice</a> <a target="_blank" href="'.route('view.sold.invoice.in.half.page', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-danger btn-sm btn-rounded">Half Page</a>';
                })
                ->addColumn('others_info', function($row){
                    $crm_info = DB::table('users')->where('id', $row->crm_id)->first(['phone', 'name']);
                    return '<small><b>Inv Num: </b>#'.str_replace("_","/", $row->invoice_id).'<br><b>Created By: </b>'.optional($crm_info)->name.' ('.optional($crm_info)->phone.')<br><b>Created at: </b>'.date("d-m-Y h:i:s A", strtotime($row->created_at)).'</small>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('customer_info', function($row){
                    $customer_info = DB::table('customers')->where('id', $row->customer_id)->first(['phone', 'name']);
                    return optional($customer_info)->name." [".optional($customer_info)->phone."]";
                })
                
                ->rawColumns(['action', 'invoice_num', 'inv_created_date', 'others_info'])
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
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){

            if(!is_null($request->pid)) {
                    $shop_id = Auth::user()->shop_id;
                    $branch_id = Auth::user()->branch_id;
                    if(empty($branch_id)) {
                        $branch_id = Auth::user()->shop_info->default_branch_id_for_sell;
                        if(empty($branch_id)) {
                            return Redirect()->back()->with('error', 'Set Default Branch From Shop Settings.');
                        }
                    }
                    $pid = $request->pid;
                    $customer_id = $request->customer_id;
                    $customer_info = DB::table('customers')->where(['id'=>$customer_id, 'shop_id'=>$shop_id])->first('code', 'name');
                    $paid = '';
                    $current_due = '';
                    $paid_by = '';
                    $validated = $request->validate([
                        'customer_id' => 'required',
                    ]);

                    $submit_form = $request->submit_from;

                    $current_time = Carbon::now();
                    $count_total = DB::table('orders')->where(['shop_id'=>$shop_id, 'branch_id'=>$branch_id])->count('id');
                    $update_count = $count_total+1;
                    $invoice_id = 'S_'.$shop_id.'_'.$branch_id.'_'.$update_count;

                    $date = date("Y-m-d", strtotime($request->date));

                    foreach($pid as $key => $item) {

                        $unit = $request->quantity[$key];
                        $price = $request->price[$key];
                        $vat = $request->individual_product_vat[$key];
                        $subtotal = $request->total[$key];
                        $discount_percent = $request->disCP[$key];
                        $flat_discount = $request->disC_flat[$key];
                        
                        $product_exist_quantity_check = DB::table('product_stocks')->where(['pid'=>$pid[$key], 'branch_id'=>$branch_id])->first(['stock']);
                        $current_quantity = $product_exist_quantity_check->stock;
                        $updateable_quantity = $current_quantity - $unit;
                        
                        $insert_invoice_products = DB::table('ordered_products')->insert(['invoice_id'=>$invoice_id, 'product_id'=>$pid[$key], 'quantity'=>$unit, 'price'=>$price, 'discount'=>$discount_percent, 'discount_amount'=>$flat_discount, 'vat_amount'=>$vat, 'total_price'=>$subtotal, 'created_at'=>$current_time]);
                        if($insert_invoice_products) {
                            $p_data = array();
                            $p_data['product_id'] = $pid[$key];
                            $p_data['quantity'] = $unit;
                            $p_data['price'] = $price;
                            $p_data['total_price'] = $subtotal;
                            $p_data['status'] = 0; // 0 means Out
                            $p_data['product_form'] = 'S';
                            $p_data['invoice_id'] = $invoice_id;
                            $p_data['note'] = $request->note;
                            $p_data['created_at'] = $current_time;
                            DB::table('product_trackers')->insert($p_data);
                            DB::table('product_stocks')->where(['pid'=>$pid[$key], 'branch_id'=>$branch_id])->update(['stock'=>$updateable_quantity]);
                        }
                    }

                    if($submit_form == 'full_payment') {
                        $paid = $request->full_payment;
                        $current_due = 0;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'partial_payment') {
                        $paid = $request->partial_paid;
                        $current_due = $request->partial_due;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'cash_on_payment') {
                        $paid = $request->cash_on_delivery_paid;
                        $current_due = $request->cash_on_delivery_due;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'cheque_payment') {
                        $paid = $request->mfs_paid;
                        $current_due = $request->mfs_current_due;
                        $paid_by = 'cheque';
                    }

                    if($customer_info->code == $shop_id.'WALKING') {
                        $paid = $request->full_payment;
                        $current_due = 0;
                    }


                    $inv_data = array();
                    $inv_data['shop_id'] = $shop_id;
                    $inv_data['branch_id'] = $branch_id;
                    $inv_data['invoice_id'] = $invoice_id;
                    $inv_data['customer_id'] = $customer_id;
                    $inv_data['total_gross'] = $request->subtotal;
                    $inv_data['vat'] = $request->vat+0;

                    if(!empty($request->discount_Tk)) {
                        $inv_data['discount_status'] = 'tk';
                        $inv_data['discount_rate'] = $request->discount_tk_price;
                    }
                    else if(!empty($request->discount_Percent)) {
                        $inv_data['discount_status'] = 'percent';
                        $inv_data['discount_rate'] = $request->discount_Percent;
                    }
                    else {
                        $inv_data['discount_status'] = 'no';
                    }

                    $inv_data['pre_due'] = $request->previous_due;
                    $inv_data['others_crg'] = $request->only_others_crg_tk;
                    $inv_data['delivery_crg'] = $request->delivery_others_crg+0;
                    $inv_data['invoice_total'] = $request->total_payable;
                    $inv_data['payment_by'] = $paid_by;
                    $inv_data['paid_amount'] = $paid;
                    $inv_data['delivery_man_id'] = $request->delivery_man_id;
                    $inv_data['cheque_or_mfs_acc'] = $request->checkNoOrMFSAccNo;
                    $inv_data['mfs_acc_type'] = $request->MFSAccType;
                    $inv_data['cheque_bank'] = $request->Chequebank;
                    $inv_data['diposit_to'] = $request->Dipositbank;
                    $inv_data['cheque_date'] = $request->Chequedate;
                    $inv_data['c_diposit_date'] = $request->DipositDate;
                    $inv_data['crm_id'] = Auth::user()->id;
                    $inv_data['sms_status'] = $request->send_sms+0;
                    $inv_data['note'] = $request->note;
                    $inv_data['date'] = $date;
                    $inv_data['created_at'] = $current_time;

                    DB::table('orders')->insert($inv_data);

                    if($paid_by == 'cash') {
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance + $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        $transaction_paid_by = 'cash';
                    }
                    else if($paid_by == 'cheque') {
                        $bank_balance = DB::table('banks')->where(['id'=>$request->Dipositbank, 'shop_id'=>$shop_id])->first(['balance']);
                        $updated_balance = $bank_balance->balance + $paid;
                        DB::table('banks')->where(['id'=>$request->Dipositbank, 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance]);
                        $transaction_paid_by = $request->Dipositbank;
                    }

                    if($customer_info->code != $shop_id.'WALKING') {
                        DB::table('customers')->where(['id'=>$customer_id, 'shop_id'=>$shop_id])->update(['balance'=>$current_due]);
                    }

                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$transaction_paid_by, 'branch_id'=>Auth::user()->branch_id, 'added_by'=>Auth::user()->id, 'for_what'=>'S', 'track'=>$customer_id, 'refference'=>$invoice_id, 'amount'=>$paid, 'creadit_or_debit'=>'CR', 'note'=>'Sell to customer. Invoice Num. #'.str_replace("_","/", $invoice_id).'', 'created_at'=>$date]);
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' =>'Product Sell to '.$customer_info->code.', Invoice Num: '.str_replace("_","/", $invoice_id).'', 'created_at' => Carbon::now()]);
                    return Redirect()->route('view.sold.invoice', ['invoice_id'=>$invoice_id]);

            }
            else {
                return Redirect()->back()->with('error', 'No product selected.');
            } 
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
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
    
    
    
    public function store_by_ajax(Request $request)
    {
        $output = '';
        
        $output = [
                    'status' => 'no',
                    'reason' => 'This is Old Feature, Please Sell into New Features.',
                ];
        return Response($output);
        
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            /*
            if(!is_null($request->pid)) {
                    $shop_id = Auth::user()->shop_id;
                    $branch_id = Auth::user()->branch_id;
                    if(empty($branch_id)) {
                        $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
                    }
                    $branch_info = DB::table('branch_settings')->where(['id'=>$branch_id])->first(['print_by', 'sms_status']);
                    $pid = $request->pid;
                    $customer_id = $request->customer_id;
                    $customer_info = DB::table('customers')->where(['id'=>$customer_id, 'shop_id'=>$shop_id])->first(['code', 'name', 'phone', 'email', 'balance']);
                    $paid = '';
                    $invoice_total = $request->total_payable;
                    $customer_balance = ($customer_info->balance) + 0;
                    $current_due = '';
                    $paid_by = '';
                    $validated = $request->validate([
                        'customer_id' => 'required',
                    ]);

                    $submit_form = $request->submit_from;

                    $current_time = Carbon::now();
                    $count_total = DB::table('orders')->where(['shop_id'=>$shop_id, 'branch_id'=>$branch_id])->count('id');
                    $update_count = $count_total+1;
                    $invoice_id = 'S_'.$shop_id.'_'.$branch_id.'_'.$update_count;

                    $date = date("Y-m-d", strtotime($request->date));

                    foreach($pid as $key => $item) {

                        $unit = $request->quantity[$key];
                        $price = $request->price[$key];
                        $vat = $request->individual_product_vat[$key];
                        $subtotal = $request->total[$key];
                        $discount_percent = $request->disCP[$key];
                        $flat_discount = $request->disC_flat[$key];
                        
                        $product_exist_quantity_check = DB::table('product_stocks')->where(['pid'=>$pid[$key], 'branch_id'=>$branch_id])->first(['stock']);
                        $current_quantity = $product_exist_quantity_check->stock;
                        $updateable_quantity = $current_quantity - $unit;
                        
                        $insert_invoice_products = DB::table('ordered_products')->insert(['invoice_id'=>$invoice_id, 'product_id'=>$pid[$key], 'quantity'=>$unit, 'price'=>$price, 'discount'=>$discount_percent, 'discount_amount'=>$flat_discount, 'vat_amount'=>$vat, 'total_price'=>$subtotal, 'created_at'=>$date]);
                        if($insert_invoice_products) {
                            $p_data = array();
                            $p_data['product_id'] = $pid[$key];
                            $p_data['quantity'] = $unit;
                            $p_data['price'] = $price;
                            $p_data['total_price'] = $subtotal;
                            $p_data['status'] = 0; // 0 means Out
                            $p_data['product_form'] = 'S';
                            $p_data['invoice_id'] = $invoice_id;
                            $p_data['note'] = $request->note;
                            $p_data['created_at'] = $date;
                            DB::table('product_trackers')->insert($p_data);
                            DB::table('product_stocks')->where(['pid'=>$pid[$key], 'branch_id'=>$branch_id])->update(['stock'=>$updateable_quantity]);
                        }
                    }

                    if($submit_form == 'full_payment') {
                        $paid = $request->full_payment;
                        // $current_due = 0;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'partial_payment') {
                        $paid = $request->partial_paid;
                        // $current_due = $request->partial_due;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'cash_on_payment') {
                        $paid = $request->cash_on_delivery_paid;
                        // $current_due = $request->cash_on_delivery_due;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'cheque_payment') {
                        $paid = $request->mfs_paid;
                        // $current_due = $request->mfs_current_due;
                        $paid_by = 'cheque';
                    }

                    if($customer_info->code == $shop_id.'WALKING') {
                        $paid = $request->full_payment;
                        // $current_due = 0;
                    }


                    $inv_data = array();
                    $inv_data['shop_id'] = $shop_id;
                    $inv_data['branch_id'] = $branch_id;
                    $inv_data['invoice_id'] = $invoice_id;
                    $inv_data['customer_id'] = $customer_id;
                    $inv_data['total_gross'] = $request->subtotal;
                    $inv_data['vat'] = $request->vat+0;

                    if(!empty($request->discount_Tk)) {
                        $inv_data['discount_status'] = 'tk';
                        $inv_data['discount_rate'] = $request->discount_tk_price;
                    }
                    else if(!empty($request->discount_Percent)) {
                        $inv_data['discount_status'] = 'percent';
                        $inv_data['discount_rate'] = $request->discount_Percent;
                    }
                    else {
                        $inv_data['discount_status'] = 'no';
                    }

                    $inv_data['pre_due'] = $customer_balance;
                    $inv_data['others_crg'] = $request->only_others_crg_tk;
                    $inv_data['delivery_crg'] = $request->delivery_others_crg+0;
                    $inv_data['invoice_total'] = $request->total_payable;
                    $inv_data['payment_by'] = $paid_by;
                    $inv_data['paid_amount'] = $paid;
                    $inv_data['delivery_man_id'] = $request->delivery_man_id;
                    $inv_data['cheque_or_mfs_acc'] = $request->checkNoOrMFSAccNo;
                    $inv_data['mfs_acc_type'] = $request->MFSAccType;
                    $inv_data['cheque_bank'] = $request->Chequebank;
                    $inv_data['diposit_to'] = $request->Dipositbank;
                    $inv_data['cheque_date'] = $request->Chequedate;
                    $inv_data['c_diposit_date'] = $request->DipositDate;
                    $inv_data['crm_id'] = Auth::user()->id;
                    $inv_data['sms_status'] = $request->send_sms+0;
                    $inv_data['note'] = $request->note;
                    $inv_data['date'] = $date;
                    $inv_data['created_at'] = $current_time;

                    DB::table('orders')->insert($inv_data);
                    
                    $current_due = (($invoice_total - $request->previous_due) + $customer_balance) - $paid;

                    if($paid_by == 'cash') {
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance + $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        $transaction_paid_by = 'cash';
                    }
                    else if($paid_by == 'cheque') {
                        $bank_balance = DB::table('banks')->where(['id'=>$request->Dipositbank, 'shop_id'=>$shop_id])->first(['balance']);
                        $updated_balance = $bank_balance->balance + $paid;
                        DB::table('banks')->where(['id'=>$request->Dipositbank, 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance]);
                        $transaction_paid_by = $request->Dipositbank;
                    }

                    if($customer_info->code != $shop_id.'WALKING') {
                        DB::table('customers')->where(['id'=>$customer_id, 'shop_id'=>$shop_id])->update(['balance'=>$current_due]);
                        if(!empty($customer_info->email)) {
                            //Mail::send(new OrderMail($invoice_id));
                        }
                        
                        $shop_settings = DB::table('shop_settings')->where('shop_code', $shop_id)->first(['sms_active_status', 'sms_limit', 'shop_name']);
                        
                        if($branch_info->sms_status == 'yes' && $request->send_sms == 1) {
                            $sms_settings = DB::table('s_m_s_settings')->first(['non_masking_price', 'masking_price']);
                            $sms_method = DB::table('sms')->where('shop_id', $shop_id)->first(['message']);
                            if(!is_null($sms_method->message)) {
                                $sms_text = $sms_method->message;
                                    $sms_text = str_replace("customer_name", optional($customer_info)->name, $sms_text);
                                //$previous_due = $customer_balance;
                                    $sms_text = str_replace("previous_due", number_format($customer_balance,2), $sms_text);
                                $todays_bill = number_format(($invoice_total - $request->previous_due), 2);
                                    $sms_text = str_replace("todays_bill", $todays_bill, $sms_text);
                                $total_bill = number_format(($invoice_total - $request->previous_due) + $customer_balance, 2);
                                    $sms_text = str_replace("total_bill", $total_bill, $sms_text);
                                //$paid = $paid;
                                    $sms_text = str_replace("todays_paid", number_format($paid, 2), $sms_text);
                                //$current_balance = $current_due;
                                    $sms_text = str_replace("current_balance", number_format($current_due, 2), $sms_text);
                                $invoice_number = "http://pos.ehishab.com/inv/".$invoice_id;
                                    $sms_text = str_replace("invoice_number", $invoice_number, $sms_text);
                                
                                $sms_length = strlen($sms_text);
                                $sms_count = $this->check_sms_count($sms_length);
                                $sms_cost = $sms_count * $sms_settings->non_masking_price;
                                
                                if($shop_settings->sms_limit >= $sms_cost) {
                                    $msg = $sms_text;
                                    $phone_num = $customer_info->phone;
                                    $send_sms = SMS_settings::send_sms($msg, $phone_num);
                                    
                                    if($send_sms != '1002' || $send_sms != '1003' || $send_sms != '1004' || $send_sms != '1005' || $send_sms != '1006' || $send_sms != '1007' || $send_sms != '1008' || $send_sms != '1009' || $send_sms != '1010' || $send_sms != '1011' || $send_sms != '1012' || $send_sms != '1013' || $send_sms != '1014') {
                                        $update_sms_balance = $shop_settings->sms_limit - $sms_cost;
                                        DB::table('shop_settings')->where('shop_code', $shop_id)->update(['sms_limit'=>$update_sms_balance]);
                                    DB::table('sms_histories')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'length'=>$sms_length, 'sms_count'=>$sms_count, 'send_to'=>'C', 'phone_number'=>$phone_num, 'info'=>$msg, 'created_at'=>Carbon::now()]);
                                    }
                                }
                            }
                        }
                        
                        
                    }

                    //$this::send_mail();
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$transaction_paid_by, 'branch_id'=>Auth::user()->branch_id, 'added_by'=>Auth::user()->id, 'for_what'=>'S', 'track'=>$customer_id, 'refference'=>$invoice_id, 'amount'=>$paid, 'creadit_or_debit'=>'CR', 'note'=>'Sell to customer. Invoice Num. #'.str_replace("_","/", $invoice_id).'', 'created_at'=>$date]);
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' =>'Product Sell to '.$customer_info->code.', Invoice Num: '.str_replace("_","/", $invoice_id).'', 'created_at' => Carbon::now()]);
                    //return Redirect()->route('view.sold.invoice', ['invoice_id'=>$invoice_id]);
                    
                    $output = [
                        'status' => 'yes',
                        'default_print' => $branch_info->print_by,
                        'invoice_num' => $invoice_id,
                    ];
                    return Response($output);
            }
            else {
                $output = [
                    'status' => 'no',
                    'reason' => 'No Products in cart!',
                ];
                return Response($output);
            } 
            */
        }
        else {
            $output = [
                'status' => 'no',
                'reason' => 'Sorry you have not access to do this work!',
            ];
            return Response($output);
        }
    }
    
    
    public function store_by_ajax_new(Request $request)
    {
        $output = '';
        
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){

            if(!is_null($request->pid)) {
                
                    $shop_id = Auth::user()->shop_id;
                    $shop_settings = DB::table('shop_settings')->where('shop_code', $shop_id)->first(['is_active_customer_points', 'sms_active_status', 'sms_limit', 'shop_name', 'point_earn_rate', 'minimum_purchase_to_get_point']);
                    
                    $branch_id = Auth::user()->branch_id;
                    if(empty($branch_id)) {
                        $branch_id = Auth::user()->shop_info->default_branch_id_for_sell; 
                    }
                    $branch_info = DB::table('branch_settings')->where(['id'=>$branch_id])->first(['print_by', 'sms_status']);
                    
                    $pid = $request->pid;
                    
                    $customer_code = $request->customer_code;
                    
                    $customer_info = DB::table('customers')->where(['code'=>$customer_code, 'shop_id'=>$shop_id])->first(['code', 'name', 'phone', 'email', 'balance', 'id', 'wallet_balance', 'wallets']);
                    $customer_id = $customer_info->id;
                    
                    $paid = '';
                    $invoice_total = $request->total_payable;
                    $customer_balance = ($customer_info->balance) + 0;
                    $current_due = '';
                    $paid_by = '';
                    
                    $validated = $request->validate([
                        'customer_code' => 'required',
                    ]);

                    $submit_form = $request->submit_from;
                    
                    $current_time = Carbon::now();
                    $count_total = DB::table('orders')->where(['shop_id'=>$shop_id, 'branch_id'=>$branch_id])->count('id');
                    $update_count = $count_total+1;
                    $invoice_id = 'S_'.$shop_id.'_'.$branch_id.'_'.$update_count;

                    $date = date("Y-m-d", strtotime($request->date));
                    
                    $individual_discount_status = 'no';
                    $individual_discount_amount = 0;
                    
                    $total_gross = 0;

                    foreach($pid as $key => $item) {

                        $unit = $request->quantity[$key];
                        $price = $request->price[$key];
                        $vat = $request->individual_product_vat[$key];
                        $variation_id = $request->variation_id[$key];
                        $discount_percent = $request->disCP[$key];
                        
                        $flat_discount = $request->disC_flat[$key];
                        
                        if($discount_percent > 0) {
                            $individual_discount_status = 'percent';
                            $individual_discount_amount = $discount_percent;
                        }
                        else if($flat_discount > 0) {
                            $individual_discount_status = 'flat';
                            $individual_discount_amount = $flat_discount;
                        }
                        else {
                            $individual_discount_status = 'no';
                            $individual_discount_amount = 0;
                        }
                        
                        
                        $old_price = $request->previous_price[$key];
                        $previous_discount = $request->previous_discount[$key];
                        $previous_discount_amount = $request->previous_discount_amount[$key];
                        
                        $product_check = Product_stock::Where(['pid'=>$pid[$key], 'branch_id'=>$branch_id, 'sales_price'=>$old_price, 'variation_id'=>$variation_id, 'discount'=>$previous_discount, 'discount_amount'=>$previous_discount_amount])->where('stock', '>', 0)->orderBy('lot_number', 'ASC')->get();
                        
                        // Individual Product with lot Wise Start
                        if(count($product_check) > 0) {
                           $sold_unit = $unit;
                           $total_count = 0;
                           foreach($product_check as $product_item) {
                               $db_minus_unit = 0;
                               $db_stock = $product_item->stock;
                               
                               if($sold_unit != 0) {
                                   
                                   if($sold_unit >= $db_stock) {
                                       $sold_unit = $sold_unit - $db_stock;
                                       $db_minus_unit = $db_stock;
                                   }
                                   else if($db_stock >= $sold_unit) {
                                      $db_minus_unit = $sold_unit;
                                      $sold_unit = $sold_unit - $sold_unit;
                                   }
                                   
                                   $total_count = $total_count + $db_minus_unit;
                                   $sum_for_item = $db_minus_unit * $price;
                                   
                                   if($individual_discount_status == 'flat') {
                                       $t_discount = $individual_discount_amount * $db_minus_unit;
                                       $total_price = $sum_for_item - $t_discount;
                                       $discount_in_tk = $t_discount;
                                   }
                                   else if($individual_discount_status == 'percent') {
                                       $discountParcent_amount_tk = ($individual_discount_amount * $sum_for_item)/100;
                                       $total_price = $sum_for_item - $discountParcent_amount_tk;
                                       $discount_in_tk = $discountParcent_amount_tk;
                                   }
                                   else {
                                       $total_price = $db_minus_unit * $price;
                                       $discount_in_tk = 0;
                                   }
                                   
                                   $vat_price = $total_price * $vat / 100;
                                   
                                   $total_price = $total_price + $vat_price;
                                   
                                   DB::table('product_trackers')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>$product_item->purchase_line_id, 'lot_number'=>$product_item->lot_number, 'purchase_price'=>$product_item->purchase_price, 'total_purchase_price'=>optional($product_item)->purchase_price*$db_minus_unit, 'sales_price'=>$price, 'variation_id'=>$product_item->variation_id, 'branch_id'=>$branch_id, 'product_id'=>$product_item->pid, 'quantity'=>$db_minus_unit, 'price'=>$price, 'discount'=>$individual_discount_status, 'discount_amount'=>$individual_discount_amount, 'discount_in_tk'=>$discount_in_tk, 'vat'=>$product_item->vat, 'total_price'=>$total_price, 'status'=>0, 'product_form'=>'S', 'invoice_id'=>$invoice_id, 'created_at'=>$date]);
                                   
                                   $update_product_item = $product_item;
                                   $update_product_item->stock = $db_stock - $db_minus_unit;
                                   $update_product_item->update();
                                   
                               }
                           }
                           
                           
                           // Individual Product
                           $sum_for_product = $total_count * $price;
                           
                          if($individual_discount_status == 'flat') {
                              $ti_product_discount = $individual_discount_amount * $total_count;
                              $total_price = $sum_for_product - $ti_product_discount;
                              $discount_in_tk = $ti_product_discount;
                          }
                          else if($individual_discount_status == 'percent') {
                              $discount_p_amount_tk = ($individual_discount_amount * $sum_for_product)/100;
                              $total_price = $sum_for_product - $discount_p_amount_tk;
                              $discount_in_tk = $discount_p_amount_tk;
                          }
                          else {
                              $total_price = $sum_for_product;
                              $discount_in_tk = 0;
                          }
                          
                          $vat_price_ip = $total_price * $vat/100;
                          $total_price = $total_price + $vat_price_ip;
                          
                          $total_gross = $total_gross + $total_price;
                          
                          DB::table('ordered_products')->insert(['invoice_id'=>$invoice_id, 'product_id'=>$pid[$key], 'variation_id'=>$variation_id, 'quantity'=>$unit, 'price'=>$price, 'discount'=>$individual_discount_status, 'discount_amount'=>$individual_discount_amount, 'discount_in_tk'=>$discount_in_tk, 'vat_amount'=>$vat, 'total_price'=>$total_price, 'created_at'=>$date]);
                          // Individual Product
                           
                        }
                    }
                    
                    
                    if($customer_info->code == $shop_id.'WALKING') { $previous_due = 0; } else { $previous_due = $customer_balance; }
                    
                    $sum = $total_gross;
                    
                    //Global Discount
                    if($request->cart_discount == 'flat') {
                        $discount = 'flat';
                        $discount_int_tk = $request->discountAmount;
                    }
                    else if($request->cart_discount == 'percent') {
                        $discount = 'percent';
                        $discount_int_tk = ($request->discountAmount * $total_gross) / 100;
                    }
                    else {
                        $discount = 'no';
                        $discount_int_tk = 0;
                    }
                    
                    $sum = $sum - $discount_int_tk;
                    
                    //Global Vat
                    if(!empty($request->vat)) {
                        $vat = $request->vat;
                        $vat_in_tk = $sum * $vat/100;
                    }
                    else {
                        $vat = 0;
                        $vat_in_tk = 0;
                    }
                    
                    $sum = $sum + $vat_in_tk;
                    
                    //Others Charge
                    if(!empty($request->only_others_crg)) {
                        $others_charge = $request->only_others_crg;
                    }
                    else {
                        $others_charge = 0;
                    }
                    
                    $sum = $sum + $others_charge;
                    
                    //Get Wallet Point
                    if($sum >= $shop_settings->minimum_purchase_to_get_point && $shop_settings->is_active_customer_points == 'yes' && $customer_info->code != $shop_id.'WALKING') {
                        $point_earn_rate = $shop_settings->point_earn_rate + 0;
                        $wallet_point = $sum / $point_earn_rate;
                        $total_for_point = $sum;
                        $point_earn_rate = $point_earn_rate;
                        $previous_point = $customer_info->wallets+0;
                        $update_wallets_point = $wallet_point + $previous_point;
                        DB::table('customers')->where('id', $customer_info->id)->update(['wallets'=>$update_wallets_point]);
                    }
                    else {
                        $wallet_point = 0;
                        $total_for_point = 0;
                        $point_earn_rate = 0;
                    }
                    
                    //Delivery Charge
                    if(!empty($request->delivery_others_crg)) {
                        $delivery_charge = $request->delivery_others_crg;
                    }
                    else {
                        $delivery_charge = 0;
                    }
                    
                    $sum = $sum + $delivery_charge + $previous_due;
                    
                    
                    //Wallet Charge
                    if($shop_settings->is_active_customer_points == 'yes' && $customer_info->code != $shop_id.'WALKING') {
                        $wallet_status = 'yes';
                        $wallet_balance = ($customer_info->wallet_balance) + 0;
                        if($wallet_balance > 0) {
                            $rest_wallet_balance = 0;
                            if($sum >= $wallet_balance) {
                                $sum = $sum - $wallet_balance;
                                $rest_wallet_balance = 0;
                            }
                            else if($wallet_balance >= $sum) {
                                $rest_wallet_balance = $wallet_balance - $sum;
                                $sum = $sum - $sum;
                            }
                            
                            DB::table('customers')->where('id', $customer_info->id)->update(['wallet_balance'=>$rest_wallet_balance]);
                        }
                    }
                    else {
                        $wallet_status = 'no';
                        $wallet_balance = 0;
                    }
                    
                    
                    if($submit_form == 'full_payment') {
                        $paid = $request->full_payment;
                        // $current_due = 0;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'partial_payment') {
                        $paid = $request->partial_paid;
                        // $current_due = $request->partial_due;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'cash_on_payment') {
                        $paid = $request->cash_on_delivery_paid;
                        // $current_due = $request->cash_on_delivery_due;
                        $paid_by = 'cash';
                    }
                    else if($submit_form == 'cheque_payment') {
                        $paid = $request->mfs_paid;
                        // $current_due = $request->mfs_current_due;
                        $paid_by = 'cheque';
                    }
                    else if($submit_form == 'multiple') {
                        $paid_by = 'multiple';
                        $multiple_paid = 0;
                        if(!is_null($request->multiple_pay_amount)) {
                            $multiple_pay_amount = $request->multiple_pay_amount;
                            $multiple_pay_type_name = $request->multiple_pay_type_name;
                            $info = $request->multiple_pay_card_info;
                            $deposit_to = $request->multiple_pay_deposit_bank;
                            foreach($multiple_pay_amount as $key => $pay_amount) {
                                $multiple_paid = $multiple_paid + $multiple_pay_amount[$key];
                                $multiple_pay_type = $multiple_pay_type_name[$key];
                                
                                DB::table('multiple_payments')->insert(['shop_id'=>$shop_id, 'customer_id'=>$customer_info->id, 'branch_id'=>$branch_id, 'invoice_id'=>$invoice_id, 'paid_amount'=>$multiple_pay_amount[$key], 'payment_type'=>$multiple_pay_type, 'info'=>$info[$key], 'deposit_to'=>$deposit_to[$key], 'created_at'=>$date]);
                                
                                if($multiple_pay_type == 'cash') {
                                    $net_balance_m = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                                    $updated_balance_m = $net_balance_m->balance + $multiple_pay_amount[$key];
                                    DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance_m]);
                                }
                                else if($multiple_pay_type == 'card') {
                                    $bank_balance_m = DB::table('banks')->where(['id'=>$deposit_to[$key], 'shop_id'=>$shop_id])->first(['balance']);
                                    $updated_balance_m = $bank_balance_m->balance + $multiple_pay_amount[$key];
                                    DB::table('banks')->where(['id'=>$deposit_to[$key], 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance_m]);
                                }
                                
                            }
                        }
                        $paid = $multiple_paid;
                    }
                    
                    
                    if($customer_info->code == $shop_id.'WALKING') {
                        $paid = $sum;
                    }
                    
                    
                    $inv_data = array();
                    $inv_data['shop_id'] = $shop_id;
                    $inv_data['branch_id'] = $branch_id;
                    $inv_data['invoice_id'] = $invoice_id;
                    $inv_data['customer_id'] = $customer_id;
                    $inv_data['total_gross'] = $total_gross;
                    $inv_data['vat'] = $vat;
                    $inv_data['vat_in_tk'] = $vat_in_tk;
                    
                    $inv_data['discount_status'] = $discount;
                    $inv_data['discount_rate'] = $request->discountAmount;
                    $inv_data['discount_in_tk'] = $discount_int_tk;

                    $inv_data['pre_due'] = $previous_due;
                    $inv_data['others_crg'] = $others_charge;
                    $inv_data['delivery_crg'] = $delivery_charge;
                    $inv_data['invoice_total'] = $sum;
                    $inv_data['payment_by'] = $paid_by;
                    $inv_data['wallet_status'] = $wallet_status;
                    $inv_data['wallet_point'] = $wallet_point;
                    $inv_data['wallet_balance'] = $wallet_balance;
                    $inv_data['total_for_point'] = $total_for_point;
                    $inv_data['point_earn_rate'] = $point_earn_rate;
                    $inv_data['paid_amount'] = $paid;
                    $inv_data['change_amount'] = $request->change_amount;
                    $inv_data['delivery_man_id'] = $request->delivery_man_id;
                    
                    if($request->card_or_mobile_banking == 'card') {
                        $inv_data['card_or_mfs'] = 'card';
                        $inv_data['cheque_or_mfs_acc'] = $request->checkNoOrMFSAccNo;
                        $inv_data['mfs_acc_type'] = 'no';
                        $inv_data['cheque_bank'] = $request->Chequebank;
                        $inv_data['diposit_to'] = $request->dipositbank;
                        $inv_data['cheque_date'] = $request->Chequedate;
                        $inv_data['c_diposit_date'] = $request->DipositDate;
                    }
                    else if($request->card_or_mobile_banking == 'mfs') {
                        $inv_data['card_or_mfs'] = 'mfs';
                        $inv_data['cheque_or_mfs_acc'] = $request->mfs_sender_number;
                        $inv_data['mfs_acc_type'] = $request->mfs_name;
                        $inv_data['cheque_bank'] = 'no';
                        $inv_data['diposit_to'] = $request->dipositbank;
                    }
                    
                    
                    $inv_data['crm_id'] = Auth::user()->id;
                    $inv_data['sms_status'] = $request->send_sms+0;
                    $inv_data['note'] = $request->note;
                    $inv_data['date'] = $date;
                    $inv_data['created_at'] = $current_time;

                    DB::table('orders')->insert($inv_data);
                    
                    
                    $current_due = $sum - $paid; // (($invoice_total - $request->previous_due) + $customer_balance) - $paid;

                    if($paid_by == 'cash') {
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance + $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        $transaction_paid_by = 'cash';
                    }
                    else if($paid_by == 'cheque') {
                        $bank_balance = DB::table('banks')->where(['id'=>$request->dipositbank, 'shop_id'=>$shop_id])->first(['balance']);
                        $updated_balance = $bank_balance->balance + $paid;
                        DB::table('banks')->where(['id'=>$request->dipositbank, 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance]);
                        $transaction_paid_by = $request->dipositbank;
                    }
                    else{
                        $transaction_paid_by = 'multiple';
                    }
                    

                    if($customer_info->code != $shop_id.'WALKING') {
                        DB::table('customers')->where(['id'=>$customer_info->id, 'shop_id'=>$shop_id])->update(['balance'=>$current_due]);
                        if(!empty($customer_info->email)) {
                            //Mail::send(new OrderMail($invoice_id));
                        }
                        
                        //$shop_settings = DB::table('shop_settings')->where('shop_code', $shop_id)->first(['sms_active_status', 'sms_limit', 'shop_name']);
                        
                        if($branch_info->sms_status == 'yes' && $request->send_sms == 1) {
                            $sms_settings = DB::table('s_m_s_settings')->first(['non_masking_price', 'masking_price']);
                            $sms_method = DB::table('sms')->where('shop_id', $shop_id)->first(['message']);
                            if(!is_null($sms_method->message)) {
                                $sms_text = $sms_method->message;
                                    $sms_text = str_replace("customer_name", optional($customer_info)->name, $sms_text);
                                //$previous_due = $customer_balance;
                                    $sms_text = str_replace("previous_due", number_format($customer_balance,2), $sms_text);
                                $todays_bill = number_format(($invoice_total - $request->previous_due), 2);
                                    $sms_text = str_replace("todays_bill", $todays_bill, $sms_text);
                                $total_bill = number_format(($invoice_total - $request->previous_due) + $customer_balance, 2);
                                    $sms_text = str_replace("total_bill", $total_bill, $sms_text);
                                //$paid = $paid;
                                    $sms_text = str_replace("todays_paid", number_format($paid, 2), $sms_text);
                                //$current_balance = $current_due;
                                    $sms_text = str_replace("current_balance", number_format($current_due, 2), $sms_text);
                                $invoice_number = "http://pos.ehishab.com/inv/".$invoice_id;
                                    $sms_text = str_replace("invoice_number", $invoice_number, $sms_text);
                                
                                $sms_length = strlen($sms_text);
                                $sms_count = $this->check_sms_count($sms_length);
                                $sms_cost = $sms_count * $sms_settings->non_masking_price;
                                
                                if($shop_settings->sms_limit >= $sms_cost) {
                                    $msg = $sms_text;
                                    $phone_num = $customer_info->phone;
                                    $send_sms = SMS_settings::send_sms($msg, $phone_num);
                                    
                                    if($send_sms != '1002' || $send_sms != '1003' || $send_sms != '1004' || $send_sms != '1005' || $send_sms != '1006' || $send_sms != '1007' || $send_sms != '1008' || $send_sms != '1009' || $send_sms != '1010' || $send_sms != '1011' || $send_sms != '1012' || $send_sms != '1013' || $send_sms != '1014') {
                                        $update_sms_balance = $shop_settings->sms_limit - $sms_cost;
                                        DB::table('shop_settings')->where('shop_code', $shop_id)->update(['sms_limit'=>$update_sms_balance]);
                                    DB::table('sms_histories')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'length'=>$sms_length, 'sms_count'=>$sms_count, 'send_to'=>'C', 'phone_number'=>$phone_num, 'info'=>$msg, 'created_at'=>Carbon::now()]);
                                    }
                                }
                            }
                        }
                    }


                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$transaction_paid_by, 'branch_id'=>Auth::user()->branch_id, 'added_by'=>Auth::user()->id, 'for_what'=>'S', 'track'=>$customer_id, 'refference'=>$invoice_id, 'amount'=>$paid, 'creadit_or_debit'=>'CR', 'note'=>'Sell to customer. Invoice Num. #'.str_replace("_","/", $invoice_id).'', 'created_at'=>$date]);
                    DB::table('moments_traffics')->insert(['shop_id' => Auth::user()->shop_id, 'user_id' => Auth::user()->id, 'info' =>'Product Sell to '.$customer_info->code.', Invoice Num: '.str_replace("_","/", $invoice_id).'', 'created_at' => Carbon::now()]);
                    //return Redirect()->route('view.sold.invoice', ['invoice_id'=>$invoice_id]);
                    
                    $output = [
                        'status' => 'yes',
                        'default_print' => $branch_info->print_by,
                        'invoice_num' => $invoice_id,
                        'due' => $current_due,
                        
                    ];
                    return Response($output);
                    
            }
            else {
                $output = [
                    'status' => 'no',
                    'reason' => 'No Products in cart!',
                ];
                return Response($output);
            } 
        }
        else {
            $output = [
                'status' => 'no',
                'reason' => 'Sorry you have not access to do this work!',
            ];
            return Response($output);
        }
    }


    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function public_invoice_show($invoice_id)
    {
        // if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $invoice_info = order::where('invoice_id', $invoice_id)->first();
            $shop_info = DB::table('shop_settings')->where('shop_code', $invoice_info->shop_id)->first();
            if($invoice_info) {
                $pdf = PDF::loadView('cms.branch.sell.view_sold_invoice', compact('shop_info', 'invoice_info'));
                return $pdf->stream('Sell invoice #'.str_replace("_","/", $invoice_id).'.pdf');

            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        // }
        // else {
        //     return Redirect()->back()->with('error', 'Sorry you can not access this page');
        // }
    }
    
    public function show($invoice_id)
    {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $invoice_info = order::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($invoice_info) {
                $pdf = PDF::loadView('cms.branch.sell.view_sold_invoice', compact('shop_info', 'invoice_info'));
                return $pdf->stream('Customer invoice '.$invoice_info->invoice_id.'.pdf');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    public function print_invoice_in_half_page($invoice_id)
    {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $invoice_info = order::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            
            if($invoice_info) {
                $pdf = PDF::loadView('cms.branch.sell.view_sold_invoice_in_half_page', 
                             compact('shop_info', 'invoice_info'), 
                            [], 
                            [ 
                              'title' => 'Certificate', 
                              'format' => 'A4-L',
                              'orientation' => 'L'
                            ]);
                return $pdf->stream('Customer invoice '.$invoice_info->invoice_id.'.pdf');

            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    
    
    public function print_invoice_in_pos_printer($invoice_id)
    {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $invoice_info = order::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($invoice_info) {
                $pdf = PDF::loadView('cms.branch.sell.view_sold_invoice', compact('shop_info', 'invoice_info'));
                return $pdf->stream('Customer invoice '.$invoice_info->invoice_id.'.pdf');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function invoice_pos_print($invoice_id)
    {
        if(User::checkMultiplePermission(['branch.sell', 'others.sell']) == true){
            $shop_id = Auth::user()->shop_id;
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $invoice_info = order::where('invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($invoice_info) {
                return view('cms.branch.sell.pos_print_invoice', compact('shop_info', 'invoice_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(order $order)
    {
        //
    }
}
