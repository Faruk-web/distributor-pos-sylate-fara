<?php

namespace App\Http\Controllers;

use App\Models\Loan_transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use App\Models\Loan_person;


class LoanTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('account.loan') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.loan.loan_paid_or_received_history', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function loan_history_data(Request $request) {
        if ($request->ajax()) {
            $orders = Loan_transaction::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('paid_or_received', function($row){
                    return $row->paid_or_received;
                })
                ->addColumn('added_by', function($row){
                    return $row->user_info->name;
                })
                ->addColumn('lender_info', function($row){
                    return $row->lender_info->name." [".$row->lender_info->phone."]";
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
               
                ->rawColumns(['paid_or_received', 'info', 'lender_info', 'date'])
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
        if(User::checkPermission('account.loan') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.loan.loan_paid_or_received', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function search_lender(Request $request) {
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $lender_info = $request->get('lender_info');

        $lenders = DB::table('loan_people')
                ->where('shop_id', '=', $shop_id)
                ->where(function ($query) use ($lender_info) {
                    $query->where('phone', 'LIKE', '%'. $lender_info. '%')
                        ->orWhere('email', 'LIKE', '%'. $lender_info. '%')
                        ->orWhere('name', 'LIKE', '%'. $lender_info. '%');
                })
                ->get();
          
          if($lender_info) {
            if(count($lenders) > 0) {
                foreach ($lenders as $lender) {
                    $output.='<tr>'.
                    '<td>'.$lender->name.'</td>'.
                    '<td>'.$lender->phone.'</td>'.
                    '<td>'.optional($lender)->email.'</td>'.
                    '<td>'.optional($lender)->address.'</td>'.
                    '<td><a href="javascript:void(0)" onclick="select_lender('.$lender->id.', \''.$lender->name.'\', \''.$lender->phone.'\','.$lender->balance.')" type="button" class="btn btn-primary btn-sm">Select</a></td>'.
                    '</tr>';
                }
            }
            else {
                $output.='<tr><td colspan="6" class="text-center"><h2>No Result Found</h2></td></tr>';
            }
                return Response($output);
        }
    }

    public function loan_paid_confirm(Request $request) {
        if(User::checkPermission('account.loan') == true){
            $note = $request->note;
            $date = $request->date;
            $shop_id = Auth::user()->shop_id;
            $lender_id = $request->lender_id;
            $cheque_lender = DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->first();
            if(!empty($cheque_lender->id)) {
                
                $current_voucher_num = DB::table('loan_transactions')->where('shop_id', $shop_id)->count('id');
                $current_num = $current_voucher_num+1;
                $voucher_num = "LP".$shop_id.'_'.$current_num;
                $transaction_by = $request->paid_by;
                if($transaction_by == 'cash') {
                    $current_cash_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                    $payable_amount = $request->cash_paid;
                    if($current_cash_balance->balance >= $payable_amount) {
                        $insert = Loan_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'lender_id'=>$lender_id, 'paid_or_received'=>'PAID', 'cash_or_cheque'=>$transaction_by, 'amount'=>$payable_amount, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $lender_update_balance = $cheque_lender->balance - $payable_amount;
                            $update_cash_balance = $current_cash_balance->balance - $payable_amount;
                            DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$update_cash_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'LP', 'track'=>$cheque_lender->id, 'refference'=>$voucher_num, 'amount'=>$payable_amount, 'creadit_or_debit'=>'DR', 'note'=>'Loan Paid to Lender, Lender name: '.$cheque_lender->name.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at'=>Carbon::now()]);
                            DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->update(['balance'=>$lender_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Loan Paid to Lender, Lender name: '.$cheque_lender->name.', Paid Amount: '.$payable_amount.',  Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at' =>Carbon::now()]);
                            return Redirect()->route('admin.account.loan.history')->with('success', 'Loan Paid to lender successfully.');
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
                        $insert = Loan_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'lender_id'=>$lender_id, 'paid_or_received'=>'PAID', 'cash_or_cheque'=>$transaction_by, 'amount'=>$payable_amount, 'bank_id'=>$request->payable_bank, 'cheque_num'=>$request->cheque_num, 'cheque_date'=>$request->cheque_date, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $lender_update_balance = $cheque_lender->balance - $payable_amount;
                            $update_bank_balance = $current_bank_balance->balance - $payable_amount;
                            DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->payable_bank])->update(['balance'=>$update_bank_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$request->payable_bank, 'added_by'=>Auth::user()->id, 'for_what'=>'LP', 'track'=>$cheque_lender->id, 'refference'=>$voucher_num, 'amount'=>$payable_amount, 'creadit_or_debit'=>'DR', 'note'=>'Loan Paid to Lender, Lender name: '.$cheque_lender->name.',  Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at'=>Carbon::now()]);
                            DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->update(['balance'=>$lender_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Loan Paid to Lender, Lender name: '.$cheque_lender->name.', Paid Amount: '.$payable_amount.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at' =>Carbon::now()]);
                            return Redirect()->route('admin.account.loan.history')->with('success', 'Loan Paid to lender successfully.');
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

    public function loan_receive()
    {
        if(User::checkPermission('account.loan') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.loan.loan_receive', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function loan_receive_confirm(Request $request) {
        if(User::checkPermission('account.loan') == true){
            
            $note = $request->note;
            $date = $request->date;
            $shop_id = Auth::user()->shop_id;
            $lender_id = $request->lender_id;
            $cheque_lender = DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->first();
            if(!empty($cheque_lender->id)) {
                
                $current_voucher_num = DB::table('loan_transactions')->where('shop_id', $shop_id)->count('id');
                $current_num = $current_voucher_num+1;
                $voucher_num = "LR".$shop_id.'_'.$current_num;
                $transaction_by = $request->received_by;
                if($transaction_by == 'cash') {
                    $current_cash_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                    $receiable_cash_amount = $request->cash_received;
                    if($receiable_cash_amount > 0) {
                        $insert = Loan_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'lender_id'=>$lender_id, 'paid_or_received'=>'RECEIVE', 'cash_or_cheque'=>$transaction_by, 'amount'=>$receiable_cash_amount, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $lender_update_balance = $cheque_lender->balance + $receiable_cash_amount;
                            $update_cash_balance = $current_cash_balance->balance + $receiable_cash_amount;
                            DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$update_cash_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'LR', 'track'=>$cheque_lender->id, 'refference'=>$voucher_num, 'amount'=>$receiable_cash_amount, 'creadit_or_debit'=>'CR', 'note'=>'Loan Received from Lender, Lender name: '.$cheque_lender->name.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at'=>Carbon::now()]);
                            DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->update(['balance'=>$lender_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Loan Received from Lender, Lender name: '.$cheque_lender->name.', Paid Amount: '.$receiable_cash_amount.',  Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at' =>Carbon::now()]);
                            return Redirect()->route('admin.account.loan.history')->with('success', 'Loan Received from lender successfully.');
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
                        $insert = Loan_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'lender_id'=>$lender_id, 'paid_or_received'=>'RECEIVE', 'cash_or_cheque'=>$transaction_by, 'amount'=>$receiable_amount, 'bank_id'=>$request->receiable_bank, 'account_num'=>$request->bank_account_num, 'cheque_num'=>$request->cheque_num, 'lender_bank_name'=>$request->bank_name, 'cheque_diposite_date'=>$request->deposit_date, 'cheque_date'=>$request->cheque_date, 'cheque_num'=>$request->cheque_num, 'cheque_date'=>$request->cheque_date, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $lender_update_balance = $cheque_lender->balance + $receiable_amount;
                            $update_bank_balance = $current_bank_balance->balance + $receiable_amount;
                            DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->receiable_bank])->update(['balance'=>$update_bank_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$request->receiable_bank, 'added_by'=>Auth::user()->id, 'for_what'=>'LR', 'track'=>$cheque_lender->id, 'refference'=>$voucher_num, 'amount'=>$receiable_amount, 'creadit_or_debit'=>'CR', 'note'=>'Loan Received from Lender, Lender name: '.$cheque_lender->name.',  Voucher Num: # '.str_replace("_","/", $voucher_num).'', 'created_at'=>Carbon::now()]);
                            DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->update(['balance'=>$lender_update_balance]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Loan Received from Lender, Lender name: '.$cheque_lender->name.', Paid Amount: '.$receiable_amount.', Voucher Num: #'.str_replace("_","/", $voucher_num).'', 'created_at' =>Carbon::now()]);
                            return Redirect()->route('admin.account.loan.history')->with('success', 'Loan Received from lender successfully.');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan_transaction  $loan_transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Loan_transaction $loan_transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan_transaction  $loan_transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan_transaction $loan_transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan_transaction  $loan_transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan_transaction $loan_transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan_transaction  $loan_transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan_transaction $loan_transaction)
    {
        //
    }
}
