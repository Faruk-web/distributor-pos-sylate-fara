@php
$shop_id = Auth::user()->shop_id;
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
            // $all_stocks_for_finding_purchase_price = DB::table('product_trackers')
            //                             ->join('products', 'product_trackers.product_id', 'products.id')
            //                             ->where('products.shop_id', $shop_id)
            //                             ->where(function ($query){
            //                                 $query->where('product_trackers.product_form', '=', 'SUPP_TO_B')
            //                                         ->orWhere('product_trackers.product_form', '=', 'SUPP_TO_G')
            //                                         ->orWhere('product_trackers.product_form', '=', 'OP')
            //                                         ->orWhere('product_trackers.product_form', '=', 'OWS')
            //                                         ->orWhere('product_trackers.product_form', '=', 'R');
            //                             })
            //                             ->select('product_trackers.quantity', 'product_trackers.total_price', 'product_trackers.product_form')
            //                             ->get();

            $own_and_opening_balance_in_products = $all_stocks_for_finding_purchase_price->filter(function($item) {
                return ($item->product_form == 'OWS' || $item->product_form == 'OP');
            })->sum('total_price');
                                        
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
            //                             ->where('product_trackers.created_at', 'LIKE', '%{{date('Y-m-d')}}%')
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

        
            $total_cr = abs($cr_custoemrs) + abs($customers_opening_balance) + abs($cr_supplier) + abs($cr_loan_person) + abs($cr_capital_transacion) + abs($total_sales) + abs($purchase_return);
            $total_dr = abs($dr_custoemrs) + abs($dr_supplier) + abs($supplier_opening_balance) + abs($dr_loan_person) + abs($dr_capital_transacion) + abs($banks) + abs($cash->balance) + abs($expenses) + abs($sales_return) + abs($total_purchase);
            
            @endphp

            <div class="col-md-12 shadow rounded p-2 mb-3">
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
                                        <td id="border_right" width="25%">{{number_format(abs($dr_custoemrs), 2)}}</td>
                                        <td width="25%">{{number_format(abs($cr_custoemrs), 2)}}</td>
                                    </tr>';
                                    @if($customers_opening_balance != 0)
                                        <tr><th id="border_right" width="50%">Customer Opening Balance / (<span style="font-size: 12px; color: #DF4646;"> Miscellaneous products / বিবিধ পণ্য বিক্রয়</span>) :</th><td id="border_right" width="25%"></td><td width="25%">{{number_format(abs($customers_opening_balance), 2)}}</td></tr>
                                    @endif
                                    <tr>
                                        <th id="border_right" width="50%">Supplier Due:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($dr_supplier), 2)}}</td>
                                        <td width="25%">{{number_format(abs($cr_supplier), 2)}}</td>
                                    </tr>';
                                    @if($supplier_opening_balance != 0)
                                        <tr><th id="border_right" width="50%">Supplier Opening Balance / (<span style="font-size: 12px; color: #DF4646;"> Miscellaneous products / বিবিধ পণ্য ক্রয়</span>):</th><td id="border_right" width="25%">{{number_format(abs($supplier_opening_balance), 2)}}</td><td width="25%"></td></tr>';
                                    @endif
                                    @if($customers_opening_balance == 0) 
                                        <tr><th id="border_right" width="50%">Product own or opening stock price (<span style="font-size: 12px; color: #DF4646;"> note</span>) :</th><td width="25%">{{number_format($own_and_opening_balance_in_products, 2)}}</td><td width="25%"></td></tr>';
                                    @endif
                                    <tr>
                                        <th id="border_right" width="50%">Loan:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($dr_loan_person), 2)}}</td>
                                        <td width="25%">{{number_format(abs($cr_loan_person), 2)}}</td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Capital:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">{{number_format(abs($cr_capital_transacion), 2)}}</td>
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Withdraw / Drawings:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($dr_capital_transacion), 2)}}</td>
                                        <td width="25%"></td>
                                    </tr>
                                    
                                    
                                    <tr>
                                        <th id="border_right" width="50%">Bank:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($banks), 2)}}</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Cash:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($cash->balance), 2)}}</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Expenses:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($expenses), 2)}}</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Sales:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">{{number_format(abs($total_sales), 2)}}</td>
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Sales Return:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($sales_return), 2)}}</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    
                                    <tr>
                                        <th id="border_right" width="50%">Purchase:</th>
                                        <td id="border_right" width="25%">{{number_format(abs($total_purchase), 2)}}</td>
                                        <td width="25%"></td>
                                        
                                    </tr>
                                    <tr>
                                        <th id="border_right" width="50%">Purchase Return:</th>
                                        <td id="border_right" width="25%"></td>
                                        <td width="25%">{{number_format(abs($purchase_return), 2)}}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="bg-secondary text-light" style="border-top: 2px solid #2C2E3B;">
                                        <th id="border_right" width="50%">Total:</th>
                                        <td id="border_right" width="25%">{{number_format($total_dr, 2)}}</td>
                                        <td width="25%">{{number_format($total_cr, 2)}}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>