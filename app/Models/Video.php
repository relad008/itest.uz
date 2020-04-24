<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Video extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        return $this->{'name_'.App::getLocale()};
    }

    public function getDescriptionAttribute()
    {
        return $this->{'description_'.App::getLocale()};
    }

    public function category()
    {
        return $this->belongsTo(TestCategory::class);
    }
}
