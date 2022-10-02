<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use DataTables;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            $banks = DB::table('banks')->where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.report.cash_flow', compact('wing', 'banks'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }


    public function cash_flow_data(Request $request, $type) {
        if ($request->ajax()) {
            $type = $type;
            $shop_id = Auth::user()->shop_id;
            if($type == 'cash_and_banks') {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->orderBy('id', 'desc')->get();
            }
            else if($type == 'all_banks') {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '!=', 'cash')->orderBy('id', 'desc')->get();
            }
            else if($type == 'only_cash') {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', 'cash')->orderBy('id', 'desc')->get();
            }
            else {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', $type)->orderBy('id', 'desc')->get();
            }
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
                    else if($row->for_what == 'IE') { //Sell
                        $info .='<p>Indirect Income <a target="_blank" href="'.route('admin.indirect.incomes.voucher', ['voucher_num'=>$row->refference]).'"><i class="fas fa-eye"></i></a></p>';
                    }
                    else if($row->for_what == 'OE') { //Sell
                        $info .='<p>Others Income </p>';
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
    
    public function transaction_history_print(Request $request) {
        $type = $request->transaction_type;
        $shop_id = Auth::user()->shop_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
        if($type == 'cash_and_banks') {
            $for_what_transaction = "All Transactions";
            if(!empty($start_date && !empty($end_date))) {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->whereBetween('created_at', [$start_date, $end_date])->orderBy('id', 'desc')->get();
            }
            else {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->orderBy('id', 'desc')->get();
            }
        }
        else if($type == 'all_banks') {
            $for_what_transaction = "All Banks Transactions";
            if(!empty($start_date && !empty($end_date))) {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '!=', 'cash')->whereBetween('created_at', [$start_date, $end_date])->orderBy('id', 'desc')->get();
            }
            else {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '!=', 'cash')->orderBy('id', 'desc')->get();
            }
            
        }
        else if($type == 'only_cash') {
            $for_what_transaction = "Only Cash Transactions";
            if(!empty($start_date && !empty($end_date))) {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', 'cash')->whereBetween('created_at', [$start_date, $end_date])->orderBy('id', 'desc')->get();
            }
            else {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', 'cash')->orderBy('id', 'desc')->get();
            }
            
        }
        else {
            $bank_info = DB::table('banks')->where(['id'=> $type, 'shop_id'=>$shop_id])->first();
            if(!empty($bank_info->id)) {
                $for_what_transaction = $bank_info->bank_name." Transactions";
                if(!empty($start_date && !empty($end_date))) {
                    $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', $type)->whereBetween('created_at', [$start_date, $end_date])->orderBy('id', 'desc')->get();
                }
                else {
                    $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', $type)->orderBy('id', 'desc')->get();
                }
                
            }
            else {
                return Redirect()->back()->with('error', 'Erroe Occoured, Please Try Again.');
            }
            
        }

        $pdf = PDF::loadView('cms.shop_admin.account_and_transaction.report.transaction_history_print', compact('shop_info', 'for_what_transaction', 'transactions', 'start_date', 'end_date', 'type', 'shop_id'));
        return $pdf->stream($for_what_transaction);
    }
    
    public function cash_flow_diagram()
    {
        if(User::checkPermission('account.report') == true){
            $wing = 'acc_and_tran';
            $banks = DB::table('banks')->where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.report.cash_flow_diagram', compact('wing', 'banks'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function cash_flow_diagram_data(Request $request)
    {
        if(User::checkPermission('account.report') == true){
            $output = '';
            $first_date = $request->first_date;
            $last_date = $request->last_date;
            $type = $request->select_info;
            
            $shop_id = Auth::user()->shop_id;
            
            DB::statement("SET SQL_MODE=''");
            
            if($type == 'only_cash') {
                
                
                
                
                
                
                
                
                
                
                $contra_transactions = Transaction::where(['shop_id'=>$shop_id])->where('for_what', 'CONTRA')->select(['for_what', 'track', DB::raw('SUM(amount) as total_amount')])->orderBy('id', 'desc')->groupBy(['track']);
                
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', 'cash')->select(['for_what', 'creadit_or_debit', DB::raw('SUM(amount) as total_amount')])->orderBy('id', 'desc')->groupBy(['for_what']);
            }
            else if($type == 'all_banks') {
                $contra_transactions = Transaction::where(['shop_id'=>$shop_id])->where('for_what', 'CONTRA')->select(['for_what', 'track', DB::raw('SUM(amount) as total_amount')])->orderBy('id', 'desc')->groupBy(['track']);
                
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '!=', 'cash')->select(['for_what', 'creadit_or_debit', DB::raw('SUM(amount) as total_amount')])->orderBy('id', 'desc')->groupBy(['for_what']);
            }
            else {
                $transactions = Transaction::where(['shop_id'=>$shop_id])->where('cash_or_bank', '=', $type)->select(['for_what', 'creadit_or_debit', DB::raw('SUM(amount) as total_amount')])->orderBy('id', 'desc')->groupBy(['for_what']);
            }
            
            $transactions = $transactions->where('for_what', '!=', 'CONTRA');
            
            if(!empty($first_date) && !empty($last_date)) {
                $contra_transactions = $contra_transactions->whereBetween('created_at', [$first_date, $last_date]);
                $transactions = $transactions->whereBetween('created_at', [$first_date, $last_date]);
            }
            
            $contra_transactions = $contra_transactions->get();
            $transactions = $transactions->get();
            
            $total_cr = 0;
            $total_dr = 0;
            
            $output .= '<div class="col-md-12 shadow rounded p-2 mb-3">
                        <table class="table table-borderless table-hover">
                            <thead>
                                <tr class="bg-secondary text-light" style="border-bottom: 2px solid #2C2E3B;">
                                    <th id="border_right" width="50%" scope="col">Heads of Transactions</th>
                                    <th id="border_right" scope="col">Debit (DR)</th>
                                    <th scope="col">Credit (CR)</th>
                                </tr>
                            </thead>
                            <tbody>';
                                if(count($transactions) > 0) {
                                   foreach($transactions as $transaction) {
                                        $output .= '<tr class="border-bottom">
                                            <th id="border_right" width="50%">';
                                                    if($transaction->for_what == 'SDP') { //Supplier Due Payment
                                                        $output .='Supplier Due Payment:'; 
                                                    }
                                                    else if($transaction->for_what == 'CONTRA') { //Contra
                                                        $output .='Contra / Balance Transfer:';
                                                    }
                                                    else if($transaction->for_what == 'CDR') { //Customer Due Received
                                                        $output .='Customer Due Received:';
                                                    }
                                                    else if($transaction->for_what == 'SIP') { //Supplier Instant Payment
                                                        $output .='Supplier Instant Payment:';
                                                    }
                                                    else if($transaction->for_what == 'LP') { //Loan Paid
                                                        $output .='Loan Paid to Lender:';
                                                    }
                                                    else if($transaction->for_what == 'LR') { //Loan Received
                                                        $output .='Loan Received from Lender:';
                                                    }
                                                    else if($transaction->for_what == 'CA') { //Capital Added
                                                        $output .='Capital Added From Owner:';
                                                    }
                                                    else if($transaction->for_what == 'CW') { //Capital Withdraw
                                                        $output .='Capital Withdraw:';
                                                    }
                                                    else if($transaction->for_what == 'E') { //Expenses Payment
                                                        $output .='Expense Payment:';
                                                    }
                                                    else if($transaction->for_what == 'CPR') { //Customer Product Return
                                                        $output .='Customer Product Return:';
                                                    }
                                                    else if($transaction->for_what == 'S') { //Sell
                                                        $output .='Sell:';
                                                    }
                                                    else if($transaction->for_what == 'IE') { //Sell
                                                        $output .='Indirect Income:';
                                                    }
                                                    else if($transaction->for_what == 'OE') { //Sell
                                                        $output .='Others Income:';
                                                    }
                                            $output .= '</th>';
                                            if($transaction->creadit_or_debit == 'CR') {
                                                $total_cr = $total_cr + $transaction->total_amount;
                                                $output .= '<td id="border_right" width="25%"></td>
                                                            <td width="25%">'.number_format($transaction->total_amount, 2).'</td>';
                                            }
                                            else if($transaction->creadit_or_debit == 'DR') {
                                                $total_dr = $total_dr + $transaction->total_amount;
                                                $output .= '<td id="border_right" width="25%">'.number_format($transaction->total_amount, 2).'</td>
                                                            <td width="25%"></td>';
                                            }
                                            
                                        $output .= '</tr>';
                                    }
                                    
                                    foreach($contra_transactions as $contra_transaction) {
                                        if($type == 'only_cash') {
                                            if($contra_transaction->track == 'CTB') {
                                                $total_dr = $total_dr + $contra_transaction->total_amount;
                                                $output .= '<tr class="border-bottom"><th id="border_right" width="50%">Contra (Cash To Bank)</th>
                                                            <td id="border_right" width="25%">'.number_format($contra_transaction->total_amount, 2).'</td>
                                                            <td width="25%"></td></tr>';
                                            }
                                            else if($contra_transaction->track == 'BTC') {
                                                $total_cr = $total_cr + $contra_transaction->total_amount;
                                                $output .= '<tr class="border-bottom"><th id="border_right" width="50%">Contra (Bank To Cash)</th>
                                                            <td id="border_right" width="25%"></td>
                                                            <td width="25%">'.number_format($contra_transaction->total_amount, 2).'</td></tr>';
                                            }
                                        }
                                        else if($type == 'all_banks') {
                                            if($contra_transaction->track == 'CTB') {
                                                $total_cr = $total_cr + $contra_transaction->total_amount;
                                                $output .= '<tr class="border-bottom"><th id="border_right" width="50%">Contra (Cash To Bank)</th>
                                                            <td id="border_right" width="25%"></td>
                                                            <td width="25%"></td>'.number_format($contra_transaction->total_amount, 2).'</tr>';
                                            }
                                            else if($contra_transaction->track == 'BTC') {
                                                $total_dr = $total_dr + $contra_transaction->total_amount;
                                                $output .= '<tr class="border-bottom"><th id="border_right" width="50%">Contra (Bank To Cash)</th>
                                                            <td id="border_right" width="25%">'.number_format($contra_transaction->total_amount, 2).'</td>
                                                            <td width="25%"></td></tr>';
                                            }
                                        }
                                        else {
                                            
                                        }
                                    }
                                }
                                else {
                                    $output .= '<tr>
                                        <td colspan="3" class="text-center"><h2>No Transaction Found!</h2></td>
                                    </tr>';
                                }
                                
                            $output .= '</tbody>
                            <tfoot>
                                <tr class="bg-secondary text-light" style="border-top: 2px solid #2C2E3B;">
                                    <th id="border_right" width="50%">Total:</th>
                                    <td id="border_right" width="25%">'.number_format($total_dr, 2).'</td>
                                    <td width="25%">'.number_format($total_cr, 2).' / '.($total_cr-$total_dr).'</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>';
            
            return Response($output);
            
            
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
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
