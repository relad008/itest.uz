<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SmsCode;
use App\Mail\VerifyMail;

use App\Models\VerifyUser;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
	/**
	 * Validation erros
	 * 
	 * @var array
	 */
	protected $errors = [];

	/**
     * Send sms to User
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function sendSms(Request $request)
    {
    	$request->merge([
    		'phone' => preg_replace('/[\+\-\(\)]/', '', $request->phone)
    	]);

    	$request->validate([
            'phone' => 'required|numeric|unique:users',
        ]);

    	// Custom validation to verify last sent time
    	if (!$this->verifyLastCodeTime($request->phone)) {
    		return response()->json($this->errors, 422);
    	}

    	$code = rand(11111, 99999);
        SmsCode::create([
            'phone' => $request->phone,
            'code' => $code,
            'expires_at' => Carbon::now()->addMinutes(10)
        ]);

    	// SMS Send API
    	// Smsc::send($request->phone, $code.' - ваш код для активации');

        return response()->json([
        	'success' => true,
        	'message' => 'SMS was successfully sent'
        ]);
    }

    /**
     * Verify the last sent code Time
     * 
     * @param  string $phone
     * @return array|boolean
     */
    private function verifyLastCodeTime($phone)
    {
    	$last_code = SmsCode::where('phone', $phone)->latest()->first();

        if ($last_code) {
            $add_minutes = $last_code->created_at->addMinutes(1);
            $diff_second = Carbon::now()->diffInSeconds($add_minutes);

            if ($diff_second < 60) {
            	$this->errors = [
                    'errors' => [
                    	'limit' => [
                    		trans('user.number_second', ['second' => $diff_second])
                    	]
                    ]
                ];
                return false;
            }
        }
        return true;
    }

    /**
     * Check sms activation code
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkCode(Request $request)
    {
        $phone = preg_replace('/[\+\-\(\)]/is', '', $request->phone);

        $code_check = SmsCode::where('phone', $phone)
            ->orderBy('id', 'desc')
            ->where('code',  $request->code)
            ->where('expires_at', '>=', Carbon::now())
            ->first();

        if ($code_check) {
            $response = [
                'error' => 0
            ];
        } else {
            $response = [
                'error' => 1
            ];
        }
        return response()->json($response);
    }

    /**
     * Check phone number for uniqueness
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkPhone(Request $request)
    {
        $phone = preg_replace('/[\+\-\(\)]/is', '', $request->phone);

        $code_phone = User::where('phone', $phone)->first();

        if ($code_phone) {
            $response = [
                'error' => 1
            ];
        } else {
            $response = [
                'error' => 0
            ];
        }
        return response()->json($response);
    }

	/**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
    	$request->merge([
    		'phone' => preg_replace('/[\+\-\(\)]/', '', $request->phone)
    	]);

    	$request->validate([
    		'name'      => 'required',
            'phone'     => 'required|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
            // 'code' => [
            //     'required',
            //     Rule::exists('sms_codes')->where(function ($query) use ($request) {
            //         $query->where('phone', $request->phone);
            //         $query->where('code', $request->code);
            //         $query->where('expires_at', '>=', Carbon::now());
            //         $query->orderBy('id', 'desc');
            //     }),
            // ],
        ]);

    	$user = User::create([
    		'name'      => $request->name,
    		'phone'     => $request->phone,
    		'email'     => $request->email,
            'password'  => bcrypt($request->password),
            'role'      => 'student'
    	]);
        
        $verifyUser = VerifyUser::create([
            'user_id' => $user->id,
            'token' => str_random(40)
        ]);

        Mail::to($user->email)->send(new VerifyMail($user));
    	// auth()->guard()->login($user);
    	return redirect()->route('login')->with('status', 'Мы отправили вам код активации. Проверьте свою электронную почту и нажмите на ссылку, чтобы подтвердить.');
        // return response()->json([
        // 	'message' => 'User was created successfully',
        // 	'user' => $user
        // ], 201);
    }

    public function resendVerifyMail()
    {
        $user = User::where('email', request()->email)->first();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->verifyUser) {
            $verifyUser = VerifyUser::create([
                'user_id' => $user->id,
                'token' => str_random(40)
            ]);
        }

        Mail::to($user->email)->send(new VerifyMail($user));
        return redirect()->route('login')->with('status', 'Мы отправили вам код активации. Проверьте свою электронную почту и нажмите на ссылку, чтобы подтвердить.');
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();

        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->email_verified_at = \Carbon\Carbon::now();
                $verifyUser->user->save();
                $status = "Ваш адрес электронной почты подтвержден. Теперь вы можете войти.";
            } else {
                $status = "Ваш адрес электронной почты уже подтвержден. Теперь вы можете войти.";
            }
        } else {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }

        return redirect('/login')->with('status', $status);
    }
}
