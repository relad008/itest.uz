<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'name',
        'thematic_count',
        'direction_count',
        'price_format',
        'economy_format'
    ];

    public function getDaysToExpired()
	{
		return $this->months_count * 31;
    }

	public function getNameAttribute()
	{
		if (isset ($this->attributes['name'])) {
			return $this->attributes['name'];
        }

		return $this->attributes['name_'.app()->getLocale()];
	}

	public function getThematicCountAttribute()
	{
		return number_format($this->getDaysToExpired() * 36 * config('app.test_per_day_limit') * $this->thematic_available, 0, ',', ' ');
	}

	public function getDirectionCountAttribute()
	{
		return number_format($this->getDaysToExpired() * 36 * 3 * config('app.test_per_day_limit') * $this->direction_available, 0, ',', ' ');
	}

	public function getPriceFormatAttribute()
	{
		return number_format($this->attributes['price'], 0, ',', ' ');
	}

	public function getEconomyFormatAttribute()
	{
		return number_format($this->attributes['economy'], 0, ',', ' ');
	}

}
