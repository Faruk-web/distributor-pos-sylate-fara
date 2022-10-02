<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use App\Models\Expense_transaction;
use App\Models\Transaction;
use PDF;
use App\Models\Loan_transaction;
use App\Models\Take_customer_due;
use App\Models\Supplier_payment;
use App\Models\Capital_transaction;
use App\Models\Contra;
use App\Models\Order;
use App\Models\Indirect_incomes;
use App\Models\Customer;
use App\Models\Expense_group;
use App\Models\Product_tracker;
use App\Models\Product;




class ReportController extends Controller
{
    public function day_book() {
        if(User::checkPermission('account.statement') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.day_book', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function day_book_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        date_default_timezone_set("Asia/Dhaka");
        if(!empty($first_date) && $last_date == 0) { // this is for today / single day

            //This is for finding opening statement
            $opening_start_date = "2010-01-01";
            $opening_end_date = date('Y-m-d', strtotime($first_date . ' -1 day'));
            
            $opening_sales_paid_by_multiple_payment = DB::table('multiple_payments')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['paid_amount', 'payment_type']);
                $opening_sale_paid_by_multiple_pament_cash = $opening_sales_paid_by_multiple_payment->filter(function($item){ return $item->payment_type == 'cash'; })->sum('paid_amount');
                $opening_sale_paid_by_multiple_pament_bank = $opening_sales_paid_by_multiple_payment->filter(function($item){ return $item->payment_type == 'card'; })->sum('paid_amount');
                
                $opening_sales_paid = DB::table('orders')->where(['shop_id'=>$shop_id])->whereBetween('date', [$opening_start_date, $opening_end_date])->get(['paid_amount', 'payment_by']);
                    $opening_sale_cash_paid = ($opening_sales_paid->filter(function($item){ return $item->payment_by == 'cash'; })->sum('paid_amount')) + $opening_sale_paid_by_multiple_pament_cash;
                    $opening_sale_cheque_paid = ($opening_sales_paid->filter(function($item){ return $item->payment_by == 'cheque'; })->sum('paid_amount')) + $opening_sale_paid_by_multiple_pament_bank;
                        
                $opening_due_received = DB::table('take_customer_dues')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['received_amount', 'paymentBy']);
                    $opening_cash_due_received = $opening_due_received->filter(function($item){ return $item->paymentBy == 'cash'; })->sum('received_amount');
                    $opening_bank_due_received = $opening_due_received->filter(function($item){ return $item->paymentBy == 'cheque'; })->sum('received_amount');
                $opening_loans = DB::table('loan_transactions')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['amount', 'cash_or_cheque', 'paid_or_received']);
                    $opening_received_cash_loan_amount = $opening_loans->filter(function($item){ return ($item->cash_or_cheque == 'cash' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                    $opening_received_bank_loan_amount = $opening_loans->filter(function($item){ return ($item->cash_or_cheque == 'cheque' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                    $opening_loan_payment_cash = $opening_loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cash'); })->sum('amount');
                    $opening_loan_payment_bank = $opening_loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cheque'); })->sum('amount');
                    
                $opening_capital = DB::table('capital_transactions')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['amount', 'cash_or_cheque', 'add_or_withdraw']);
                    $opening_received_cash_capital = $opening_capital->filter(function($item){
                        return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cash');
                    })->sum('amount');

                    $opening_received_bank_capital = $opening_capital->filter(function($item){
                        return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cheque');
                    })->sum('amount');

                    $opening_capital_payment_in_cash = $opening_capital->filter(function($item){
                        return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cash');
                    })->sum('amount');

                    $opening_capital_payment_in_bank = $opening_capital->filter(function($item){
                        return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cheque');
                    })->sum('amount');

                $opening_supplier_instant_payment = DB::table('supplier_invoices')->where(['shop_id'=>$shop_id])->whereBetween('date', [$opening_start_date, $opening_end_date])->sum('paid');
                $opening_supplier_due_payment = DB::table('supplier_payments')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get();
                
                    $opening_supplier_due_payment_in_cash = $opening_supplier_due_payment->filter(function($item)
                    {
                        return $item->paymentBy == 'cash';
                    })->sum('paid');
                    $opening_supplier_due_payment_in_bank = $opening_supplier_due_payment->filter(function($item)
                    {
                        return $item->paymentBy == 'cheque';
                    })->sum('paid');

                $opening_contra = DB::table('contras')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['contra_amount', 'sender', 'CTB_or_BTC']);
                $opening_contra_received_in_cash = $opening_contra->filter(function($item){
                    return ($item->CTB_or_BTC == 'BTC' && $item->sender != 'cash');
                })->sum('contra_amount');

                $opening_contra_received_in_bank = $opening_contra->filter(function($item){
                    return ($item->CTB_or_BTC == 'CTB' && $item->sender == 'cash');
                })->sum('contra_amount');
                    $opening_contra_payment_in_bank = $opening_contra_received_in_cash;
                    $opening_contra_payment_in_cash = $opening_contra_received_in_bank;
                    
                $opening_expense_payment_in_cash = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cash'])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->sum('amount');
                $opening_expense_payment_in_bank = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cheque'])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->sum('amount');
                $opening_return_orders_payment = DB::table('transactions')->where(['shop_id'=>$shop_id, 'for_what'=>'CPR'])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->sum('amount');
                
                //Opening indirect Income
                $opening_indirect_incomes = Indirect_incomes::where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['amount', 'cash_or_cheque']);
                    $opening_indirect_cash_incomes = $opening_indirect_incomes->filter(function($item) {
                        return $item->cash_or_cheque == 'cash';
                    })->sum('amount');
                    
                    $opening_indirect_bank_incomes = $opening_indirect_incomes->filter(function($item) {
                        return $item->cash_or_cheque != 'cash';
                    })->sum('amount');
                //Opening indirect Income

                $opening_cash_received_total = $opening_sale_cash_paid + $opening_cash_due_received + $opening_received_cash_loan_amount + $opening_received_cash_capital + $opening_contra_received_in_cash + $opening_indirect_cash_incomes;
                $opening_bank_received_total = $opening_sale_cheque_paid + $opening_bank_due_received + $opening_received_bank_loan_amount + $opening_received_bank_capital + $opening_contra_received_in_bank + $opening_indirect_bank_incomes;
                $opening_cash_payment_total = $opening_supplier_instant_payment + $opening_expense_payment_in_cash + $opening_loan_payment_cash + $opening_capital_payment_in_cash + $opening_return_orders_payment + $opening_supplier_due_payment_in_cash + $opening_contra_payment_in_cash;
                $opening_bank_payment_total = $opening_supplier_due_payment_in_bank + $opening_expense_payment_in_bank + $opening_loan_payment_bank + $opening_capital_payment_in_bank + $opening_contra_payment_in_bank;
                    $opening_cash_balance = $opening_cash_received_total - $opening_cash_payment_total;
                    $opening_bank_balance = $opening_bank_received_total - $opening_bank_payment_total;
                        
            //End :: This is for finding opening statement


            $sales_paid_by_multiple_payment_for_date = DB::table('multiple_payments')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['paid_amount', 'payment_type']);
                $sale_paid_by_multiple_pament_cash_for_date = $sales_paid_by_multiple_payment_for_date->filter(function($item){ return $item->payment_type == 'cash'; })->sum('paid_amount');
                $sale_paid_by_multiple_pament_bank_for_date = $sales_paid_by_multiple_payment_for_date->filter(function($item){ return $item->payment_type == 'card'; })->sum('paid_amount');


            $sales_paid = DB::table('orders')->where(['shop_id'=>$shop_id])->whereDate('date', $first_date)->get(['paid_amount', 'payment_by']);
                $sale_cash_paid = ($sales_paid->filter(function($item){ return $item->payment_by == 'cash'; })->sum('paid_amount')) + $sale_paid_by_multiple_pament_cash_for_date;
                $sale_cheque_paid = ($sales_paid->filter(function($item){ return $item->payment_by == 'cheque'; })->sum('paid_amount')) + $sale_paid_by_multiple_pament_bank_for_date;
                
                    
            $due_received = DB::table('take_customer_dues')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['received_amount', 'paymentBy']);
                $cash_due_received = $due_received->filter(function($item){ return $item->paymentBy == 'cash'; })->sum('received_amount');
                $bank_due_received = $due_received->filter(function($item){ return $item->paymentBy == 'cheque'; })->sum('received_amount');
            $loans = DB::table('loan_transactions')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['amount', 'cash_or_cheque', 'paid_or_received']);
                $received_cash_loan_amount = $loans->filter(function($item){ return ($item->cash_or_cheque == 'cash' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                $received_bank_loan_amount = $loans->filter(function($item){ return ($item->cash_or_cheque == 'cheque' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                $loan_payment_cash = $loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cash'); })->sum('amount');
                $loan_payment_bank = $loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cheque'); })->sum('amount');
                 
            $capital = DB::table('capital_transactions')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['amount', 'cash_or_cheque', 'add_or_withdraw']);
                $received_cash_capital = $capital->filter(function($item){
                    return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cash');
                })->sum('amount');

                $received_bank_capital = $capital->filter(function($item){
                    return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cheque');
                })->sum('amount');

                $capital_payment_in_cash = $capital->filter(function($item){
                    return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cash');
                })->sum('amount');

                $capital_payment_in_bank = $capital->filter(function($item){
                    return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cheque');
                })->sum('amount');

            $contra = DB::table('contras')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['contra_amount', 'sender', 'CTB_or_BTC']);
                $contra_received_in_cash = $contra->filter(function($item){
                    return ($item->CTB_or_BTC == 'BTC' && $item->sender != 'cash');
                })->sum('contra_amount');

                $contra_received_in_bank = $contra->filter(function($item){
                    return ($item->CTB_or_BTC == 'CTB' && $item->sender == 'cash');
                })->sum('contra_amount');

                $contra_payment_in_bank = $contra_received_in_cash;
                $contra_payment_in_cash = $contra_received_in_bank;
                
            $supplier_instant_payment = DB::table('supplier_invoices')->where(['shop_id'=>$shop_id])->whereDate('date', $first_date)->sum('paid');
            $supplier_due_payment = DB::table('supplier_payments')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get();
               
                $supplier_due_payment_in_cash = $supplier_due_payment->filter(function($item)
                {
                    return $item->paymentBy == 'cash';
                })->sum('paid');
                $supplier_due_payment_in_bank = $supplier_due_payment->filter(function($item)
                {
                    return $item->paymentBy == 'cheque';
                })->sum('paid');
                
            $expense_payment_in_cash = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cash'])->whereDate('created_at', $first_date)->selectRaw("SUM(amount) as expense_total, ledger_head")->groupBy('ledger_head')->get();
            $total_cash_expenses = 0;

            $expense_payment_in_bank = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cheque'])->whereDate('created_at', $first_date)->selectRaw("SUM(amount) as expense_total, ledger_head")->groupBy('ledger_head')->get();
            $total_bank_expenses = 0;
            
            //indirect Income
            $indirect_incomes = Indirect_incomes::where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['amount', 'cash_or_cheque']);
                $indirect_cash_incomes = $indirect_incomes->filter(function($item) {
                    return $item->cash_or_cheque == 'cash';
                })->sum('amount');
                
                $indirect_bank_incomes = $indirect_incomes->filter(function($item) {
                    return $item->cash_or_cheque != 'cash';
                })->sum('amount');
            //indirect Income

            $return_orders_payment = DB::table('transactions')->where(['shop_id'=>$shop_id, 'for_what'=>'CPR'])->whereDate('created_at', $first_date)->sum('amount');

            $output .= '<div class="row">
                            <div class="col-md-12">
                                <h5><b>Date: </b>'.date("d M, Y", strtotime($first_date)).'</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center bg-dark text-light"><th colspan="3">Received</th></tr>
                                    </thead>
                                    <tbody>
                                        <!--This is for Cash Received Start-->
                                        <tr>
                                            <td><br><br><br><br><br><b>Cash Received </b></td>
                                            <td width="75%">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td width="80%">Opening Cash Received</td><td>'.number_format($opening_cash_balance, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="80%">Sell Paid</td><td>'.number_format($sale_cash_paid, 2).'</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td>Due Received</td>
                                                            <td>'.number_format($cash_due_received, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Loan Received</td>
                                                            <td>'.number_format($received_cash_loan_amount, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Capital Received</td>
                                                            <td>'.number_format($received_cash_capital, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contra Cash Received</td>
                                                            <td>'.number_format($contra_received_in_cash, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Indirect Income</td>
                                                            <td>'.number_format($indirect_cash_incomes, 2).'</td>
                                                        </tr>';
                                                        $cash_received_total = $sale_cash_paid + $cash_due_received + $received_cash_loan_amount + $received_cash_capital + $contra_received_in_cash + $opening_cash_balance + $indirect_cash_incomes;
                                                        $output .='<tr class="text-right"><td colspan="2">Total Cash Received = '.number_format($cash_received_total, 2).'</td></tr>
                                                        <tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!--This is for Cash Received End-->
                                        <!--This is for Bank Received Start-->
                                        <tr>
                                            <td><br><br><br><br><br><b>Bank Received </b></td>
                                            <td>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td width="80%">Opening Bank Received</td><td>'.number_format($opening_bank_balance, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="80%">Sell Paid</td>
                                                            <td>'.number_format($sale_cheque_paid, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Due Received</td>
                                                            <td>'.number_format($bank_due_received, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Loan Received</td>
                                                            <td>'.number_format($received_bank_loan_amount, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Capital Received</td>
                                                            <td>'.number_format($received_bank_capital, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Contra Bank Received</td>
                                                            <td>'.number_format($contra_received_in_bank, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Indirect Income</td>
                                                            <td>'.number_format($indirect_bank_incomes, 2).'</td>
                                                        </tr>';
                                                        $bank_received_total = $sale_cheque_paid + $bank_due_received + $received_bank_loan_amount + $received_bank_capital + $contra_received_in_bank + $opening_bank_balance + $indirect_bank_incomes;
                                                        $output .='<tr class="text-right"><td colspan="2">Total Bank Received = '.number_format($bank_received_total, 2).'</td></tr>
                                                    <tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <!--This is for Bank Received End-->
                                        <tr class="text-right">
                                            <th colspan="3">Total = '.number_format($bank_received_total + $cash_received_total, 2).'</th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center bg-dark text-light"><th colspan="3" scope="col">Payment</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr width="100%">
                                            <td><br><br><br><br><b>Cash Payment</b></td>
                                            <td width="75%">
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                            <td width="80%">Supplier Instant Paid</td>
                                                            <td>'.number_format($supplier_instant_payment, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Supplier Due Paid</td>
                                                            <td>'.number_format($supplier_due_payment_in_cash, 2).'</td>
                                                        </tr>';
                                                            if($expense_payment_in_cash != '[]') {
                                                                foreach($expense_payment_in_cash as $payment){
                                                                    $total_cash_expenses = $total_cash_expenses + $payment->expense_total;
                                                                    $output .='<tr>
                                                                        <td width="80%">'.optional($payment->head_name)->head_name.'<span style="font-size: 11px; color:#F50057; ">(Expense)</span></td>
                                                                        <td>'.number_format($payment->expense_total, 2).'</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        $output .='<tr>
                                                            <td>Loan Paid</td>
                                                            <td>'.number_format($loan_payment_cash, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="80%">Return Product From Customer</td>
                                                            <td>'.number_format($return_orders_payment, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="80%">Capital Withdraw</td>
                                                            <td>'.number_format($capital_payment_in_cash, 2).'</td>
                                                        </tr>
                                                        
                                                        <tr>
                                                            <td width="80%">Contra Cash Payment</td>
                                                            <td width="20%">'.number_format($contra_payment_in_cash, 2).'</td>
                                                        </tr>';
                                                        $cash_payment_total = $supplier_instant_payment + $total_cash_expenses + $loan_payment_cash + $capital_payment_in_cash + $return_orders_payment + $supplier_due_payment_in_cash + $contra_payment_in_cash;
                                                        $output .='<tr class="text-right"><td colspan="2">Total Cash Payment = '.number_format($cash_payment_total, 2).'</td></tr>
                                                    <tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr width="100%">
                                                <td><br><br><br><br><b>Bank Payment</b></td>
                                                <td width="75%">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>Supplier Due Paid</td>
                                                                <td>'.number_format($supplier_due_payment_in_bank, 2).'</td>
                                                            </tr>';
                                                            if($expense_payment_in_bank != '[]') {
                                                                foreach($expense_payment_in_bank as $payment){
                                                                    $total_bank_expenses = $total_bank_expenses + $payment->expense_total;
                                                                    $output .='<tr>
                                                                        <td width="80%">'.optional($payment->head_name)->head_name.'<span style="font-size: 11px; color:#F50057; ">(Expense)</span></td>
                                                                        <td>'.number_format($payment->expense_total, 2).'</td>
                                                                    </tr>';
                                                                }
                                                            }
                                                        $output .='<tr>
                                                            <td>Loan Paid</td>
                                                            <td>'.number_format($loan_payment_bank, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="80%">Capital Withdraw</td>
                                                            <td>'.number_format($capital_payment_in_bank, 2).'</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="80%">Contra Bank Payment</td>
                                                            <td width="20%">'.number_format($contra_payment_in_bank, 2).'</td>
                                                        </tr>';
                                                        $bank_payment_total = $supplier_due_payment_in_bank + $total_bank_expenses + $loan_payment_bank + $capital_payment_in_bank + $contra_payment_in_bank;
                                                        $output .='<tr class="text-right"><td colspan="2">Total Bank Payment = '.number_format($bank_payment_total, 2).'</td></tr>

                                                        <tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="text-right">
                                            <th colspan="3">Total = '.number_format($bank_payment_total + $cash_payment_total, 2).'</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 text-center" style="padding-bottom: 10px;">
                                <h4 class="bg-dark text-light"
                                    style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                    <b>Cash Balance: </b> '.number_format($cash_received_total - $cash_payment_total, 2).'
                                </h4>
                            </div>
                            <div class="col-md-6 text-center" style="padding-bottom: 10px;">
                                <h4 class="bg-dark text-light"
                                    style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                    <b>Bank Balance: </b> '.number_format($bank_received_total - $bank_payment_total, 2).'
                                </h4>
                            </div>
                            
                        </div>';
        }
        else if(!empty($first_date) && $last_date != 0) { // this is for date wise
            $first_date_number = strtotime($first_date);
            $last_date_number = strtotime($last_date);
            $j = 2;
            $i = 0;
            
            if($first_date_number <= $last_date_number) {

                $output .= '<div class="row">
                                <div class="col-md-12"><h3 class="text-light p-2 bg-primary text-center rounded"><b>'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' date Day Book</b></h3></div>
                            </div>';

                for($i; $i < $j; $i++) {

                    if($first_date_number <= $last_date_number) {

                        //This is for finding opening statement
                        $opening_start_date = "2010-01-01";
                        $opening_end_date = date('Y-m-d', strtotime($first_date . ' -1 day'));
                        
                    $opening_sales_paid_by_multiple_payment = DB::table('multiple_payments')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['paid_amount', 'payment_type']);
                        $opening_sale_paid_by_multiple_pament_cash = $opening_sales_paid_by_multiple_payment->filter(function($item){ return $item->payment_type == 'cash'; })->sum('paid_amount');
                        $opening_sale_paid_by_multiple_pament_bank = $opening_sales_paid_by_multiple_payment->filter(function($item){ return $item->payment_type == 'card'; })->sum('paid_amount');
                        
                            $opening_sales_paid = DB::table('orders')->where(['shop_id'=>$shop_id])->whereBetween('date', [$opening_start_date, $opening_end_date])->get(['paid_amount', 'payment_by']);
                                $opening_sale_cash_paid = ($opening_sales_paid->filter(function($item){ return $item->payment_by == 'cash'; })->sum('paid_amount')) + $opening_sale_paid_by_multiple_pament_cash;
                                $opening_sale_cheque_paid = ($opening_sales_paid->filter(function($item){ return $item->payment_by == 'cheque'; })->sum('paid_amount')) + $opening_sale_paid_by_multiple_pament_bank;
                                    
                            $opening_due_received = DB::table('take_customer_dues')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['received_amount', 'paymentBy']);
                                $opening_cash_due_received = $opening_due_received->filter(function($item){ return $item->paymentBy == 'cash'; })->sum('received_amount');
                                $opening_bank_due_received = $opening_due_received->filter(function($item){ return $item->paymentBy == 'cheque'; })->sum('received_amount');
                            $opening_loans = DB::table('loan_transactions')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['amount', 'cash_or_cheque', 'paid_or_received']);
                                $opening_received_cash_loan_amount = $opening_loans->filter(function($item){ return ($item->cash_or_cheque == 'cash' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                                $opening_received_bank_loan_amount = $opening_loans->filter(function($item){ return ($item->cash_or_cheque == 'cheque' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                                $opening_loan_payment_cash = $opening_loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cash'); })->sum('amount');
                                $opening_loan_payment_bank = $opening_loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cheque'); })->sum('amount');
                                
                            $opening_capital = DB::table('capital_transactions')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['amount', 'cash_or_cheque', 'add_or_withdraw']);
                                $opening_received_cash_capital = $opening_capital->filter(function($item){
                                    return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cash');
                                })->sum('amount');

                                $opening_received_bank_capital = $opening_capital->filter(function($item){
                                    return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cheque');
                                })->sum('amount');

                                $opening_capital_payment_in_cash = $opening_capital->filter(function($item){
                                    return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cash');
                                })->sum('amount');

                                $opening_capital_payment_in_bank = $opening_capital->filter(function($item){
                                    return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cheque');
                                })->sum('amount');

                            $opening_supplier_instant_payment = DB::table('supplier_invoices')->where(['shop_id'=>$shop_id])->whereBetween('date', [$opening_start_date, $opening_end_date])->sum('paid');
                            $opening_supplier_due_payment = DB::table('supplier_payments')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get();
                            
                                $opening_supplier_due_payment_in_cash = $opening_supplier_due_payment->filter(function($item)
                                {
                                    return $item->paymentBy == 'cash';
                                })->sum('paid');
                                $opening_supplier_due_payment_in_bank = $opening_supplier_due_payment->filter(function($item)
                                {
                                    return $item->paymentBy == 'cheque';
                                })->sum('paid');
                                
                            $opening_expense_payment_in_cash = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cash'])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->sum('amount');
                            $opening_expense_payment_in_bank = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cheque'])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->sum('amount');
                            $opening_return_orders_payment = DB::table('transactions')->where(['shop_id'=>$shop_id, 'for_what'=>'CPR'])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->sum('amount');

                            $opening_contra = DB::table('contras')->where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['contra_amount', 'sender', 'CTB_or_BTC']);
                            $opening_contra_received_in_cash = $opening_contra->filter(function($item){
                                return ($item->CTB_or_BTC == 'BTC' && $item->sender != 'cash');
                            })->sum('contra_amount');

                            $opening_contra_received_in_bank = $opening_contra->filter(function($item){
                                return ($item->CTB_or_BTC == 'CTB' && $item->sender == 'cash');
                            })->sum('contra_amount');
                                $opening_contra_payment_in_bank = $opening_contra_received_in_cash;
                                $opening_contra_payment_in_cash = $opening_contra_received_in_bank;
                                
                            //Opening indirect Income
                            $opening_indirect_incomes = Indirect_incomes::where(['shop_id'=>$shop_id])->whereBetween('created_at', [$opening_start_date, $opening_end_date])->get(['amount', 'cash_or_cheque']);
                                $opening_indirect_cash_incomes = $opening_indirect_incomes->filter(function($item) {
                                    return $item->cash_or_cheque == 'cash';
                                })->sum('amount');
                                
                                $opening_indirect_bank_incomes = $opening_indirect_incomes->filter(function($item) {
                                    return $item->cash_or_cheque != 'cash';
                                })->sum('amount');
                            //Opening indirect Income

                            // $opening_cash_received_total = $opening_sale_cash_paid + $opening_cash_due_received + $opening_received_cash_loan_amount + $opening_received_cash_capital;
                            // $opening_bank_received_total = $opening_sale_cheque_paid + $opening_bank_due_received + $opening_received_bank_loan_amount + $opening_received_bank_capital;
                            // $opening_cash_payment_total = $opening_supplier_instant_payment + $opening_expense_payment_in_cash + $opening_loan_payment_cash + $opening_capital_payment_in_cash + $opening_return_orders_payment + $opening_supplier_due_payment_in_cash;
                            // $opening_bank_payment_total = $opening_supplier_due_payment_in_bank + $opening_expense_payment_in_bank + $opening_loan_payment_bank + $opening_capital_payment_in_bank;
                            //     $opening_cash_balance = $opening_cash_received_total - $opening_cash_payment_total;
                            //     $opening_bank_balance = $opening_bank_received_total - $opening_bank_payment_total;
                                  
                            $opening_cash_received_total = $opening_sale_cash_paid + $opening_cash_due_received + $opening_received_cash_loan_amount + $opening_received_cash_capital + $opening_contra_received_in_cash + $opening_indirect_cash_incomes;
                            $opening_bank_received_total = $opening_sale_cheque_paid + $opening_bank_due_received + $opening_received_bank_loan_amount + $opening_received_bank_capital + $opening_contra_received_in_bank + $opening_indirect_bank_incomes;
                            $opening_cash_payment_total = $opening_supplier_instant_payment + $opening_expense_payment_in_cash + $opening_loan_payment_cash + $opening_capital_payment_in_cash + $opening_return_orders_payment + $opening_supplier_due_payment_in_cash + $opening_contra_payment_in_cash;
                            $opening_bank_payment_total = $opening_supplier_due_payment_in_bank + $opening_expense_payment_in_bank + $opening_loan_payment_bank + $opening_capital_payment_in_bank + $opening_contra_payment_in_bank;
                                $opening_cash_balance = $opening_cash_received_total - $opening_cash_payment_total;
                                $opening_bank_balance = $opening_bank_received_total - $opening_bank_payment_total;
                                
                        //This is for finding opening statement

                $sales_paid_by_multiple_payment_for_date = DB::table('multiple_payments')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['paid_amount', 'payment_type']);
                    $sale_paid_by_multiple_pament_cash_for_date = $sales_paid_by_multiple_payment_for_date->filter(function($item){ return $item->payment_type == 'cash'; })->sum('paid_amount');
                    $sale_paid_by_multiple_pament_bank_for_date = $sales_paid_by_multiple_payment_for_date->filter(function($item){ return $item->payment_type == 'card'; })->sum('paid_amount');
               
                    $sales_paid = DB::table('orders')->where(['shop_id'=>$shop_id])->whereDate('date', $first_date)->get(['paid_amount', 'payment_by']);
                    $sale_cash_paid = ($sales_paid->filter(function($item){ return $item->payment_by == 'cash'; })->sum('paid_amount')) + $sale_paid_by_multiple_pament_cash_for_date;
                    $sale_cheque_paid = ($sales_paid->filter(function($item){ return $item->payment_by == 'cheque'; })->sum('paid_amount')) + $sale_paid_by_multiple_pament_bank_for_date;
                        
                $due_received = DB::table('take_customer_dues')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['received_amount', 'paymentBy']);
                    $cash_due_received = $due_received->filter(function($item){ return $item->paymentBy == 'cash'; })->sum('received_amount');
                    $bank_due_received = $due_received->filter(function($item){ return $item->paymentBy == 'cheque'; })->sum('received_amount');
                $loans = DB::table('loan_transactions')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['amount', 'cash_or_cheque', 'paid_or_received']);
                    $received_cash_loan_amount = $loans->filter(function($item){ return ($item->cash_or_cheque == 'cash' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                    $received_bank_loan_amount = $loans->filter(function($item){ return ($item->cash_or_cheque == 'cheque' && $item->paid_or_received == 'RECEIVE'); })->sum('amount');
                    $loan_payment_cash = $loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cash'); })->sum('amount');
                    $loan_payment_bank = $loans->filter(function($item){ return ($item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cheque'); })->sum('amount');
                    
                $capital = DB::table('capital_transactions')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['amount', 'cash_or_cheque', 'add_or_withdraw']);
                    $received_cash_capital = $capital->filter(function($item){
                        return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cash');
                    })->sum('amount');

                    $received_bank_capital = $capital->filter(function($item){
                        return ($item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cheque');
                    })->sum('amount');

                    $capital_payment_in_cash = $capital->filter(function($item){
                        return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cash');
                    })->sum('amount');

                    $capital_payment_in_bank = $capital->filter(function($item){
                        return ($item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cheque');
                    })->sum('amount');

                $contra = DB::table('contras')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['contra_amount', 'sender', 'CTB_or_BTC']);
                    $contra_received_in_cash = $contra->filter(function($item){
                        return ($item->CTB_or_BTC == 'BTC' && $item->sender != 'cash');
                    })->sum('contra_amount');

                    $contra_received_in_bank = $contra->filter(function($item){
                        return ($item->CTB_or_BTC == 'CTB' && $item->sender == 'cash');
                    })->sum('contra_amount');

                    $contra_payment_in_bank = $contra_received_in_cash;
                    $contra_payment_in_cash = $contra_received_in_bank;
                    
                $supplier_instant_payment = DB::table('supplier_invoices')->where(['shop_id'=>$shop_id])->whereDate('date', $first_date)->sum('paid');
                $supplier_due_payment = DB::table('supplier_payments')->where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get();
                
                    $supplier_due_payment_in_cash = $supplier_due_payment->filter(function($item)
                    {
                        return $item->paymentBy == 'cash';
                    })->sum('paid');
                    $supplier_due_payment_in_bank = $supplier_due_payment->filter(function($item)
                    {
                        return $item->paymentBy == 'cheque';
                    })->sum('paid');
                    
                $expense_payment_in_cash = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cash'])->whereDate('created_at', $first_date)->selectRaw("SUM(amount) as expense_total, ledger_head")->groupBy('ledger_head')->get();
                $total_cash_expenses = 0;

                $expense_payment_in_bank = Expense_transaction::where(['shop_id'=>$shop_id, 'cash_or_cheque'=>'cheque'])->whereDate('created_at', $first_date)->selectRaw("SUM(amount) as expense_total, ledger_head")->groupBy('ledger_head')->get();
                $total_bank_expenses = 0;
                
                //indirect Income
                $indirect_incomes = Indirect_incomes::where(['shop_id'=>$shop_id])->whereDate('created_at', $first_date)->get(['amount', 'cash_or_cheque']);
                    $indirect_cash_incomes = $indirect_incomes->filter(function($item) {
                        return $item->cash_or_cheque == 'cash';
                    })->sum('amount');
                    
                    $indirect_bank_incomes = $indirect_incomes->filter(function($item) {
                        return $item->cash_or_cheque != 'cash';
                    })->sum('amount');
                //indirect Income

                $return_orders_payment = DB::table('transactions')->where(['shop_id'=>$shop_id, 'for_what'=>'CPR'])->whereDate('created_at', $first_date)->sum('amount');

                $output .= '<div class="row border border-dark rounded mb-3 p-1">
                                <div class="col-md-12">
                                    <h5><b>Date: </b>'.date("d M, Y", strtotime($first_date)).'</h5>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center bg-dark text-light"><th colspan="3">Received</th></tr>
                                        </thead>
                                        <tbody>
                                            <!--This is for Cash Received Start-->
                                            <tr>
                                                <td><br><br><br><br><br><b>Cash Received </b></td>
                                                <td width="75%">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td width="80%">Opening Cash Received</td><td>'.number_format($opening_cash_balance, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="80%">Sell Paid</td><td>'.number_format($sale_cash_paid, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Due Received</td>
                                                                <td>'.number_format($cash_due_received, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Loan Received</td>
                                                                <td>'.number_format($received_cash_loan_amount, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Capital Received</td>
                                                                <td>'.number_format($received_cash_capital, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Contra Cash Received</td>
                                                                <td>'.number_format($contra_received_in_cash, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Indirect Income</td>
                                                                <td>'.number_format($indirect_cash_incomes, 2).'</td>
                                                            </tr>';
                                                            $cash_received_total = $sale_cash_paid + $cash_due_received + $received_cash_loan_amount + $received_cash_capital + $contra_received_in_cash + $opening_cash_balance + $indirect_cash_incomes;
                                                            $output .='<tr class="text-right"><td colspan="2">Total Cash Received = '.number_format($cash_received_total, 2).'</td></tr>
                                                            <tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--This is for Cash Received End-->
                                            <!--This is for Bank Received Start-->
                                            <tr>
                                                <td><br><br><br><br><br><b>Bank Received </b></td>
                                                <td>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td width="80%">Opening Bank Received</td><td>'.number_format($opening_bank_balance, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="80%">Sell Paid</td>
                                                                <td>'.number_format($sale_cheque_paid, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Due Received</td>
                                                                <td>'.number_format($bank_due_received, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Loan Received</td>
                                                                <td>'.number_format($received_bank_loan_amount, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Capital Received</td>
                                                                <td>'.number_format($received_bank_capital, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Contra Bank Received</td>
                                                                <td>'.number_format($contra_received_in_bank, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Indirect Income</td>
                                                                <td>'.number_format($indirect_bank_incomes, 2).'</td>
                                                            </tr>';
                                                            $bank_received_total = $sale_cheque_paid + $bank_due_received + $received_bank_loan_amount + $received_bank_capital + $contra_received_in_bank + $opening_bank_balance + $indirect_bank_incomes;
                                                            $output .='<tr class="text-right"><td colspan="2">Total Bank Received = '.number_format($bank_received_total, 2).'</td></tr>
                                                        <tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <!--This is for Bank Received End-->
                                            <tr class="text-right">
                                                <th colspan="3">Total = '.number_format($bank_received_total + $cash_received_total, 2).'</th>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="text-center bg-dark text-light"><th colspan="3" scope="col">Payment</th></tr>
                                        </thead>
                                        <tbody>
                                            <tr width="100%">
                                                <td><br><br><br><br><b>Cash Payment</b></td>
                                                <td width="75%">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td width="80%">Supplier Instant Paid</td>
                                                                <td>'.number_format($supplier_instant_payment, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Supplier Due Paid</td>
                                                                <td>'.number_format($supplier_due_payment_in_cash, 2).'</td>
                                                            </tr>';
                                                                if($expense_payment_in_cash != '[]') {
                                                                    foreach($expense_payment_in_cash as $payment){
                                                                        $total_cash_expenses = $total_cash_expenses + $payment->expense_total;
                                                                        $output .='<tr>
                                                                            <td width="80%">'.optional($payment->head_name)->head_name.'<span style="font-size: 11px; color:#F50057; ">(Expense)</span></td>
                                                                            <td>'.number_format($payment->expense_total, 2).'</td>
                                                                        </tr>';
                                                                    }
                                                                }
                                                            $output .='<tr>
                                                                <td>Loan Paid</td>
                                                                <td>'.number_format($loan_payment_cash, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="80%">Return Product From Customer</td>
                                                                <td>'.number_format($return_orders_payment, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="80%">Capital Withdraw</td>
                                                                <td>'.number_format($capital_payment_in_cash, 2).'</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td width="80%">Contra Cash Payment</td>
                                                                <td width="20%">'.number_format($contra_payment_in_cash, 2).'</td>
                                                            </tr>';
                                                            $cash_payment_total = $supplier_instant_payment + $supplier_due_payment_in_cash + $total_cash_expenses + $loan_payment_cash + $capital_payment_in_cash + $return_orders_payment + $contra_payment_in_cash;
                                                            $output .='<tr class="text-right"><td colspan="2">Total Cash Payment = '.number_format($cash_payment_total, 2).'</td></tr>
                                                        <tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr width="100%">
                                                    <td><br><br><br><br><b>Bank Payment</b></td>
                                                    <td width="75%">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td>Supplier Due Paid</td>
                                                                    <td>'.number_format($supplier_due_payment_in_bank, 2).'</td>
                                                                </tr>';
                                                                if($expense_payment_in_bank != '[]') {
                                                                    foreach($expense_payment_in_bank as $payment){
                                                                        $total_bank_expenses = $total_bank_expenses + $payment->expense_total;
                                                                        $output .='<tr>
                                                                            <td width="80%">'.optional($payment->head_name)->head_name.'<span style="font-size: 11px; color:#F50057; ">(Expense)</span></td>
                                                                            <td>'.number_format($payment->expense_total, 2).'</td>
                                                                        </tr>';
                                                                    }
                                                                }
                                                            $output .='<tr>
                                                                <td>Loan Paid</td>
                                                                <td>'.number_format($loan_payment_bank, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="80%">Capital Withdraw</td>
                                                                <td>'.number_format($capital_payment_in_bank, 2).'</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="80%">Contra Bank Payment</td>
                                                                <td width="20%">'.number_format($contra_payment_in_bank, 2).'</td>
                                                            </tr>';
                                                            $bank_payment_total = $supplier_due_payment_in_bank + $total_bank_expenses + $loan_payment_bank + $capital_payment_in_bank + $contra_payment_in_bank;
                                                            $output .='<tr class="text-right"><td colspan="2">Total Bank Payment = '.number_format($bank_payment_total, 2).'</td></tr>

                                                            <tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr class="text-right">
                                                <th colspan="3">Total = '.number_format($bank_payment_total + $cash_payment_total, 2).'</th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6 text-center" style="padding-bottom: 10px;">
                                    <h4 class="bg-dark text-light"
                                        style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                        <b>Cash Balance: </b> '.number_format($cash_received_total - $cash_payment_total, 2).'
                                    </h4>
                                </div>
                                <div class="col-md-6 text-center" style="padding-bottom: 10px;">
                                    <h4 class="bg-dark text-light"
                                        style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                        <b>Bank Balance: </b> '.number_format($bank_received_total - $bank_payment_total, 2).'
                                    </h4>
                                </div>
                            </div>';


                        $first_date = date('Y-m-d', strtotime($first_date . ' +1 day'));
                        $first_date_number = strtotime($first_date);
                        $j += 1;
                    }
                    else {
                        break;
                    }
                }
            }
            else {
                $output .= '<div class="row">
                                <div class="col-md-12"><h3 class="text-light p-2 bg-danger text-center rounded"><b>No Data Found!</b></h3></div>
                            </div>';
            }
            
            
            
        }
        
        return Response($output);
    }
    //End:: Day book

    //Begin:: Trial Balance
    public function trial_balance() {
        if(User::checkPermission('account.statement') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.trial_balance', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function trial_balance_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        
        date_default_timezone_set("Asia/Dhaka");
        if(!empty($first_date) && $last_date == 0) { // this is for today || single day
        
            $customer_due = DB::table('customers')->where('shop_id', $shop_id)->where('balance', '!=', 0)->get(['balance']);
                $cr_custoemrs = $customer_due->filter(function($item) { return $item->balance < 0; })->sum('balance');
                $dr_custoemrs = $customer_due->filter(function($item) { return $item->balance > 0; })->sum('balance');
 
            $customers_opening_balance = DB::table('customers')->where('shop_id', $shop_id)->where('opening_bl', '!=', 0)->sum('opening_bl');

            $supplier = DB::table('suppliers')->where('shop_id', $shop_id)->where('balance', '!=', 0)->get(['balance']);
                $cr_supplier = $supplier->filter(function($item) { return $item->balance > 0; })->sum('balance');
                $dr_supplier = $supplier->filter(function($item) { return $item->balance < 0; })->sum('balance');

            $supplier_opening_balance = DB::table('suppliers')->where('shop_id', $shop_id)->where('opening_bl', '!=', 0)->sum('opening_bl');

            $loan_person = DB::table('loan_people')->where('shop_id', $shop_id)->where('balance', '!=', 0)->get(['balance']);
                $cr_loan_person = $loan_person->filter(function($item) { return $item->balance > 0; })->sum('balance');
                $dr_loan_person = $loan_person->filter(function($item) { return $item->balance < 0; })->sum('balance');
                
            $capital_transactions = DB::table('capital_transactions')->where('shop_id', $shop_id)->get(['add_or_withdraw', 'amount']);
                $cr_capital_transacion = $capital_transactions->filter(function($item) { return $item->add_or_withdraw == 'ADD'; })->sum('amount');
                $dr_capital_transacion = $capital_transactions->filter(function($item) { return $item->add_or_withdraw == 'WITHDRAW'; })->sum('amount');
            
            $banks = DB::table('banks')->where('shop_id', $shop_id)->where('balance', '!=', 0)->sum('balance');
            $cash = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first('balance');
            $expenses = DB::table('expense_transactions')->where('shop_id', $shop_id)->sum('amount');
            $sales_info = DB::table('orders')->where('shop_id', $shop_id)->get(['invoice_total', 'pre_due']);
                $total_sales = $sales_info->sum('invoice_total') - $sales_info->sum('pre_due');
            $sales_return = DB::table('return_orders')->where('shop_id', $shop_id)->sum('refundAbleAmount');
            $purchase_info = DB::table('supplier_invoices')->where('shop_id', $shop_id)->get(['total_gross', 'others_crg']);
            
                $total_purchase = $purchase_info->sum('total_gross') - $purchase_info->sum('others_crg');
            $purchase_return = DB::table('supplier_inv_returns')->where('shop_id', $shop_id)->sum('total_gross');
            
            //closing stock
            $all_stocks_for_finding_purchase_price = DB::table('product_trackers')
                                        ->join('products', 'product_trackers.product_id', 'products.id')
                                        ->where('products.shop_id', $shop_id)
                                        ->where(function ($query){
                                            $query->where('product_trackers.product_form', '=', 'SUPP_TO_B')
                                                    ->orWhere('product_trackers.product_form', '=', 'SUPP_TO_G')
                                                    ->orWhere('product_trackers.product_form', '=', 'OP')
                                                    ->orWhere('product_trackers.product_form', '=', 'OWS')
                                                    ->orWhere('product_trackers.product_form', '=', 'R');
                                        })
                                        ->select('product_trackers.quantity', 'product_trackers.total_price', 'product_trackers.product_form')
                                        ->get();

            $own_and_opening_balance_in_products = $all_stocks_for_finding_purchase_price->filter(function($item) {
                return ($item->product_form == 'OWS' || $item->product_form == 'OP');
            })->sum('total_price');
            
            //indirect Income
            $indirect_incomes = Indirect_incomes::where(['shop_id'=>$shop_id])->sum('amount');
            //indirect Income                          
            // $total_stock_in_price = $all_stocks_for_finding_purchase_price->sum('total_price');
            // $total_stock_in_qty = $all_stocks_for_finding_purchase_price->sum('quantity');

            // if($total_stock_in_price != 0 || $total_stock_in_price != 0) {
            //     $avg_purchase_price = $total_stock_in_price / $total_stock_in_qty;
            // }
            // else {
            //     $avg_purchase_price = 0;
            // }
            
            // // $own_stock = $all_stocks_for_finding_purchase_price->filter(function($item) {
            // //     return $item->product_form == 'OWS';
            // // })->sum('quantity');
            
            // // $opening_stock = $all_stocks_for_finding_purchase_price->filter(function($item) {
            // //     return $item->product_form == 'OP';
            // // })->sum('quantity');
            
            // // $test_stock_price = ($own_stock) * $avg_purchase_price;

            // $godowns_stock_find = DB::table('products')->where('shop_id', $shop_id)->sum('G_current_stock');
            // $branch_current_stock = DB::table('product_stocks')->where('shop_id', $shop_id)->sum('stock');
            // $closing_stock = ($godowns_stock_find + $branch_current_stock) * $avg_purchase_price;
            // //closing stock

            // //opening stock
            // $start_date = "2010-01-01";
            // $one_day_before = date('Y-m-d', strtotime(date('Y-m-d') . ' -1 day'));
            // $opening_product_trackers = DB::table('product_trackers')
            //                             ->join('products', 'product_trackers.product_id', 'products.id')
            //                             ->where('products.shop_id', $shop_id)
            //                             ->where('product_trackers.created_at', 'LIKE', '%'.date('Y-m-d').'%')
            //                             ->select('product_trackers.quantity', 'product_trackers.total_price', 'product_trackers.product_form')
            //                             ->get();

            // $opening_purchase = $opening_product_trackers->filter(function($item) {
            //     return ($item->product_form == 'SUPP_TO_B' || $item->product_form == 'SUPP_TO_G' || $item->product_form == 'OP' || $item->product_form == 'OWS' || $item->product_form == 'R');
            // })->sum('quantity');

            // $opening_paid_or_sales = $opening_product_trackers->filter(function($item) {
            //     return ($item->product_form == 'S' || $item->product_form == 'SUPP_R' || $item->product_form == 'DM');
            // })->sum('quantity');
            // $opening_stock = $closing_stock + $opening_paid_or_sales - $opening_purchase * $avg_purchase_price;
            //opening stock

        
            $total_cr = abs($cr_custoemrs) + abs($customers_opening_balance) + abs($cr_supplier) + abs($cr_loan_person) + abs($cr_capital_transacion) + abs($total_sales) + abs($purchase_return) + abs($indirect_incomes);
            $total_dr = abs($dr_custoemrs) + abs($dr_supplier) + abs($supplier_opening_balance) + abs($dr_loan_person) + abs($dr_capital_transacion) + abs($banks) + abs($cash->balance) + abs($expenses) + abs($sales_return) + abs($total_purchase);
            
            

            $output .= '<div class="col-md-12 shadow rounded p-2 mb-3">
                            <table class="table table-borderless table-hover">
                                <thead>
                                    <tr class="bg-secondary text-light" style="border-bottom: 2px solid #2C2E3B;">
                                        <th id="border_right" width="50%" scope="col">Heads of Accounts</th>
                                        <th id="border_right" scope="col">Debit</th>
                                        <th scope="col">Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th id="border_right" width="50%">Customer Due:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($dr_custoemrs), 2).'</td>
                                        <td width="25%">'.number_format(abs($cr_custoemrs), 2).'</td>
                                    </tr>';
                                    if($customers_opening_balance != 0) {
                                        $output .= '<tr><th id="border_right" width="50%">Customer Opening Balance / (<span style="font-size: 12px; color: #DF4646;"> Miscellaneous products / বিবিধ পণ্য বিক্রয়</span>) :</th><td id="border_right" width="25%"></td><td width="25%">'.number_format(abs($customers_opening_balance), 2).'</td></tr>';
                                    }
                                    $output .= '<tr>
                                        <th id="border_right" width="50%">Supplier Due:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($dr_supplier), 2).'</td>
                                        <td width="25%">'.number_format(abs($cr_supplier), 2).'</td>
                                    </tr>';
                                    if($supplier_opening_balance != 0) {
                                        $output .= '<tr><th id="border_right" width="50%">Supplier Opening Balance / (<span style="font-size: 12px; color: #DF4646;"> Miscellaneous products / বিবিধ পণ্য ক্রয়</span>):</th><td id="border_right" width="25%">'.number_format(abs($supplier_opening_balance), 2).'</td><td width="25%"></td></tr>';
                                    }
                                    if($customers_opening_balance == 0) {
                                        $output .= '<tr><th id="border_right" width="50%">Product own or opening stock price (<span style="font-size: 12px; color: #DF4646;"> note</span>) :</th><td width="25%" id="border_right">'.number_format($own_and_opening_balance_in_products, 2).'</td><td width="25%"></td></tr>';
                                    }
                                    $output .= '<tr>
                                        <th id="border_right" width="50%">Loan:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($dr_loan_person), 2).'</td>
                                        <td width="25%">'.number_format(abs($cr_loan_person), 2).'</td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Capital:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">'.number_format(abs($cr_capital_transacion), 2).'</td>
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Direct / Indirect Incomes:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">'.number_format(abs($indirect_incomes), 2).'</td>
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Withdraw / Drawings:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($dr_capital_transacion), 2).'</td>
                                        <td width="25%"></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <th id="border_right" width="50%">Bank:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($banks), 2).'</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Cash:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($cash->balance), 2).'</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Expenses:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($expenses), 2).'</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Sales:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">'.number_format(abs($total_sales), 2).'</td>
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Sales Return:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($sales_return), 2).'</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    
                                    <tr>
                                        <th id="border_right" width="50%">Purchase:</th>
                                        <td id="border_right" width="25%">'.number_format(abs($total_purchase), 2).'</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Purchase Return:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">'.number_format(abs($purchase_return), 2).'</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-secondary text-light" style="border-top: 2px solid #2C2E3B;">
                                        <th id="border_right" width="50%">Total:</th>
                                        <td id="border_right" width="25%">'.number_format($total_dr, 2).'</td>
                                        <td width="25%">'.number_format($total_cr, 2).'</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>';
        }
        else if(!empty($first_date) && $last_date != 0) { // this is for date range
            $first_date_number = strtotime($first_date);
            $last_date_number = strtotime($last_date);
            $j = 2;
            $i = 0;
            
            if($first_date_number <= $last_date_number) {

                $output .= '<div class="row">
                                <div class="col-md-12"><h3 class="text-light p-2 bg-primary text-center rounded"><b>'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' date Day Book</b></h3></div>
                            </div>';

                for($i; $i < $j; $i++) {

                    if($first_date_number <= $last_date_number) {

                        


                        $first_date = date('Y-m-d', strtotime($first_date . ' +1 day'));
                        $first_date_number = strtotime($first_date);
                        $j += 1;
                    }
                    else {
                        break;
                    }
                }
            }
            else {
                $output .= '<div class="row">
                                <div class="col-md-12"><h3 class="text-light p-2 bg-danger text-center rounded"><b>No Data Found!</b></h3></div>
                            </div>';
            }
            
        }
        
        return Response($output);
    }
    //End:: Trial Balance
    
    //Begin:: Income & Expenditure
    public function income_and_expenditure() {
        if(User::checkPermission('account.statement') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.income_and_expenditure', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function income_and_expenditure_data(Request $request) {
        $date_or_month = $request->date_or_month;
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $action = $request->action;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        date_default_timezone_set("Asia/Dhaka");
        $business_starting_date = "2010-01-01 00:00:00";
        $expenses_groups = Expense_group::all();
        
        if($action == 'm') { // this is for month wise 
            
            $updated_month_in_date = $date_or_month."-01";
            $start_date_of_month = $date_or_month."-01 00:00:00";
            $end_date_of_month = $date_or_month."-31 23:59:59";
            
            $One_day_minus_from_start_date = date('Y-m-d', strtotime('-1 day', strtotime($updated_month_in_date)))." 23:59:59";
            
            //find direct income
            $direct_expense_group = $expenses_groups->where('group_name', 'direct incomes')->first();
            $direct_income_ledger_heads = $direct_expense_group->ledger_heads->pluck('id');
            $total_direct_income = DB::table('indirect_incomes')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $direct_income_ledger_heads)->whereBetween('created_at', [$start_date_of_month, $end_date_of_month])->sum('amount');
            //find direct income
            
            
            $sales = DB::table('orders')->where(['shop_id'=>$shop_id])->where('date', 'like', '%'.$date_or_month.'%')->get(['invoice_total', 'pre_due']);
                $invoice_total = $sales->sum('invoice_total');
                $pre_due = $sales->sum('pre_due');
                $total_sales = $invoice_total - $pre_due;
                
            $customer_returns = DB::table('return_orders')->where(['shop_id'=>$shop_id])->where('date', 'like', '%'.$date_or_month.'%')->sum('refundAbleAmount');
            
            $net_sales = $total_sales - $customer_returns;
                
            $product_trackers_upto_end_month = DB::table('product_trackers')
                                                ->where('shop_id', $shop_id)
                                                ->whereBetween('created_at', [$business_starting_date, $end_date_of_month])
                                                ->where(function ($query){
                                                    $query->where('product_trackers.product_form', '=', 'SUPP_TO_B')
                                                            ->orWhere('product_trackers.product_form', '=', 'SUPP_TO_G')
                                                            ->orWhere('product_trackers.product_form', '=', 'OP')
                                                            ->orWhere('product_trackers.product_form', '=', 'OWS')
                                                            ->orWhere('product_trackers.product_form', '=', 'R')
                                                            ->orWhere('product_trackers.product_form', '=', 'S')
                                                            ->orWhere('product_trackers.product_form', '=', 'DM')
                                                            ->orWhere('product_trackers.product_form', '=', 'SUPP_R');
                                                })
                                                ->select('total_purchase_price', 'total_price', 'product_form')
                                                ->get();
            
                                        
            $stock_in_price_upto_end_day_of_month = $product_trackers_upto_end_month->filter(function($item) {
                return ($item->product_form == 'SUPP_TO_B' || $item->product_form == 'SUPP_TO_G'|| $item->product_form == 'OWS' || $item->product_form == 'OP' || $item->product_form == 'R');
            })->sum('total_purchase_price');
            
            // $stock_in_qty_upto_end_day_of_month = $product_trackers_upto_end_month->filter(function($item) {
            //     return ($item->product_form == 'SUPP_TO_B' || $item->product_form == 'SUPP_TO_G'|| $item->product_form == 'OWS' || $item->product_form == 'OP' || $item->product_form == 'R');
            // })->sum('quantity');
            
            // if($stock_in_price_upto_end_day_of_month != 0) {
            //     $avg_purchase_price = $stock_in_price_upto_end_day_of_month / $stock_in_qty_upto_end_day_of_month;
            // }
            // else {
            //     $avg_purchase_price = 0;
            // }
            
            $stock_out_upto_end_day_of_month = $product_trackers_upto_end_month->filter(function($item) {
                return (($item->product_form == 'S' || $item->product_form == 'SUPP_R'|| $item->product_form == 'DM'));
            })->sum('total_purchase_price');
            
            
            $stock_in_upto_end_day_of_month = $stock_in_price_upto_end_day_of_month;
            //$stock_out_upto_end_day_of_month = $stock_out_qty_upto_end_day_of_month * $avg_purchase_price;
            
            // current month
            $product_trackers_for_current_month = DB::table('product_trackers')
                                        ->where('shop_id', $shop_id)
                                        ->whereBetween('created_at', [$start_date_of_month, $end_date_of_month])
                                        ->where(function ($query){
                                            $query->where('product_trackers.product_form', '=', 'SUPP_TO_B')
                                                    ->orWhere('product_trackers.product_form', '=', 'SUPP_TO_G')
                                                    ->orWhere('product_trackers.product_form', '=', 'OP')
                                                    ->orWhere('product_trackers.product_form', '=', 'OWS')
                                                    ->orWhere('product_trackers.product_form', '=', 'R')
                                                    ->orWhere('product_trackers.product_form', '=', 'S')
                                                    ->orWhere('product_trackers.product_form', '=', 'DM')
                                                    ->orWhere('product_trackers.product_form', '=', 'SUPP_R');
                                        })
                                        ->select('total_purchase_price', 'total_price', 'product_form')
                                        ->get();
                                        
                              
                              
            $current_month_stock_in_price = $product_trackers_for_current_month->filter(function($item) {
                return (($item->product_form == 'SUPP_TO_B') || ($item->product_form == 'SUPP_TO_G') || ($item->product_form == 'OWS') || ($item->product_form == 'OP') || ($item->product_form == 'R'));
            })->sum('total_purchase_price');
            
            $current_month_stock_out_price = $product_trackers_for_current_month->filter(function($item) {
                return (($item->product_form == 'S' || $item->product_form == 'SUPP_R'|| $item->product_form == 'DM'));
            })->sum('total_purchase_price');
            
            $current_month_supp_return_price = $product_trackers_for_current_month->filter(function($item) {
                return ($item->product_form == 'SUPP_R');
            })->sum('total_purchase_price');
            
            
            //Begin:: for opening & closing stock
            $opening_stock = (($stock_in_upto_end_day_of_month - $current_month_stock_in_price) - ($stock_out_upto_end_day_of_month - $current_month_stock_out_price));
            $closing_stock = $opening_stock + ($current_month_stock_in_price - $current_month_stock_out_price);
            
            //find direct expenses
            $direct_expense_group = $expenses_groups->where('group_name', 'direct expenses')->first();
            $direct_expense_ledger_heads = $direct_expense_group->ledger_heads->pluck('id');
            $total_direct_expenses = DB::table('expense_transactions')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $direct_expense_ledger_heads)->whereBetween('created_at', [$start_date_of_month, $end_date_of_month])->sum('amount');
            //find direct expenses
            
            //find indirect expenses
            $inderict_expense_group = $expenses_groups->where('group_name', 'indirect expenses')->first();
            $indirect_expense_ledger_heads = $inderict_expense_group->ledger_heads->pluck('id');
            $total_indirect_expenses = DB::table('expense_transactions')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $indirect_expense_ledger_heads)->whereBetween('created_at', [$start_date_of_month, $end_date_of_month])->sum('amount');
            //find indirect expenses
            
            //find indirect income
            $indirect_expense_group = $expenses_groups->where('group_name', 'indirect incomes')->first();
            $indirect_income_ledger_heads = $indirect_expense_group->ledger_heads->pluck('id');
            $total_indirect_income = DB::table('indirect_incomes')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $indirect_income_ledger_heads)->whereBetween('created_at', [$start_date_of_month, $end_date_of_month])->sum('amount');
            //find indirect income
            
            $net_purchase = $current_month_stock_in_price - $current_month_supp_return_price;
            $cogs = $opening_stock + $net_purchase + $total_direct_expenses - $closing_stock;
            $gross_profit = $net_sales + $total_direct_income - $cogs;
            
            $net_profit = $gross_profit + $total_indirect_income - $total_indirect_expenses;
            
            $output .= '<div class="row">
                            <div class="col-md-12">
                                <h5><b>Month Name: </b>'.date("M, Y", strtotime($date_or_month)).'</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center text-light bg-dark"><th colspan="2">Gross Profit</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Direct Income</b><span id="font_size_12"><br>[ Others Income ]</span></td>
                                            <td width="35%">'.number_format($total_direct_income, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Sales</b><span id="font_size_12"><br>[ Total Sales - Sales Return ]</span></td>
                                            <td width="35%">'.number_format($net_sales, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Opening Stock</b><span id="font_size_12"><br>([Total Stock in - Total Stock Out] upto '.date("d M, Y h:i:s a", strtotime($One_day_minus_from_start_date)).')</span></td>
                                            <td width="35%">'.number_format($opening_stock, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Purchase</b><span id="font_size_12"><br>(Total purchase – Purchase return)</span></td>
                                            <td width="35%">'.number_format($net_purchase).'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><b>Closing Stock</b><span id="font_size_12"><br>(Opening Stock + Stock In - Total Stock Out)</span></td>
                                            <td width="35%">'.number_format($closing_stock, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Direct Expenses</b><span id="font_size_12"></td>
                                            <td width="35%">'.number_format($total_direct_expenses, 2).'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><b>COGS (Cost Of Goods Sold)</b><span id="font_size_12"><br>(Opening Stock + Net Purchase + direct expense – closing stock )</span></td>
                                            <td width="35%">'.number_format($cogs, 2).'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="text-right"><b>Gross Profit </b><span id="font_size_12">(Net Sales + Direct Incomes – COGS)</span></td>
                                            <td width="35%">'.number_format($gross_profit, 2).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center text-light bg-dark"><th colspan="3" scope="col">Net Profit</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Indirect expenses</b></td>
                                            <td width="35%">'.number_format($total_indirect_expenses, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Indirect income</b></td>
                                            <td width="35%">'.number_format($total_indirect_income, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Profit</b><span id="font_size_12"><br>(Gross profit – All indirect expenses + All indirect Income)</span></td>
                                            <td width="35%">'.number_format($net_profit, 2).'</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>';
            
        }
        else if($action == 'date_range' && !empty($first_date) && $last_date != 0) { // this is for date wise
        
            //$updated_month_in_date = $date_or_month."-01";
            $end_date_of_month = $last_date." 23:59:59";
            $One_day_minus_from_start_date = date('Y-m-d', strtotime('-1 day', strtotime($first_date)))." 23:59:59";
            
            //find direct income
            $direct_expense_group = $expenses_groups->where('group_name', 'direct incomes')->first();
            $direct_income_ledger_heads = $direct_expense_group->ledger_heads->pluck('id');
            $total_direct_income = DB::table('indirect_incomes')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $direct_income_ledger_heads)->whereBetween('created_at', [$first_date, $last_date])->sum('amount');
            //find direct income
            
