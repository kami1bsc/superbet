<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MonthKalam;
use App\Models\Video;
use App\Models\Month;

class MonthKalamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = MonthKalam::all();
        
        return view('admin.months.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vids = MonthKalam::pluck('video_id');

        $videos = Video::whereNotIn('id', $vids)->get();

        return view('admin.months.create', compact('videos'));
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
            $kalam = new MonthKalam;
            
            if($request->has('video_id') && $request->video_id != null)
            {
                $kalam->video_id = $request->video_id;
            }

            $kalam->save();

            return back()->with('message', 'Video Added to Month Kalam Section');

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $video = MonthKalam::find($id);

        $video->delete();

        return back()->with('message', 'Video Removed from Month Kalam Section');
    }

    public function month()
    {
        $month = Month::all();

        return view('admin.months.month', compact('month'));
    }

    public function edit_month($month_id)
    {
        $month = Month::find($month_id);

        return view('admin.months.edit_month', compact('month'));
    }

    public function update_month(Request $request)
    {
        try{
            // dd($request->all());
            $month = Month::find($request->month_id);

            if($request->has('month_name') && $request->month_name != null)
            {
                $month->month_name = $request->month_name;
            }

            if($request->has('is_active'))
            {
                $month->is_active = $request->is_active;
            }

            $month->save();

            return back()->with('message', 'Month Updated');
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }    
}
