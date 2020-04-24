<?php

namespace App\Library;

use Cache;
use DB;
use Log;
use App\Exceptions\TestMixerException;
use App\Models\TestCategory;
use App\Models\Text;

class TestMixer
{
	static $map = null;

	private $shuffle_map = [],
			$unshuffle_map = [];

	private static $start_arr = ['A', 'B', 'C', 'D'];

	public function __construct($shuffle_map=null)
	{
		if ($shuffle_map === null)
		{
			$shuffle_map = self::$start_arr;
			shuffle($shuffle_map);
		}
		foreach (self::$start_arr as $ind => $char)
		{
			$this->shuffle_map[$char] = $shuffle_map[$ind];
			$this->unshuffle_map[$shuffle_map[$ind]] = $char;
		}
		// \Log::info([$this->shuffle_map, $this->unshuffle_map]);
	}

	public function unshuffle($shuffled)
	{
		return $this->unshuffle_map[$shuffled];
	}

	public function shuffle($unshuffled)
	{
		return $this->shuffle_map[$unshuffled];
	}

	public function getShuffleMap()
	{
		return $this->shuffle_map;
	}

	public function getShuffleMapStr()
	{
		return implode('-', $this->shuffle_map);
	}

	public function shuffleQuestion(&$q)
	{
		foreach (self::$start_arr as  $char)
				$q->{$this->shuffle($char)} = $q->getOriginal($char);
		return $q;
	}

	public static function updateMap()
	{
		Cache::forget('test_mixer_map');
	}

	/**
	 * Загрузить формулу создания теста
	 * 
	 * @return array
	 */
	private static function loadMap()
	{
		if(self::$map === null)
			self::$map = Cache::get('test_mixer_map', function()
			{
				$categs = TestCategory::where('from','>','0')->orWhere('to','>','0')->orderBy('depth')->get();
				$map = [];
				foreach ($categs as $cat)
				{
					$parents = $cat->parentIds();
					$category_id = array_shift($parents);

					if (!isset($map[$category_id])) {
						$map[$category_id]=[];
					}

					$parents = $cat->parents.'#'.$cat->id.'#';
					$map[$category_id][$parents] = [
						'from'=> $cat->from,
						'to' => $cat->to,
						'not' => [],
						'need_text' => $cat->need_text,'
						count' => 0
					];
					if (isset($map[$category_id][$cat->parents])) {
						$map[$category_id][$cat->parents]['not'][] = $parents;
					}
				}
				Cache::forever('test_mixer_map', $map);
				return $map;
			});
		return self::$map;
	}

	static $main_categories = null;

	public static function isNeedLang($parents)
	{
		if(self::$main_categories === null)
		{
			self::$main_categories = [];
			$categs = TestCategory::where('depth',0)->get();
			// Log::info($categs);
			foreach ($categs as $ind=>$c) {
				self::$main_categories[$c->id] = $c;
			}
		}
		$category_id = preg_replace('/^#(\d+)#.*$/', '$1', $parents);
		$res = !isset(self::$main_categories[$category_id]) || self::$main_categories[$category_id]->subject_type != 'foreign';
		// Log::info($res);
		return $res;

	}

