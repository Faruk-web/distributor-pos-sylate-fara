<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use DataTables;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(User::checkPermission('admin.area') == true){
            $wing = 'main';
            return view('cms.shop_admin.area.index', compact('wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    public function index_data(Request $request) {
        if ($request->ajax()) {
            $area = Area::orderBy('id', 'DESC')->get();
            return Datatables::of($area)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('admin.edit.area', ['id'=>$row->id]).'" class="btn btn-success btn-sm btn-rounded">edit</a>';
                })
                ->rawColumns(['action'])
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
        if(User::checkPermission('admin.area') == true){
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:areas',
            ]);
        
            if ($validator->fails()) {
                Alert::error('Error', 'Area is exist!');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $area = new Area;
            $area->name = $request->name;
            $area->shop_id = Auth::user()->shop_id;
            $insert = $area->save();

            if($insert) {
                return Redirect()->back()->with('success', 'New Area Added Successfully.');
            }
            else {
                return redirect()->back()->with('error', 'Error occurred! Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(User::checkPermission('account.bank.and.cash') == true){
            $wing = 'main';
            $area_info = Area::find($id);
            if(is_null($area_info)) {
                return Redirect()->back()->with('error', 'No Area Found!!!');
            }
            return view('cms.shop_admin.area.edit', compact('area_info', 'wing'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(User::checkPermission('admin.area') == true){
            $check_area = Area::Where('name', $request->name)->where('id', '!=', $id)->first();
            if(!is_null($check_area)) {
                return Redirect()->back()->with('error', 'Area name is exist');
            }

            $area = Area::find($id);
            $area->name = $request->name;
            $update = $area->update();
            
            if($update) {
                return redirect()->route('admin.all.area')->with('success', 'Area Info Update Successfully.');
            }
            else {
                return redirect()->back()->with('error', 'Error occurred! Please try again.');
            }
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }
}
