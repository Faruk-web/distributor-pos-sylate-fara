<?php

namespace App\Http\Controllers;

use App\Models\Indirect_incomes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use App\Models\Expense_group;
use App\Models\Expense_transaction;
use App\Models\Ledger_Head;


class IndirectIncomesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('account.indirect.income') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.income.indirect_income_vouchers', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    
    public function indirect_income_vouchers_data(Request $request) {
        if ($request->ajax()) {
            $income_vouchers = Indirect_incomes::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'desc')->get();
            return Datatables::of($income_vouchers)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $info = '<a target="_blank" href="'.route('admin.indirect.incomes.voucher', ['voucher_num'=>$row->voucher_num]).'" class="btn btn-success btn-sm"><i class="fas fa-eye"></i></a>';
                    return $info;
                })
                ->addColumn('added_user', function($row){
                    return optional($row->user_info)->name.' ['.optional($row->user_info)->phone.']';
                })
                ->addColumn('head_name', function($row){
                    return optional($row->head_name)->head_name;
                })
                ->addColumn('voucher_num', function($row){
                    return "#".str_replace("_","/", $row->voucher_num);
                })
                ->addColumn('date', function($row){
                    return date("d-m-Y", strtotime($row->created_at));
                })
                ->rawColumns(['action', 'head_name', 'voucher_num', 'date', 'added_user'])
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
        if(User::checkPermission('account.indirect.income') == true){
            $wing = 'acc_and_tran';
            $expenses_group = Expense_group::where('group_name', 'indirect incomes')->orWhere('group_name', 'direct incomes')->get();
            return view('cms.shop_admin.account_and_transaction.income.add_indirect_income', compact('wing', 'expenses_group'));
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
        if(User::checkPermission('account.indirect.income') == true){
            $validated = $request->validate([
                'amount' => 'required',
                'ledger_head' => 'required',
            ]);
            
            $shop_id = Auth::user()->shop_id;
            $date = $request->date;
            
            $count = Indirect_incomes::where('shop_id', $shop_id)->count('id');
            $update_count = $count + 1;
            $voucher_num = 'OE_'.$shop_id."_".$update_count;
            
            $data = array();
            
            if($request->MFSAccType != '') {
                $data['cheque_or_mfs_acc_bank'] = $request->MFSAccType;
            }
            else {
                $data['cheque_or_mfs_acc_bank'] = $request->Chequebank;
            }
            
            $data['voucher_num'] = $voucher_num;
            $data['shop_id'] = $shop_id;
            $data['user_id'] = Auth::user()->id;
            $data['ledger_head'] = $request->ledger_head;
            $data['cash_or_cheque'] = $request->income_add_by;
            $data['amount'] = $request->amount;
            $data['bank_id'] = $request->Dipositbank;
            $data['cheque_or_mfs_acc_num'] = $request->checkNoOrMFSAccNo;
            $data['cheque_date'] = $request->Chequedate;
            $data['cheque_deposit_date'] = $request->DipositDate;
            $data['note'] = $request->note;
            $data['created_at'] = $request->date;
            
            $insert = Indirect_incomes::insert($data);
            if($insert) {
                $cheque_head = DB::table('ledger__heads')->where('id', $request->ledger_head)->first();
                if($request->income_add_by == 'cash') {
                    $cash_info = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first();
                    $updated_cash = $cash_info->balance + $request->amount;
                    DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_cash]);
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'OE', 'track'=>$voucher_num, 'refference'=>$voucher_num, 'amount'=>$request->amount, 'creadit_or_debit'=>'CR', 'note'=>'New Others Income Added, Ledger Head name: '.$cheque_head->head_name.', Amount: '.$request->amount.', Voucher Num: '.str_replace("_","/", $voucher_num).', Note: '.$request->note.'', 'created_at'=>$date]);
                }
                else if($request->income_add_by == 'cheque'){
                    $bank_info = DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$request->Dipositbank])->first();
                    $updated_bank_balance = $bank_info->balance + $request->amount;
                    DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$bank_info->id])->update(['balance'=>$updated_bank_balance]);
                    DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$request->Dipositbank, 'added_by'=>Auth::user()->id, 'for_what'=>'OE', 'track'=>$voucher_num, 'refference'=>$voucher_num, 'amount'=>$request->amount, 'creadit_or_debit'=>'CR', 'note'=>'New Others Income Added, Ledger Head name: '.$cheque_head->head_name.', Amount: '.$request->amount.', Voucher Num: '.str_replace("_","/", $voucher_num).', Note: '.$request->note.'', 'created_at'=>$date]);
                }
                
                DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Others Income Added, Ledger Head name: '.$cheque_head->head_name.', Amount: '.$request->amount.', Voucher Num: '.str_replace("_","/", $voucher_num).', Note: '.$request->note.'', 'created_at' =>$date]);
                
                return Redirect()->route('admin.indirect.incomes.voucher', ['voucher_num'=>$voucher_num])->with('success', 'Others Income added Successfully.');
                
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured, please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indirect_incomes  $indirect_incomes
     * @return \Illuminate\Http\Response
     */
    public function show($voucher_num)
    {
        if(User::checkPermission('account.indirect.income') == true){
            $shop_id = Auth::user()->shop_id;
            $voucher_info = Indirect_incomes::where(['voucher_num'=>$voucher_num, 'shop_id'=>$shop_id])->first();
            if(!empty($voucher_info->id)) {
                $wing = 'acc_and_tran';
                $shop_info = DB::table('shop_settings')->where('shop_code', $shop_id)->first();
                return view('cms.shop_admin.account_and_transaction.income.indirect_income_voucher', compact('wing', 'shop_info', 'voucher_info'));
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
     * @param  \App\Models\Indirect_incomes  $indirect_incomes
     * @return \Illuminate\Http\Response
     */
    public function edit(Indirect_incomes $indirect_incomes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Indirect_incomes  $indirect_incomes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Indirect_incomes $indirect_incomes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indirect_incomes  $indirect_incomes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indirect_incomes $indirect_incomes)
    {
        //
    }
}
