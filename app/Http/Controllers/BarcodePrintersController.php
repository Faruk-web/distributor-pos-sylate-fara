<?php

namespace App\Http\Controllers;

use App\Models\BarcodePrinters;
use Illuminate\Http\Request;
use DataTables;
use App\Models\User;
use PHPUnit\Framework\TestCase;
use Picqer;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BarcodePrintersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $printers = BarcodePrinters::where('shop_id', Auth::user()->shop_id)->orderBy('id', 'DESC')->get();
            return view('cms.shop_admin.produts.barcode_level_printers', compact('wing', 'printers'));
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
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'DESC')->get(['id', 'branch_name', 'branch_address']);
            return view('cms.shop_admin.produts.barcode_level_printer_add', compact('wing', 'branches'));
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
        if(User::checkPermission('admin.products') == true){
            $shop_id =  Auth::user()->shop_id;
            $code = $request->code;
            $printer = BarcodePrinters::where(['shop_id' => $shop_id, 'code' => $code])->first();
            if(is_null($printer)) {
                $printer = new BarcodePrinters;
                $printer->shop_id = $shop_id;
                $printer->code = $code;
                
            }
            
            $printer->branch_id = $request->branch_id;
            $printer->printer_name = $request->printer_name;
            $printer->page_width = $request->page_width;
            $printer->page_margin_left = $request->page_margin_left;
            $printer->page_margin_right = $request->page_margin_right;
            $printer->page_margin_top = $request->page_margin_top;
            $printer->page_margin_bottom = $request->page_margin_bottom;
            $printer->barcode_row = $request->barcode_in_per_row;
            $printer->barcode_width = $request->barcode_width;
            $printer->barcode_height = $request->barcode_height;
            $printer->barcode_margin_left = $request->barcode_column_margin_left;
            $printer->barcode_margin_right = $request->barcode_column_margin_right;
            $printer->barcode_margin_top = $request->barcode_column_margin_top;
            $printer->barcode_margin_bottom = $request->barcode_column_margin_bottom;
            
            $printer->column1_margin_left = $request->margin_left_for_column1;
            $printer->column1_margin_right = $request->margin_right_for_column1;
            $printer->column1_margin_top = $request->margin_top_for_column1;
            $printer->column1_margin_bottom = $request->margin_bottom_for_column1;
            
            $printer->column2_margin_left = $request->margin_left_for_column2;
            $printer->column2_margin_right = $request->margin_right_for_column2;
            $printer->column2_margin_top = $request->margin_top_for_column2;
            $printer->column2_margin_bottom = $request->margin_bottom_for_column2;
            
            $printer->column3_margin_left = $request->margin_left_for_column3;
            $printer->column3_margin_right = $request->margin_right_for_column3;
            $printer->column3_margin_top = $request->margin_top_for_column3;
            $printer->column3_margin_bottom = $request->margin_bottom_for_column3;
            
            $printer->column4_margin_left = $request->margin_left_for_column4;
            $printer->column4_margin_right = $request->margin_right_for_column4;
            $printer->column4_margin_top = $request->margin_top_for_column4;
            $printer->column4_margin_bottom = $request->margin_bottom_for_column4;
            
            $printer->column5_margin_left = $request->margin_left_for_column5;
            $printer->column5_margin_right = $request->margin_right_for_column5;
            $printer->column5_margin_top = $request->margin_top_for_column5;
            $printer->column5_margin_bottom = $request->margin_bottom_for_column5;
            
            $printer->barcode_image_height = $request->image_height;
            $printer->text_size = $request->text_size;
            $printer->note = $request->note;
            
            $status = $printer->save();
            $output = '';
            if($status) {
                $output = [
                        'status' => 'yes',
                    ];
            }
            else {
                $output = [
                        'status' => 'no',
                    ];
            }
            
            return Response($output);
              
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarcodePrinters  $barcodePrinters
     * @return \Illuminate\Http\Response
     */
    public function show(BarcodePrinters $barcodePrinters)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarcodePrinters  $barcodePrinters
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('admin.products') == true){
            $wing = 'main';
            $printer = BarcodePrinters::where('shop_id', Auth::user()->shop_id)->where('id', $id)->first();
            $branches = DB::table('branch_settings')->where('shop_id', Auth::user()->shop_id)->orderBy('id', 'DESC')->get(['id', 'branch_name', 'branch_address']);
            return view('cms.shop_admin.produts.barcode_level_printers_edit', compact('wing', 'printer', 'branches'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarcodePrinters  $barcodePrinters
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarcodePrinters $barcodePrinters)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarcodePrinters  $barcodePrinters
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarcodePrinters $barcodePrinters)
    {
        //
    }
}
