<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use App\Models\Expense_group;
use App\Models\Expense_transaction;
use App\Models\Ledger_Head;


class ExpenseController extends Controller
{
    public function expense_group() {
        if(User::checkPermission('account.expense') == true){
            $wing = 'acc_and_tran';
            $expenses_group = Expense_group::all();
            return view('cms.shop_admin.account_and_transaction.expense.expense_group', compact('wing', 'expenses_group'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function make_expense_entry() {
        if(User::checkPermission('account.expense') == true){
            $wing = 'acc_and_tran';
            $expenses_group = Expense_group::where('group_under', 'DR')->orWhere('group_under', 'assets')->get(['id', 'group_name']);
            return view('cms.shop_admin.account_and_transaction.expense.make_expense', compact('wing', 'expenses_group'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function make_expense_entry_confirm(Request $request) {
        if(User::checkPermission('account.expense') == true){
            $note = $request->note;
            $date = $request->date;
            $shop_id = Auth::user()->shop_id;
            $ledger_head = $request->ledger_head;
            $cheque_head = DB::table('ledger__heads')->where(['id'=>$ledger_head, 'shop_id'=>$shop_id])->first();
            if(!empty($cheque_head->id)) {
                
                $current_voucher_num = DB::table('expense_transactions')->where('shop_id', $shop_id)->count('id');
                $current_num = $current_voucher_num+1;
                $voucher_num = "E".$shop_id.'_'.$current_num;
                $transaction_by = $request->paid_by;
                $payable_amount = $request->paid_amount;

                if(!empty($request->file)) {
                    $fileName = $shop_id.time().'.'.$request->file->extension();  
                    $request->file->move(public_path('images'), $fileName);
                }
                else {
                    $fileName = '';
                }

                if($transaction_by == 'cash') {
                    $current_cash_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                    if($current_cash_balance->balance >= $payable_amount) {
                        $insert = Expense_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'ledger_head'=>$ledger_head, 'cash_or_cheque'=>$transaction_by, 'amount'=>$payable_amount, 'voucher'=>$request->voucher, 'file'=>$fileName, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $update_cash_balance = $current_cash_balance->balance - $payable_amount;
                            DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$update_cash_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'E', 'track'=>$cheque_head->id, 'refference'=>$voucher_num, 'amount'=>$payable_amount, 'creadit_or_debit'=>'DR', 'note'=>'New Expense Added, Ledger Head name: '.$cheque_head->head_name.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at'=>$date]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Expense Added, Ledger Head name: '.$cheque_head->head_name.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at' =>$date]);
                            return Redirect()->route('admin.account.expenses.voucher.view', ['voucher_num'=>$voucher_num])->with('success', 'Expenses Added Successfully.');
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
                    if($current_bank_balance->balance >= $payable_amount) {
                        $insert = Expense_transaction::insert(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>Auth::user()->id, 'ledger_head'=>$ledger_head, 'cash_or_cheque'=>$transaction_by, 'amount'=>$payable_amount, 'bank_id'=>$request->payable_bank, 'cheque_num'=>$request->cheque_num, 'cheque_date'=>$request->cheque_date, 'voucher'=>$request->voucher, 'file'=>$fileName, 'note'=>$note, 'created_at'=>$date]);
                        if($insert) {
                            $update_bank_balance = $current_bank_balance->balance - $payable_amount;
                            DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->payable_bank])->update(['balance'=>$update_bank_balance]);
                            DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$request->payable_bank, 'added_by'=>Auth::user()->id, 'for_what'=>'E', 'track'=>$cheque_head->id, 'refference'=>$voucher_num, 'amount'=>$payable_amount, 'creadit_or_debit'=>'DR', 'note'=>'New Expense Added, Ledger Head name: '.$cheque_head->head_name.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at'=>$date]);
                            DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Expense Added, Ledger Head name: '.$cheque_head->head_name.', Voucher Num: '.str_replace("_","/", $voucher_num).'', 'created_at' =>$date]);
                            return Redirect()->route('admin.account.expenses.voucher.view', ['voucher_num'=>$voucher_num])->with('success', 'Expenses Added Successfully.');
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


    public function expenses_vouchers() {
        if(User::checkPermission('account.expense') == true){
            $wing = 'acc_and_tran';
            $expenses_vouchers = Expense_transaction::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.expense.expense_vouchers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function expenses_vouchers_data(Request $request) {
        if ($request->ajax()) {
            $expenses_vouchers = Expense_transaction::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($expenses_vouchers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('admin.account.expenses.voucher.view', ['voucher_num'=>$row->voucher_num]).'" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
                    return $info;
                })
                ->addColumn('head_name', function($row){
                    return optional($row->head_name)->head_name;
                })
                ->addColumn('voucher_num', function($row){
                    return "#".str_replace("_","/", $row->voucher_num);
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['action', 'head_name', 'voucher_num', 'date'])
                ->make(true);
        }
    }

    public function expenses_voucher_view($voucher_num) {
        if(User::checkPermission('account.expense') == true){
            $shop_id = Auth::user()->shop_id;
            $voucher_info = Expense_transaction::where(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id])->first();
            if(!empty($voucher_info->id)) {
                $wing = 'acc_and_tran';
                $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
                return view('cms.shop_admin.account_and_transaction.expense.view_expense_voucher', compact('wing', 'shop_info', 'voucher_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


}
