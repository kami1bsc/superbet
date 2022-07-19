<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Month;
use App\Models\Album;
use App\Models\Category;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::orderBy('id', 'desc')->get();

        return view('admin.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $albums = Album::all();
        $categories = Category::all();

        return view('admin.videos.create', compact('albums', 'categories'));
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
            $video = new Video;
            
            if($request->has('category_id') && $request->category_id != null)
            {
                $video->category_id = $request->category_id;
            }

            if($request->has('album_id') && $request->album_id != null)
            {
                $video->album_id = $request->album_id;
            }

            if($request->has('video_title') && $request->video_title != null)
            {
                $video->video_title = $request->video_title;
            }

            if($request->has('video_description') && $request->video_description != null)
            {
                $video->video_description = $request->video_description;
            }

            if($request->has('youtube_url') && $request->youtube_url != null)
            {
                $video->youtube_url = $request->youtube_url;
            }

            if($request->has('spotify_url') && $request->spotify_url != null)
            {
                $video->spotify_url = $request->spotify_url;
            }

            if($request->has('apple_music_url') && $request->apple_music_url != null)
            {
                $video->apple_music_url = $request->apple_music_url;
            }

            if($request->has('amazon_music_url') && $request->amazon_music_url != null)
            {
                $video->amazon_music_url = $request->amazon_music_url;
            }

            if($request->has('lyrics') && $request->lyrics != null)
            {
                $video->lyrics = $request->lyrics;
            }

            if($request->has('poet_name') && $request->poet_name != null)
            {
                $video->poet_name = $request->poet_name;
            }

            if($request->has('preview_url'))
            {
                if($request->preview_url->getClientOriginalExtension() == 'PNG' ||$request->preview_url->getClientOriginalExtension() == 'png' || $request->preview_url->getClientOriginalExtension() == 'JPG' || $request->preview_url->getClientOriginalExtension() == 'jpg' || $request->preview_url->getClientOriginalExtension() == 'jpeg' || $request->preview_url->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->preview_url->getClientOriginalExtension();
                    $request->file('preview_url')->move(public_path("/video_images"), $newfilename);
                    $new_path1 = 'video_images/'.$newfilename;
                    $video->preview_url = $new_path1;
                }else{
                    return back()->with('error', 'Choose a Valid Image');
                }                       
            }

            $video->save();

            return back()->with('message', 'Video Added Successfully');

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
            $video = Video::find($id);

            if(empty($video))
            {
                return back()->with('error', 'Video does not Exists');    
            }

            $albums = Album::all();
            $categories = Category::all();

            return view('admin.videos.edit', compact('albums', 'categories', 'video'));

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
            $video = Video::find($id);
            
            if($request->has('category_id') && $request->category_id != null)
            {
                $video->category_id = $request->category_id;
            }

            if($request->has('album_id') && $request->album_id != null)
            {
                $video->album_id = $request->album_id;
            }

            if($request->has('video_title') && $request->video_title != null)
            {
                $video->video_title = $request->video_title;
            }

            if($request->has('video_description') && $request->video_description != null)
            {
                $video->video_description = $request->video_description;
            }

            if($request->has('youtube_url') && $request->youtube_url != null)
            {
                $video->youtube_url = $request->youtube_url;
            }

            if($request->has('spotify_url') && $request->spotify_url != null)
            {
                $video->spotify_url = $request->spotify_url;
            }

            if($request->has('apple_music_url') && $request->apple_music_url != null)
            {
                $video->apple_music_url = $request->apple_music_url;
            }

            if($request->has('amazon_music_url') && $request->amazon_music_url != null)
            {
                $video->amazon_music_url = $request->amazon_music_url;
            }

            if($request->has('lyrics') && $request->lyrics != null)
            {
                $video->lyrics = $request->lyrics;
            }

            if($request->has('poet_name') && $request->poet_name != null)
            {
                $video->poet_name = $request->poet_name;
            }

            if($request->has('preview_url'))
            {
                if($request->preview_url->getClientOriginalExtension() == 'PNG' ||$request->preview_url->getClientOriginalExtension() == 'png' || $request->preview_url->getClientOriginalExtension() == 'JPG' || $request->preview_url->getClientOriginalExtension() == 'jpg' || $request->preview_url->getClientOriginalExtension() == 'jpeg' || $request->preview_url->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->preview_url->getClientOriginalExtension();
                    $request->file('preview_url')->move(public_path("/video_images"), $newfilename);
                    $new_path1 = 'video_images/'.$newfilename;
                    $video->preview_url = $new_path1;
                }else{
                    return back()->with('error', 'Choose a Valid Image');
                }                       
            }

            $video->save();

            return back()->with('message', 'Video Updated Successfully');

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

    public function delete_video($video_id)
    {
        try{
            $video = Video::find($video_id);

            if(empty($video))
            {
                return back()->with('error', 'Video does not Exists');
            }

            $video->delete();

            return back()->with('message', 'Video Deleted Successfully');
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }
}
