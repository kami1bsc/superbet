<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TopSection;
use App\Models\Video;

class TopSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = TopSection::all();

        return view('admin.tops.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tops = TopSection::pluck('video_id');

        $videos = Video::whereNotIn('id', $tops)->get();

        return view('admin.tops.create', compact('videos'));
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
            $top = new TopSection;
            
            if($request->has('video_id') && $request->video_id != null)
            {
                $top->video_id = $request->video_id;
            }

            $top->save();

            return back()->with('message', 'Video Added to Top Section');

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
        $top = TopSection::find($id);
        
        $top->delete();

        return back()->with('message', 'Video Removed from Top Section');
    }
}
