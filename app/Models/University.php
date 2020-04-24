<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class University extends Model
{
    public function name()
    {
        return $this->{'name_'.App::getLocale()};
    }
    
    public function getAddressAttribute()
    {
        return $this->{'address_'.App::getLocale()};
    }

    public function faculties()
	{
		return $this->hasMany(Faculty::class);
    }
    
    public function city()
	{
		return $this->belongsTo(Region::class);
	}
}
