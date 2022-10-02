<?php

namespace App\Http\Controllers;

use App\Models\Loan_person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Carbon;
use DataTables;
use Illuminate\Support\Facades\Validator;

class LoanPersonController extends Controller
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
            $loan_persons = Loan_person::where('shop_id', Auth::user()->shop_id)->get();
            return view('cms.shop_admin.account_and_transaction.loan.loan_person', compact('wing', 'loan_persons'));
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
        if(User::checkPermission('account.loan') == true){
            $shop_id = Auth::user()->shop_id;
            $phone = $request->phone;
            $email = $request->email;

            $loan_person = DB::table('loan_people')
                    ->where('shop_id', '=', $shop_id)
                    ->where(function ($query) use ($phone, $email) {
                        $query->where('phone', '=', $phone)
                                ->orWhere('email', '=', $email);
                    })->first(['id', 'name']);
            
            if(empty($loan_person->id)) {
                $data = array();
                $data['shop_id']= Auth::user()->shop_id;
                $data['name']=$request->name;
                $data['phone']=$request->phone;
                $data['email']=$request->email;
                $data['address']=$request->address;
                $data['opening_balance'] = 0;
                $data['balance'] = 0;
                $data['created_at']= Carbon::now();
                $insert = DB::table('loan_people')->insert($data);
                if($insert) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'New Loan Person (Name: '.$request->name.', Phone: '.$phone.') Added', 'created_at' => Carbon::now()]);
                    return Redirect()->back()->with('success', 'New Loan Person Added Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Sorry you can not access this page');
                }
            }
            else {
                return Redirect()->back()->with('error', 'Sorry This person is exist. name: '.$loan_person->name.'');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan_person  $loan_person
     * @return \Illuminate\Http\Response
     */
    public function show(Loan_person $loan_person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan_person  $loan_person
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('account.loan') == true){
            $wing = 'acc_and_tran';
            $loan_person = Loan_person::where(['shop_id'=>Auth::user()->shop_id, 'id'=>$id])->first();
            if(!empty($loan_person->id)) {
                return view('cms.shop_admin.account_and_transaction.loan.edit_loan_person', compact('wing', 'loan_person'));
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
     * @param  \App\Models\Loan_person  $loan_person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('account.loan') == true){
            
            $phone = $request->phone;
            $email = $request->email;
            $shop_id = Auth::user()->shop_id;

            $loan_person = DB::table('loan_people')
                    ->where('id', '!=', $id)
                    ->where('shop_id', '=', $shop_id)
                    ->where(function ($query) use ($phone, $email) {
                        $query->where('phone', '=', $phone)
                                ->orWhere('email', '=', $email);
                    })
                    ->first();

            if(!$loan_person) {
                $data = array();
                $data['name'] = $request->name;
                $data['phone'] = $phone;
                $data['email'] = $email;
                $data['address'] = $request->address;
                $data['updated_at'] = Carbon::now();

                $update = Loan_person::where('id', $id)->update($data);
                if($update) {
                    DB::table('moments_traffics')->insert(['shop_id' => $shop_id, 'user_id' => Auth::user()->id, 'info' => 'Updated Loan Person(Name: '.$request->name.', Phone: '.$phone.')', 'created_at' => Carbon::now()]);
                    return redirect()->route('admin.account.loan.person')->with('success', 'Loan Person Update Successfully.');
                }
                else {
                    return Redirect()->back()->with('error', 'Something is wrong, please try again.');
                }
            
            }
            else {
                return Redirect()->back()->with('error', 'Email or Phone is Exist, please try new.');
            }

        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan_person  $loan_person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan_person $loan_person)
    {
        //
    }
}
