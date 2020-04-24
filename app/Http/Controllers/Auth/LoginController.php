<?php

namespace App\Http\Controllers\Auth;

use Hash;
use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * User object
     * 
     * @var object
     */
    protected $user;

	/**
	 * Login post handle
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
    public function handle(Request $request)
    {
    	$request->merge([
    		'login' => preg_replace('/[\+\(\)]/', '', $request->login)
    	]);

    	$request->validate([
            'login'    => 'required',
            'password' => 'required'
        ]);

        if ($this->attempt($request->login, $request->password, $request->has('remember'))) {
            $user = auth()->user();
            
            if (strlen($user->email) > 0 && !$user->email_verified_at) {
                return redirect()->back()->withInput()->withErrors(['verified' => ['Вам необходимо подтвердить свой аккаунт. Мы отправили вам код активации, пожалуйста, проверьте вашу электронную почту.']]);
            }

            $url = url()->route('cabinet').'/#'.($user->subject_1_id  == 0 || $user->subject_2_id == 0 ? 'profile' : '');
            return redirect()->to($url);
        	// return response()->json([
        	// 	'success' => true
        	// ]);
        }

        return redirect()->back()->withInput()->withErrors([
            'password' => trans('auth.email_or_password_incorrect')
        ]);
    	// return response()->json([
        //     'errors' => [
        //     	'email_or_password' => [
        //     		trans('auth.email_or_password_incorrect')
        //     	]
        //     ]
    	// ]);
    }

    /**
     * Verify login and password
     * 
     * @param  string $login
     * @param  string $password
     * @param  boolean $remember
     * @return boolean | object
     */
    private function attempt($login, $password, $remember = false)
    {
    	$user = User::where('phone', $login)->orWhere('email', $login)->first();
        if (!$user) {
            return false;
        }

		// Verify A password Against MD5
        if (mb_strlen($user->password) == 32 && $user->password == md5($password)) {
            
            // Change hashing password from md5 to bcrypt
            $user->password = bcrypt($password);
            $user->save();

            auth()->guard()->login($user, $remember);
            return $user;
        }
        // Verifying A Password Against A Hash
    	elseif (Hash::check($password, $user->password)) {
    		auth()->guard()->login($user, $remember);
    		return $user;
    	}
    	
    	return false;
    }
    
    public function logout()
    {
        auth()->logout();
        return redirect()->route('home');
    }
}
