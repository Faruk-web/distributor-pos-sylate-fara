<?php

namespace App\Http\Controllers;

use App\Models\Supplier_invoice;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use PDF;
use DataTables;
use App\Models\Product_stock;

class SupplierInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('supplier.stock.in') == true){
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.stock_in.all_invoice', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function supplier_invoice_data(Request $request)
    {
        if ($request->ajax()) {
            $all_invoices = supplier_invoice::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($all_invoices)
                ->addIndexColumn()
                ->addColumn('supplier_name', function($row){
                    return optional($row->supplier_name)->name."<br>Phone: ".optional($row->supplier_company_name)->phone."<br>Company Name: ".optional($row->supplier_company_name)->company_name;
                })
                ->addColumn('invoice', function($row){
                    return str_replace("_","/", $row->supp_invoice_id);
                })
                ->addColumn('date', function($row){
                    return date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('purchase_amount', function($row){
                    return ($row->total_gross);
                })
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->supp_invoice_id]).'" class="btn btn-primary btn-sm">Invoice</a>';
                    return $info;
                })
                ->rawColumns(['supplier_name', 'action', 'invoice', 'date', 'purchase_amount'])
                ->make(true);
        }
    }
    
    public function supplier_all_invoice()
    {
        if(User::checkPermission('supplier.stock.in') == true){
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.stock_in.all_invoices_report', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function supplier_all_invoice_data(Request $request) {
        $first_date = $request->first_date;
        $last_date = $request->last_date;
        $output = '';
        $shop_id = Auth::user()->shop_id;
        date_default_timezone_set("Asia/Dhaka");
        if(!empty($first_date) && $last_date == 0) { // this is for today / single day

            $invoices = supplier_invoice::where('shop_id', $shop_id)->whereDate('date', $first_date)->get();

            $output .= '<div class="row">
                            <div class="col-md-12">
                                <h5>'.date("d M, Y", strtotime($first_date)).' All Purchase Invoices</h5>
                            </div>';
                            foreach($invoices as $key => $invoice) {
                                $key++;
                                $supplier_info = $invoice->supplier_name;
                                $output .= '<div class="col-md-12 shadow rounded p-2 mt-3 border">
                                    <p class="bg-success p-1 rounded text-light"><b>Purchase Num: '.$key.' </b></p>
                                    <div class="row p-2">
                                        <div class="col-md-6 text-left">
                                            <p>
                                                Supplier Name: '.$supplier_info->name.'<br>
                                                Company Name: '.optional($supplier_info)->company_name.'<br>
                                                Address: '.optional($supplier_info)->address.'<br>
                                                Phone: '.optional($supplier_info)->phone.'<br>
                                                Email: '.optional($supplier_info)->email.'<br>
                                            </p>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <p class="invoiceIDandDate" style="font-family: Arial;">Invoice #
                                                '.str_replace("_","/", $invoice->supp_invoice_id).'<br>Supplier
                                                Voucher Num. '.optional($invoice)->supp_voucher_num.'<br>Date:
                                                '.date('d M, Y', strtotime(optional($invoice)->date)).'
                                            </p>
                                        </div>
                                        
                                        <div class="col-md-12 ">
                                            <table class="table table-bordered table-sm">
                                                <thead class="thead-light">
                                                    <tr style="text-align: right; background-color: #dddddd;">
                                                        <th scope="col" style="text-align: center;">SN</th>
                                                        <th width="50%" style="text-align: left;">Product Name</th>
                                                        <th scope="col" style="text-align: center;">Quantity</th>
                                                        <th scope="col" style="text-align: center;">Price</th>
                                                        <th scope="col" style="text-align: center;">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                                    $i = 1;
                                                    foreach($invoice->invoice_products as $product){
                                                    $output .= '<tr>
                                                        <th style="text-align: center;">'.$i.'</th>
                                                        <td>'.$product->product_info->p_name.' </td>
                                                        <td style="text-align: center;">'.$product->quantity.' '.$product->product_info->unit_type_name->unit_name.'</td>
                                                        <td style="text-align: center;">'.$product->price.'</td>
                                                        <td style="text-align: center;">'.$product->total_price.'</td>
                                                    </tr>';
                                                    $i++;
                                                    }
                                                    $sum = $invoice->total_gross;
                                                $output .= '</tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="col-md-12 text-right" style="margin-top: 8px; text-align: right;">
                                            <table class="text-right table table-bordered table-sm">
                                                <tbody class="text-right" style="text-align: right;">';
                                                    if($invoice->others_crg > 0) {
                                                    $output .= '<tr style="text-align: right;">
                                                        <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                            <b>Others Charge</b></td>
                                                        <td style="text-align: right;">'.number_format($invoice->others_crg, 2).'</td>
                                                    </tr>';
                                                    }
                                                    $output .= '<tr style="text-align: right;">
                                                        <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                            <b>Total Gross</b></td>
                                                        <td style="text-align:right; width:100px !important;">'.number_format($invoice->total_gross, 2).'</td>
                                                    </tr>';
                                                    if($invoice->pre_due > 0) {
                                                    $sum = $sum + $invoice->pre_due;
                                                    $output .= '<tr style="text-align: right;">
                                                        <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                            <b>Previous Get</b></td>
                                                        <td style="text-align: right;">'.number_format($invoice->pre_due, 2).'</td>
                                                    </tr>';
                                                    }
                                                    $output .= '<tr style="text-align: right;">
                                                        <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                            <b>Total</b></td>
                                                        <td style="text-align: right;">'.number_format($sum, 2).'</td>
                                                    </tr>
                                                    <tr style="text-align: right;">
                                                        <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                            <b>Paid</b></td>
                                                        <td style="text-align: right;">'.number_format($invoice->paid, 2).'</td>
                                                    </tr>
                                    
                                                    <tr style="text-align: right;">
                                                        <td style="border-bottom: 1px solid white; border-left: 1px solid white; border-top: 1px solid white; text-align: right;">
                                                            <b>Current Due</b></td>
                                                        <td style="text-align: right; width:30px;">'.number_format($sum - $invoice->paid, 2).'</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>';
                            }
                            
                             $output .= '<div class="col-md-6 text-center mt-2 d-none" style="padding-bottom: 10px;">
                                <h4 class="bg-dark text-light"
                                    style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                    <b>Cash Balance: </b> '.number_format(6665, 2).'
                                </h4>
                            </div>
                            <div class="col-md-6 text-center mt-2 d-none" style="padding-bottom: 10px;">
                                <h4 class="bg-dark text-light"
                                    style="padding: 5px 10px; border: 1px solid red; border-radius: 10px; margin-left: 10px;">
                                    <b>Bank Balance: </b> '.number_format(7767, 2).'
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
                            $opening_sales_paid = DB::table('orders')->where(['shop_id'=>$shop_id])->whereBetween('date', [$opening_start_date, $opening_end_date])->get(['paid_amount', 'payment_by']);
                                $opening_sale_cash_paid = $opening_sales_paid->filter(function($item){ return $item->payment_by == 'cash'; })->sum('paid_amount');
                                $opening_sale_cheque_paid = $opening_sales_paid->filter(function($item){ return $item->payment_by == 'cheque'; })->sum('paid_amount');
                                    
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


                
                    $sales_paid = DB::table('orders')->where(['shop_id'=>$shop_id])->whereDate('date', $first_date)->get(['paid_amount', 'payment_by']);
                    $sale_cash_paid = $sales_paid->filter(function($item){ return $item->payment_by == 'cash'; })->sum('paid_amount');
                    $sale_cheque_paid = $sales_paid->filter(function($item){ return $item->payment_by == 'cheque'; })->sum('paid_amount');
                        
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\supplier_invoice  $supplier_invoice
     * @return \Illuminate\Http\Response
     */
    public function show($invoice_id)
    {
        if(User::checkPermission('supplier.stock.in') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
            $supplier_invoice_info = supplier_invoice::where('supp_invoice_id', $invoice_id)->where('shop_id', $shop_id)->first();
            if($supplier_invoice_info) {
                $pdf = PDF::loadView('cms.shop_admin.supplier.stock_in.view_invoice', compact('shop_info', 'supplier_invoice_info', 'wing'));
                return $pdf->stream('supplier invoice '.$supplier_invoice_info->supp_invoice_id);
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function all_invoice_for_edit()
    {
        if(User::checkPermission('supplier.return.product') == true){
            $wing = 'supplier';
            return view('cms.shop_admin.supplier.stock_in.all_invoice_for_return', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function all_invoice_for_edit_data(Request $request)
    {
        if ($request->ajax()) {
            $all_invoices = supplier_invoice::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($all_invoices)
                ->addIndexColumn()
                ->addColumn('supplier_name', function($row){
                    return optional($row->supplier_name)->name."<br>Company Name: ".optional($row->supplier_company_name)->company_name;
                })
                ->addColumn('invoice', function($row){
                    return str_replace("_","/", $row->supp_invoice_id);
                })
                ->addColumn('date', function($row){
                    return date('d-m-Y', strtotime($row->date));
                })
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('supplier.stock.in.view.invoice', ['invoice_id'=>$row->supp_invoice_id]).'" class="btn btn-primary btn-sm">Inv</a> <a href="'.route('supplier.invoice.return.new', ['id'=>$row->id]).'" class="btn btn-danger btn-sm">Return</a>';
                    return $info;
                })
                ->rawColumns(['supplier_name', 'action', 'invoice', 'date'])
                ->make(true);
        }
    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\supplier_invoice  $supplier_invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'This is old versions';
        if(User::checkPermission('supplier.return.product') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            $supplier_invoice = supplier_invoice::where('id', $id)->where('shop_id', $shop_id)->first();
            if($supplier_invoice) {
                $how_many_time_returns = DB::table('supplier_inv_returns')->where('supp_invoice_id', $supplier_invoice->supp_invoice_id)->count('id');
                $supplier_info = DB::table('suppliers')->where('id', $supplier_invoice->supplier_id)->first();
                return view('cms.shop_admin.supplier.stock_in.inv_return', compact('supplier_invoice', 'wing', 'supplier_info', 'how_many_time_returns'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    
    public function supplier_product_return_place(Request $request) {
        $shop_id = Auth::user()->shop_id;
        $pid = $request->pid;
        $output = '';
        
        $product_info = DB::table('products')->where(['shop_id'=>$shop_id, 'id'=>$pid])->first(['p_name', 'id', 'G_current_stock']);
        $branches_stock = Product_stock::where('pid', $pid)->where('stock', '>', 0)->get(['branch_id', 'stock']);
        if($branches_stock != [] || $product_info->G_current_stock > 0) {
            $output .= '<div class="shadow p-2 rounded text-center"><h6 class=" text-success">'.$product_info->p_name.'</h6></div><br>
            <div class="form-group p-2 shadow rounded">
                            <label for="exampleFormControlSelect1">Select Place</label>
                            <select class="form-control select_supplier_return_place_confrim"  onchange="getval(this);" id="select_supplier_return_place_confrim">
                                <option value="'.$pid.'_,only">-- Select Place --</option>';
                                if($product_info->G_current_stock > 0){ $output .='<option value="'.$pid.'_,g_,Godowns_,'.$product_info->G_current_stock.'">Godowns ['.$product_info->G_current_stock.']</option>'; }
                                foreach($branches_stock as $branch_stock) {
                                    $output .= '<option value="'.$pid.'_,'.$branch_stock->branch_id.'_,'.$branch_stock->branch_info->branch_name.'_,'.$branch_stock->stock.'">'.$branch_stock->branch_info->branch_name.' ['.$branch_stock->stock.']</option>';
                                }
                            $output .= '</select>
                        </div>';
        }
        else {
            $output .= '<div class="text-center text-danger"><h6>'.$product_info->p_name.' has no stock to return.</h6></div>';
        }
        
        return Response($output);
    }



    // Supplier Return New ---------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    public function edit_new($id)
    {
        if(User::checkPermission('supplier.return.product') == true){
            $shop_id = Auth::user()->shop_id;
            $wing = 'supplier';
            $supplier_invoice = supplier_invoice::where('id', $id)->where('shop_id', $shop_id)->first();
            if($supplier_invoice) {
                $how_many_time_returns = DB::table('supplier_inv_returns')->where('supp_invoice_id', $supplier_invoice->supp_invoice_id)->count('id');
                $supplier_info = DB::table('suppliers')->where('id', $supplier_invoice->supplier_id)->first();
                return view('cms.shop_admin.supplier.stock_in.inv_return_new', compact('supplier_invoice', 'wing', 'supplier_info', 'how_many_time_returns'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function supplier_product_return_place_new(Request $request) {
        $shop_id = Auth::user()->shop_id;
        $pid = $request->pid;
        $lot_number = $request->lot_number;
        $variation_id = $request->variation_id;
        
        $output = '';
        
        $product_info = DB::table('products')->where(['shop_id'=>$shop_id, 'id'=>$pid])->first(['p_name', 'id', 'G_current_stock']);
        $branches_stock = Product_stock::where(['pid'=>$pid, 'lot_number'=>$lot_number, 'variation_id'=>$variation_id])->where('stock', '>', 0)->get(['branch_id', 'stock']);
        if(count($branches_stock) > 0) {
            $output .= '<div class="shadow p-2 rounded text-center"><h6 class=" text-success">'.$product_info->p_name.'</h6></div><br>
            <div class="form-group p-2 shadow rounded">
                            <label for="exampleFormControlSelect1">Select Place</label>
                            <select class="form-control select_supplier_return_place_confrim"  onchange="getval(this);" id="select_supplier_return_place_confrim">
                                <option value="'.$pid.'_,only">-- Select Place --</option>';
                                foreach($branches_stock as $branch_stock) {
                                    $output .= '<option value="'.$pid.'_,'.$branch_stock->branch_id.'_,'.optional($branch_stock->branch_info)->branch_name.'_,'.$branch_stock->stock.'">'.optional($branch_stock->branch_info)->branch_name.' ['.$branch_stock->stock.']</option>';
                                }
                            $output .= '</select>
                        </div>';
        }
        else {
            $output .= '<div class="text-center text-danger"><h6>'.$product_info->p_name.' has no stock to return.</h6></div>';
        }
        
        return Response($output);
    }
    
    
    
    // Supplier Return New ---------------------------------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
    



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\supplier_invoice  $supplier_invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(User::checkPermission('supplier.return.product') == true){
            $pid = $request->pid;
            if(!is_null($pid)) {
                $shop_id = Auth::user()->shop_id;
                $return_place = $request->return_place;
                $supplier_id = $request->supplier_id;
                $invoice_id = $request->supplier_invoice_id;
                $validated = $request->validate([
                    'supplier_invoice_id' => 'required',
                    'supplier_id' => 'required',
    
                ]);
                
                $how_many_time_returns = DB::table('supplier_inv_returns')->where('supp_invoice_id', $invoice_id)->count('id');
                $update_count = $how_many_time_returns+1;
                $current_time = Carbon::now();


                foreach($pid as $key => $item) {
                    $unit = $request->quantity[$key];
                    $price = $request->price[$key];
                    $total = $request->total[$key];
    
                    $p_data = array();
                    
                    $p_data['branch_id'] = $return_place[$key];
                    $p_data['product_id'] = $pid[$key];
                    $p_data['quantity'] = $unit;
                    $p_data['price'] = $price;
                    $p_data['total_price'] = $total;
                    $p_data['status'] = 0; // 0 means Out
                    $p_data['product_form'] = 'SUPP_R';
                    $p_data['invoice_id'] = $invoice_id;
                    $p_data['supplier_id'] = $supplier_id;
                    $p_data['note'] = $request->note;
                    $p_data['created_at'] = $current_time;
                    $insert_product_trackers = DB::table('product_trackers')->insert($p_data);
                    if($insert_product_trackers) {
                        if($return_place[$key] == 'g') {
                            $product_exist_quantity_check = DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->first(['G_current_stock']);
                            $current_quantity = $product_exist_quantity_check->G_current_stock;
                            $updateable_quantity = $current_quantity - $request->quantity[$key];
                            DB::table('products')->where('id', $pid[$key])->where('shop_id', $shop_id)->update(['G_current_stock' => $updateable_quantity]);
                        }
                        else {
                            
                            $branch_stock = DB::table('product_stocks')->where('branch_id', $return_place[$key])->where('pid', $pid[$key])->where('shop_id', $shop_id)->first();
                            $branch_current_quantity = $branch_stock->stock;
                            $branch_update_qty = $branch_current_quantity - $request->quantity[$key];
                            echo $branch_current_quantity."<br>";
                            DB::table('product_stocks')->where(['branch_id'=>$return_place[$key], 'pid'=>$pid[$key]])->update(['stock' => $branch_update_qty]);
                        }
                        
                        DB::table('supplier_return_products')->insert(['shop_id' => $shop_id, 'supp_invoice_id'=>$invoice_id, 'how_many_times_edited'=>$update_count, 'product_id'=>$pid[$key], 'quantity'=>$unit, 'price'=>$price, 'total_price'=>$total, 'created_at'=>$current_time, 'updated_at'=>$return_place[$key]]);
                    }
                }
                
                $supplier_info = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->first(['balance']);
                $current_balance = $supplier_info->balance;
    
                $return_supplier = DB::table('supplier_inv_returns')->insert(['shop_id'=>$shop_id, 'supp_invoice_id'=>$invoice_id, 'supplier_id'=>$supplier_id, 'total_gross'=>$request->total_gross, 'supp_Due'=>$current_balance, 'note'=>$request->note, 'how_many_times_edited'=>$update_count, 'date'=>$current_time, 'created_at'=>$current_time]);
                if($return_supplier) {
                    $update_balance = $current_balance - $request->total_gross;
                    $supplier_balance_update = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->update(['balance'=>$update_balance]);
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Product Return to supplier. Invoice num '.$invoice_id.' Current Returnable times '.$update_count.'', 'created_at' => $current_time]);
                    return Redirect()->route('supplier.all.returned.invoices')->with('success', 'Product Return Successfully done.');
            
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, Please try again.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'No Product Select');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }
    
    public function update_new(Request $request)
    {
        if(User::checkPermission('supplier.return.product') == true){
            $pid = $request->pid;
            if(!is_null($pid)) {
                $shop_id = Auth::user()->shop_id;
                $return_place = $request->return_place;
                $supplier_id = $request->supplier_id;
                $invoice_id = $request->supplier_invoice_id;
                $sum = 0;
                
                $validated = $request->validate([
                    'supplier_invoice_id' => 'required',
                    'supplier_id' => 'required',
                ]);
                
                $how_many_time_returns = DB::table('supplier_inv_returns')->where('supp_invoice_id', $invoice_id)->count('id');
                $update_count = $how_many_time_returns+1;
                $current_time = Carbon::now();


                foreach($pid as $key => $item) {
                    $unit = $request->quantity[$key];
                    $price = $request->price[$key];
                    $product_id = $pid[$key];
                    $variation_id = $request->variation_id[$key];
                    $lot_number = $request->lot_number[$key];
                    
                    $concates_return_qty = "return_qty_".$product_id;
                    $return_qty = $request->$concates_return_qty;
                    
                    $concates_return_db_id = "return_db_id_".$product_id;
                    $return_db_id = $request->$concates_return_db_id;
                    
                    $countable_unit = 0;
                    
                    if(!is_null($return_qty)) {
                        
                        foreach($return_qty as $sn => $item_return_qty) {
                            
                            if($return_qty[$sn] > 0) {
                                $rest_unit = '';
                                $return_unit = '';
                                $item_stock_info = DB::table('product_stocks')->where('id', $return_db_id[$sn])->where('pid', $product_id)->first();
                                
                                if(!is_null($item_stock_info)) {
                                   if(optional($item_stock_info)->stock >= $return_qty[$sn]) {
                                        $countable_unit = $countable_unit + $return_qty[$sn];
                                        $rest_unit = optional($item_stock_info)->stock - $return_qty[$sn];
                                        $return_unit = $return_qty[$sn];
                                    }
                                    else if($return_qty[$sn] >= optional($item_stock_info)->stock) {
                                        $countable_unit = $countable_unit + optional($item_stock_info)->stock;
                                        $rest_unit = 0;
                                        $return_unit = optional($item_stock_info)->stock;
                                    }
                                    
                                    if($rest_unit > 0) {
                                        DB::table('product_stocks')->where('id', $item_stock_info->id)->update(['stock'=>$rest_unit]);
                                    }
                                    else if($rest_unit == 0) {
                                        DB::table('product_stocks')->where('id', $item_stock_info->id)->delete();
                                    }
                                    
                                     DB::table('product_trackers')->insert(['shop_id'=>$shop_id, 'purchase_line_id'=>optional($item_stock_info)->purchase_line_id, 'lot_number'=>optional($item_stock_info)->lot_number, 'purchase_price'=>optional($item_stock_info)->purchase_price, 'total_purchase_price'=>optional($item_stock_info)->purchase_price*$return_unit, 'sales_price'=>optional($item_stock_info)->sales_price, 'variation_id'=>optional($item_stock_info)->variation_id, 'branch_id'=>optional($item_stock_info)->branch_id, 'product_id'=>optional($item_stock_info)->pid, 'quantity'=>$return_unit, 'price'=>$price, 'discount'=>optional($item_stock_info)->discount, 'discount_amount'=>optional($item_stock_info)->discount_amount, 'vat'=>optional($item_stock_info)->vat, 'total_price'=>$return_unit*$price, 'status'=>0, 'product_form'=>'SUPP_R', 'invoice_id'=>$invoice_id, 'supplier_id'=>$supplier_id, 'created_at'=>$current_time]);
                                    
                                }
                            }
                        }
                        
                        $total = $price * $countable_unit;
                        $sum = $sum + $total;
        
                        DB::table('supplier_return_products')->insert(['shop_id' => $shop_id, 'supp_invoice_id'=>$invoice_id, 'lot_number'=>$lot_number, 'how_many_times_edited'=>$update_count, 'product_id'=>$pid[$key], 'variation_id'=>$variation_id, 'quantity'=>$countable_unit, 'price'=>$price, 'total_price'=>$total, 'created_at'=>$current_time]);
                    }
                    
                }
                
                
                $supplier_info = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->first(['balance']);
                $current_balance = $supplier_info->balance;
    
                $return_supplier = DB::table('supplier_inv_returns')->insert(['shop_id'=>$shop_id, 'supp_invoice_id'=>$invoice_id, 'supplier_id'=>$supplier_id, 'total_gross'=>$sum, 'supp_Due'=>$current_balance, 'note'=>$request->note, 'how_many_times_edited'=>$update_count, 'date'=>$current_time, 'created_at'=>$current_time]);
                if($return_supplier) {
                    $update_balance = $current_balance - $sum;
                    $supplier_balance_update = DB::table('suppliers')->where('id', $supplier_id)->where('shop_id', $shop_id)->update(['balance'=>$update_balance]);
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Product Return to supplier. Invoice num '.$invoice_id.' Current Returnable times '.$update_count.'', 'created_at' => $current_time]);
                    return Redirect()->route('supplier.all.returned.invoices')->with('success', 'Product Return Successfully done.');
            
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, Please try again.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'No Product Select');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }

    }
    
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\supplier_invoice  $supplier_invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(supplier_invoice $supplier_invoice)
    {
        //
    }
}
