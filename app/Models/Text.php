<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Text extends Model
{
	/**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

	public function author()
	{
		return $this->hasOne('App\Models\User', 'id', 'author_id');
	}
}
