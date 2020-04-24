<?php

namespace App\Models;

class Theme extends TestCategory
{
    public function parent()
	{
		return $this->hasOne('App\Models\Theme', 'id', 'parent_id');
	}
}
