<?php

namespace App\Http\Controllers\Backend;

use App\Models\Text;
use App\Models\Theme;
use App\Models\TestCategory;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class QuestionController extends Controller
{
    /**
     * Questions
     *
     * @param string $filter
     * @return \Illuminate\Http\Response
     */
    public function index($filter = 'mine')
	{
        $q = TestQuestion::select('*')
                         ->with('creator')
                         ->orderBy('id','desc');
		$categories = [];
		$filter_arr = [$filter];
		$questions = [];
		$paginate = [];
		if ($filter == 'duplicate') {
			// 'select count(*), GROUP_CONCAT(id SEPARATOR ',') from `test_test_questions` where `creator_id` = 7 GROUP BY CONCAT(A,B,C,D) having count(id) >1'
			$quests = TestQuestion::select(DB::raw('count(*) as count,group_concat(id separator "|") as ids'))->having(DB::raw('count(*)'),'>','1')->where('creator_id','=', auth()->user()->id)->groupBy(DB::raw('concat(A,B,C,D)'))->paginate(10);
			$ids = [];
			foreach ($quests as $ind => $q) {
				$ids = array_merge($ids, explode('|', $q->ids));
            }
			$questions = TestQuestion::whereIn('id',$ids)->orderBy(DB::raw('concat(A,B,C,D)'))->get();
			$paginate = $quests;

        }
        else {

            switch ($filter) {
                case 'not_mine':
                case 'mine':
                case 'all':
                    if (!auth()->user()->hasRole(['admin'])) {
                        $q->where(function ($q) {
                            $q->where('parents', 'like', '#'.auth()->user()->category_id.'#%')->orWhere('category_id',Auth::user()->category_id);
                        });
                    }
                    if ($filter!='all') {
                        $q->where('creator_id', ($filter == 'not_mine' ? '!=' : '='), auth()->user()->id);
                    }
                break;

                case 'duplicate_a':
                    $q->whereRaw('(BINARY B=A or BINARY  C=A or BINARY  D=A or BINARY  C=B or BINARY  D=B or BINARY  D=C )');
                break;

                case 'category':
                case 'theme':
                    $parents_arr = func_get_args();
                    if (!auth()->user()->hasRole(['admin'])) {
                        $parents_arr[0] = auth()->user()->category_id;
                    }
                    else {
                        array_shift($parents_arr);
                    }

                    // \Log::info($parents_arr);
                    $parents = '';

                    if ($parents_arr) {
                        $parents='#'.implode('##', $parents_arr).'#';
                    }

                    if ($filter=='category') {
                        $categories = TestCategory::where('parents', $parents)->get();
                        $q->where('parents','like','%'.$parents.'%');
                    }
                    else {
                        $categories = Theme::where('parents', $parents)->get();
                        $q->where('t_parents', 'like', '%'.$parents.'%');
                    }

                    $filter_arr = $parents_arr;
                    $filter_arr[0] = $filter;
                    break;

                default:
                break;
            }

		    $questions = $q->paginate(20);
		    $paginate = $questions;
        }
		$texts = Text::select('id', 'name');

		if (!auth()->user()->hasRole(['admin'])) {
			$texts = $texts->where('category_id', auth()->user()->category_id);
        }
        $texts = $texts->get();
        
        return view('backend.question.index', compact(
            'paginate',
            'questions',
            'filter_arr',
            'texts',
            'categories'
        ));
    }
    
    /**
     * Find a question
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function findQuestion(Request $request)
	{
		$word = $request->input('search','');
		$word = '%'.preg_replace('/[\s]+/', '%', trim($word)).'%';
		// echo $word;
        $q = TestQuestion::select('*')
                         ->with('creator')
                         ->orderBy('id','desc')
                         ->where(function($q) use($word) {
                            $q->orWhere('description', 'like', $word);

                            foreach(['A','B','C','D'] as $ind => $val) {
                                $q->orWhere($val, 'like', $word);
                            }
                        });
        
		if (!auth()->user()->hasRole(['admin'])) {
			$q->where(function ($q) {
				$q->where('parents', 'like', '#'.auth()->user()->category_id.'#%')
				  ->orWhere('category_id', auth()->user()->category_id);
            });
        }

        $questions = $q->paginate(20);
        
	    return view('backend.question.index', [
            'questions' => $questions,
            'filter_arr' => [],
            'texts' => [],
            'categories' => [],
            'paginate' => $questions
        ]);
    }
    /**
     * Actions (set_text, remove, set_category, set_theme)
     *
     * @param Request $request
     * @return void
     */
    public function doAction(Request $request)
	{
        $inp = $request->all();
        $request->validate([
            'ids'         => 'required|array|min:1',
            'action'      => 'required',
            'category_id' => 'integer',
            'theme_id'    => 'integer',
            'text_id'     => 'integer'
        ]);

		if (!empty($inp['ids'])) {
			$q = TestQuestion::whereIn('id', $inp['ids']);

			if (auth()->user()->hasRole(['main_teacher'])) {
				$q->where('creator_id', '=', auth()->user()->id);
            }

			switch ($inp['action'])
			{
				case 'remove':
					$q->delete();
				break;

				case 'set_text':
					if ($inp['text_id']) {
						$q->update(['text_id' => $inp['text_id']]);
					}
				break;

				case 'set_category':
                    $category = TestCategory::select('parents')
                                            ->findOrFail($inp['category_id']);
					if ($inp['category_id']) {
						$q->update([
                            'category_id' => $inp['category_id'],
                            'parents'=>$category->parents.'#'.$inp['category_id'].'#'
                        ]);
                    }
                break;

				case 'set_theme':
                    $category = Theme::select('parents')
                                     ->findOrFail($inp['theme_id']);

					if ($inp['theme_id']) {
						$q->update(['theme_id'=>$inp['theme_id'],'t_parents'=>$category->parents.'#'.$inp['theme_id'].'#']);
                    }
                break;
			}
		}
		
		return redirect()->back();
    }
    
    public function edit($id = null)
	{
		$q = null;
		if (!$id) {
			$q = new TestQuestion;
		} else {
            $q = TestQuestion::with('category')->with('theme');
            
			if (!auth()->user()->hasRole(['main_teacher'])) {
				$q->where('creator_id', '=', auth()->user()->id);
            }

            $q = $q->findOrFail($id);
            
			if ($q->category) {
				$q->category->name = $q->category->name();
            }

			if ($q->theme) {
				$q->theme->name = $q->theme->name();
            }
        }
        
        $texts = Text::select('id','name')
                     ->where('category_id', auth()->user()->category_id)
                     ->get();

		return view('backend.question.edit', compact('q', 'text'));
    }
    
	public function remove($id = null)
	{
		if (!$id) {
			return abort(404);
        }

        $q = TestQuestion::where('id', $id);
        
		if (!auth()->user()->hasRole(['main_teacher'])) {
			$q->where('creator_id', auth()->user()->id);
        }

        $q->delete();
		return redirect()->back();
	}
}
