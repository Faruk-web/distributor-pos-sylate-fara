<?php

namespace App\Http\Controllers;

use App\Models\Take_customer_due;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use App\Models\Customer;

class TakeCustomerDueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('branch.received.customer.due') == true){
            return view('cms.branch.take_due.all_due_received_vouchers');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function index_data(Request $request) {
        if ($request->ajax()) {
            $orders = Take_customer_due::where(['branch_id'=>Auth::user()->branch_id,'shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('view.due.received.voucher', ['voucher_num'=>optional($row)->voucher_number]).'" class="btn btn-info btn-sm">View</a>';
                    return $info;
                })
                ->addColumn('customer_name', function($row){
                    $info = optional($row->customer_info)->name." [".optional($row->customer_info)->code."]";
                    return $info;
                })
                ->addColumn('customer_phone', function($row){
                    $info = optional($row->customer_info)->phone;
                    return $info;
                })
                ->addColumn('voucher_num', function($row){
                    return "#".str_replace("_","/", $row->voucher_number);
                })
                ->addColumn('date', function($row){
                    $info = date("d M, Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['action', 'customer_name', 'customer_phone', 'voucher_num'])
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
        if(User::checkPermission('branch.received.customer.due') == true){
            $shop_id = Auth::user()->shop_id;
            $customer_code = $request->customer_code;
            $count = DB::table('take_customer_dues')->where('shop_id', $shop_id)->count('id');
            $count = $count++;
            $voucher_num = "CDR".$shop_id."_".$count;

            $validated = $request->validate([
                'customer_code' => 'required',
                'paymentBy' => 'required',

            ]);
           
            $customer_info = DB::table('customers')->where(['code'=>$customer_code, 'shop_id'=>$shop_id])->first(['balance', 'id', 'name']);
            
            if(!empty($customer_info->id)) {
                if($request->paymentBy == 'cash') {
                    $paid = $request->paid_amount_by_cash;
                    $due = $customer_info->balance;
                    $paid_by = 'cash';
                }
                else if($request->paymentBy == 'cheque') {
                    $paid = $request->paid_amount_by_cheque;
                    $due = $customer_info->balance;
                    $paid_by = 'cheque';
                }
    
                $insert = Take_customer_due::insert(['shop_id'=>$shop_id, 'voucher_number'=>$voucher_num, 'user_id'=>Auth::user()->id, 'branch_id'=>Auth::user()->branch_id, 'customer_code'=>$customer_code, 'paymentBy'=>$paid_by, 'due'=>$due, 'received_amount'=>$paid, 'cheque_or_mfs_account'=>$request->cheque_or_mfs_account, 'cheque_date'=>$request->cheque_date, 'cheque_bank_or_mfs_name'=>$request->cheque_bank_or_mfs_name, 'deposit_to'=>$request->deposit_to, 'deposit_date'=>$request->deposit_date, 'note'=>$request->note, 'created_at'=>$request->tansectionDate]);
                if($insert) {
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'branch_id'=>Auth::user()->branch_id, 'added_by'=>Auth::user()->id, 'for_what'=>'CDR', 'track'=>$customer_info->id, 'refference'=>$voucher_num, 'amount'=>$paid, 'creadit_or_debit'=>'CR', 'note'=>'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.'', 'created_at'=>Carbon::now()]);
                    $update_balance = $due-$paid;
                    DB::table('customers')->where('code', $customer_code)->update(['balance'=>$update_balance]);
                    if($paid_by == 'cash') {
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance + $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        //DB::table('cash_flows')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'branch_id'=>Auth::user()->branch_id, 'account'=>'cash', 'credit_or_debit'=>'CR', 'description'=>'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.'', 'balance'=>$paid, 'created_at'=>Carbon::now()]);
                    }
                    else if($paid_by == 'cheque') {
                        $bank_balance = DB::table('banks')->where(['id'=>$request->deposit_to, 'shop_id'=>$shop_id])->first(['balance']);
                        $updated_balance = $bank_balance->balance + $paid;
                        DB::table('banks')->where(['id'=>$request->deposit_to, 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance]);
                        //DB::table('cash_flows')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'branch_id'=>Auth::user()->branch_id, 'account'=>$request->deposit_to, 'credit_or_debit'=>'CR', 'description'=>'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.'', 'balance'=>$paid, 'created_at'=>Carbon::now()]);
                    }
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.', Amount: '.$paid.'', 'created_at' =>Carbon::now()]);
                    return Redirect()->route('view.due.received.voucher', ['voucher_num'=>$voucher_num])->with('success', 'Successfully Received');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Error occured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Take_customer_due  $take_customer_due
     * @return \Illuminate\Http\Response
     */
    public function show($voucher_num)
    {
        if(User::checkPermission('branch.received.customer.due') == true){
            $shop_id = Auth::user()->shop_id;
            $voucher_info = Take_customer_due::where(['voucher_number'=>$voucher_num, 'shop_id'=>$shop_id])->first();
            if(!empty($voucher_info->id)) {
                $wing = 'acc_and_tran';
                $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
                return view('cms.branch.take_due.view_due_received_voucher', compact('voucher_info', 'shop_info', 'wing'));
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
     * @param  \App\Models\Take_customer_due  $take_customer_due
     * @return \Illuminate\Http\Response
     */
    public function edit(Take_customer_due $take_customer_due)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Take_customer_due  $take_customer_due
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Take_customer_due $take_customer_due)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Take_customer_due  $take_customer_due
     * @return \Illuminate\Http\Response
     */
    public function destroy(Take_customer_due $take_customer_due)
    {
        //
    }

    //Begin:: take customer due from admin
    public function admin_customers_due_received($customer_code) {
        if(User::checkMultiplePermission(['account.transaction', 'others.receive.customers.due']) == true){
            $wing = 'acc_and_tran';
            $customer_info = DB::table('customers')->where(['code'=>$customer_code, 'shop_id'=>Auth::user()->shop_id])->first();
            return view('cms.shop_admin.customers.take_customer_due', compact('customer_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_take_due_search_customers(Request $request) {
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
                        '<td><a href="'.route('admin.customer.due.received', ['customer_code'=>$customer->code]).'" type="button" class="btn btn-primary btn-sm">Select</a></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h2>No Result Found</h2></td></tr>';
            }
            
        }
        
        return Response($output);
    }

    public function admin_received_customer_due_confirm(Request $request)
    {
        if(User::checkMultiplePermission(['account.transaction', 'others.receive.customers.due']) == true){
            $shop_id = Auth::user()->shop_id;
            $customer_code = $request->customer_code;
            $count = DB::table('take_customer_dues')->where('shop_id', $shop_id)->count('id');
            $count = $count++;
            $voucher_num = "CDR".$shop_id."_".$count;

            $validated = $request->validate([
                'customer_code' => 'required',
                'paymentBy' => 'required',

            ]);
           
            $customer_info = DB::table('customers')->where(['code'=>$customer_code, 'shop_id'=>$shop_id])->first(['balance', 'id', 'name']);
            
            if(!empty($customer_info->id)) {
                if($request->paymentBy == 'cash') {
                    $paid = $request->paid_amount_by_cash;
                    $due = $customer_info->balance;
                    $paid_by = 'cash';
                    $transaction_paid_by = 'cash';
                }
                else if($request->paymentBy == 'cheque') {
                    $paid = $request->paid_amount_by_cheque;
                    $due = $customer_info->balance;
                    $paid_by = 'cheque';
                    $transaction_paid_by = $request->deposit_to;
                }
    
                $insert = Take_customer_due::insert(['shop_id'=>$shop_id, 'voucher_number'=>$voucher_num, 'user_id'=>Auth::user()->id, 'customer_code'=>$customer_code, 'paymentBy'=>$paid_by, 'due'=>$due, 'received_amount'=>$paid, 'cheque_or_mfs_account'=>$request->cheque_or_mfs_account, 'cheque_date'=>$request->cheque_date, 'cheque_bank_or_mfs_name'=>$request->cheque_bank_or_mfs_name, 'deposit_to'=>$request->deposit_to, 'deposit_date'=>$request->deposit_date, 'note'=>$request->note, 'created_at'=>$request->tansectionDate]);
                if($insert) {
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$transaction_paid_by, 'added_by'=>Auth::user()->id, 'for_what'=>'CDR', 'track'=>$customer_info->id, 'refference'=>$voucher_num, 'amount'=>$paid, 'creadit_or_debit'=>'CR', 'note'=>'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.'', 'created_at'=>Carbon::now()]);
                    $update_balance = $due-$paid;
                    DB::table('customers')->where('code', $customer_code)->update(['balance'=>$update_balance]);
                    if($paid_by == 'cash') {
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance + $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                        //DB::table('cash_flows')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'branch_id'=>Auth::user()->branch_id, 'account'=>'cash', 'credit_or_debit'=>'CR', 'description'=>'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.'', 'balance'=>$paid, 'created_at'=>Carbon::now()]);
                    }
                    else if($paid_by == 'cheque') {
                        $bank_balance = DB::table('banks')->where(['id'=>$request->deposit_to, 'shop_id'=>$shop_id])->first(['balance']);
                        $updated_balance = $bank_balance->balance + $paid;
                        DB::table('banks')->where(['id'=>$request->deposit_to, 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance]);
                        //DB::table('cash_flows')->insert(['shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'branch_id'=>Auth::user()->branch_id, 'account'=>$request->deposit_to, 'credit_or_debit'=>'CR', 'description'=>'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.'', 'balance'=>$paid, 'created_at'=>Carbon::now()]);
                    }
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Take Due From Customer, Customer Code: '.$customer_code.', name: '.$customer_info->name.', Amount: '.$paid.'', 'created_at' =>Carbon::now()]);
                    return Redirect()->route('admin.view.customer.due.received.voucher', ['voucher_num'=>$voucher_num])->with('success', 'Successfully Received');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Error occured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function admin_customer_due_received_vouchers() {
        if(User::checkMultiplePermission(['account.transaction', 'others.receive.customers.due']) == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.customers.customer_due_received_vouchers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_customer_due_received_vouchers_data(Request $request) {
        if ($request->ajax()) {
            $orders = Take_customer_due::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('admin.view.customer.due.received.voucher', ['voucher_num'=>optional($row)->voucher_number]).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    return $info;
                })
                ->addColumn('branch_name', function($row){
                    $info = '';
                    if(optional($row)->branch_id != '') {
                        $info = optional($row->branch_info)->branch_name;
                    }
                    else {
                        $info .='Admin';
                    }
                    return $info;
                })
                ->addColumn('customer_name', function($row){
                    $info = optional($row->customer_info)->name." [".optional($row->customer_info)->code."]";
                    return $info;
                })
                ->addColumn('customer_phone', function($row){
                    $info = optional($row->customer_info)->phone;
                    return $info;
                })
                ->addColumn('voucher_num', function($row){
                    return str_replace("_","/", $row->voucher_number);
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['action', 'customer_name', 'customer_phone', 'voucher_num', 'branch_name'])
                ->make(true);
        }
    }

    public function admin_view_customer_due_received_voucher_info($voucher_num)
    {
        if(User::checkMultiplePermission(['admin.transaction.vouchers', 'others.receive.customers.due']) == true){
            $shop_id = Auth::user()->shop_id;
            $voucher_info = Take_customer_due::where(['voucher_number'=>$voucher_num, 'shop_id'=>$shop_id])->first();
            if(!empty($voucher_info->id)) {
                $wing = 'acc_and_tran';
                $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
                return view('cms.shop_admin.customers.view_customer_due_received_voucher', compact('voucher_info', 'shop_info', 'wing'));
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: take customer due from admin


    




}

