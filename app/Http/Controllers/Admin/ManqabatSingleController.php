<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManqabatSingle;
use App\Models\Album;
use App\Models\Video;

class ManqabatSingleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = ManqabatSingle::all();

        return view('admin.manqabat_singles.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vids = ManqabatSingle::pluck('video_id');
        $albums = Album::where('album_type', 'Manqabat')->pluck('id');

        $videos = Video::whereNotIn('id', $vids)->whereIn('album_id', $albums)->get();
        
        return view('admin.manqabat_singles.create', compact('videos'));
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
            $video = new ManqabatSingle;

            if($request->video_id == null)
            {
                return back()->with('error', 'Select a Video Title');
            }

            $video->video_id = $request->video_id;
            $video->save();

            return back()->with('message', 'Video Added to Manqabat Singles'); 
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
        $video = ManqabatSingle::find($id);

        $video->delete();

        return back()->with('message', 'Video Removed from Manqabat Singles');
    }
}
