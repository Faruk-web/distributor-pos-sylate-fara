<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('account.bank.and.cash') == true){
            $wing = 'acc_and_tran';
            $banks = Bank::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.bank.all_banks', compact('banks', 'wing'));
            
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
        if(User::checkPermission('account.bank.and.cash') == true){
            $validator = Validator::make($request->all(), [
                'account_no' => 'required|unique:banks',
            ]);
        
            if ($validator->fails()) {
                Alert::error('Error', 'Error occurred!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = array();
            $data['shop_id']= Auth::user()->shop_id;
            $data['bank_name']=$request->bank_name;
            $data['bank_branch']=$request->bank_branch;
            $data['account_no']=$request->account_no;
            $data['account_type']=$request->account_type;
            $data['opening_bl']= 0;
            $data['balance']= 0;
            
            $insert = bank::insert($data);
            if($insert) {
                return Redirect()->back()->with('success', 'New Bank Added Successfully.');
            }
            else {
                Alert::error('Error', 'Error occurred! Please try again.');
                return redirect()->back();
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('account.bank.and.cash') == true){
            $wing = 'acc_and_tran';
            $bank_info = bank::where(['id'=>$id, 'shop_id'=>Auth::user()->shop_id])->first();
            return view('cms.shop_admin.account_and_transaction.bank.edit_bank', compact('bank_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('account.bank.and.cash') == true){
            $check_info = bank::where('account_no', $request->account_no)->where('id', '!=', $id)->first(['id']);
            
            if(empty($check_info->id)) {
                $data = array();
                $data['bank_name']=$request->bank_name;
                $data['bank_branch']=$request->bank_branch;
                $data['account_no']=$request->account_no;
                $data['account_type']=$request->account_type;
                $update_bank = bank::where(['id'=>$id, 'shop_id'=>Auth::user()->shop_id])->update($data);
                if($update_bank) {
                    return redirect()->route('admin.account.transaction.bank')->with('success', 'Bank information update successfully.');
                    
                }
                else {
                    return Redirect()->back()->with('error', 'Error occurred! Please try again');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Sorry this account number is used in another bank.');
            }
            
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy(bank $bank)
    {
        //
    }
}
