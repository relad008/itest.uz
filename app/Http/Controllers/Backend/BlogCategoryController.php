<?php

namespace App\Http\Controllers\Backend;

use DataTables;
use App\Models\BlogCategory;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogCategoryController extends Controller
{
    public function index()
    {
        return view('backend.blog-category.index');
    }

    public function data(Request $request)
    {
        $data = BlogCategory::query();
        return DataTables::of($data)
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
            'meta_description_ru'   => 'nullable|min:50|max:160',
			'meta_description_uz'   => 'nullable|min:50|max:160',
			'meta_keywords_ru'      => 'nullable|max:160',
			'meta_keywords_uz'      => 'nullable|max:160',
        ]);
        
        if ($request->id) {
            $item = BlogCategory::find($request->id);

            if($item) {
                $item->update($data);
            }

        } else {
            $data['alias'] = $this->aliasCreate($data['name_ru']);
            $item = BlogCategory::create($data);
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
            $item = BlogCategory::find($request->input('id'));
            $item->blogs()->sync([]);
            $item->delete();

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

    /**
	 * Alias Create
     * 
	 * @param  string $value
	 * @return string       
	 */
	private function aliasCreate($value)
    {
        $slug = str_slug($value);
        $model = new BlogCategory;
        $slugCount = count($model->whereRaw("alias REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
