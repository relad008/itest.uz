<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
	public function index()
	{
		$prices = Price::where('disabled', '0')
                       ->orderBy('price')
                       ->get();
		return view('frontend.page.index', compact('prices'));
	}

    public function passRecovery()
    {
        return view('frontend.page.password-recovery');
    }

	public function sendEmail(Request $request)
	{
		$data = request()->validate([
            'name' 					=> 'required',
            'email' 				=> 'required|email',
            'message' 		    	=> 'required',
            'g-recaptcha-response' 	=> 'required|captcha'
		]);

		// if (request()->session()->has('errors')) {
		// 	return response()->json([
		// 		'errors' => [
		// 			'g-recaptcha-response' => ['Поле g-recaptcha-response обязательно для заполнения.']
		// 		]
		// 	]);
		// }
		
		return response()->json([
			'status' => 1
		]);
	}

	public function termsOfUse()
	{
		return view('frontend.page.terms-of-use');
	}
}
