<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MajlisUpdate;
class MajlisUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $majlises = MajlisUpdate::orderBy('id', 'desc')->get();

        return view('admin.majlises.index', compact('majlises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.majlises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $majlis = new MajlisUpdate;
            
            if($request->has('title') && $request->title != null)
            {
                $majlis->title = $request->title;
            }

            if($request->has('description') && $request->description != null)
            {
                $majlis->description = $request->description;
            }

            if($request->has('address') && $request->address != null)
            {
                $majlis->address = $request->address;
            }

            if($request->has('date_time') && $request->date_time != null)
            {
                $majlis->date_time = $request->date_time;
            }

            if($request->has('banner_image'))
            {
                if($request->banner_image->getClientOriginalExtension() == 'PNG' ||$request->banner_image->getClientOriginalExtension() == 'png' || $request->banner_image->getClientOriginalExtension() == 'JPG' || $request->banner_image->getClientOriginalExtension() == 'jpg' || $request->banner_image->getClientOriginalExtension() == 'jpeg' || $request->banner_image->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->banner_image->getClientOriginalExtension();
                    $request->file('banner_image')->move(public_path("/banner_images"), $newfilename);
                    $new_path1 = 'banner_images/'.$newfilename;
                    $majlis->banner_image = $new_path1;
                }else{
                    return back()->with('error', 'Choose a Valid Image');
                }                       
            }

            $majlis->save();

            return back()->with('message', 'Majlis Data Added Successfully');
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $majlis = MajlisUpdate::find($id);

            if(empty($majlis))
            {
                return back()->with('error', 'Majlis does not Exists');    
            }

            return view('admin.majlises.edit', compact('majlis'));
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $majlis = MajlisUpdate::find($id);
            
            if($request->has('title') && $request->title != null)
            {
                $majlis->title = $request->title;
            }

            if($request->has('description') && $request->description != null)
            {
                $majlis->description = $request->description;
            }

            if($request->has('address') && $request->address != null)
            {
                $majlis->address = $request->address;
            }

            if($request->has('date_time') && $request->date_time != null)
            {
                $majlis->date_time = $request->date_time;
            }

            if($request->has('banner_image'))
            {
                if($request->banner_image->getClientOriginalExtension() == 'PNG' ||$request->banner_image->getClientOriginalExtension() == 'png' || $request->banner_image->getClientOriginalExtension() == 'JPG' || $request->banner_image->getClientOriginalExtension() == 'jpg' || $request->banner_image->getClientOriginalExtension() == 'jpeg' || $request->banner_image->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->banner_image->getClientOriginalExtension();
                    $request->file('banner_image')->move(public_path("/banner_images"), $newfilename);
                    $new_path1 = 'banner_images/'.$newfilename;
                    $majlis->banner_image = $new_path1;
                }else{
                    return back()->with('error', 'Choose a Valid Image');
                }                       
            }

            $majlis->save();

            return back()->with('message', 'Majlis Data Updated Successfully');
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function delete_majlis($majlis_id)
    {
        $majlis = MajlisUpdate::find($majlis_id);

        if(empty($majlis))
        {
            return back()->with('error', 'Majlis does not Exists');
        }

        $majlis->delete();
        
        return back()->with('message', 'Majlis Data Deleted Successfully');
    }
}
