<?php

namespace App\Http\Controllers;

use App\Models\BranchToBranchTransfer;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch_setting;
use Illuminate\Support\Facades\Auth;

class BranchToBranchTransferController extends Controller
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
        if(User::checkPermission('admin.products') == true){

            $branches = Branch_setting::Where('shop_id', Auth::user()->shop_id)->get();
            $wing = 'main';
            return view('cms.shop_admin.produts.b_to_b_transfer', compact('wing', 'branches'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function edit(BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BranchToBranchTransfer  $branchToBranchTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy(BranchToBranchTransfer $branchToBranchTransfer)
    {
        //
    }
}
