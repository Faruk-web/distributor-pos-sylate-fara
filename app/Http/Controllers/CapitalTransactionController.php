<?php

namespace App\Http\Controllers;

use App\Models\Capital_transaction;
use App\Models\Owners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;

class CapitalTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('account.capital') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.capital.capital_history', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function capital_history_data(Request $request) {
        if ($request->ajax()) {
            $orders = Capital_transaction::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('add_or_withdraw', function($row){
                    return $row->add_or_withdraw;
                })
                ->addColumn('owner_info', function($row){
                    return $row->owner_info->name." [".$row->owner_info->phone."]";
                })
                ->addColumn('info', function($row){
                    $info = '';
                    if($row->cash_or_cheque == 'cash') {
                        $info .= '<p>Transaction by: Cash.<br /><b>Voucher Num: </b># '.str_replace("_","/", $row->voucher_num).'<br /> <b>Note: </b>'.optional($row)->note.'<br /> <b>Added By: </b>'.optional($row->user_info)->name.'</p>';
                    }
                    else if($row->cash_or_cheque == 'cheque') {
                        $info .= '<p>Transaction by: Cheque[ '.optional($row->bank_info)->bank_name.' ('.optional($row->bank_info)->account_no.') ].<br /><b>Voucher Num: </b># '.str_replace("_","/", $row->voucher_num).'<br /> <b>Note: </b>'.optional($row)->note.'<br /> <b>Added By: </b>'.optional($row->user_info)->name.'</p>';
                    }
                    return $info;
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
               
                ->rawColumns(['add_or_withdraw', 'info', 'owner_info', 'date'])
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
        //
    }

    public function capital_receive()
    {
        if(User::checkPermission('account.capital') == true){
            $wing = 'acc_and_tran';
            $owners = Owners::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.capital.capital_receive', compact('wing', 'owners'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function capital_receive_confirm(Request $request) {
        if(User::checkPermission('account.capital') == true){
            
            $note = $request->note;
            $date = $request->date;
            $shop_id = Auth::user()->shop_id;
            $owner_id = $request->capital_person_id;
            $cheque_owner = DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->first();
            if(!empty($cheque_owner->id)) {
                $current_voucher_num = DB::table('capital_transactions')->where('shop_id', $shop_id)->count('id');
                $current_num = $current_voucher_num+1;
                $voucher_num = "CA".$shop_id.'_'.$current_num;

                $transaction_by = $request->received_by;
                if($transaction_by == 'cash') {
                    $current_cash_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                    $receiable_cash_amount = $request->cash_received;
                    if($receiable_cash_amount > 0) {
                        $insert = Capital_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'owner_id'=>$owner_id, 'add_or_withdraw'=>'ADD', 'cash_or_cheque'=>$transaction_by, 'amount'=>$receiable_cash_amount, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $owner_update_balance = $cheque_owner->capital + $receiable_cash_amount;
                            $update_cash_balance = $current_cash_balance->balance + $receiable_cash_amount;
                            DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$update_cash_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'CA', 'track'=>$cheque_owner->id, 'refference'=>$voucher_num, 'amount'=>$receiable_cash_amount, 'creadit_or_debit'=>'CR', 'note'=>'Capital Received from Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at'=>$date]);
                            DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->update(['capital'=>$owner_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Capital Received from Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at' =>$date]);
                            return Redirect()->route('admin.account.capital.history')->with('success', 'Capital Added from Owner successfully.');
                        }
                        else {
                            return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                        }
                    }
                    else {
                        return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                    }
                }
                else if($transaction_by == 'cheque') {
                    $current_bank_balance = DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->receiable_bank])->first();
                    $receiable_amount = $request->receiable_amount;
                    if($receiable_amount > 0) {
                        $insert = Capital_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'owner_id'=>$owner_id, 'add_or_withdraw'=>'ADD', 'cash_or_cheque'=>$transaction_by, 'amount'=>$receiable_amount, 'bank_id'=>$request->receiable_bank, 'account_num'=>$request->bank_account_num, 'cheque_num'=>$request->cheque_num, 'owner_bank_name'=>$request->bank_name, 'cheque_diposite_date'=>$request->deposit_date, 'cheque_date'=>$request->cheque_date, 'cheque_num'=>$request->cheque_num, 'cheque_date'=>$request->cheque_date, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $owner_update_balance = $cheque_owner->capital + $receiable_amount;
                            $update_bank_balance = $current_bank_balance->balance + $receiable_amount;
                            DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->receiable_bank])->update(['balance'=>$update_bank_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$request->receiable_bank, 'added_by'=>Auth::user()->id, 'for_what'=>'CA', 'track'=>$cheque_owner->id, 'refference'=>$voucher_num, 'amount'=>$receiable_amount, 'creadit_or_debit'=>'CR', 'note'=>'Capital Received from Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at'=>$date]);
                            DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->update(['capital'=>$owner_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Capital Received from Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at' =>$date]);
                            return Redirect()->route('admin.account.capital.history')->with('success', 'Capital Added from Owner successfully.');
                        }
                        else {
                            return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                        }
                    }
                    else {
                        return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                    }

                }
            }
            else {
                return Redirect()->back()->with('error', '000 Error Occoured! Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function capital_withdraw(Request $request) {
        if(User::checkPermission('account.capital') == true){
            $wing = 'acc_and_tran';
            $owners = Owners::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.capital.capital_withdraw', compact('wing', 'owners'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function capital_withdraw_confirm(Request $request) {
        if(User::checkPermission('account.capital') == true){
           
            $note = $request->note;
            $date = $request->date;
            $shop_id = Auth::user()->shop_id;
            $owner_id = $request->capital_person_id;
            $cheque_owner = DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->first();
            if(!empty($cheque_owner->id)) {
                
                $current_voucher_num = DB::table('capital_transactions')->where('shop_id', $shop_id)->count('id');
                $current_num = $current_voucher_num+1;
                $voucher_num = "CW".$shop_id.'_'.$current_num;
                $transaction_by = $request->paid_by;
                if($transaction_by == 'cash') {
                    $current_cash_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                    $payable_amount = $request->cash_paid;
                    if($current_cash_balance->balance >= $payable_amount) {
                        $insert = Capital_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'owner_id'=>$owner_id, 'add_or_withdraw'=>'WITHDRAW', 'cash_or_cheque'=>$transaction_by, 'amount'=>$payable_amount, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $owner_update_balance = $cheque_owner->capital - $payable_amount;
                            $update_cash_balance = $current_cash_balance->balance - $payable_amount;
                            DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$update_cash_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'CW', 'track'=>$cheque_owner->id, 'refference'=>$voucher_num, 'amount'=>$payable_amount, 'creadit_or_debit'=>'DR', 'note'=>'Capital Withdraw For Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at'=>$date]);
                            DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->update(['capital'=>$owner_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Capital Withdraw For Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at' =>$date]);
                            return Redirect()->route('admin.account.capital.history')->with('success', 'Capital Withdraw successfully.');
                        }
                        else {
                            return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                        }
                    }
                    else {
                        return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                    }
                }
                else if($transaction_by == 'cheque') {
                    $current_bank_balance = DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->payable_bank])->first();
                    $payable_amount = $request->cheque_paid;
                    if($current_bank_balance->balance >= $payable_amount) {
                        $insert = Capital_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'owner_id'=>$owner_id, 'add_or_withdraw'=>'WITHDRAW', 'cash_or_cheque'=>$transaction_by, 'amount'=>$payable_amount, 'bank_id'=>$request->payable_bank, 'cheque_num'=>$request->cheque_num, 'cheque_date'=>$request->cheque_date, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $owner_update_balance = $cheque_owner->capital - $payable_amount;
                            $update_bank_balance = $current_bank_balance->balance - $payable_amount;
                            DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->payable_bank])->update(['balance'=>$update_bank_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$request->payable_bank, 'added_by'=>Auth::user()->id, 'for_what'=>'CW', 'track'=>$cheque_owner->id, 'refference'=>$voucher_num, 'amount'=>$payable_amount, 'creadit_or_debit'=>'DR', 'note'=>'Capital Withdraw For Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at'=>$date]);
                            DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->update(['capital'=>$owner_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Capital Withdraw For Owner, Owner name: '.$cheque_owner->name.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at' =>$date]);
                            return Redirect()->route('admin.account.capital.history')->with('success', 'Loan Paid to lender successfully.');
                        }
                        else {
                            return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                        }
                    }
                    else {
                        return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
                    }

                }
            }
            else {
                return Redirect()->back()->with('error', 'Error Occoured! Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Capital_transaction  $capital_transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Capital_transaction $capital_transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Capital_transaction  $capital_transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Capital_transaction $capital_transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Capital_transaction  $capital_transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Capital_transaction $capital_transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Capital_transaction  $capital_transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Capital_transaction $capital_transaction)
    {
        //
    }
}
