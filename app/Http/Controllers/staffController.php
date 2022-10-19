<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Area;
use App\Models\StaffInOutDetails;
use Illuminate\Support\Carbon;
use DataTables;

class staffController extends Controller
{
     // Staff Start

     public function staff_index()
     {
         if(User::checkPermission('account.report') == true){  
             $wing = 'acc_and_tran';
             $areas = Area::all();
             $users = User::where('is_employee','0')->get();
            //  dd($users);
             return view('cms.shop_admin.staff.index', compact('areas', 'wing','users'));
         }
         else {
             return Redirect()->back()->with('error', 'Sorry you can not access this page');
         }
     }

     public function create()
     {
         if(User::checkPermission('account.report') == true){  
             $wing = 'acc_and_tran';
             $areas = Area::all();
             $users = User::where('is_employee','0')->get();
            //  dd($users);
             return view('cms.shop_admin.staff.create', compact('areas', 'wing','users'));
         }
         else {
             return Redirect()->back()->with('error', 'Sorry you can not access this page');
         }
     }
  
//staff data fache
     public function staff_index_data(Request $request) {
        if ($request->ajax()) {
            $area = User::where('is_employee','0')->orderBy('id', 'DESC')->get();
            return Datatables::of($area)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('admin.edit.staff', ['id'=>$row->id]).'" class="btn btn-success btn-sm btn-rounded">Make Staff</a>';
                })

                ->addColumn('area', function($row){
                    return optional(DB::table('areas')->where('id', $row->sr_area_id)->first())->name;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
    //staff all data fache
    public function staff_data(Request $request) {
        if ($request->ajax()) {
            $area = User::where('is_employee','1')->orderBy('id', 'DESC')->get();
            return Datatables::of($area)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.route('admin.edit.staff', ['id'=>$row->id]).'" class="btn btn-success btn-sm btn-rounded">Change Info</a>';
                })

                ->addColumn('area', function($row){
                    return optional(DB::table('areas')->where('id', $row->sr_area_id)->first())->name;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function staff_edit($id)
    {
        if(User::checkPermission('admin.sr') == true){
            $wing = 'acc_and_tran';
            $staff_info = User::find($id);
            if(is_null($staff_info)) {
                return Redirect()->back()->with('error', 'No Staff found!!!');
            }
            $areas = Area::all();
            return view('cms.shop_admin.staff.edit', compact('staff_info', 'wing', 'areas'));
        }
        else {
            return Redirect()->back()->with('error', 'Sorry you can not access this page');
        }
    }
    public function staff_update(Request $request, $id)
    {
        if(User::checkPermission('admin.sr') == true){
            $sr_info = User::find($id);
            $data = array();
            $data['is_employee']=$request->is_employee;
            $data['sallery']=$request->sallery;
            $update_staff = User::where('id', $id)->update($data);

            if($update_staff) {
                Alert::success('Success', 'Staff Info Update Successfully.');
                return redirect()->route('admin.all.staff');
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
   //=================================== help wedding==============================
        public function staff_attendance_details() {

            if(User::checkPermission('account.report') == true){  
                $wing = 'acc_and_tran';
                User::addAttendance();
               return view('cms.shop_admin.staff.staff_attendance_details',compact('wing'));
            }
            else {
                return Redirect()->back()->with('error', 'Sorry you can not access this page');
            }
        }
        //data fache
        public function staff_attendance_details_data(Request $request)
        {
             if ($request->ajax()) {
            $data = StaffInOutDetails::OrderBy('id', 'DESC')->get();
            return Datatables::of($data)
            ->addIndexColumn()
                ->addColumn('name', function($row){
                      return optional($row->staffInfo)->name;
                })
                ->addColumn('date', function($row){
                    return date('d-m-Y', strtotime(optional($row)->date));
                })
                ->addColumn('time', function($row){
                    return date("g:i a", strtotime(optional($row)->time));
                })
                
                ->rawColumns(['name', 'time','date'])
                        ->make(true);
        }  
        }
     
}
