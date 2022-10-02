<?php

namespace App\Http\Controllers;

use App\Models\Contra;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use DataTables;

class ContraController extends Controller
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
            return view('cms.shop_admin.account_and_transaction.contra.contra_list', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function contra_list_data(Request $request) {
        if ($request->ajax()) {
            $contra = Contra::where(['shop_id'=>Auth::user()->shop_id])->orderBy('id', 'desc')->get();
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
                    return '# '.str_replace("_","/", $row->voucher_number);
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(User::checkPermission('account.transaction') == true){
            $wing = 'acc_and_tran';
            return view('cms.shop_admin.account_and_transaction.contra.add_contra', compact('wing'));
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
        if(User::checkPermission('account.transaction') == true){
            $contra_by = $request->contra_by;
            $shop_id = Auth::user()->shop_id;
            $count = DB::table('contras')->where('shop_id', $shop_id)->count('id');
            $count = $count+1;
            $voucher_num = "CONTRA".$shop_id."_".$count;
            $user_id = Auth::user()->id;

            if($contra_by == 'CTB') {
                $exist_cash = optional(Auth::user()->shop_cash)->balance+0;
                $paid = $request->cash_to_bank_paid;
                $place_bank = $request->cash_to_bank_bank;
                $check_bank = DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$place_bank])->first(['id', 'balance']);
                if($exist_cash >= $paid && !empty($check_bank->id)) {
                    $insert = Contra::insert(['voucher_number'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>$user_id, 'CTB_or_BTC'=>$contra_by, 'sender'=>'cash', 'receiver'=>$place_bank, 'contra_amount'=>$paid, 'note'=>$request->note, 'created_at'=>$request->date]);
                    if($insert) {
                        $updated_cash = $exist_cash - $paid;
                        $update_bank_balance = $check_bank->balance + $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_cash]);
                        DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$place_bank])->update(['balance'=>$update_bank_balance]);
                        DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>'cash', 'added_by'=>Auth::user()->id, 'for_what'=>'CONTRA', 'track'=>$contra_by, 'refference'=>$voucher_num, 'amount'=>$paid, 'creadit_or_debit'=>'CONTRA', 'note'=>'Balance Transfer Cash to bank', 'created_at'=>Carbon::now()]);
                        DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Balance Transfer Cash To Bank, Tracking Num: # '.str_replace("_","/", $voucher_num).', Amount: '.$paid.'', 'created_at' =>Carbon::now()]);
                        return Redirect()->route('admin.contra.list')->with('success', 'New Contra Added Successfully.');
                    }
                    else {
                        return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
                    }
                }
                else {
                    return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
                }

            }
            else if($contra_by == 'BTC') {
                $paid = $request->bank_to_cash_paid;
                $from_bank = $request->bank_to_cash_bank;
                $check_bank = DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$from_bank])->first(['id', 'balance']);
                if($check_bank->balance >= $paid) {
                    $insert = Contra::insert(['voucher_number'=>$voucher_num, 'shop_id'=>$shop_id, 'user_id'=>$user_id, 'CTB_or_BTC'=>$contra_by, 'sender'=>$from_bank, 'receiver'=>'cash', 'contra_amount'=>$paid, 'note'=>$request->note, 'created_at'=>$request->date]);
                    if($insert) {
                        $cash_info = DB::table('net_cash_bls')->where('shop_id', $shop_id)->first('balance');
                        $updated_cash = $cash_info->balance + $paid;
                        $update_bank_balance = $check_bank->balance - $paid;
                        DB::table('net_cash_bls')->where('shop_id', $shop_id)->update(['balance'=>$updated_cash]);
                        DB::table('banks')->where(['shop_id'=>$shop_id, 'id'=>$from_bank])->update(['balance'=>$update_bank_balance]);
                        DB::table('transactions')->insert(['shop_id'=>$shop_id, 'cash_or_bank'=>$from_bank, 'added_by'=>Auth::user()->id, 'for_what'=>'CONTRA', 'track'=>$contra_by, 'refference'=>$voucher_num, 'amount'=>$paid, 'creadit_or_debit'=>'CONTRA', 'note'=>'Balance Transfer bank to cash', 'created_at'=>Carbon::now()]);
                        DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Balance Transfer Bank To Cash, Tracking Num: # '.str_replace("_","/", $voucher_num).', Amount: '.$paid.'', 'created_at' =>Carbon::now()]);
                        return Redirect()->route('admin.contra.list')->with('success', 'New Contra Added Successfully.');
                    }
                    else {
                        return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
                    }
                }
                else {
                    return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Error Occoured, Please Try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contra  $contra
     * @return \Illuminate\Http\Response
     */
    public function show(Contra $contra)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contra  $contra
     * @return \Illuminate\Http\Response
     */
    public function edit(Contra $contra)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contra  $contra
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contra $contra)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contra  $contra
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contra $contra)
    {
        //
    }
}