            $sales = DB::table('orders')->where(['shop_id'=>$shop_id])->whereBetween('date', [$first_date, $last_date])->get(['invoice_total', 'pre_due']);
                $invoice_total = $sales->sum('invoice_total');
                $pre_due = $sales->sum('pre_due');
                $total_sales = $invoice_total - $pre_due;
                
            $customer_returns = DB::table('return_orders')->where(['shop_id'=>$shop_id])->whereBetween('date', [$first_date, $last_date])->sum('refundAbleAmount');
            
            $net_sales = $total_sales - $customer_returns;
                
            $product_trackers_upto_end_month = DB::table('product_trackers')
                                                ->where('shop_id', $shop_id)
                                                ->whereBetween('created_at', [$business_starting_date, $end_date_of_month])
                                                ->where(function ($query){
                                                    $query->where('product_trackers.product_form', '=', 'SUPP_TO_B')
                                                            ->orWhere('product_trackers.product_form', '=', 'SUPP_TO_G')
                                                            ->orWhere('product_trackers.product_form', '=', 'OP')
                                                            ->orWhere('product_trackers.product_form', '=', 'OWS')
                                                            ->orWhere('product_trackers.product_form', '=', 'R')
                                                            ->orWhere('product_trackers.product_form', '=', 'S')
                                                            ->orWhere('product_trackers.product_form', '=', 'DM')
                                                            ->orWhere('product_trackers.product_form', '=', 'SUPP_R');
                                                })
                                                ->select('total_purchase_price', 'total_price', 'product_form')
                                                ->get();
            
                                        
            $stock_in_price_upto_end_day_of_month = $product_trackers_upto_end_month->filter(function($item) {
                return ($item->product_form == 'SUPP_TO_B' || $item->product_form == 'SUPP_TO_G'|| $item->product_form == 'OWS' || $item->product_form == 'OP' || $item->product_form == 'R');
            })->sum('total_purchase_price');
            