	public static function getQuestionsQuery($category_id,$lang,&$texts)
	{
		$map = self::loadMap();
		// print_r(array_keys($map));
		if (!isset($map[$category_id])) {
			throw new TestMixerException('no map for category '.$category_id, 1);
		}
		$map = $map[$category_id];
		// -------
		$total_count = 0;
		foreach ($map as $el) {
			$total_count+=$el['from'];
		}

		$total_count = 0;
		foreach ($map as $el) {
			$total_count+=$el['to'];
		}

		$minus_index = [];
		$plus_index = [];

		// Подсчитать общее количество в 36
		$total_count = 0;
		// Пройтись по всем категориям от младшей до страших
		foreach($map as $parents => $cat)
		{
			$new_from = $cat['from'];
			if (count($cat['not']))
			{
				foreach($cat['not'] as $child_parents)
				{
					// Log::info($map);
					$new_from -= $map[$child_parents]['count'];

					// Убираю из индекса чтобы не пересчитывать родительскую категорию
					unset($minus_index[$child_parents]);
					unset($plus_index[$child_parents]);
				}
				$map[$parents]['from']=$new_from;
			}
			// Зарендомить количество
			$count = rand($new_from,$cat['to']);
			$map[$parents]['count'] = $count;

			// Добавить в индекс те поля где можно подшаманить в минус, где в плюс
			if ($count > $new_from) {
				$minus_index[] = $parents;
			}

			if ($count < $cat['to']) {
				$plus_index[]=$parents;
			}

			$total_count += $count;
		}

		// Если не 36 то из перемешенного индекса шаманства вытягивать до оптимы
		if ($total_count > 36)
		{
			$diff = $total_count - 36;
			shuffle($minus_index);
			foreach ($minus_index as $parents)
			{
				$cat = $map[$parents];
				//Запас диапазона
				$val = $cat['count'] - $cat['from'];
				// Если у категории есть запас достаточный для выравнивания то все ок
				if ($val>=$diff)
				{
					$map[$parents]['count'] -= $diff;
					break;
				}
				else //$val<$diff
				{
					$map[$parents]['count'] -= $val;
					$diff-=$val;
				}
			}

		}
		elseif($total_count < 36)
		{
			$diff = 36 - $total_count;
			shuffle($plus_index);

			foreach ($plus_index as $parents)
			{
				$cat = $map[$parents];
				//Запас диапазона
				$val = $cat['to'] - $cat['count'];
				// Если у категории есть запас достаточный для выравнивания то все ок
				if($val >= $diff)
				{
					$map[$parents]['count'] += $diff;
					break;
				}
				else //$val<$diff
				{
					$map[$parents]['count'] += $val;
					$diff -= $val;
				}
			}

		}

		// Log::info(json_encode($map));
		$q = null;
		$text_ids = [];
		foreach($map as $parents => $el)
			if ($el['count'] > 0)
			{
				$q_el = DB::table('test_questions')
					->where('correct_answer','!=','-');

				if (self::isNeedLang($parents)) {
					$q_el->where('lang',$lang);
				}

				if ($el['need_text'])
				{
					$ids = [];
					$q_ids = $q_el
						->select(DB::raw('GROUP_CONCAT(id SEPARATOR ",") as id_list'),'text_id')
						->where('parents','like',$parents.'%')
						->where('text_id','!=',0)
						->limit($el['count'])
						->groupBy('text_id')
						->orderBy(DB::raw('rand()'));

					if (self::isNeedLang($parents)) {
						$q_ids->where('lang',$lang);
					}

					$q_ids = $q_ids->get();
					foreach ($q_ids as $id_list)
					{
						if (!isset($texts[$id_list->text_id])) {
							$text_ids[$id_list->text_id] = $id_list->text_id;
						}

						$id_list = explode(',', $id_list->id_list);
						foreach ($id_list as $id)
							if ($id)
							{
								$ids[$id] = $id;
								if(count($ids) >= $el['count']) {
									break 2;
								}
							}
					}
					$q_el = DB::table('test_questions')->whereIn('id',$ids);
				}
				else
				{
					$q_el = $q_el
						->where('parents', 'like', $parents.'%')
						->limit($el['count'])
						->orderBy(DB::raw('rand()'));

				}

				foreach ($el['not'] as $child_parents) {
					$q_el->where('parents', 'not like', $child_parents.'%');
				}


				if($q === null) {
					$q = $q_el;
				}
				else {
					$q->union($q_el);
				}
			}

		if (count($text_ids))
		{
			$db_texts = Text::select('name','text','id')->whereIn('id',$text_ids)->get();
			foreach($db_texts as $t) {
				$texts[$t->id] = $t->toArray();
			}
		}

		return $q;
	}


	public static function randomize($questions_arr,$test_session,$subj_num=1)
	{
		$questions=[];

		$q_count=0;
		foreach ($questions_arr as $q_ind => $q)
		{
			$q_num = $q_ind + 1;

			$questions[$q_num] = [
				'description'=>$q->description,
				'text_id'=>$q->text_id,
				'id'=>$q->id,
			];

			foreach(TestMixer::$start_arr as $symb)
			{
				$questions[$q_num][$symb] = $q->{$test_session->shuffle_map->unshuffle($symb)};
			}

			$test_session->{"answer_correct_{$subj_num}_{$q_num}"} = $test_session->shuffle_map->shuffle($q->correct_answer);
			$test_session->total_questions++;
			$test_session->{"question_id_{$subj_num}_{$q_num}"} = $q->id;
			$test_session->{"answer_{$subj_num}_{$q_num}"} = 'no_answer';
			$q_count++;
		}
		$test_session->{"questions_count_{$subj_num}"} = $q_count;
		return $questions;
	}
}
