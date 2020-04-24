<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public function name()
    {
        return $this->{'name_'.app()->getLocale()};
    }

    public function university()
	{
		return $this->belongsTo(University::class);
	}
}