            // $stock_in_qty_upto_end_day_of_month = $product_trackers_upto_end_month->filter(function($item) {
            //     return ($item->product_form == 'SUPP_TO_B' || $item->product_form == 'SUPP_TO_G'|| $item->product_form == 'OWS' || $item->product_form == 'OP' || $item->product_form == 'R');
            // })->sum('quantity');
            
            // if($stock_in_price_upto_end_day_of_month != 0) {
            //     $avg_purchase_price = $stock_in_price_upto_end_day_of_month / $stock_in_qty_upto_end_day_of_month;
            // }
            // else {
            //     $avg_purchase_price = 0;
            // }
            
            $stock_out_upto_end_day_of_month = $product_trackers_upto_end_month->filter(function($item) {
                return (($item->product_form == 'S' || $item->product_form == 'SUPP_R'|| $item->product_form == 'DM'));
            })->sum('total_purchase_price');
            
            
            $stock_in_upto_end_day_of_month = $stock_in_price_upto_end_day_of_month;
            //$stock_out_upto_end_day_of_month = $stock_out_qty_upto_end_day_of_month * $avg_purchase_price;
            
            // current month
            $product_trackers_for_current_month = DB::table('product_trackers')
                                        ->where('shop_id', $shop_id)
                                        ->whereBetween('created_at', [$first_date, $last_date])
                                        ->where(function ($query){
                                            $query->where('product_trackers.product_form', '=', 'SUPP_TO_B')
                                                    ->orWhere('product_trackers.product_form', '=', 'SUPP_TO_G')
                                                    ->orWhere('product_trackers.product_form', '=', 'OP')
                                                    ->orWhere('product_trackers.product_form', '=', 'OWS')
                                                    ->orWhere('product_trackers.product_form', '=', 'R')
                                                    ->orWhere('product_trackers.product_form', '=', 'S')
                                                    ->orWhere('product_trackers.product_form', '=', 'DM')
                                                    ->orWhere('product_trackers.product_form', '=', 'SUPP_R');
                                        })
                                        ->select('total_purchase_price', 'total_price', 'product_form')
                                        ->get();
                                        
                              
                              
