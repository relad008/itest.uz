<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Region extends Model
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [];

    public function universities()
    {
        return $this->hasMany(University::class, 'city_id', 'id');
    }

    public function name()
    {
        return $this->{'name_'.App::getLocale()};
    }
}
