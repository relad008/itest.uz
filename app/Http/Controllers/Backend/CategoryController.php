<?php

namespace App\Http\Controllers\Backend;

use App\Models\TestCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index($parent_id = 0)
    {
        $breadcrumbs = [
            'links'=>[],
            'active'=> 'Категории'
        ];

		if ($parent_id) {
            $parent = TestCategory::find($parent_id);

			$breadcrumbs['active'] = $parent->name;
			$ids = explode('##', trim($parent->parents, '#'));
			
			if ($ids) {
                $parents = TestCategory::whereIn('id', $ids)
                            ->orderBy('depth')
                            ->get();
                $breadcrumbs['links'][action('\\'.static::class.'@index')] = 'Категории';
                
				foreach($parents as $p) {
					$breadcrumbs['links'][action('\\'.static::class.'@index', [$p->id])] = $p->name;
                }
			}
        }
        
        $categories = TestCategory::where('parent_id', $parent_id)->paginate(30);
        return view('backend.category.index', compact('categories', 'breadcrumbs', 'parent_id'));
    }

    public function form($parent_id = 0, $id = null)
    {
        $cat = null;
        if ($id) {
            $cat = TestCategory::find($id);
        }
        return view('backend.category.form', compact('id', 'parent_id'));
    }

    public function delete($parent_id = 0, $id = null)
    {

    }
}
