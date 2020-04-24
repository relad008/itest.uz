<?php

namespace App\Http\Controllers\Backend;

use Upload;
use DataTables;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('backend.blog.index');
    }

    public function data(Request $request)
    {
        $data = Blog::query();
        return DataTables::of($data)
            ->addColumn('img', function ($blog) {
                return Upload::getFile('blog', $blog->id);
            })
            ->make(true);
    }

    public function form($id = null)
	{
		$entered = $id
			? Blog::findOrFail($id)
			: new Blog;

		$categories = BlogCategory::all();
		$entered_categories = [];

		if ($entered->categories) {
			$entered_categories = $entered->categories->pluck('id')->toArray();
		}

		return view('backend.blog.form', compact('entered', 'categories', 'entered_categories'));
	}
	
	public function handleForm(Request $request, $id = null)
	{
        $request->merge([
            'recommended' => $request->has('recommended')
        ]);

		$data = $request->validate([
			'title'             => 'required',
            'text'              => 'required',
            'recommended'       => 'boolean',
            'lang'              => 'in:uz,ru',
			'meta_description'  => 'nullable|min:50|max:160',
			'meta_keywords'     => 'nullable|max:160',
		]);

        $entered = Blog::find($id);
        
		if ($entered) {
            $entered->update($data);
            session()->flash('success', trans('alert.success.update'));
		} else {
            $data['alias'] = $this->aliasCreate($data['title']);
            $data['user_id'] = auth()->user()->id;
            $entered = Blog::create($data);
            session()->flash('success', trans('alert.success.insert'));
        }

		if (count($request->input('category')) > 0) {
            $entered->categories()->sync($request->input('category'));
        } else {
            $entered->categories()->sync([]);
        }

		if($request->hasFile('photo'))
		{
			Upload::saveFile('blog', $entered->id, $request->file('photo'));
		}

		return redirect()->action('Backend\BlogController@index');
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
            $item = Blog::find($request->input('id'));
            $item->categories()->sync([]);
            Upload::removeFiles('blog', $item->id);
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
	 * Generate alias for SEO URL
     * 
	 * @param  string $value
	 * @return string
	 */
	private function aliasCreate($value)
    {
        $slug = str_slug($value);
        $model = new Blog;
        $slugCount = count($model->whereRaw("alias REGEXP '^{$slug}(-[0-9]+)?$' and id != '{$model->id}'")->get());

        return ($slugCount > 0) ? "{$slug}-{$slugCount}" : $slug;
    }
}
