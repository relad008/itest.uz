<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Video;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index()
    {
        $subjects = TestCategory::where('depth', 0)->get();
        $videos = Video::latest();
        
        if (request()->has('category_id')) {
            $videos->where('category_id', request()->input('category_id'));
        }

        $videos = $videos->paginate(18);
        return view('frontend.video.index', compact('videos', 'subjects'));
    }

    public function show($id)
    {
        $video = Video::findOrFail($id);
        $relatives = Video::where('id', '!=', $video->id)->limit(4)->get();
        return view('frontend.video.show', compact('video', 'relatives'));
    }
}
