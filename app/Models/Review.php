<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = [];

    public function region()
    {
        return $this->hasOne(Region::class, 'id', 'region_id');
    }

    public function university()
    {
        return $this->hasOne(University::class, 'id', 'university_id');
    }

    public function getNameAttribute()
    {
        return $this->{'name_'.app()->getLocale()};
    }

    public function getCommentAttribute()
    {
        return $this->{'comment_'.app()->getLocale()};
    }
}
