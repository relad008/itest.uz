<?php

namespace App\Http\Controllers\Backend;

use Upload;
use App\Models\Region;

use App\Models\Review;
use App\Models\University;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        $universities = University::get()->pluck('name_ru', 'id');
        $regions = Region::where('parent_id', 0)->orWhere('id', 2)->get()->pluck('name_ru', 'id');
        return view('backend.review.index', compact('universities', 'regions'));
    }

    public function data(Request $request)
    {
        $data = Review::with('university', 'region');
        return datatables()->of($data)
            ->addColumn('image', function($item) {
                return Upload::getThumbFile('review', $item->id, '300x300');
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
            'name_uz'               => 'nullable|min:2|max:255',
            'comment_ru'            => 'required',
            'comment_uz'            => 'nullable',
            'ball'                  => 'nullable',
            'university_id'         => 'required',
            'region_id'             => 'required'
        ]);
        
        if ($request->id) {
            $item = Review::find($request->id);

            if($item) {
                $item->update($data);
            }

        } else {
            $item = Review::create($data);
        }

        if ($request->hasFile('image')) {
            Upload::saveFile('review', $item->id, $request->file('image'));
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
            $item = Review::find($request->input('id'));

            if ($item) {
                Upload::removeFile('review', $item->id);
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
