<?php

namespace App\Http\Controllers;

use App\Models\Ledger_Head;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use App\Models\Expense_group;

class LedgerHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('account.expense') == true){
            $wing = 'acc_and_tran';
            $expenses_group = Expense_group::all();
            $ledger_heads = Ledger_Head::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.expense.ledger_head', compact('wing', 'ledger_heads', 'expenses_group'));
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
        if(User::checkPermission('account.expense') == true){
            $shop_id = Auth::user()->shop_id;
            $group_id = $request->group_id;
            $head_name = $request->head_name;
            $check_head = DB::table('ledger__heads')->where(['shop_id'=>$shop_id, 'group_id'=>$group_id, 'head_name'=>$head_name])->first();
                    
            if(empty($check_head->id)) {
                $data = array();
                $data['shop_id']= Auth::user()->shop_id;
                $data['group_id']=$group_id;
                $data['head_name']=$head_name;
                $data['created_at']= Carbon::now();
                $insert = DB::table('ledger__heads')->insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Ledger Head (Name: '.$head_name.') Added', 'created_at' => Carbon::now()]);
                    return Redirect()->back()->with('success', 'New Ledger Head Added Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Error Occoured! please try again.');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Sorry This Head is Exist.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ledger_Head  $ledger_Head
     * @return \Illuminate\Http\Response
     */
    public function show(Ledger_Head $ledger_Head)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ledger_Head  $ledger_Head
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('account.expense') == true){
            $wing = 'acc_and_tran';
            $head_info = Ledger_Head::where(['shop_id'=>Auth::user()->shop_id, 'id'=>$id])->first();
            if(!empty($head_info->id)) {
                $expenses_group = Expense_group::all();
                return view('cms.shop_admin.account_and_transaction.expense.edit_ledger_head', compact('wing', 'head_info', 'expenses_group'));
            }
            else {
                return Redirect()->back()->with('error', 'Error occoured! please try agai.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ledger_Head  $ledger_Head
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('account.expense') == true){
            
            $shop_id = Auth::user()->shop_id;
            $group_id = $request->group_id;
            $head_name = $request->head_name;
            $check_head = DB::table('ledger__heads')->where(['shop_id'=>$shop_id, 'group_id'=>$group_id, 'head_name'=>$head_name])->where('id', '!=', $id)->first();
                 
            if(!$check_head) {
                $data = array();
                $data['group_id']=$group_id;
                $data['head_name']=$head_name;
                $data['updated_at'] = Carbon::now();
                $update = Ledger_Head::where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Update Ledger Head (Name: '.$head_name.') Added', 'created_at' => Carbon::now()]);
                    return redirect()->route('admin.account.ledger.heads')->with('success', 'Ledger Head Update Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Head name and Group name is Exist, please try new.');
            }

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ledger_Head  $ledger_Head
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ledger_Head $ledger_Head)
    {
        //
    }
}
