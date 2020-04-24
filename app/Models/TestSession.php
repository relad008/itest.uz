<?php

namespace App\Models;

use App\Library\TestMixer;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

	private $_shuffle_map = null,
			$questions = null;

    public function getTotalBallAttribute()
    {
        return number_format($this->attributes['total_ball'], 1, '.' ,' ');
    }

    public function setShuffleMapAttribute($shuffle_map)
    {
        $this->_shuffle_map = $shuffle_map;
        $this->attributes['shuffle_map'] = $shuffle_map->getShuffleMapStr();
    }

    public function getSpeedAttribute()
    {
        if (!isset($this->updated_at)|| !isset($this->created_at)) {
            return null;
        }
        return date('H:i:s', strtotime($this->updated_at) - strtotime($this->created_at) - 6 * 60 * 60);
    }

    public function getShuffleMapAttribute($shuffle_map_str)
    {
        if ($this->_shuffle_map === null) {
            $this->_shuffle_map = new TestMixer(explode('-', $shuffle_map_str));
        }
        return $this->_shuffle_map;
    }

    public function getSubjectIds()
    {
    	$subjects_ids=[];

    	for ($i=1; $i <=3; $i++)
    	{
    		if (!isset($this->attributes['subject_id_'.$i])) {
    			continue;
    		}

    		$id = $this->attributes['subject_id_'.$i];
    		if ($id) {
    			$subjects_ids[$id] = $i;
    		}
    	}

    	return $subjects_ids;
    }

    public function getSubjects()
    {
    	$subjects_ids = $this->getSubjectIds();
    	$query = $this->type == "thematic"
    		? Theme::select('*')
    		: TestCategory::select('*');

    	$subjects_q = $query->whereIn('id', array_keys($subjects_ids))->get();
    	$subjects = [];
    	foreach ($subjects_q as $ind => $s) {
    		$subjects[$subjects_ids[$s->id]] = $s;
    	}
    	ksort($subjects);
    	return $subjects;
    }

    public function setSubjects($subjects_ids)
    {
    	foreach ($subjects_ids as $ind=>$id) {
    		$this->attributes['subject_id_'.$ind] = $id;
    	}
    }

    public function getQuestionsIds(&$ids_order, $subject_index=null)
    {
    	$ids = [];
    	$ids_order = [];
    	$subjects = $subject_index === null ? [1,2,3] : [$subject_index];
    	foreach ($subjects as $subject_ind) {
    		for ($question_ind = 1; $question_ind <= 36; $question_ind++){
    			$id = $this->attributes["question_id_{$subject_ind}_{$question_ind}"];
    			if ($id) {
    				$ids[] = $id;
    				$ids_order[$id] = [$subject_ind, $question_ind];
    			}
    		}
    	}
    	if($subject_index !== null && $ids) {
    		$ids = array_shift($ids);
    		$ids_order = array_shift($ids_order);
    	}
    	return $ids;
    }
}
