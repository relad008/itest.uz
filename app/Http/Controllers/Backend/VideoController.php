<?php

namespace App\Http\Controllers\Backend;

use Upload;
use DataTables;
use App\Models\Video;
use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoController extends Controller
{
    public function index()
    {
        $categories = TestCategory::where('depth', 0)->get()->pluck('name_ru', 'id');
        return view('backend.video.index', compact('categories'));
    }

    public function data(Request $request)
    {
        $data = Video::with('user');
        return DataTables::of($data)
            ->addColumn('video_image', function($item) {
                return Upload::getFile('video-image', $item->id);
            })
            ->make(true);
    }

    /**
     * Create and update
     * 
     * @param  Request $request
     * @return json
     */
    public function form(Request $request)
    {
        $data = $request->validate([
            'name_ru'               => 'required|min:2|max:255',
            'name_uz'               => 'required|min:2|max:255',
            'description_ru'        => 'nullable',
            'description_uz'        => 'nullable',
            'url'                   => 'required|url',
            'category_id'           => 'required',
            'tags'                  => 'nullable'
        ]);
        
        if ($request->id) {
            $item = Video::find($request->id);

            if($item) {
                $item->update($data);
            }

        } else {
            $data['user_id'] = $request->user()->id;
            $item = Video::create($data);
        }

        if ($request->hasFile('image')) {
            Upload::saveFile('video-image', $item->id, $request->file('image'));
        }
        
        return response()->json(['status' => 'success']);
    }

    /**
     * Delete
     * 
     * @param  Request $request
     * @return json           
     */
    public function delete(Request $request)
    {
        if ($request->has('id')) {
            $item = Video::find($request->input('id'));

            if ($item) {
                Upload::removeFile('video-image', $item->id);
                $item->delete();
            }

            $response = [
                'status' => 'success',
                'message' => trans('alert.success.delete')
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Пожалуйста попробуйте снова'
            ];
        }
        
        return response()->json($response);
    }
}
