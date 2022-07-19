<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Album;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::orderBy('id', 'desc')->get();

        return view('admin.albums.index', compact('albums'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.albums.create');
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
            $album = new Album;

            if($request->has('album_name') && $request->album_name != null)
            {
                $album->album_name = $request->album_name;
            }

            if($request->has('album_image'))
            {
                if($request->album_image->getClientOriginalExtension() == 'PNG' ||$request->album_image->getClientOriginalExtension() == 'png' || $request->album_image->getClientOriginalExtension() == 'JPG' || $request->album_image->getClientOriginalExtension() == 'jpg' || $request->album_image->getClientOriginalExtension() == 'jpeg' || $request->album_image->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->album_image->getClientOriginalExtension();
                    $request->file('album_image')->move(public_path("/album_images"), $newfilename);
                    $new_path1 = 'album_images/'.$newfilename;
                    $album->album_image = $new_path1;
                }else{
                    return back()->with('error', 'Choose a Valid Image');
                }                       
            }

            if($request->has('released_year') && $request->released_year != null)
            {
                $album->released_year = $request->released_year;
            }

            if($request->has('album_type') && $request->album_type != null)
            {
                $album->album_type = $request->album_type;
            }

            $album->save();

            return back()->with('message', 'Album Added Successfully');
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
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
        $album = Album::find($id);

        if(empty($album))
        {
            return back()->with('error', 'Album does not Exists');
        }

        return view('admin.albums.edit', compact('album'));
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
            $album = Album::find($id);

            if(empty($album))
            {
                return back()->with('error', 'Album does not Exists');
            }

            if($request->has('album_name') && $request->album_name != null)
            {
                $album->album_name = $request->album_name;
            }

            if($request->has('album_image'))
            {
                if($request->album_image->getClientOriginalExtension() == 'PNG' ||$request->album_image->getClientOriginalExtension() == 'png' || $request->album_image->getClientOriginalExtension() == 'JPG' || $request->album_image->getClientOriginalExtension() == 'jpg' || $request->album_image->getClientOriginalExtension() == 'jpeg' || $request->album_image->getClientOriginalExtension() == 'JPEG')
                {
                    $newfilename = md5(mt_rand()) .'.'. $request->album_image->getClientOriginalExtension();
                    $request->file('album_image')->move(public_path("/album_images"), $newfilename);
                    $new_path1 = 'album_images/'.$newfilename;
                    $album->album_image = $new_path1;
                }else{
                    return back()->with('error', 'Choose a Valid Image');
                }                       
            }

            if($request->has('released_year') && $request->released_year != null)
            {
                $album->released_year = $request->released_year;
            }

            if($request->has('album_type') && $request->album_type != null)
            {
                $album->album_type = $request->album_type;
            }

            $album->save();

            return back()->with('message', 'Album Updated Successfully');
        }catch(\Exception $e)
        {
            return response()->json([
                'status' => false,
                'message' => 'There is some trouble to proceed your action',
            ], 200);
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

    public function delete_album($album_id)
    {
        try{
            $album = Album::where('id', $album_id)->first();
            if(empty($album))
            {
                return back()->with('error', 'Album does not Exists');    
            }

            $album->delete();

            return back()->with('message', 'Album Deleted');
        }catch(\Exception $e)
        {
            return back()->with('error', 'There is some trouble to proceed your action');
        }
    }
}
