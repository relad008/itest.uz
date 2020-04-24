<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class TestCategory extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['name'];

    protected $table = 'test_categories';
    protected $binded_field = 'category_id';

	public function getType()
	{
		return $this->binded_field == 'category_id' ? 'category' : 'theme';
    }
    
    public function parentIds()
	{
		return explode('##', trim($this->parents,'#'));
	}

    public function getNameAttribute()
    {
        return $this->{'name_'.App::getLocale()};
    }

    public function getIdsForChild()
	{
		$parents = $this->parents ? $this->parentIds() : [];
		$parents[] = $this->id;
		return $parents;
    }
    
	public function parents()
	{
		if (!$this->depth) {
		    return null;
        }

		$parents = $this->parentIds();
		return self::where('parent_id', 'in',$parents)->all();
    }
    
	public function getChildsIds($self_include=true)
	{
        $res = [];
        
		if($self_include) {
			$res[] = $this->id;
        }

        $ids = self::select('id')
                   ->where('parents', 'like', $this->parents.'#'.$this->id.'#%')
                   ->get();

		if ($ids) {
            foreach($ids as $ind => $cat) {
                $res[] = $cat->id;
            }
        }

		return $res;
    }
    
    public function parent()
	{
		return $this->hasOne('App\Models\TestCategory', 'id', 'parent_id');
    }

    public function allQuestionsCount($lang=null)
	{
		$all_questions = TestQuestion::where($this->getType() == 'theme' ? 't_parents' : 'parents', 'like', $this->parents.'#'.$this->id.'#%');
        
        if ($lang!==null) {
			$all_questions->where('lang', $lang);
        }

		return $all_questions->count();
    }

    public function questionsCount($lang)
	{
        $curernt_questions = TestQuestion::where($this->binded_field, $this->id);
        
		if ($lang !== null) {
            $curernt_questions->where('lang', $lang);
        }
        
		return $curernt_questions->count();
	}
    
    public function childQuestionsCount($lang=null)
	{
        $child_questions = TestQuestion::where($this->getType() == 'theme' ? 't_parents' : 'parents', 'like', $this->parents.'#'.$this->id.'#%')
			                           ->where($this->binded_field, '!=', $this->id);

		if ($lang !== null) {
			$child_questions->where('lang', $lang);
        }

		return $child_questions->count();
	}
}
