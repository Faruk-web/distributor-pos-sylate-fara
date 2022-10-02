<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tutorial = Tutorial::orderby('active', 'desc')->get();
        return view('cms.super_admin.all_tutorials', compact('tutorial'));
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
        $link = str_replace(['https://youtu.be/', 'https://www.youtube.com/embed/', 'https://www.youtube.com/watch?v='], 'https://www.youtube.com/embed/', $request->link);
        
        $data = array();
        $data['title'] = $request->title;
        $data['link'] = $link;
        $data['active'] = $request->serial_num;
        $data['created_at'] = Carbon::now();
        $insert = DB::table('tutorials')->insert($data);
        if($insert) {
            return redirect()->back()->with('success', 'New Tutorial has been Added.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function show(tutorial $tutorial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tutorial_info = Tutorial::where('id', $id)->first();
        return view('cms.super_admin.edit_tutorials', compact('tutorial_info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // dd($request);
        $link = str_replace(['https://youtu.be/', 'https://www.youtube.com/embed/', 'https://www.youtube.com/watch?v='], 'https://www.youtube.com/embed/', $request->link);
        
        $data = array();
        $data['title'] = $request->title;
        $data['link'] = $link;
        $data['active'] = $request->serial_num;
        $update = DB::table('tutorials')->where('id', $id)->update($data);
        if($update) {
            return redirect()->route('super_admin.tutorials')->with('success', 'Tutorial has been Updated.');
        }
        else {
            return Redirect()->back()->with('error', 'Something is wrong, please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function destroy(tutorial $tutorial)
    {
        //
    }
}
