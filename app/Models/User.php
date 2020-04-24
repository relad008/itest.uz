<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'email', 'password', 'role',
        'category_id','city_id', 'district_id', 'birthdate',
        'lang', 'university_id', 'faculty_id',
        'subject_1_id', 'subject_2_id', 'subject_3_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set the user's phone.
     *
     * @param  string  $value
     * @return void
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/[\+\-\(\)]/', '', $value);
    }

    /**
     * Get Today tests count
     * 
     * @param  string $type
     * @return int
     */
    public function getTodayTestCount($type)
    {
        $count = TestSession::where('user_id', $this->id)
            ->where('created_at','>', date('Y-m-d 00:00:00'))
            ->where('type', $type)
            ->count();

        return $count;
    }

    /**
     * Find for Passport package
     * 
     * @param  string $username
     * @return Object          
     */
    public function findForPassport($username)
    {
        return $this->where('phone', $username)->first();
    }

    /**
     * Validate for Passport
     * 
     * @param  string $password
     * @return boolean
     */
    public function validateForPassportPasswordGrant($password)
    {
        return (mb_strlen($this->password) == 32 && $this->password == md5($password)) || \Hash::check($password, $this->password);
    }

    /**
     * Check role
     *
     * @param array $roles
     * @return boolean
     */
    public function hasRole($roles)
    {
        return in_array($this->role, $roles);
    }

    public function category()
	{
		return $this->hasOne('App\Models\TestCategory', 'id', 'category_id');
    }
    
    public function getAccount()
	{
        $acc = Account::select(\DB::raw('sum(`sum`) as sum'))
                      ->where('user_id', $this->id)
                      ->first();

		if ($acc && $acc->sum) {
			return $acc->sum;
        }

		return 0;
    }
    
    public function totalTests()
	{
		return Rating::where('user_id', $this->id)->count();
    }

    public function getSubjectsIds()
	{
		$subs = [];
		for ($i = 1; $i < 4; $i++) {
			$name = "subject_{$i}_id";
			if ($this->$name) {
                $subs[$i-1] = $this->$name;
            }
		}
		return $subs;
    }

    public function canSolveTest($type)
	{
		if ($this->year_subscribe) {
            return true;
        }
        \Log::info($this->id);
        $res = \DB::table('accounts')
                  ->select('accounts.id')
                  ->where('user_id',$this->id)
                  ->where('expired_at', '>', gmdate('Y-m-d', time()))
                  ->join('prices', function ($q) use ($type) {
                    $q->on('accounts.price_id', '=', 'prices.id');
                    //   ->where($type.'_available', '=', 1);
                  })
                  ->first();

		return $res ? true : false;
    }
    
    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }

    public function isNoSubjects()
	{
		return !($this->subject_1_id && $this->subject_2_id && $this->subject_3_id);

	}
}
