<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

    public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
	public function getAccountId()
	{
		$student = User::select('phone')->where('id',$this->user_id)->first();
		return $student->phone;
    }
    
	public function getSum()
	{
		if ($this->sum<0) {
            return $this->sum*(-1);
        }

		return $this->sum;
    }
    
	public static function valid()
	{
		return self::where('user_id', auth()->user('id'))->where('expired_at', '>', gmdate('Y-m-d',time()))->where('status', 'active');
	}
	
	public function getAmountAttribute()
	{
		return $this->sum;
	}
}
