<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App;

class TestQuestion extends Model
{
    public function creator()
	{
		return $this->hasOne('App\Models\User', 'id', 'creator_id');
	}

	public function getCategoryIds($type)
	{
		$cat = $this->$type;
		$res = [$this->{$type.'_id'}];
		if ($cat && $cat->parents) {
			$res = array_merge($res, explode('##', trim($cat->parents, '#')));
		}
		return $res;
	}

	public function getParentCategories()
	{
		return TestCategory::select('id', DB::raw('name_'.App::getLocale().' as name'))
						   ->whereIn('id', $this->getCategoryIds('category'))
						   ->orderBy('depth')
						   ->get();
	}

	public function text()
	{
		return $this->hasOne('App\Models\Text', 'id',' text_id');
	}
}
