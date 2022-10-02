<?php

namespace App\Http\Controllers;

use App\Models\SMS_settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SMSSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->type == 'super_admin') {
           $info = SMS_settings::first();
           return view('cms.super_admin.sms.settings', compact('info'));
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
        if(Auth::user()->type == 'super_admin') {
           $info = SMS_settings::first();
           if(!empty($info->id)) {
               $update = SMS_settings::where('id', $info->id)->update( ['masking_price' => $request->masking_price, 'non_masking_price' => $request->non_masking_price]);
               if($update) {
                   return Redirect()->back()->with('success', 'Settings Update Successfully.');
               }
               else {
                   return Redirect()->back()->with('error', 'Error Occoured, please try again.');
               }
           }
           else {
               $insert = SMS_settings::insert( ['masking_price' => $request->masking_price, 'non_masking_price' => $request->non_masking_price]);
               if($insert) {
                   return Redirect()->back()->with('success', 'Settings Insert Successfully.');
               }
               else {
                   return Redirect()->back()->with('error', 'Error Occoured, please try again.');
               }
           }
           
           
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SMS_settings  $sMS_settings
     * @return \Illuminate\Http\Response
     */
    public function show(SMS_settings $sMS_settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SMS_settings  $sMS_settings
     * @return \Illuminate\Http\Response
     */
    public function edit(SMS_settings $sMS_settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SMS_settings  $sMS_settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SMS_settings $sMS_settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SMS_settings  $sMS_settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(SMS_settings $sMS_settings)
    {
        //
    }
}
