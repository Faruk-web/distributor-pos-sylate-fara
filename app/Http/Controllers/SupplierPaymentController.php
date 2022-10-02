<?php

namespace App\Http\Controllers;

use App\Models\Supplier_payment;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use DataTables;

class SupplierPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.transaction.vouchers') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.supplier.payment.supplier_payment_vouchers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function supplier_payment_vouchers_data(Request $request) {
        if ($request->ajax()) {
            $orders = Supplier_payment::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('view.supplier.payment.voucher', ['voucher_num'=>$row->voucher_number]).'" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
                    return $info;
                })
                ->addColumn('supplier_name', function($row){
                    $info = optional($row->supplier_info)->name." [".optional($row->supplier_info)->company_name."]";
                    return $info;
                })
                ->addColumn('supplier_phone', function($row){
                    $info = optional($row->supplier_info)->phone;
                    return $info;
                })
                ->addColumn('voucher_num', function($row){
                    return str_replace("_","/", $row->voucher_number);
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['action', 'supplier_name', 'supplier_phone', 'voucher_num', 'date'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($supplier_code)
    {
        if(User::checkPermission('account.transaction') == true){
            $wing = 'acc_and_tran';
            $supplier_info = DB::table('suppliers')->where(['code'=>$supplier_code, 'shop_id'=>Auth::user()->shop_id])->first();
            return view('cms.shop_admin.supplier.payment.take_supplier_payment', compact('supplier_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_search_supplier_to_pay(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $supplier_info = $request->get('supplier_info');
        //   $suppliers = Supplier::where('shop_id', $shop_id)
        //   ->where('name', 'LIKE', '%'. $supplier_info. '%')
        //   ->orWhere('phone', 'LIKE', '%'. $supplier_info. '%')
        //   ->orWhere('company_name', 'LIKE', '%'. $supplier_info. '%')
        //   ->where('active', 1)
        //   ->get(['name', 'address', 'phone', 'email', 'code', 'balance', 'company_name']);

          $suppliers = DB::table('suppliers')
                ->where('shop_id', '=', $shop_id)
                ->where('active', 1)
                ->where(function ($query) use ($supplier_info) {
                    $query->where('phone', 'LIKE', '%'. $supplier_info. '%')
                        ->orWhere('company_name', 'LIKE', '%'. $supplier_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $supplier_info. '%');
                })
                ->get(['name', 'address', 'phone', 'email', 'code', 'balance', 'company_name']);
          
          if(!empty($supplier_info)) {
              if(count($suppliers) > 0) {
                foreach ($suppliers as $supplier) {
                    $output.='<tr>'.
                        '<td>'.$supplier->name.'</td>'.
                        '<td>'.$supplier->company_name.'</td>'.
                        '<td>'.$supplier->phone.'</td>'.
                        '<td>'.$supplier->address.'</td>'.
                        '<td>'.$supplier->code.'</td>'.
                        '<td>'.$supplier->balance.'</td>'.
                        '<td><a href="'.route('admin.supplier.payment', ['supplier_code'=>$supplier->code]).'" type="button" class="btn btn-primary btn-sm">Select</a></td>'.
                        '</tr>';
                    }
              }
              else {
                $output.='<tr><td colspan="6" class="text-center"><h2>No Result Found</h2></td></tr>';
            }
            
        }
        
        return Response($output);
    }

    public function admin_supplier_payment_change_bank(Request $request) {
        $output = '';
        $bankID = $request->bankID;
        $shop_id = Auth::user()->shop_id;
        $bank_info = DB::table('banks')->where(['id'=>$bankID, 'shop_id'=>$shop_id])->first(['balance', 'id']);
        if(!empty($bank_info->id)) {
            $output .= '<div class="form-group p-2"><b>Bank Balance.</b><input type="text" name="BankBalance" id="BankBalanceC" class="form-control" value="'.$bank_info->balance.'" readonly><b>CQ Num.</b><input type="text" name="chequeNumber" id="chequeNumber" class="form-control" value="000"></div>';
        }
        else {
            $output = 'Error occoured!';
        }
        return Response($output);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(User::checkPermission('account.transaction') == true){
            $shop_id = Auth::user()->shop_id;
            $supplier_code = $request->supplier_code;
            $count = DB::table('supplier_payments')->where('shop_id', $shop_id)->count('id');
            $count = $count++;
            $voucher_num = "SDP".$shop_id."_".$count;
            $validated = $request->validate([
                'supplier_code' => 'required',
                'paymentBy' => 'required',

            ]);
           
            $supplier_info = DB::table('suppliers')->where(['code'=>$supplier_code, 'shop_id'=>$shop_id])->first(['balance', 'id', 'name']);
            
            if(!empty($supplier_info->id) && optional($supplier_info)->balance > 0) {
                if($request->paymentBy == 'cash') {
                    $paid = $request->paid_amount_by_cash;
                    $due = $supplier_info->balance;
                    $paid_by = 'cash';
                    $transaction_paid_by = 'cash';
                }
                else if($request->paymentBy == 'cheque') {
                    $paid = $request->paid_amount_by_cheque;
                    $due = $supplier_info->balance;
                    $paid_by = 'cheque';
                    $transaction_paid_by = $request->deposit_to;
                }
    
                $insert = Supplier_payment::insert(['voucher_number'=>$voucher_num,'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'supplier_code'=>$supplier_code, 'paymentBy'=>$paid_by, 'due'=>$due, 'paid'=>$paid, 'cheque_or_mfs_account'=>$request->deposit_to, 'cheque_date'=>$request->deposit_date, 'cheque_num'=>$request->chequeNumber, 'note'=>$request->note, 'created_at'=>$request->tansectionDate]);
                if($insert) {
                    $update_balance = $due-$paid;
                    DB::table('suppliers')->where('code', $supplier_code)->update(['balance'=>$update_balance]);
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$transaction_paid_by, 'added_by'=>Auth::user()->id, 'for_what'=>'SDP', 'track'=>$supplier_code, 'refference'=>$voucher_num, 'amount'=>$paid, 'creadit_or_debit'=>'DR', 'note'=>'Payment To supplier, supplier Code: '.$supplier_code.', name: '.$supplier_info->name.', Amount: '.$paid.'', 'created_at'=>Carbon::now()]);
                    if($paid_by == 'cash') {
                        $net_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first(['balance']);
                        $updated_balance = $net_balance->balance - $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_balance]);
                    }
                    else if($paid_by == 'cheque') {
                        $bank_balance = DB::table('banks')->where(['id'=>$request->deposit_to, 'shop_id'=>$shop_id])->first(['balance']);
                        $updated_balance = $bank_balance->balance - $paid;
                        DB::table('banks')->where(['id'=>$request->deposit_to, 'shop_id'=>$shop_id])->update(['balance'=>$updated_balance]);
                    }
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Payment To supplier, supplier Code: '.$supplier_code.', name: '.$supplier_info->name.', Amount: '.$paid.'', 'created_at' =>Carbon::now()]);
                    return Redirect()->route('view.supplier.payment.voucher', ['voucher_num'=>$voucher_num]);
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
     * @param  \App\Models\Supplier_payment  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function show($voucher_num)
    {
        if(User::checkPermission('admin.transaction.vouchers') == true){
            $wing = 'acc_and_tran';
            $shop_id = Auth::user()->shop_id;
            $voucher_info = Supplier_payment::where(['voucher_number'=>$voucher_num, 'shop_id'=>$shop_id])->first();
            if(!empty($voucher_info->id)) {
                $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
                return view('cms.shop_admin.supplier.payment.view_supplier_payment_voucher', compact('voucher_info', 'shop_info', 'wing'));
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
     * @param  \App\Models\Supplier_payment  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier_payment $supplier_payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier_payment  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier_payment $supplier_payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier_payment  $supplier_payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier_payment $supplier_payment)
    {
        //
    }
}
