<?php

namespace App\Http\Controllers\API;

use App\Models\Theme;
use App\Models\Faculty;

use App\Library\TestMixer;

use App\Models\TestSession;
use App\Models\TestQuestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class TestController extends Controller
{
	/**
	 * Demo test
	 * 
	 * @param  int $subject_id_1
	 * @param  int $subject_id_2
	 * @param  int $subject_id_3
	 * @return \Illuminate\Http\Response
	 */
    public function demo($subject_id_1, $subject_id_2, $subject_id_3)
	{
		$lang = auth()->user()->lang;
		$name = "demo_session_{$subject_id_1}_{$subject_id_2}_{$subject_id_3}_{$lang}";
		$loaded_from_cache = true;

		$demo_session_data = cache($name, function () use (
			$loaded_from_cache,
			$name,
			$subject_id_1,
			$subject_id_2,
			$subject_id_3,
			$lang
		) {
			if (auth()->user()->getTodayTestCount('demo') > config('app.test_per_day_limit'))
			{
				// return response()->json([
				// 	'user' => 'You have a limit 6 tests per a day'
				// ]);
			}

			$demo_session_data = self::genDirectionTest($subject_id_1, $subject_id_2, $subject_id_3, $lang, true);
			cache()->forever($name, $demo_session_data);
			$loaded_from_cache = false;

			return $demo_session_data;
		});

		if ($loaded_from_cache)
		{
			$ts = $demo_session_data['test_session']->toArray();

			$ts['user_id'] = auth()->user()->id; // Fix
			$ts['end_at'] = now()->addDay(); // Fix
			// dd($ts);
			// unset($ts['user_id']);
			unset($ts['id']);
			// unset($ts['end_at']);
			// unset($ts['create_at']);
			$test_session = TestSession::create($ts);
			$demo_session_data['test_session'] = $test_session;
		}

		$demo_session_data['session_id'] = $demo_session_data['test_session']->id;

		return response()->json($demo_session_data, 200);
	}

	public function direction($subject_id_1, $subject_id_2, $subject_id_3)
	{
		// \Log::info(Auth::user());
		// if(Auth::user()->getTodayTestCount('direction')>Config::get('app.test_per_day_limit'))
		// {
		// 	new Popup('test.limit_mess');
		// 	throw new RedirectException(action('CabController@getIndex'));
		// }
		if (!auth()->user()->hasRole(['student']) || !auth()->user()->canSolveTest('direction')) {
			return response()->json([
				'status' => 0,
				'message' => 'Чтобы получить возможность пройти тесты вам нужно оплатить подписку',
			]);
		}

		$res = self::genDirectionTest($subject_id_1, $subject_id_2, $subject_id_3, auth()->user()->lang);
		$res['session_id'] = $res['test_session']->id;
		$res['google'] = true;
		return response()->json($res, 200);
	}

	/**
	 * Get Direction test
	 * 
	 * @param  int  $subject_id_1
	 * @param  int  $subject_id_2
	 * @param  int  $subject_id_3
	 * @param  string  $lang        
	 * @param  boolean $is_demo_test
	 * @return array               
	 */
	public static function genDirectionTest($subject_id_1, $subject_id_2, $subject_id_3, $lang, $is_demo_test=false)
	{
		$texts = [];
		$questions = [];

		$subject_ids = [
			1 => $subject_id_1, $subject_id_2, $subject_id_3
		];
		$subjects_order = array_flip($subject_ids);

		$test_session = new TestSession();
		$test_session->shuffle_map = new TestMixer();
		$test_session->type = $is_demo_test ? 'demo' : 'direction';
		$test_session->setSubjects($subject_ids);
		$subjects = $test_session->getSubjects();
		$test_session->total_questions = 0;

		for ($subj_num = 1; $subj_num <= 3; $subj_num++)
		{
			if (!$subject_ids[$subj_num]) {
				continue;
			}
			$question_q = TestMixer::getQuestionsQuery($subject_ids[$subj_num], $lang, $texts);
			$questions_arr = $question_q->limit(30)->get();

			$questions[$subj_num] = TestMixer::randomize($questions_arr, $test_session, $subj_num);
		}

		$test_session->user_id = auth()->user()->id; // fix
		$test_session->total_correct = 0; // fix
		$test_session->end_at = now()->addDay(); // fix
		$test_session->correct_count_1 = 0; // fix
		$test_session->correct_count_2 = 0; // fix
		$test_session->correct_count_3 = 0; // fix
		$test_session->total_ball = 0; // fix

		foreach ([1,2,3] as $block) {
			foreach(range(31,36) as $qq) {
				$test_session->{'question_id_'.$block.'_'.$qq} = 0;
				$test_session->{'answer_'.$block.'_'.$qq} = 'no_answer';
				$test_session->{'answer_correct_'.$block.'_'.$qq} = 'no_question';
			}
			// $test_session->{'subject_id_'.$block} = 0;
			// $test_session->{'questions_count_'.$block} = 0;
		}

		$test_session->save();
		$no_chat = true;

		return compact('questions', 'texts', 'subjects', 'test_session', 'no_chat');
	}

	public function getThematic($theme_id)
	{
		// if(auth()->user()->getTodayTestCount('thematic')>Config::get('app.test_per_day_limit'))
		// {
		// 	new Popup('test.limit_mess');
		// 	throw new RedirectException(action('CabController@getIndex'));
		// }
		if (!auth()->user()->hasRole(['student']) || !auth()->user()->canSolveTest('thematic')) {
			return response()->json([
				'status' => 0,
				'message' => 'Чтобы получить возможность пройти тесты вам нужно оплатить подписку',
			]);
		}

		$theme = Theme::findOrFail($theme_id);
		$res = self::genThematic($theme, auth()->user()->lang);
		$res['session_id'] = $res['test_session']->id;
		return response()->json($res, 200);
	}

	/**
	 * Generate thematic test
	 *
	 * @param int $theme
	 * @param string $lang
	 * @return json
	 */
	public static function genThematic($theme, $lang)
	{
		$questions = TestQuestion::select(
			'id',
			'description',
			'A', 'B', 'C', 'D',
			'text_id',
			'correct_answer'
		)->where('parents', 'like', $theme->parents.'#'.$theme->id.'#%')
			// ->where('t_parents','like',$theme->parents.'#'.$theme->id.'#%')
			->where('correct_answer','!=','-')
			->limit(36)
			->orderBy(DB::raw('rand()'));

		if (TestMixer::isNeedLang($theme->parents.'#'.$theme->id.'#')) {
			$questions->where('lang',$lang);
		}

		$questions = $questions->limit(30)->get();

		$test_session = new TestSession();
		$test_session->shuffle_map = new TestMixer();
		$test_session->type = 'thematic';
		$test_session->setSubjects([
			1 => $theme->id
		]);
		$test_session->total_questions = 0;

		$text_ids = [];
		foreach($questions as $q) {
			if($q->text_id) {
				$text_ids[$q->text_id]=$q->text_id;
			}
		}
		$texts = [];
		if (count($text_ids))
		{
			$db_texts = Text::select('name','text','id')
							->whereIn('id', $text_ids)
							->get();

			foreach($db_texts as $t) {
				$texts[$t->id]=$t->toArray();
			}
		}

		$questions = [
			1 => TestMixer::randomize($questions,$test_session)
		];

		$test_session->user_id = auth()->user()->id; // fix
		$test_session->total_correct = 0; // fix
		$test_session->end_at = now()->addDay(); // fix
		$test_session->correct_count_1 = 0; // fix
		$test_session->correct_count_2 = 0; // fix
		$test_session->correct_count_3 = 0; // fix
		$test_session->total_ball = 0; // fix
		

		foreach(range(31,36) as $qq) {
			$test_session->{'question_id_1_'.$qq} = 0;
			$test_session->{'answer_1_'.$qq} = 'no_answer';
			$test_session->{'answer_correct_1_'.$qq} = 'no_question';
		}
		foreach ([2,3] as $block) {
			foreach(range(1,36) as $qq) {
				$test_session->{'question_id_'.$block.'_'.$qq} = 0;
				$test_session->{'answer_'.$block.'_'.$qq} = 'no_answer';
				$test_session->{'answer_correct_'.$block.'_'.$qq} = 'no_question';
			}
			$test_session->{'subject_id_'.$block} = 0;
			$test_session->{'questions_count_'.$block} = 0;
		}

		// dd($test_session);
		$test_session->save();

		$subjects = [
			1 => $theme->toArray()
		];
		// $test_session=$test_session->toArray();
		$no_chat = true;

		return compact('questions', 'texts', 'subjects', 'test_session', 'no_chat');
	}

	/**
	 * Get a result
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function getResult(Request $request)
	{
		$test_session = TestSession::where('user_id', auth()->user()->id)
									->findOrFail($request->session_id);
		return response()->json([
			'result' => self::checkAnswers($request->answers, $test_session)
		]);
	}

	/**
	 * Check the answers
	 *
	 * @param array $answers
	 * @param Object $test_session
	 * @return string
	 */
	public static function checkAnswers($answers, $test_session)
	{
		if ($test_session->status == 'finished') {
			return 'already_finished';
		}
		$ids_order = [];
		$q_ids = $test_session->getQuestionsIds($ids_order);

		$update_data = [];
		$update_data['total_correct'] = 0;
		$update_data['total_ball'] = 0;

		foreach ($ids_order as $q_id => $ord)
		{
			$subj_num = $ord[0];
			$q_num = $ord[1];

			$ball = 4 - $subj_num;
			$ball = "{$ball}.1" * 1;

			$shuffuled_answer = 'no_answer';
			if (isset($answers[$subj_num][$q_num]))
			{
				$shuffuled_answer = $answers[$subj_num][$q_num];
				if ($test_session->{"answer_correct_{$subj_num}_{$q_num}"} == $shuffuled_answer)
				{
					$update_data['total_correct']++;
					if (!isset($update_data["correct_count_{$subj_num}"])) {
						$update_data["correct_count_{$subj_num}"] = 0;
					}
					$update_data["correct_count_{$subj_num}"]++;
					$update_data['total_ball'] += $ball;
				}
			}
			$update_data["answer_{$subj_num}_{$q_num}"] = $shuffuled_answer;
		}
		$update_data['status'] = 'finished';
		$test_session->update($update_data);
		return 'finished';
	}
	
	/**
	 * Get User statistics
	 *
	 * @param integer $user_id
	 * @param boolean $as_sections
	 * @return array
	 */
	public static function getStatistics($user_id, $as_sections = true)
    {
		$test_session = TestSession::where('user_id', $user_id)
								   ->where('status', 'finished')
								   ->orderBy('id','desc')
								   ->first();
		if ($test_session) {
			$test_session->append('speed');
		}

		$subjects = [];
		$answer_sections = [];
		$best_session = null;
		$faculties = [];

		if ($test_session) {
			$subjects = $test_session->getSubjects();
			$answer_sections = [];

			foreach ($subjects as $subj_num => $s) {

				for ($i = 0; $i < 4; $i++) {
					$offset = $i * 9;

					for ($j = 1; $j <= 9; $j++) {
						$q = [];
						$q['num'] = $offset + $j;
						$q['correct'] = $test_session->{'answer_correct_'.$subj_num.'_'.$q['num']};
						$q['answer'] = $test_session->{'answer_'.$subj_num.'_'.$q['num']};

						if ($as_sections) {
							$answer_sections[$subj_num][$i][$q['num']] = $q;
						} else {
							$answer_sections[$subj_num][$q['num']] = $q;
						}
					}
				}
			}

			$best_session = TestSession::where('user_id', $user_id)
									   ->where('status', 'finished')
									   ->where('type', $test_session->type)
									   ->orderBy('total_ball', 'desc')
									   ->first();
			if ($best_session) {
				$best_session->append('speed');
			}

			$faculties = Faculty::where(function ($q) use($subjects) {
					foreach ($subjects as $subj_num => $s) {
						$q->whereOr('subject_'.$subj_num.'_id', $s->id);
					}
				})
				->where('contract_ball','<=',$test_session->total_ball)
				->where('contract_ball','!=',0)
				->where('lang', app()->getLocale())
				->with('university')
				->orderBy('university_id')
				->get();
		}

		return compact(
			'test_session',
			'subjects',
			'answer_sections',
			'best_session',
			'faculties'
		);
	}
	
	/**
	 * User statistics response
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function statistics()
	{
		$user_id = auth()->user()->id;
		$data = self::getStatistics($user_id);
		
		return response()->json($data);
	}
	
	/**
	 * Undocumented function
	 *
	 * @param Object $test_session
	 * @return array
	 */
	public static function getMistakes($test_session)
	{
		$texts = [];
		$subjects = $test_session->getSubjects();
		$questions = [];
		$q_order = [];
		$q_ids = [];

		foreach ($subjects as $subj_num => $s) {
			$questions[$subj_num] = [];
			for ($q_num = 1; $q_num <= 36; $q_num++) {
				$user_answer = $test_session->{"answer_{$subj_num}_{$q_num}"};
				$correct_answer = $test_session->{"answer_correct_{$subj_num}_{$q_num}"};

				if ($user_answer !== $correct_answer) {
					$q_id = $test_session->{"question_id_{$subj_num}_{$q_num}"};
					$q_order[$q_id] = [$subj_num, $q_num, $user_answer, $correct_answer];
					$q_ids[] = $q_id;
				}
			}
		}

		$question_arr = TestQuestion::whereIn('id', $q_ids)->with('text')->get();
		foreach ($question_arr as $q) {
			list($subj_num, $q_num, $q->user_answer_symb, $q->correct_answer_symb) = $q_order[$q->id];
			$questions[$subj_num][$q_num] = $q;
			$q->correct_answer_text = $q->{$q->correct_answer};

			if ($q->user_answer_symb == 'no_answer') {
				$q->user_answer_text = trans('student.no_answer');
				$q->user_answer_symb = '';
			} else {
				$q->user_answer_text = $q->{$test_session->shuffle_map->unshuffle($q->user_answer_symb)};
			}
		}
		foreach ($questions as $ind => $val) {
			ksort($questions[$ind]);
		}

		return compact('subjects', 'questions');
	}

	public function mistakes($sessions_id)
	{
		$test_session = TestSession::where('user_id', auth()->user()->id)
								   ->findOrFail($sessions_id);

		$data = self::getMistakes($test_session);
		return response()->json($data);
	}

	public function thematicSelect()
	{
		$ids = auth()->user()->getSubjectsIds();
		$query = Theme::selectRaw('
				id,
				name_ru,
				name_uz,
				parent_id,
				depth,
				name_'.app()->getLocale().' as name'
			)
			->whereIn('id', $ids);

		foreach ($ids as $i => $id) {
			$query->orWhere('parents', 'like', "#$id#%");
		}

		$t_arr = $query->orderBy('depth')
					   ->get()
					   ->makeHidden([
						   'name_ru',
						   'name_uz'
						]);
		$themes = [];
		$t_by_id = [];

		foreach ($t_arr as $t) {
			$t_by_id[$t->id] = $t;
			$t->list = [];

			if ($t->depth == 0) {
				$themes[] = $t;
			}
			elseif (isset($t_by_id[$t->parent_id])) {
				$list = $t_by_id[$t->parent_id]->list;
				$list[] = $t;
				$t_by_id[$t->parent_id]->list = $list;
			}
		}

		return response()->json($themes);
	}
}