            $current_month_stock_in_price = $product_trackers_for_current_month->filter(function($item) {
                return (($item->product_form == 'SUPP_TO_B') || ($item->product_form == 'SUPP_TO_G') || ($item->product_form == 'OWS') || ($item->product_form == 'OP') || ($item->product_form == 'R'));
            })->sum('total_purchase_price');
            
            $current_month_stock_out_price = $product_trackers_for_current_month->filter(function($item) {
                return (($item->product_form == 'S' || $item->product_form == 'SUPP_R'|| $item->product_form == 'DM'));
            })->sum('total_purchase_price');
            
            $current_month_supp_return_price = $product_trackers_for_current_month->filter(function($item) {
                return ($item->product_form == 'SUPP_R');
            })->sum('total_purchase_price');
            
            
            //Begin:: for opening & closing stock
            $opening_stock = (($stock_in_upto_end_day_of_month - $current_month_stock_in_price) - ($stock_out_upto_end_day_of_month - $current_month_stock_out_price));
            $closing_stock = $opening_stock + ($current_month_stock_in_price - $current_month_stock_out_price);
            
            //find direct expenses
            $direct_expense_group = $expenses_groups->where('group_name', 'direct expenses')->first();
            $direct_expense_ledger_heads = $direct_expense_group->ledger_heads->pluck('id');
            $total_direct_expenses = DB::table('expense_transactions')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $direct_expense_ledger_heads)->whereBetween('created_at', [$first_date, $last_date])->sum('amount');
            //find direct expenses
            
            //find indirect expenses
            $inderict_expense_group = $expenses_groups->where('group_name', 'indirect expenses')->first();
            $indirect_expense_ledger_heads = $inderict_expense_group->ledger_heads->pluck('id');
            $total_indirect_expenses = DB::table('expense_transactions')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $indirect_expense_ledger_heads)->whereBetween('created_at', [$first_date, $last_date])->sum('amount');
            //find indirect expenses
            
            //find indirect income
            $indirect_expense_group = $expenses_groups->where('group_name', 'indirect incomes')->first();
            $indirect_income_ledger_heads = $indirect_expense_group->ledger_heads->pluck('id');
            $total_indirect_income = DB::table('indirect_incomes')->where(['shop_id'=> $shop_id])->whereIn('ledger_head', $indirect_income_ledger_heads)->whereBetween('created_at', [$first_date, $last_date])->sum('amount');
            //find indirect income
            
            $net_purchase = $current_month_stock_in_price - $current_month_supp_return_price;
            $cogs = $opening_stock + $net_purchase + $total_direct_expenses - $closing_stock;
            $gross_profit = $net_sales + $total_direct_income - $cogs;
            
            $net_profit = $gross_profit + $total_indirect_income - $total_indirect_expenses;
            
            $output .= '<div class="row">
                            <div class="col-md-12">
                                <h5>'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' Income & Expenditure</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center text-light bg-dark"><th colspan="2">Gross Profit</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Direct Income</b><span id="font_size_12"><br>[ Others Income ]</span></td>
                                            <td width="35%">'.number_format($total_direct_income, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Sales</b><span id="font_size_12"><br>[ Total Sales - Sales Return ]</span></td>
                                            <td width="35%">'.number_format($net_sales, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Opening Stock</b><span id="font_size_12"><br>([Total Stock in - Total Stock Out] upto '.date("d M, Y h:i:s a", strtotime($One_day_minus_from_start_date)).')</span></td>
                                            <td width="35%">'.number_format($opening_stock, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Purchase</b><span id="font_size_12"><br>(Total purchase – Purchase return)</span></td>
                                            <td width="35%">'.number_format($net_purchase).'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><b>Closing Stock</b><span id="font_size_12"><br>(Opening Stock + Stock In - Total Stock Out)</span></td>
                                            <td width="35%">'.number_format($closing_stock, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Direct Expenses</b><span id="font_size_12"></td>
                                            <td width="35%">'.number_format($total_direct_expenses, 2).'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td><b>COGS (Cost Of Goods Sold)</b><span id="font_size_12"><br>(Opening Stock + Net Purchase + direct expense – closing stock )</span></td>
                                            <td width="35%">'.number_format($cogs, 2).'</td>
                                        </tr>
                                        
                                        <tr>
                                            <td class="text-right"><b>Gross Profit </b><span id="font_size_12">(Net Sales + Direct Incomes – COGS)</span></td>
                                            <td width="35%">'.number_format($gross_profit, 2).'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center text-light bg-dark"><th colspan="3" scope="col">Net Profit</th></tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Indirect expenses</b></td>
                                            <td width="35%">'.number_format($total_indirect_expenses, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Indirect income</b></td>
                                            <td width="35%">'.number_format($total_indirect_income, 2).'</td>
                                        </tr>
                                        <tr>
                                            <td><b>Net Profit</b><span id="font_size_12"><br>(Gross profit – All indirect expenses + All indirect Income)</span></td>
                                            <td width="35%">'.number_format($net_profit, 2).'</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>';
            
            
            
        }
        
        return Response($output);
    }
    //End:: Income & Expenditure
    
    
    
    public function test() {
        return view('cms.test.table');
    }


    //Begin:: Customer Ledger Tabel
    public function customer_ledger_table($code) {
        $shop_id = Auth::user()->shop_id;
        $customer_info = DB::table('customers')->where(['code'=>$code, 'shop_id'=>$shop_id])->first();
        if(!empty($customer_info->id)) {
            $wing = 'acc_and_tran';
            $invoices = DB::table('orders')->where(['shop_id'=>$shop_id, 'customer_id'=>$customer_info->id])->get(['invoice_total', 'pre_due', 'paid_amount']);
                $invoice_total = $invoices->sum('invoice_total');
                $paid_amount = $invoices->sum('paid_amount');
                $pre_due = $invoices->sum('pre_due');
            
            $total_receive = DB::table('take_customer_dues')->where(['shop_id'=>$shop_id, 'customer_code'=>$customer_info->code])->sum('received_amount');
            $total_return = DB::table('return_orders')->where(['customer_id'=>$customer_info->id])->sum('refundAbleAmount');
                
            
            return view('cms.shop_admin.account_and_transaction.report.customer_ledger', compact('wing', 'customer_info', 'invoice_total', 'paid_amount', 'pre_due', 'total_receive', 'total_return'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this information.');
        }
    }

    public function customer_ledger_table_invoice_summery(Request $request, $id) {
        if ($request->ajax()) {
            $invoices = DB::table('orders')->where(['shop_id'=>Auth::user()->shop_id, 'customer_id'=>$id])->orderBy('id', 'desc')->get(['branch_id', 'invoice_id', 'date', 'branch_id', 'invoice_total', 'paid_amount', 'pre_due']);
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-outline-secondary btn-sm">#'.str_replace("_","/", $row->invoice_id).'</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('invoice_total', function($row){
                    return $row->invoice_total - $row->pre_due;
                })
                ->addColumn('branch_name', function($row){
                    $branch_info = DB::table('branch_settings')->where('id', $row->branch_id)->first('branch_name');
                    return $branch_info->branch_name;
                })
                
                ->rawColumns(['date', 'action', 'invoice_total', 'branch_name'])
                ->make(true);
        }
    }

    public function customer_ledger_table_payment_summery(Request $request, $id) {
        $customer_info = DB::table('customers')->where('id', $id)->first('code');
        if ($request->ajax()) {
            $payments = DB::table('take_customer_dues')->where(['shop_id'=>Auth::user()->shop_id, 'customer_code'=>$customer_info->code])->orderBy('id', 'desc')->get(['voucher_number', 'paymentBy', 'received_amount', 'created_at']);
            return Datatables::of($payments)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('admin.view.customer.due.received.voucher', ['voucher_num'=>optional($row)->voucher_number]).'" class="btn btn-outline-dark btn-sm">#'.str_replace("_","/", $row->voucher_number).'</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['date', 'action', 'voucher_num'])
                ->make(true);
        }
    }

    public function customer_ledger_table_returned_product_summery(Request $request, $id) {
        
        if ($request->ajax()) {
            $returned_invoices = DB::table('return_orders')->where(['customer_id'=>$id])->orderBy('id', 'desc')->get(['invoice_id', 'return_current_times', 'date', 'id', 'refundAbleAmount']);
            return Datatables::of($returned_invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('view.product.returned.invoice', ['invoice_id'=>$row->invoice_id, 'current_return_times'=>$row->return_current_times]).'" class="btn btn-outline-dark btn-sm">#'.str_replace("_","/", $row->invoice_id).'</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->rawColumns(['date', 'action'])
                ->make(true);
        }
    }

    public function customer_ledger_table_summery(Request $request, $id) {
        
        if ($request->ajax()) {
            $contra = Transaction::where(['shop_id'=>Auth::user()->shop_id, 'track'=>$id])
                                    ->where(function ($query){
                                        $query->where('for_what', '=', 'CPR')
                                                ->orWhere('for_what', '=', 'S')
                                                ->orWhere('for_what', '=', 'CDR');
                                    })->orderBy('id', 'desc')->get();
                                    
            return Datatables::of($contra)
                ->addIndexColumn()
                ->addColumn('info', function($row){
                    $info = '';
                    if($row->for_what == 'S') { //sell
                        $info .='Sell';
                    }
                    else if($row->for_what == 'CDR') { //Customer Due Received
                        $info .='Payment Received';
                    }
                    else if($row->for_what == 'CPR') { //Customer Product Return
                        $info .='Product Return';
                    }
                    return $info;
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->addColumn('action', function($row){
                    $info = '';
                    if($row->for_what == 'S') { //sell
                        $info .='<a class="btn btn-success btn-sm" target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->refference]).'">View</a>';
                    }
                    else if($row->for_what == 'CDR') { //Customer Due Received
                        $info .='<a class="btn btn-success btn-sm" target="_blank" href="'.route('view.due.received.voucher', ['voucher_num'=>$row->refference]).'">View</a>';
                    }
                    else if($row->for_what == 'CPR') { //Customer Product Return
                        $info .='Product Return';
                    }
                    return $info;
                })
                
                ->rawColumns(['what_to_do', 'action', 'date'])
                ->make(true);
        }
    }

    public function customer_date_range_ledger(Request $request) {
        $customer_id = $request->customer_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $shop_id = Auth::user()->shop_id;
        $customer_info = DB::table('customers')->where(['id'=>$customer_id, 'shop_id'=>$shop_id])->first();
        if(!empty($customer_info->id)) {
            $wing = 'acc_and_tran';
            $invoices = DB::table('orders')->where(['shop_id'=>$shop_id, 'customer_id'=>$customer_info->id])->whereBetween('date', [$start_date, $end_date])->get(['invoice_total', 'pre_due', 'paid_amount', 'invoice_id', 'date']);
                $invoice_total = $invoices->sum('invoice_total');
                $paid_amount = $invoices->sum('paid_amount');
                $pre_due = $invoices->sum('pre_due');
            
            $payment_received = DB::table('take_customer_dues')->where(['shop_id'=>$shop_id, 'customer_code'=>$customer_info->code])->whereBetween('created_at', [$start_date, $end_date])->get(['received_amount', 'voucher_number', 'created_at']);
                $total_receive = $payment_received->sum('received_amount');
            $return_invoices = DB::table('return_orders')->where(['customer_id'=>$customer_info->id])->whereBetween('date', [$start_date, $end_date])->get(['refundAbleAmount', 'invoice_id', 'return_current_times', 'date']);
                $total_return = $return_invoices->sum('refundAbleAmount');
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();

            $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.date_range_customer_ledger', compact('return_invoices', 'shop_info', 'wing', 'customer_info', 'invoice_total', 'paid_amount', 'pre_due', 'total_receive', 'total_return', 'start_date', 'end_date', 'invoices', 'payment_received'));
            return $pdf->stream('Customer / '.$customer_info->name.' Ledger');
            
            //return view('cms.shop_admin.account_and_transaction.report.date_range_customer_ledger', compact('shop_info', 'wing', 'customer_info', 'invoice_total', 'paid_amount', 'pre_due', 'total_receive', 'total_return'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this information.');
        }

    }
    //End:: Customer Ledger Tabel
    
    //Begin:: customer sold products ledger
    public function customer_sold_product_ledger($code) {
        if(User::checkPermission('others.customers') == true){
            $wing = 'main';
            $customer_info = Customer::where('code', $code)->where('shop_id', Auth::user()->shop_id)->first();
            if(!is_null($customer_info)) {
                $orders = Order::where(['shop_id'=>Auth::user()->shop_id, 'customer_id'=>$customer_info->id])->get(['invoice_id', 'id']);
                return view('cms.shop_admin.customers.customer_sold_product_ledger', compact('orders', 'wing', 'customer_info'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: customer sold products ledger


    //Begin:: All User moments
    public function all_user_moments() {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.all_user_moments', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function all_user_moments_data(Request $request)
    {
        if ($request->ajax()) {
            $moments = DB::table('moments_traffics')->where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['created_at', 'info', 'user_id']);
            return Datatables::of($moments)
                ->addIndexColumn()
                ->addColumn('date', function($row){
                    return date('d-m-Y', strtotime(optional($row)->created_at));
                })
                ->addColumn('user_info', function($row){
                    $user = DB::table('users')->where('id', $row->user_id)->first(['name', 'phone']);
                    return $user->name." [".$user->phone." ]";
                })
                ->rawColumns(['date', 'user_info'])
                ->make(true);
        }
    }
    //End:: All User moments

    //Begin:: All Custoemrs or Due Custoemrs
    public function admin_report_all_customers() {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.all_customers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function all_or_due_customers_data(Request $request, $customer_type)
    {
        if ($request->ajax()) {
            if($customer_type == 'all') {
                $customers = DB::table('customers')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
                return Datatables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<div class="dropdown"><button class="btn dropdown-toggle btn btn-success btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="'.route('report.customer.ledger.table', ['code'=>$row->code]).'">Ledger</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" target="_blank" href="'.route('customer.sold.product.ledger', ['code'=>$row->code]).'">Sold Product Ledger (<small class="text-danger">New</small>)</a>
                                </div>
                            </div>';
                    return $info;
                })
                ->addColumn('type', function($row){
                    $type_info = DB::table('customer_types')->where('id', $row->customers_type_id)->first();
                    return optional($type_info)->type_name;
                })
                ->rawColumns(['action', 'type'])
                ->make(true);
            }
            else if($customer_type == 'due') {
                $customers = DB::table('customers')->where('shop_id', Auth::user()->shop_id)->where('balance', '>', 0)->orderBy('id', 'desc')->get();
                return Datatables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<div class="dropdown"><button class="btn dropdown-toggle btn btn-danger btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="'.route('report.customer.ledger.table', ['code'=>$row->code]).'">Ledger</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" target="_blank" href="'.route('customer.sold.product.ledger', ['code'=>$row->code]).'">Sold Product Ledger (<small class="text-danger">New</small>)</a>
                                </div>
                            </div>';
                    return $info;
                })
                ->addColumn('type', function($row){
                    $type_info = DB::table('customer_types')->where('id', $row->customers_type_id)->first();
                    return optional($type_info)->type_name;
                })
                
                ->rawColumns(['action', 'type'])
                ->make(true);
            }
        }
    }

    public function print_all_customers_or_due_custoers(Request $request) {
        $shop_id = Auth::user()->shop_id;
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $customer_type = $request->customers_type;
            if($customer_type == 'all') {
                $customers = DB::table('customers')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
                $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.all_or_due_customers_pdf', compact('customer_type', 'shop_info', 'wing', 'customers'));
                return $pdf->stream('All Customers');
            }
            else if($customer_type == 'due') {
                $customers = DB::table('customers')->where('shop_id', Auth::user()->shop_id)->where('balance', '>', 0)->orderBy('id', 'desc')->get();
                $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.all_or_due_customers_pdf', compact('customer_type', 'shop_info', 'wing', 'customers'));
                return $pdf->stream('Due Customers');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: All Custoemrs or Due Custoemrs

    //Begin:: All Suppliers or Due Suppliers
    public function admin_report_suppliers() {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.all_suppliers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function all_or_due_suppliers_data(Request $request, $supplier_type)
    {
        if ($request->ajax()) {
            if($supplier_type == 'all') {
                $customers = DB::table('suppliers')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
                return Datatables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<div class="dropdown"><button class="btn dropdown-toggle btn btn-success btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="'.route('report.supplier.ledger.table', ['id'=>$row->id]).'">Ledger</a>
                                    <a class="dropdown-item" href="'.route('supplier.grout.product.ledger', ['code'=>$row->code]).'">Sold Product Ledger (<small class="text-danger">New</small>)</a>
                                </div>
                            </div>';
                    return $info;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
            else if($supplier_type == 'due') {
                $customers = DB::table('suppliers')->where('shop_id', Auth::user()->shop_id)->where('balance', '>', 0)->orderBy('id', 'desc')->get();
                return Datatables::of($customers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<div class="dropdown"><button class="btn dropdown-toggle btn btn-danger btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="'.route('report.supplier.ledger.table', ['id'=>$row->id]).'">Ledger</a>
                                    <a class="dropdown-item" href="'.route('supplier.grout.product.ledger', ['code'=>$row->code]).'">Sold Product Ledger (<small class="text-danger">New</small>)</a>
                                </div>
                            </div>';
                    return $info;
                })
                ->rawColumns(['action'])
                ->make(true);
            }
        }
    }

    public function print_all_suppliers_or_due_suppliers(Request $request) {
        $shop_id = Auth::user()->shop_id;
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $supplier_type = $request->suppliers_type;
            if($supplier_type == 'all') {
                $suppliers = DB::table('suppliers')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
                $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.all_or_due_suppliers_pdf', compact('supplier_type', 'shop_info', 'wing', 'suppliers'));
                return $pdf->stream('All suppliers');
            }
            else if($supplier_type == 'due') {
                $suppliers = DB::table('suppliers')->where('shop_id', Auth::user()->shop_id)->where('balance', '>', 0)->orderBy('id', 'desc')->get();
                $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.all_or_due_suppliers_pdf', compact('supplier_type', 'shop_info', 'wing', 'suppliers'));
                return $pdf->stream('Due Customers');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: All Suppliers or Due Suppliers

    //Begin:: Supplier Ledger Tabel
    public function supplier_ledger_table($id) {
        $shop_id = Auth::user()->shop_id;
        $supplier_info = DB::table('suppliers')->where(['id'=>$id, 'shop_id'=>$shop_id])->first();
        if(!empty($supplier_info->id)) {
            $wing = 'acc_and_tran';
            $invoices = DB::table('supplier_invoices')->where(['shop_id'=>$shop_id, 'supplier_id'=>$supplier_info->id])->get(['total_gross', 'pre_due', 'paid', 'others_crg']);
                $total_gross = $invoices->sum('total_gross');
                $paid_amount = $invoices->sum('paid');
                
            $others_paid = DB::table('supplier_payments')->where(['shop_id'=>$shop_id, 'supplier_code'=>$supplier_info->code])->sum('paid');
            $total_return = DB::table('supplier_inv_returns')->where(['supplier_id'=>$supplier_info->id])->sum('total_gross');
              
            return view('cms.shop_admin.account_and_transaction.report.supplier_ledger', compact('wing', 'supplier_info', 'total_gross', 'paid_amount', 'others_paid', 'total_return'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this information.');
        }
    }

    public function supplier_ledger_table_invoice_summery(Request $request, $id) {
        if ($request->ajax()) {
            $invoices = DB::table('supplier_invoices')->where(['shop_id'=>Auth::user()->shop_id, 'supplier_id'=>$id])->orderBy('id', 'desc')->get(['supp_invoice_id', 'date', 'others_crg', 'total_gross', 'paid']);
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->supp_invoice_id]).'" class="btn btn-primary btn-sm">View Invoice</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('invoice_num', function($row){
                    return "#".str_replace("_","/", $row->supp_invoice_id);
                })
                ->rawColumns(['date', 'action', 'invoice_num'])
                ->make(true);
        }
    }

    public function supplier_ledger_table_payment_summery(Request $request, $id) {
        $supplier_info = DB::table('suppliers')->where('id', $id)->first('code');
        if ($request->ajax()) {
            $payments = DB::table('supplier_payments')->where(['shop_id'=>Auth::user()->shop_id, 'supplier_code'=>$supplier_info->code])->orderBy('id', 'desc')->get(['voucher_number', 'paymentBy', 'paid', 'created_at']);
            return Datatables::of($payments)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('view.supplier.payment.voucher', ['voucher_num'=>$row->voucher_number]).'" class="btn btn-success btn-sm">View Voucher</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->addColumn('voucher_num', function($row){
                    return "#".str_replace("_","/", $row->voucher_number);
                })
                ->rawColumns(['date', 'action', 'voucher_num'])
                ->make(true);
        }
    }

    public function supplier_ledger_table_returned_product_summery(Request $request, $id) {
        
        if ($request->ajax()) {
            $returned_invoices = DB::table('supplier_inv_returns')->where(['shop_id'=>Auth::user()->shop_id, 'supplier_id'=>$id])->orderBy('id', 'desc')->get(['supp_invoice_id', 'how_many_times_edited', 'date', 'id']);
            return Datatables::of($returned_invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('supplier.returned.invoice.view', ['id'=>$row->id, 'how_many_times_edit'=>$row->how_many_times_edited]).'" class="btn btn-info btn-sm">Returned inv</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('invoice_num', function($row){
                    return "#".str_replace("_","/", $row->supp_invoice_id);
                })
                ->rawColumns(['date', 'action', 'invoice_num'])
                ->make(true);
        }
    }

    
    public function supplier_date_range_ledger(Request $request) {
        $supplier_id = $request->supplier_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $shop_id = Auth::user()->shop_id;
        $supplier_info = DB::table('suppliers')->where(['id'=>$supplier_id, 'shop_id'=>$shop_id])->first();
        if(!empty($supplier_info->id)) {
            $wing = 'acc_and_tran';
            $invoices = DB::table('supplier_invoices')->where(['shop_id'=>$shop_id, 'supplier_id'=>$supplier_info->id])->whereBetween('date', [$start_date, $end_date])->get(['total_gross', 'pre_due', 'paid', 'others_crg', 'supp_invoice_id', 'date']);
                $total_gross = $invoices->sum('total_gross');
                $paid_amount = $invoices->sum('paid');
                
            $due_payments = DB::table('supplier_payments')->where(['shop_id'=>$shop_id, 'supplier_code'=>$supplier_info->code])->whereBetween('created_at', [$start_date, $end_date])->get(['paid', 'paymentBy', 'created_at', 'voucher_number']);
                $total_due_payments = $due_payments->sum('paid');
            $total_return_invoices = DB::table('supplier_inv_returns')->where(['supplier_id'=>$supplier_info->id])->whereBetween('date', [$start_date, $end_date])->get(['total_gross', 'how_many_times_edited', 'created_at', 'supp_invoice_id', 'date']);
                $total_return_products_amount = $total_return_invoices->sum('total_gross');
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();

            $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.date_range_supplier_ledger', compact('total_due_payments', 'due_payments', 'total_return_invoices', 'shop_info', 'wing', 'supplier_info', 'invoices', 'total_gross', 'paid_amount', 'total_return_invoices', 'total_return_products_amount', 'start_date', 'end_date'));
            return $pdf->stream('Supplier / '.$supplier_info->name.' Ledger');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this information.');
        }

    }
    //End:: Supplier Ledger Tabel

    //Begin:: All Ledger Report in one page
    public function all_ledger_in_one_page() {
        if(User::checkPermission('account.statement') == true){
            $wing = 'acc_and_tran';
            $user = Auth::user();
            return view('cms.shop_admin.account_and_transaction.report.ledger_table', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function admin_all_lenders_for_ledger(Request $request) {
        
        if ($request->ajax()) {
            $lenders = DB::table('loan_people')->where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['name', 'phone', 'address', 'id', 'balance']);
            return Datatables::of($lenders)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('report.lender.ledger.table', ['id'=>$row->id]).'" class="btn btn-success btn-sm">Ledger</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function admin_all_banks_for_ledger(Request $request) {
        
        if ($request->ajax()) {
            $banks = DB::table('banks')->where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['bank_name', 'bank_branch', 'account_no', 'account_type', 'id', 'balance']);
            return Datatables::of($banks)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('report.bank.ledger.table', ['id'=>$row->id]).'" class="btn btn-success btn-sm">Ledger</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function admin_all_capital_persons_for_ledger(Request $request) {
        
        if ($request->ajax()) {
            $owners = DB::table('owners')->where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get(['name', 'phone', 'nid_number', 'address', 'id', 'capital']);
            return Datatables::of($owners)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('report.owner.ledger.table', ['id'=>$row->id]).'" class="btn btn-success btn-sm">Ledger</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    //End:: All Ledger Report in one page

    //Begin:: Lender Ledger Info
    public function lender_ledger_table($id) {
        if(User::checkPermission('account.report') == true){
            $shop_id = Auth::user()->shop_id;
            $lender_info = DB::table('loan_people')->where(['id'=>$id, 'shop_id'=>$shop_id])->first();
            if(!empty($lender_info->id)) {
                $wing = 'acc_and_tran';
                $transactions = DB::table('loan_transactions')->where(['shop_id'=>$shop_id, 'lender_id'=>$lender_info->id])->get(['paid_or_received', 'cash_or_cheque', 'amount']);
                    $cash_loan_paid = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cash';
                    })->sum('amount');
                    $bank_loan_paid = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cheque';
                    })->sum('amount');
                    
                    $cash_loan_received = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'RECEIVE' && $item->cash_or_cheque == 'cash';;
                    })->sum('amount');
                    $bank_loan_received = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'RECEIVE' && $item->cash_or_cheque == 'cheque';;
                    })->sum('amount');
                    
                return view('cms.shop_admin.account_and_transaction.report.lender_ledger', compact('wing', 'lender_info', 'cash_loan_received', 'bank_loan_received', 'bank_loan_paid', 'cash_loan_paid'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this information.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function lender_ledger_table_invoice_summery(Request $request, $id) {
        if ($request->ajax()) {
            $orders = Loan_transaction::where(['shop_id'=>Auth::user()->shop_id, 'lender_id'=>$id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('added_by', function($row){
                    return $row->user_info->name;
                })
                ->addColumn('info', function($row){
                    $info = '';
                    if($row->cash_or_cheque == 'cash') {
                        $info .= '<p>Transaction by: Cash.<br /><b>Voucher Num: </b>#'.str_replace("_","/", $row->voucher_num).'<br /> <b>Note: </b>'.optional($row)->note.'</p>';
                    }
                    else if($row->cash_or_cheque == 'cheque') {
                        $info .= '<p>Transaction by: Cheque[ '.optional($row->bank_info)->bank_name.' ('.optional($row->bank_info)->account_no.') ].<br /><b>Voucher Num: </b>#'.str_replace("_","/", $row->voucher_num).'<br /> <b>Note: </b>'.optional($row)->note.'</p>';
                    }
                    return $info;
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['info', 'date', 'added_by'])
                ->make(true);
        }
    }
    public function admin_Lender_date_range_ledger(Request $request) {
        $lender_id = $request->lender_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $shop_id = Auth::user()->shop_id;
        $lender_info = DB::table('loan_people')->where(['id'=>$lender_id, 'shop_id'=>$shop_id])->first();
        if(!empty($lender_info->id)) {
            $wing = 'acc_and_tran';
            $transactions = Loan_transaction::where(['shop_id'=>$shop_id, 'lender_id'=>$lender_info->id])->whereBetween('created_at', [$start_date, $end_date])->get();
                    $cash_loan_paid = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cash';
                    })->sum('amount');
                    $bank_loan_paid = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'PAID' && $item->cash_or_cheque == 'cheque';
                    })->sum('amount');
                    
                    $cash_loan_received = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'RECEIVE' && $item->cash_or_cheque == 'cash';;
                    })->sum('amount');
                    $bank_loan_received = $transactions->filter(function($item) {
                        return $item->paid_or_received == 'RECEIVE' && $item->cash_or_cheque == 'cheque';;
                    })->sum('amount');
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();

            $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.date_range_lender_ledger', compact('cash_loan_paid', 'bank_loan_paid', 'cash_loan_received', 'shop_info', 'wing', 'lender_info', 'bank_loan_received', 'transactions', 'start_date', 'end_date'));
            return $pdf->stream('Lender / '.$lender_info->name.' Ledger');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this information.');
        }

    }
    //End:: Lender Ledger Info

    //Begin:: Bank Ledger Info
    public function bank_ledger_table($id) {
        if(User::checkPermission('account.report') == true){
            $shop_id = Auth::user()->shop_id;
            $bank_info = DB::table('banks')->where(['id'=>$id, 'shop_id'=>$shop_id])->first();
            if(!empty($bank_info->id)) {
                $wing = 'acc_and_tran';
                $bank_orders_cash_in = DB::table('orders')->where(['payment_by'=>'cheque', 'diposit_to'=>$id])->sum('paid_amount');
                $customer_due_cash_in = DB::table('take_customer_dues')->where(['paymentBy'=>'cheque', 'deposit_to'=>$id])->sum('received_amount');
                $contra = DB::table('contras')->where('shop_id', $shop_id)->Where(function ($query) use ($id) {
                                                    $query->where('sender', $id)
                                                        ->orWhere('receiver', $id);
                                                })->get(['CTB_or_BTC', 'contra_amount']);
                    
                $contra_cash_in = $contra->filter(function($item) {
                    return $item->CTB_or_BTC == 'CTB';
                })->sum('contra_amount');

                $contra_cash_out = $contra->filter(function($item) {
                    return $item->CTB_or_BTC == 'BTC';
                })->sum('contra_amount');

                $loans = DB::table('loan_transactions')->where(['cash_or_cheque'=>'cheque', 'bank_id'=>$id])->get(['paid_or_received', 'amount']);
                        $loan_received_in = $loans->filter(function($item) {
                            return $item->paid_or_received == 'RECEIVE';
                        })->sum('amount');

                        $loan_paid_out = $loans->filter(function($item) {
                            return $item->paid_or_received == 'PAID';
                        })->sum('amount');

                $capital = DB::table('capital_transactions')->where(['cash_or_cheque'=>'cheque', 'bank_id'=>$id])->get(['add_or_withdraw', 'amount']);                                
                    $capital_received_in = $capital->filter(function($item) {
                        return $item->add_or_withdraw == 'ADD';
                    })->sum('amount');

                    $capital_paid_out = $capital->filter(function($item) {
                        return $item->add_or_withdraw == 'WITHDRAW';
                    })->sum('amount');

                $supplier_payment_out = DB::table('supplier_payments')->where(['paymentBy'=>'cheque', 'cheque_or_mfs_account'=>$id])->sum('paid');
                $expense_out = DB::table('expense_transactions')->where(['cash_or_cheque'=>'cheque', 'bank_id'=>$id])->sum('amount');
                return view('cms.shop_admin.account_and_transaction.report.bank_ledger', compact('wing', 'bank_info', 'bank_orders_cash_in', 'customer_due_cash_in', 'contra_cash_in', 'contra_cash_out', 'loan_received_in', 'loan_paid_out', 'capital_received_in', 'capital_paid_out', 'supplier_payment_out', 'expense_out'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this information.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function transaction_summery_of_bank(Request $request, $bank_id) {
        if ($request->ajax()) {
            $shop_id = Auth::user()->shop_id;
            $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', $bank_id)->orderBy('id', 'desc')->get();
            return Datatables::of($transactions)
                ->addIndexColumn()
                ->addColumn('added_by', function($row){
                    $info = '';
                    if(!empty($row->branch_id)) {
                        $info .= '<b>Branch: </b> '.($row->brnach_info)->branch_name.' [ '.optional($row->user_info)->name.' ]';
                    }
                    else {
                        $info .= 'Admin Wing[ '.optional($row->user_info)->name.' ]';
                    }
                    return $info;
                })
                ->addColumn('info', function($row){
                    $info = '';
                    if($row->for_what == 'SDP') { //Supplier Due Payment
                        $info .='<p>Supplier Due Payment <a target="_blank" href="'.route('view.supplier.payment.voucher', ['voucher_num'=>$row->refference]).'"><i class="fas fa-eye"></i></a></p>';
                    }
                    else if($row->for_what == 'CONTRA') { //Contra
                        $info .='<p>Contra / Balance Transfer. Voucher Num: # '.str_replace("_","/", $row->refference).'</p>';
                    }
                    else if($row->for_what == 'CDR') { //Customer Due Received
                        $info .='<p>Customer Due Received <a target="_blank" href="'.route('view.due.received.voucher', ['voucher_num'=>$row->refference]).'"><i class="fas fa-eye"></i></a></p>';
                    }
                    else if($row->for_what == 'SIP') { //Supplier Instant Payment
                        $info .='<p>Supplier Instant Payment <a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->refference]).'"><i class="fas fa-eye"></i></a></p>';
                    }
                    else if($row->for_what == 'LP') { //Loan Paid
                        $info .='<p>Loan Paid to Lender</p>';
                    }
                    else if($row->for_what == 'LR') { //Loan Received
                        $info .='<p>Loan Received from Lender</p>';
                    }
                    else if($row->for_what == 'CA') { //Capital Added
                        $info .='<p>Capital Added From Owner</p>';
                    }
                    else if($row->for_what == 'CW') { //Capital Withdraw
                        $info .='<p>Capital Withdraw</p>';
                    }
                    else if($row->for_what == 'E') { //Expenses Payment
                        $info .='<p>Expense Payment <a target="_blank" href="'.route('admin.account.expenses.voucher.view', ['voucher_num'=>$row->refference]).'"><i class="fas fa-eye"></i></a></p>';
                    }
                    else if($row->for_what == 'CPR') { //Customer Product Return
                        $info .='<p>Customer Product Return</p>';
                    }
                    else if($row->for_what == 'S') { //Sell
                        $info .='<p>Sell <a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->refference]).'"><i class="fas fa-eye"></i></a></p>';
                    }
                    
                    return $info;
                })
                ->addColumn('cr_or_dr', function($row){
                    $output = '';
                    if($row->cash_or_bank == 'cash') {
                        $output .= '<b>'.$row->creadit_or_debit.'</b>( Cash )';
                    }
                    else {
                        $output .= '<b>'.$row->creadit_or_debit.'</b>( '.optional($row->bank_info)->bank_name.' ['.optional($row->bank_info)->account_no.'])';
                    }
                    return $output;
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                
                ->rawColumns(['added_by', 'info', 'cr_or_dr', 'date'])
                ->make(true);
        }
    }

    public function bank_ledger_sell_paid_summery(Request $request, $id) {
        if ($request->ajax()) {
            $invoices = DB::table('orders')->where(['shop_id'=>Auth::user()->shop_id, 'diposit_to'=>$id, 'payment_by'=>'cheque'])->orderBy('id', 'desc')->get(['branch_id', 'invoice_id', 'date', 'branch_id', 'invoice_total', 'paid_amount', 'pre_due']);
            return Datatables::of($invoices)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a target="_blank" href="'.route('view.sold.invoice', ['invoice_id'=>$row->invoice_id]).'" class="btn btn-outline-secondary btn-sm">#'.str_replace("_","/", $row->invoice_id).'</a>';
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->date));
                })
                ->addColumn('invoice_total', function($row){
                    return $row->invoice_total - $row->pre_due;
                })
                ->addColumn('branch_name', function($row){
                    $branch_info = DB::table('branch_settings')->where('id', $row->branch_id)->first('branch_name');
                    return $branch_info->branch_name;
                })
                
                ->rawColumns(['date', 'action', 'invoice_total', 'branch_name'])
                ->make(true);
        }
    }

    public function bank_ledger_customer_due_received_summery(Request $request, $id) {
        if ($request->ajax()) {
            $orders = Take_customer_due::where(['shop_id'=>Auth::user()->shop_id, 'paymentBy'=>'cheque', 'deposit_to'=>$id])->orderBy('id', 'desc')->get();
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
                ->addColumn('voucher_num', function($row){
                    return "#".str_replace("_","/", $row->voucher_number);
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['action', 'customer_name', 'voucher_num', 'branch_name'])
                ->make(true);
        }
    }

    public function bank_ledger_expenses_payment_summery(Request $request, $id) {
        if ($request->ajax()) {
            $expenses_vouchers = Expense_transaction::where(['shop_id'=>Auth::user()->shop_id, 'cash_or_cheque'=>'cheque', 'bank_id'=>$id])->orderBy('id', 'desc')->get();
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

    public function bank_ledger_loans_summery(Request $request, $id) {
        if ($request->ajax()) {
            $orders = Loan_transaction::where(['shop_id'=>Auth::user()->shop_id, 'cash_or_cheque'=>'cheque', 'bank_id'=>$id])->orderBy('id', 'desc')->get();
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

    public function bank_ledger_supplier_payments_summery(Request $request, $id) {
        if ($request->ajax()) {
            $orders = Supplier_payment::where(['shop_id'=>Auth::user()->shop_id, 'paymentBy'=>'cheque', 'cheque_or_mfs_account'=>$id])->orderBy('id', 'desc')->get();
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
                ->addColumn('voucher_num', function($row){
                    return "#".str_replace("_","/", $row->voucher_number);
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
                ->rawColumns(['action', 'supplier_name', 'voucher_num', 'date'])
                ->make(true);
        }
    }


    public function bank_ledger_capitals_summery(Request $request, $id) {
        if ($request->ajax()) {
            $orders = Capital_transaction::where(['shop_id'=>Auth::user()->shop_id, 'cash_or_cheque'=>'cheque', 'bank_id'=>$id])->orderBy('id', 'desc')->get();
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

    public function bank_ledger_contras_summery(Request $request, $id) {
        if ($request->ajax()) {
            $contra = Contra::where(['shop_id'=>Auth::user()->shop_id])
                                ->Where(function ($query) use ($id) {
                                    $query->where('sender', $id)
                                        ->orWhere('receiver', $id);
                                })
                                ->orderBy('id', 'desc')->get();
            return Datatables::of($contra)
                ->addIndexColumn()
                ->addColumn('added_by', function($row){
                    return optional($row->user_info)->name;
                })
                ->addColumn('subject', function($row){
                    $info = '';
                    if($row->CTB_or_BTC == 'CTB') {
                        $info .='<p>Cash To Bank<br /><b>Sender: </b>Cash<br /><b>Receiver: </b>'.optional($row->receiver_info)->bank_name.'</p>';
                    }
                    else if($row->CTB_or_BTC == 'BTC') {
                        $info .='<p>Bank To Cash<br /><b>Sender: </b>'.optional($row->sender_info)->bank_name.'<br /><b>Receiver: </b>Cash</p>';
                    }
                    return $info;
                })
                ->addColumn('voucher_num', function($row){
                    return '#'.str_replace("_","/", $row->voucher_number);
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->addColumn('amount', function($row){
                    return $row->contra_amount;
                })
                
                ->rawColumns(['added_by', 'subject', 'voucher_num', 'amount', 'date'])
                ->make(true);
        }
    }

    public function admin_bank_date_range_ledger(Request $request) {

        if(User::checkPermission('account.report') == true){
            $id = $request->bank_id;
            $shop_id = Auth::user()->shop_id;
            $bank_info = DB::table('banks')->where(['id'=>$id, 'shop_id'=>$shop_id])->first();
            if(!empty($bank_info->id)) {
                $wing = 'acc_and_tran';
                $start_date = $request->start_date;
                $end_date = $request->end_date;

                $orders_summery = DB::table('orders')->where(['payment_by'=>'cheque', 'diposit_to'=>$id])->whereBetween('created_at', [$start_date, $end_date])->get();
                    $bank_orders_cash_in = $orders_summery->sum('paid_amount');

                $due_received_transactions = Take_customer_due::where(['paymentBy'=>'cheque', 'deposit_to'=>$id])->whereBetween('created_at', [$start_date, $end_date])->get();
                    $customer_due_cash_in = $due_received_transactions->sum('received_amount');
                $contra = Contra::whereBetween('created_at', [$start_date, $end_date])->where('shop_id', $shop_id)->Where(function ($query) use ($id) {
                                                    $query->where('sender', $id)
                                                        ->orWhere('receiver', $id);
                                                })->get();
                    
                $contra_cash_in = $contra->filter(function($item) {
                    return $item->CTB_or_BTC == 'CTB';
                })->sum('contra_amount');

                $contra_cash_out = $contra->filter(function($item) {
                    return $item->CTB_or_BTC == 'BTC';
                })->sum('contra_amount');

                $loans = Loan_transaction::whereBetween('created_at', [$start_date, $end_date])->where(['cash_or_cheque'=>'cheque', 'bank_id'=>$id])->get();
                        $loan_received_in = $loans->filter(function($item) {
                            return $item->paid_or_received == 'RECEIVE';
                        })->sum('amount');

                        $loan_paid_out = $loans->filter(function($item) {
                            return $item->paid_or_received == 'PAID';
                        })->sum('amount');

                $capital = Capital_transaction::whereBetween('created_at', [$start_date, $end_date])->where(['cash_or_cheque'=>'cheque', 'bank_id'=>$id])->get();                                
                    $capital_received_in = $capital->filter(function($item) {
                        return $item->add_or_withdraw == 'ADD';
                    })->sum('amount');

                    $capital_paid_out = $capital->filter(function($item) {
                        return $item->add_or_withdraw == 'WITHDRAW';
                    })->sum('amount');

                $supplier_payment_transactions = Supplier_payment::whereBetween('created_at', [$start_date, $end_date])->where(['paymentBy'=>'cheque', 'cheque_or_mfs_account'=>$id])->get();
                    $supplier_payment_out = $supplier_payment_transactions->sum('paid');
                $expense_transactions = Expense_transaction::whereBetween('created_at', [$start_date, $end_date])->where(['cash_or_cheque'=>'cheque', 'bank_id'=>$id])->get();
                    $expense_out = $expense_transactions->sum('amount');
                $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();

                $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.date_range_bank_ledger', compact('bank_info', 'orders_summery', 'bank_orders_cash_in', 'shop_info', 'wing', 'due_received_transactions', 'customer_due_cash_in', 'contra', 'contra_cash_in', 'contra_cash_out', 'loans', 'capital', 'loan_received_in', 'loan_paid_out', 'capital_received_in', 'capital_paid_out', 'supplier_payment_transactions', 'supplier_payment_out', 'expense_transactions', 'expense_out', 'start_date', 'end_date'));
                return $pdf->stream('Bank / '.$bank_info->bank_name.' Ledger');
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this information.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: Bank Ledger Info

    //Begin:: Owner Ledger Info
    public function owner_ledger_table($id) {
        if(User::checkPermission('account.report') == true){
            $shop_id = Auth::user()->shop_id;
            $owner_info = DB::table('owners')->where(['id'=>$id, 'shop_id'=>$shop_id])->first();
            if(!empty($owner_info->id)) {
                $wing = 'acc_and_tran';
                $transactions = DB::table('capital_transactions')->where(['shop_id'=>$shop_id, 'owner_id'=>$owner_info->id])->get(['add_or_withdraw', 'cash_or_cheque', 'amount']);
                    
                    $capital_add_in_cash = $transactions->filter(function($item) {
                        return $item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cash';
                    })->sum('amount');
                    $capital_add_in_cheque = $transactions->filter(function($item) {
                        return $item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cheque';
                    })->sum('amount');

                    $capital_withdraw_in_cash = $transactions->filter(function($item) {
                        return $item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cash';
                    })->sum('amount');
                    $capital_withdraw_in_cheque = $transactions->filter(function($item) {
                        return $item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cheque';
                    })->sum('amount');
                    
                return view('cms.shop_admin.account_and_transaction.report.owner_ledger', compact('wing', 'owner_info', 'capital_add_in_cash', 'capital_add_in_cheque', 'capital_withdraw_in_cash', 'capital_withdraw_in_cheque'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this information.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function owner_ledger_table_transaction_summery(Request $request, $id) {
        if ($request->ajax()) {
            $orders = Capital_transaction::where(['shop_id'=>Auth::user()->shop_id, 'owner_id'=>$id])->orderBy('id', 'desc')->get();
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('add_or_withdraw', function($row){
                    return $row->add_or_withdraw;
                })
                ->addColumn('info', function($row){
                    $info = '';
                    if($row->cash_or_cheque == 'cash') {
                        $info .= '<p>Transaction by: Cash.<br /><b>Voucher Num: </b>#'.str_replace("_","/", $row->voucher_num).'<br /> <b>Note: </b>'.optional($row)->note.'<br /> <b>Added By: </b>'.optional($row->user_info)->name.'</p>';
                    }
                    else if($row->cash_or_cheque == 'cheque') {
                        $info .= '<p>Transaction by: Cheque[ '.optional($row->bank_info)->bank_name.' ('.optional($row->bank_info)->account_no.') ].<br /><b>Voucher Num: </b>#'.str_replace("_","/", $row->voucher_num).'<br /> <b>Note: </b>'.optional($row)->note.'<br /> <b>Added By: </b>'.optional($row->user_info)->name.'</p>';
                    }
                    return $info;
                })
                ->addColumn('date', function($row){
                    $info = date("d-m-Y", strtotime($row->created_at));
                    return $info;
                })
               
                ->rawColumns(['add_or_withdraw', 'info', 'date'])
                ->make(true);
        }
    }

    public function admin_owner_date_range_ledger(Request $request) {
        $owner_id = $request->owner_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $shop_id = Auth::user()->shop_id;
        $owner_info = DB::table('owners')->where(['id'=>$owner_id, 'shop_id'=>$shop_id])->first();
        
        if(!empty($owner_info->id)) {
            $wing = 'acc_and_tran';
            $transactions = Capital_transaction::where(['shop_id'=>Auth::user()->shop_id, 'owner_id'=>$owner_id])->whereBetween('created_at', [$start_date, $end_date])->orderBy('id', 'desc')->get();
                $capital_add_in_cash = $transactions->filter(function($item) {
                    return $item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cash';
                })->sum('amount');
                $capital_add_in_cheque = $transactions->filter(function($item) {
                    return $item->add_or_withdraw == 'ADD' && $item->cash_or_cheque == 'cheque';
                })->sum('amount');

                $capital_withdraw_in_cash = $transactions->filter(function($item) {
                    return $item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cash';
                })->sum('amount');
                $capital_withdraw_in_cheque = $transactions->filter(function($item) {
                    return $item->add_or_withdraw == 'WITHDRAW' && $item->cash_or_cheque == 'cheque';
                })->sum('amount');
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.date_range_owner_ledger', compact('shop_info', 'wing', 'owner_info', 'capital_add_in_cash', 'capital_add_in_cheque', 'capital_withdraw_in_cash', 'capital_withdraw_in_cheque', 'transactions', 'start_date', 'end_date'));
            return $pdf->stream('Owner / '.$owner_info->name.' Ledger');
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this information.');
        }

    }
    //End:: Owner Ledger Info

    //Begin:: admin_header_show_balance_statements
    public function admin_header_show_balance_statements() {
        if(User::checkPermission('admin.header.balance.statements') == true){
            $shop_id = Auth::user()->shop_id;
            $output = '';
            $cash_balance = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first('balance');
            $banks_info = DB::table('banks')->where('shop_id', $shop_id)->get(['balance', 'bank_name', 'bank_branch']);
            $output .= '<div class="col-md-12"><div class="media d-flex align-items-center push shadow rounded p-3"><div class="mr-3"><a class="item item-rounded bg-success" href="javascript:void(0)"><i class="fas fa-coins fa-2x text-white-75"></i></a></div><div class="media-body"><div class="font-w600">Cash Balance</div><div class="font-size-sm">'.number_format($cash_balance->balance, 2).'</div></div></div></div>
                        <div class="col-md-12"><div class="shadow rounded p-1"><table class="table"><thead><tr class="bg-dark text-light text-center"><th colspan="2" align="center">Bank Balance</th></tr></thead>
                            <tbody>';
                            foreach($banks_info as $bank) {
                            $output .= '<tr><td>'.$bank->bank_name.'</td><td>'.number_format($bank->balance, 2).'</td></tr>';
                            }
                            $output .= '</tbody>
                        </table></div></div>';
            return Response($output);
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    //End:: admin_header_show_balance_statements
    
    //Begin:: Expenses Ledger
    public function expenses_ledger() {
        if(User::checkPermission('account.statement') == true){
            $wing = 'acc_and_tran';
            $user = Auth::user();
            return view('cms.shop_admin.account_and_transaction.report.expenses_ledger', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function expenses_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $date_or_month = $request->date_or_month;
        $action = $request->action;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        date_default_timezone_set("Asia/Dhaka");
        $business_starting_date = "2010-01-01 00:00:00";
        
        if($action == 'm') { // this is for month wise 
            
            $updated_month_in_date = $date_or_month."-01";
            $start_date_of_month = $date_or_month."-01 00:00:00";
            $end_date_of_month = $date_or_month."-31 23:59:59";
            $One_day_minus_from_start_date = date('Y-m-d', strtotime('-1 day', strtotime($updated_month_in_date)))." 23:59:59";
            
            
            //find direct expenses
            $direct_expenses = DB::table('expense_groups')->where('group_name', 'direct expenses')->first(['id']);
            $direct_expense_id = $direct_expenses->id;
            
            //find indirect expenses
            $indirect_expenses = DB::table('expense_groups')->where('group_name', 'indirect expenses')->first(['id']);
            $indirect_expense_id = $indirect_expenses->id;
            $total_direct_expenses = 0;
            
            //find Fixed ASset expenses
            $fixed_asset_expenses = DB::table('expense_groups')->where('group_name', 'fixed assets')->first(['id']);
            $fixed_asset_expense_id = $fixed_asset_expenses->id;
            $total_fixed_expenses = 0;
            
            
            $total_expense = 0;
            
            $ledger_heads = DB::table('ledger__heads')->where('shop_id', $shop_id)->Where(function ($query) use ($direct_expense_id, $indirect_expense_id, $fixed_asset_expense_id) {
                                                    $query->where('group_id', $direct_expense_id)
                                                        ->orWhere('group_id', $indirect_expense_id)
                                                        ->orWhere('group_id', $fixed_asset_expense_id);
                                                })->get();
            
           
            
            $output .= '<div class="row p-2 shadow rounded">
                            <div class="col-md-12">
                                <h5><b>Month Name: </b>'.date("M, Y", strtotime($date_or_month)).'</h5>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tbody>';
                                        foreach($ledger_heads as $head) {
                                            $group_expense = 0;
                                            $expense_transactions = DB::table('expense_transactions')->where(['ledger_head'=>$head->id, 'shop_id'=> $shop_id])->whereBetween('created_at', [$start_date_of_month, $end_date_of_month])->orderBy('created_at', 'asc')->get(['cash_or_cheque', 'amount', 'created_at', 'voucher_num']);
                                            if($expense_transactions != '[]') {
                                            $output .= '<tr>
                                                <td><h3>'.$head->head_name.'</h3>
                                                </td>
                                                <td width="50%" class="expenses_details" style="display: none;">
                                                <table class="table">
                                                      <thead>
                                                        <tr>
                                                          <th>Date</th>
                                                          <th>VOUCHER NUM</th>
                                                          <th>AMOUNT</th>
                                                          <th>Action</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>';
                                                           
                                                            foreach($expense_transactions as $data) {
                                                                $group_expense = $group_expense + $data->amount;
                                                                $output .= '<tr>
                                                                  <td>'.date("d-m-Y", strtotime($data->created_at)).'</td>
                                                                  <td>#'.str_replace("_","/", $data->voucher_num).'</td>
                                                                  <td>'.number_format($data->amount, 2).'</td>
                                                                  <td><a target="_blank" href="'.route('admin.account.expenses.voucher.view', ['voucher_num'=>$data->voucher_num]).'" class="btn btn-success btn-rounded btn-sm"><i class="fas fa-eye"></i></a></td>
                                                                </tr>';
                                                            }
                                                      $output .= '</tbody>
                                                    </table>
                                                     </td>
                                                <td width="15%">'.number_format($group_expense, 2).'</td>
                                            </tr>';
                                            }
                                            $total_expense = $total_expense + $group_expense;
                                                    
                                        }
                                    $output .= '</tbody>
                                </table>
                                <div class="col-md-12 text-right">
                                <h5><b>Total Expense of '.date("M Y", strtotime($date_or_month)).' = </b>'.number_format($total_expense, 2).'</h5>
                            </div>
                                
                            </div>';
            
        }
        else if($action == 'all') { // this is for all Expenses
            //find direct expenses
            $direct_expenses = DB::table('expense_groups')->where('group_name', 'direct expenses')->first(['id']);
            $direct_expense_id = $direct_expenses->id;
            
            //find indirect expenses
            $indirect_expenses = DB::table('expense_groups')->where('group_name', 'indirect expenses')->first(['id']);
            $indirect_expense_id = $indirect_expenses->id;
            $total_direct_expenses = 0;
            
            //find Fixed ASset expenses
            $fixed_asset_expenses = DB::table('expense_groups')->where('group_name', 'fixed assets')->first(['id']);
            $fixed_asset_expense_id = $fixed_asset_expenses->id;
            $total_fixed_expenses = 0;
            
           
            $total_expense = 0;
            
            $ledger_heads = DB::table('ledger__heads')->where('shop_id', $shop_id)->Where(function ($query) use ($direct_expense_id, $indirect_expense_id, $fixed_asset_expense_id) {
                                                    $query->where('group_id', $direct_expense_id)
                                                        ->orWhere('group_id', $indirect_expense_id)
                                                        ->orWhere('group_id', $fixed_asset_expense_id);
                                                })->get();
            
           
            
            $output .= '<div class="row p-2 shadow rounded">
                            <div class="col-md-12">
                                <h5><b>All Expenses Ledger</b></h5>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tbody>';
                                        foreach($ledger_heads as $head) {
                                            $group_expense = 0;
                                            $expense_transactions = DB::table('expense_transactions')->where(['ledger_head'=>$head->id, 'shop_id'=> $shop_id])->orderBy('created_at', 'asc')->get(['cash_or_cheque', 'amount', 'created_at', 'voucher_num']);
                                            if($expense_transactions != '[]') {
                                            $output .= '<tr>
                                                <td><h3>'.$head->head_name.'</h3></td>
                                                <td width="50%" class="expenses_details" style="display: none;">
                                                <table class="table">
                                                      <thead>
                                                        <tr>
                                                          <th>Date</th>
                                                          <th>VOUCHER NUM</th>
                                                          <th>AMOUNT</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>';
                                                           
                                                            foreach($expense_transactions as $data) {
                                                                $group_expense = $group_expense + $data->amount;
                                                                $output .= '<tr>
                                                                  <td>'.date("d-m-Y", strtotime($data->created_at)).'</td>
                                                                  <td>#'.str_replace("_","/", $data->voucher_num).'</td>
                                                                  <td>'.number_format($data->amount, 2).'</td>
                                                                </tr>';
                                                            }
                                                      $output .= '</tbody>
                                                    </table>
                                                   </td>
                                                <td width="15%">'.number_format($group_expense, 2).'</td>
                                            </tr>';
                                            }
                                            $total_expense = $total_expense + $group_expense;
                                        }
                                    $output .= '</tbody>
                                </table>
                                <div class="col-md-12 text-right">
                                <h5><b>Total Expense = </b>'.number_format($total_expense, 2).'</h5>
                            </div>
                                
                            </div>';
        }
        else if($action == 'date_range' && !empty($first_date) && $last_date != 0) {
            
            //find direct expenses
            $direct_expenses = DB::table('expense_groups')->where('group_name', 'direct expenses')->first(['id']);
            $direct_expense_id = $direct_expenses->id;
            
            //find indirect expenses
            $indirect_expenses = DB::table('expense_groups')->where('group_name', 'indirect expenses')->first(['id']);
            $indirect_expense_id = $indirect_expenses->id;
            $total_direct_expenses = 0;
            
            //find Fixed ASset expenses
            $fixed_asset_expenses = DB::table('expense_groups')->where('group_name', 'fixed assets')->first(['id']);
            $fixed_asset_expense_id = $fixed_asset_expenses->id;
            $total_fixed_expenses = 0;
            
           
            $total_expense = 0;
            
            $ledger_heads = DB::table('ledger__heads')->where('shop_id', $shop_id)->Where(function ($query) use ($direct_expense_id, $indirect_expense_id, $fixed_asset_expense_id) {
                                                    $query->where('group_id', $direct_expense_id)
                                                        ->orWhere('group_id', $indirect_expense_id)
                                                        ->orWhere('group_id', $fixed_asset_expense_id);
                                                })->get();
            
           
            $output .= '<div class="row p-2 shadow rounded">
                            <div class="col-md-12">
                                <h5><b>'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' Expenses Ledger</b></h5>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tbody>';
                                        foreach($ledger_heads as $head) {
                                            $group_expense = 0;
                                            $expense_transactions = DB::table('expense_transactions')->where(['ledger_head'=>$head->id, 'shop_id'=> $shop_id])->whereBetween('created_at', [$first_date, $last_date])->orderBy('created_at', 'asc')->get(['cash_or_cheque', 'amount', 'created_at', 'voucher_num']);
                                            if(count($expense_transactions) > 0) {
                                            $output .= '<tr>
                                                <td><h3>'.$head->head_name.'</h3></td>
                                                <td width="50%" class="expenses_details" style="display: none;">
                                                <table class="table">
                                                      <thead>
                                                        <tr>
                                                          <th>Date</th>
                                                          <th>VOUCHER NUM</th>
                                                          <th>AMOUNT</th>
                                                        </tr>
                                                      </thead>
                                                      <tbody>';
                                                           
                                                            foreach($expense_transactions as $data) {
                                                                $group_expense = $group_expense + $data->amount;
                                                                $output .= '<tr>
                                                                  <td>'.date("d-m-Y", strtotime($data->created_at)).'</td>
                                                                  <td>#'.str_replace("_","/", $data->voucher_num).'</td>
                                                                  <td>'.number_format($data->amount, 2).'</td>
                                                                </tr>';
                                                            }
                                                      $output .= '</tbody>
                                                    </table>
                                                   </td>
                                                <td width="15%">'.number_format($group_expense, 2).'</td>
                                            </tr>';
                                            }
                                            $total_expense = $total_expense + $group_expense;
                                        }
                                    $output .= '</tbody>
                                </table>
                                <div class="col-md-12 text-right">
                                <h5><b>Total Expense = </b>'.number_format($total_expense, 2).'</h5>
                            </div>
                                
                            </div>';
        }
        
        return Response($output);
    }
    
    public function sales_report_by_product() {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.sales_report_by_product', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function sales_report_by_product_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        date_default_timezone_set("Asia/Dhaka");
        if(!empty($first_date) && $last_date == 0) { // this is for today / single day
        
            $products = DB::table('product_trackers')
                        ->join('orders', 'product_trackers.invoice_id', '=', 'orders.invoice_id')
                        ->where('orders.shop_id', $shop_id)
                        ->where('product_trackers.product_form', 'S')
                        ->whereDate('orders.date', $first_date)
                        ->groupBy('product_trackers.product_id')
                        ->select('product_trackers.product_id')
                        ->get();
                        
            $products_id = $products->pluck('product_id');
            
            $tracking_info = Product_tracker::whereIn('product_id', $products_id)->whereDate('created_at', $first_date)->Where(function($query) {
                            $query->where('product_form', 'S')
                                  ->orWhere('product_form', 'R');
                            })->get(['product_id', 'quantity', 'total_price', 'product_form']);
                        
            $total_profit = 0;    
            
        
            $output .= '<div class="row p-2">
                            <div class="col-md-12 shadow rounded p-2">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">'.date("d M, Y", strtotime($first_date)).' Sales Report By Product</th>
                                    </tr>
                                    <tr>
                                      <th scope="col">SN.</th>
                                      <th scope="col">Product Title</th>
                                      <th scope="col">Customer Sell & Return Info</th>
                                      <th scope="col">Actual Sell(Qty)</th>
                                      <th scope="col">Average Sold Price</th>
                                      <th scope="col">Total Sell(TK)</th>
                                      <th scope="col">Profit</th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>';
                                      foreach($products as $key => $product) {
                                          $product_info = Product::find($product->product_id);
                                          $unit_name = optional($product_info->unit_type_name)->unit_name;
                                          $sold_qty = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'S')->sum('quantity');
                                          $sold_price = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'S')->sum('total_price');
                                          $sold_return_qty = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'R')->sum('quantity');
                                          $sold_return_price = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'R')->sum('total_price');
                                          
                                          $actual_sold_in_quantity = $sold_qty - $sold_return_qty;
                                          
                                          if($sold_price != 0) {
                                              $average_sold_price = $sold_price / $sold_qty;
                                          }
                                          else {
                                              $average_sold_price = 0;
                                          }
                                          
                                          $total_sold_price = $actual_sold_in_quantity * $average_sold_price;
                                          $purchase_price = $product_info->purchase_price;
                                          $profit = ( $average_sold_price - $purchase_price ) * $actual_sold_in_quantity;
                                          $total_profit = $total_profit + $profit;
                                          $key++;
                                          
                                          $output .= '<tr>
                                              <td>'.$key.'</td>
                                              <th>'.$product_info->p_name.'<br><small><b class="text-success">Brand: </b>'.optional($product_info->brand_info)->brand_name.'<br><small><b>Purchase Price: </b>'.number_format($purchase_price, 2).'</small></th>
                                              <td width="20%">
                                                <small>Sold Qty. '.$sold_qty.' '.$unit_name.'<br>Sold Price: '.number_format($sold_price, 2).' TK</small><br>
                                                <small>Return Qty. '.$sold_return_qty.' '.$unit_name.'<br>Return Price: '.number_format($sold_return_price, 2).' TK</small>
                                              </td>
                                              <td>'.$actual_sold_in_quantity.' '.$unit_name.'</td>
                                              <td>'.number_format($average_sold_price, 2).' TK</td>
                                              <td>'.number_format($total_sold_price, 2).' TK</td>
                                              <td>'.number_format($profit, 2).' TK</td>
                                          </tr>';
                                      }
                                      $output .= '<tr>
                                          <td colspan="7" class="text-right"><h3>Total Profit: '.number_format($total_profit, 2).'</h3></td>
                                      </tr>
                                  </tbody>
                                </table>
                            </div>
                        </div>';
                        
        }
        else if(!empty($first_date) && $last_date != 0) { // this is for date wise
            $first_date_number = strtotime($first_date);
            $last_date_number = strtotime($last_date);
            $j = 2;
            $i = 0;
            
            $products = DB::table('product_trackers')
                        ->join('orders', 'product_trackers.invoice_id', '=', 'orders.invoice_id')
                        ->where('orders.shop_id', $shop_id)
                        ->where('product_trackers.product_form', 'S')
                        ->whereBetween('orders.date', [$first_date, $last_date])
                        ->groupBy('product_trackers.product_id')
                        ->select('product_trackers.product_id')
                        ->get();
                        
            $products_id = $products->pluck('product_id');
            
            $tracking_info = Product_tracker::whereIn('product_id', $products_id)->whereBetween('created_at', [$first_date, $last_date])->Where(function($query) {
                            $query->where('product_form', '!=', 'G')
                                  ->orWhere('product_form', '!=', 'OP');
                            })->get(['product_id', 'quantity', 'total_price', 'product_form']);
                            
                            
                            
                            
            $output .= '<div class="row p-2">
                <div class="col-md-12 shadow rounded p-2">
                    <table class="table table-bordered">
                      <thead>
                        <tr class="text-center bg-primary text-light background_color">
                          <th colspan="7" class="text-light text_color">'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' Sales Report By Product</th>
                        </tr>
                        <tr>
                          <th scope="col">SN.</th>
                          <th scope="col">Product Title</th>
                          <th scope="col">Customer Sell & Return Info</th>
                          <th scope="col">Actual Sell(Qty)</th>
                          <th scope="col">Average Sold Price</th>
                          <th scope="col">Total Sell(TK)</th>
                          <th scope="col">Profit</th>
                          
                        </tr>
                      </thead>
                      <tbody>';
                          foreach($products as $key => $product) {
                              $product_info = Product::find($product->product_id);
                              $unit_name = optional($product_info->unit_type_name)->unit_name;
                              $sold_qty = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'S')->sum('quantity');
                              $sold_price = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'S')->sum('total_price');
                              $sold_return_qty = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'R')->sum('quantity');
                              $sold_return_price = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'R')->sum('total_price');
                              
                              $actual_sold_in_quantity = $sold_qty - $sold_return_qty;
                              if($sold_price != 0) {
                                  $average_sold_price = $sold_price / $sold_qty;
                              }
                              else {
                                  $average_sold_price = 0;
                              }
                              
                              $total_sold_price = $actual_sold_in_quantity * $average_sold_price;
                              
                              
                              $total_purchase_in_qty = $tracking_info->filter(function($item) { 
                                  return ($item->product_form == 'SUPP_TO_B') || ($item->product_form == 'SUPP_TO_G');
                              })->sum('quantity');
                              
                              $total_purchase_in_price = $tracking_info->filter(function($item) { 
                                  return ($item->product_form == 'SUPP_TO_B') || ($item->product_form == 'SUPP_TO_G');
                              })->sum('total_price');
                              
                              
                              if($total_purchase_in_price == 0) {
                                  $purchase_price = $product_info->purchase_price;
                              }
                              else {
                                  $purchase_price = $total_purchase_in_price / $total_purchase_in_qty;
                              }
                              
                              $profit = ( $average_sold_price - $purchase_price ) * $actual_sold_in_quantity;
                              $key++;
                              
                              $output .= '<tr>
                                  <td>'.$key.'</td>
                                  <th>'.$product_info->p_name.'<br><small><b class="text-success">Brand: </b>'.optional($product_info->brand_info)->brand_name.'<br><small><b>Purchase Price: </b>'.number_format($purchase_price, 2).'</small></th>
                                  <td width="20%">
                                    <small>Sold Qty. '.$sold_qty.' '.$unit_name.'<br>Sold Price: '.number_format($sold_price, 2).' TK</small><br>
                                    <small>Return Qty. '.$sold_return_qty.' '.$unit_name.'<br>Return Price: '.number_format($sold_return_price, 2).' TK</small>
                                  </td>
                                  <td>'.$actual_sold_in_quantity.' '.$unit_name.'</td>
                                  <td>'.number_format($average_sold_price, 2).' TK</td>
                                  <td>'.number_format($total_sold_price, 2).' TK</td>
                                  <td>'.number_format($profit, 2).' TK</td>
                                  
                              </tr>';
                          }
                        
                      $output .= '</tbody>
                    </table>
                </div>
                
            </div>';
                            
            
        }
        
        return Response($output);
    }
    
    
    public function best_selling_products() {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.best_selling_products', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function best_selling_products_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $limit = $request->limit;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        date_default_timezone_set("Asia/Dhaka");
        if(!empty($first_date) && $last_date == 0) { // this is for today / single day
        
            $products = DB::table('product_trackers')
                        ->join('orders', 'product_trackers.invoice_id', '=', 'orders.invoice_id')
                        ->where('orders.shop_id', $shop_id)
                        ->where('product_trackers.product_form', 'S')
                        ->whereDate('orders.date', $first_date)
                        ->groupBy('product_trackers.product_id')
                        ->selectRaw('product_trackers.product_id, SUM(product_trackers.quantity) as quantity_item')
                        ->orderBy('quantity_item', 'DESC')
                        ->take($limit)
                        ->get();
                        
            
            $products_id = $products->pluck('product_id');
            
            $tracking_info = Product_tracker::whereIn('product_id', $products_id)->whereDate('created_at', $first_date)->where('product_form', 'S')->get(['product_id', 'quantity', 'total_price', 'product_form']);
                            
            
            $output .= '<div class="row p-2">
                            <div class="col-md-12 shadow rounded p-2">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-success text-light background_color">
                                      <th colspan="7" class="text-light text_color">'.date("d M, Y", strtotime($first_date)).' Best Selling Products (Limit: '.$limit.')</th>
                                    </tr>
                                    <tr>
                                      <th scope="col">SN.</th>
                                      <th scope="col">Product Title</th>
                                      <th scope="col">Sold(Qty)</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                                      foreach($products as $key => $product) {
                                          $product_info = Product::find($product->product_id);
                                          $unit_name = optional($product_info->unit_type_name)->unit_name;
                                          $sold_qty = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'S')->sum('quantity');
                                          $key++;
                                          $output .= '<tr>
                                              <td>'.$key.'</td>
                                              <th>'.$product_info->p_name.'<br><small><b class="text-success">Brand: </b>'.optional($product_info->brand_info)->brand_name.'</small></th>
                                              <td>'.$sold_qty.' '.$unit_name.'</td>
                                          </tr>';
                                      }
                                    
                                  $output .= '</tbody>
                                </table>
                            </div>
                        </div>';
                        
        }
        else if(!empty($first_date) && $last_date != 0) { // this is for date wise
            $first_date_number = strtotime($first_date);
            $last_date_number = strtotime($last_date);
            $j = 2;
            $i = 0;
            
            $products = DB::table('product_trackers')
                        ->join('orders', 'product_trackers.invoice_id', '=', 'orders.invoice_id')
                        ->where('orders.shop_id', $shop_id)
                        ->where('product_trackers.product_form', 'S')
                        ->whereBetween('orders.date', [$first_date, $last_date])
                        ->groupBy('product_trackers.product_id')
                        ->selectRaw('product_trackers.product_id, SUM(product_trackers.quantity) as quantity_item')
                        ->orderBy('quantity_item', 'DESC')
                        ->take($limit)
                        ->get();
                        
            
            $products_id = $products->pluck('product_id');
            
            $tracking_info = Product_tracker::whereIn('product_id', $products_id)->whereBetween('created_at', [$first_date, $last_date])->where('product_form', 'S')->get(['product_id', 'quantity', 'total_price', 'product_form']);
                     
                            
            $output .= '<div class="row p-2">
                            <div class="col-md-12 shadow rounded p-2">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-success text-light background_color">
                                      <th colspan="7" class="text-light text_color">'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' Best Selling Products (Limit: '.$limit.')</th>
                                    </tr>
                                    <tr>
                                      <th scope="col">SN.</th>
                                      <th scope="col">Product Title</th>
                                      <th scope="col">Sold(Qty)</th>
                                    </tr>
                                  </thead>
                                  <tbody>';
                                      foreach($products as $key => $product) {
                                          $product_info = Product::find($product->product_id);
                                          $unit_name = optional($product_info->unit_type_name)->unit_name;
                                          $sold_qty = $tracking_info->where('product_id', $product_info->id)->where('product_form', 'S')->sum('quantity');
                                          $key++;
                                          $output .= '<tr>
                                              <td>'.$key.'</td>
                                              <th>'.$product_info->p_name.'<br><small><b class="text-success">Brand: </b>'.optional($product_info->brand_info)->brand_name.'</small></th>
                                              <td>'.$sold_qty.' '.$unit_name.'</td>
                                          </tr>';
                                      }
                                    
                                  $output .= '</tbody>
                                </table>
                            </div>
                        </div>';
                            
            
        }
        
        return Response($output);
    }
    
    public function only_sales_report() {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.report.only_sales_report', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function only_sales_report_in_date_range(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $type = $request->type;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        $currency = ENV('DEFAULT_CURRENCY');
        date_default_timezone_set("Asia/Dhaka");
        
        if($type == 'all') { // this is for all data
        
            $sales = DB::table('orders')->where('shop_id', $shop_id)->get(['invoice_total', 'pre_due', 'paid_amount', 'others_crg', 'delivery_crg', 'payment_by']);
            $invoice_total = $sales->sum('invoice_total');
            $total_others_crg = $sales->sum('others_crg');
            $total_delivery_crg = $sales->sum('delivery_crg');
            $invoice_total_pre_due = $sales->sum('pre_due');
            $total_sales = $invoice_total - $invoice_total_pre_due;
            $invoice_instant_paid = $sales->sum('paid_amount');
            
            $multiple_payment_received = DB::table('multiple_payments')->where('shop_id', $shop_id)->get(['payment_type', 'paid_amount']);
            
            $instant_cash_received = $sales->filter(function($item) { return $item->payment_by == 'cash'; })->sum('paid_amount') + $multiple_payment_received->filter(function($item) { return $item->payment_type == 'cash'; })->sum('paid_amount');
            $instant_bank_received = $sales->filter(function($item) { return $item->payment_by == 'cheque'; })->sum('paid_amount') + $multiple_payment_received->filter(function($item) { return $item->payment_type == 'card'; })->sum('paid_amount');
            
            $total_discount = DB::table('orders')->where('shop_id', $shop_id)->where('discount_status', '!=', 'no')->sum('discount_in_tk');
            
            $return = DB::table('return_orders')->where('shop_id', $shop_id)->get(['refundAbleAmount', 'fine', 'others_crg', 'paid']);
            $return_other_charge = $return->filter(function($item) { return $item->others_crg > 0; })->sum('others_crg');
            $return_amount = $return->sum('refundAbleAmount');
            $return_fine = $return->sum('fine');
            $return_paid = $return->sum('paid');
            $total_return = $return_amount - $return_other_charge;
            
            $net_sales = $total_sales - $total_delivery_crg - $total_return;
            
            $customers = DB::table('customers')->where('shop_id', $shop_id)->get(['balance', 'id', 'opening_bl']);
            $customers_due = $customers->filter(function($item) { return $item->balance > 0; })->sum('balance');
            
            $due_received = DB::table('take_customer_dues')->where('shop_id', $shop_id)->get(['received_amount', 'paymentBy']);
            $due_received_by_cash = $due_received->filter(function($item) { return $item->paymentBy == 'cash'; })->sum('received_amount');
            $due_received_by_bank = $due_received->filter(function($item) { return $item->paymentBy == 'cheque'; })->sum('received_amount');
            
            $total_received = $instant_cash_received + $instant_bank_received + $due_received_by_cash + $due_received_by_bank;
            
          
            $output .= '<div class="row">
                        <div class="col-md-4 p-1">
                            <div class="shadow rounded p-1 border">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">Sales</th>
                                    </tr>
                                    <tr>
                                      <th width="50%">Total Sales</th>
                                      <th class="text-right">'.number_format($total_sales, 2).'</th>
                                    </tr>
                                    <tr class="d-none">
                                      <th width="40%">(-)Total Discount</th>
                                      <th class="text-right">'.number_format($total_discount, 2).'</th>
                                    </tr>
                                    <tr class="d-none">
                                      <th width="40%">(-)Others Charge</th>
                                      <th class="text-right">'.number_format($total_others_crg, 2).'</th>
                                    </tr>
                                    <tr class="d-none">
                                      <th width="40%">(-)Delivery Charge</th>
                                      <th class="text-right">'.number_format($total_delivery_crg, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">(-)Total Return</th>
                                      <th class="text-right">'.number_format($total_return, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" colspan="2">Net Sales = '.number_format($net_sales, 2).'</th>
                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5 p-1">
                            <div class="shadow rounded p-1 border">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">Sales Received</th>
                                    </tr>
                                    <tr>
                                      <th width="50%">Instant Cash Received</th>
                                      <th class="text-right">'.number_format($instant_cash_received, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">Due Cash Received</th>
                                      <th class="text-right">'.number_format($due_received_by_cash, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">Instant Bank Received</th>
                                      <th class="text-right">'.number_format($instant_bank_received, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">Due bank Received</th>
                                      <th class="text-right">'.number_format($due_received_by_bank, 2).'</th>
                                    </tr>
                                    
                                    <tr>
                                      <th class="text-right" colspan="2">Total Received = '.number_format($total_received, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" colspan="2">Refund to customer(-) = '.number_format($return_paid, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" colspan="2">Actual Received = '.number_format($total_received - $return_paid, 2).'</th>
                                    </tr>
                                    
                                  </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3 p-2">
                            <div class="shadow rounded p-1 border">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">Customer Due</th>
                                    </tr>
                                    <tr>
                                      <th width="50%">Current Due</th>
                                      <th class="text-right">'.number_format($customers_due, 2).'</th>
                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>
                    </div>';
                    
                        
        }
        else if($type == 'date_wise' && !empty($first_date) && $last_date != 0) { // this is for date wise
            $first_date_number = strtotime($first_date);
            $last_date_number = strtotime($last_date);
            
            
            $sales = DB::table('orders')->where('shop_id', $shop_id)->whereBetween('date', [$first_date, $last_date])->get(['invoice_total', 'pre_due', 'paid_amount', 'others_crg', 'delivery_crg', 'payment_by']);
            $invoice_total = $sales->sum('invoice_total');
            $total_others_crg = $sales->sum('others_crg');
            $total_delivery_crg = $sales->sum('delivery_crg');
            $invoice_total_pre_due = $sales->sum('pre_due');
            $total_sales = $invoice_total - $invoice_total_pre_due;
            $invoice_instant_paid = $sales->sum('paid_amount');
            
            
            
            $multiple_payment_received = DB::table('multiple_payments')->where('shop_id', $shop_id)->whereBetween('created_at', [$first_date, $last_date])->get(['payment_type', 'paid_amount']);
            
            $instant_cash_received = $sales->filter(function($item) { return $item->payment_by == 'cash'; })->sum('paid_amount') + $multiple_payment_received->filter(function($item) { return $item->payment_type == 'cash'; })->sum('paid_amount');
            $instant_bank_received = $sales->filter(function($item) { return $item->payment_by == 'cheque'; })->sum('paid_amount') + $multiple_payment_received->filter(function($item) { return $item->payment_type == 'card'; })->sum('paid_amount');
            
            $total_discount = DB::table('orders')->where('shop_id', $shop_id)->whereBetween('date', [$first_date, $last_date])->where('discount_status', '!=', 'no')->sum('discount_in_tk');
            
            
            $return = DB::table('return_orders')->where('shop_id', $shop_id)->whereBetween('date', [$first_date, $last_date])->get(['refundAbleAmount', 'fine', 'others_crg', 'paid']);
            $return_other_charge = $return->filter(function($item) { return $item->others_crg > 0; })->sum('others_crg');
            $return_amount = $return->sum('refundAbleAmount');
            $return_fine = $return->sum('fine');
            $return_paid = $return->sum('paid');
            $total_return = $return_amount - $return_other_charge;
            
            $net_sales = $total_sales - $total_delivery_crg - $total_return;
            
            // $customers = DB::table('customers')->where('shop_id', $shop_id)->get(['balance', 'id', 'opening_bl']);
            $customers_due = $total_sales - $invoice_instant_paid;
            
            $due_received = DB::table('take_customer_dues')->where('shop_id', $shop_id)->whereBetween('created_at', [$first_date, $last_date])->get(['received_amount', 'paymentBy']);
            $due_received_by_cash = $due_received->filter(function($item) { return $item->paymentBy == 'cash'; })->sum('received_amount');
            $due_received_by_bank = $due_received->filter(function($item) { return $item->paymentBy == 'cheque'; })->sum('received_amount');
            
            $total_received = $instant_cash_received + $instant_bank_received + $due_received_by_cash + $due_received_by_bank;
            
          
            $output .= '<div class="row">
                    <div class="col-md-12 p-1"><h4 class="mb-1">'.date("d M, Y", strtotime($first_date)).' To '.date("d M, Y", strtotime($last_date)).' Sales Report</h4></div>
                        <div class="col-md-4 p-1">
                            <div class="shadow rounded p-1 border">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">Sales</th>
                                    </tr>
                                    <tr>
                                      <th width="50%">Total Sales</th>
                                      <th class="text-right">'.number_format($total_sales, 2).'</th>
                                    </tr>
                                    <tr class="d-none">
                                      <th width="40%">(-)Total Discount</th>
                                      <th class="text-right">'.number_format($total_discount, 2).'</th>
                                    </tr>
                                    <tr class="d-none">
                                      <th width="40%">(-)Others Charge</th>
                                      <th class="text-right">'.number_format($total_others_crg, 2).'</th>
                                    </tr>
                                    <tr class="d-none">
                                      <th width="40%">(-)Delivery Charge</th>
                                      <th class="text-right">'.number_format($total_delivery_crg, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">(-)Total Return</th>
                                      <th class="text-right">'.number_format($total_return, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" colspan="2">Net Sales = '.number_format($net_sales, 2).'</th>
                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5 p-1">
                            <div class="shadow rounded p-1 border">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">Sales Received</th>
                                    </tr>
                                    <tr>
                                      <th width="50%">Instant Cash Received</th>
                                      <th class="text-right">'.number_format($instant_cash_received, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">Due Cash Received</th>
                                      <th class="text-right">'.number_format($due_received_by_cash, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">Instant Bank Received</th>
                                      <th class="text-right">'.number_format($instant_bank_received, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th width="40%">Due bank Received</th>
                                      <th class="text-right">'.number_format($due_received_by_bank, 2).'</th>
                                    </tr>
                                    
                                    <tr>
                                      <th class="text-right" colspan="2">Total Received = '.number_format($total_received, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" colspan="2">Refund to customer(-) = '.number_format($return_paid, 2).'</th>
                                    </tr>
                                    <tr>
                                      <th class="text-right" colspan="2">Actual Received = '.number_format($total_received - $return_paid, 2).'</th>
                                    </tr>
                                    
                                  </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3 p-2">
                            <div class="shadow rounded p-1 border">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr class="text-center bg-dark text-light background_color">
                                      <th colspan="7" class="text-light text_color">Customer Due</th>
                                    </tr>
                                    <tr>
                                      <th width="50%">Customer Due</th>
                                      <th class="text-right">'.number_format($customers_due, 2).'</th>
                                    </tr>
                                  </thead>
                                </table>
                            </div>
                        </div>
                    </div>';
                            
            
        }
        
        return Response($output);
    }
    
    
    
    
    
    
    


    




}
