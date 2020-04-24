<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => ['localize']
], function() {


	/*
	|--------------------------------------------------------------------------
	| Frontend TEMP
	|--------------------------------------------------------------------------
	*/
	Route::get('/', function () {
	    return view('frontend.page.index');
	})->name('home');

	// Route::get('/video', function() {
	// 	return view('frontend.video.index');
	// })->name('video.index');

	Route::get('/video/show', function() {
		return view('frontend.video.show');
	})->name('video.show');

	// Auth pages
	Route::get('/login', function() {
		return view('frontend.page.login');
	})->name('login');

	Route::get('/register', function() {
		return view('frontend.page.register');
	})->name('register');

	Route::get('/profieducation', function() {
		return view('frontend.pro-edu.index');
	});

	Route::get('/profieducation-about', function() {
		return view('frontend.pro-edu.about');
	});

	Route::get('/profieducation-teachers', function() {
		return view('frontend.pro-edu.teachers');
	});

	// TO DO remove
	Route::get('/sms-codes', function() {
		echo '<pre>';
		var_dump(\App\Models\SmsCode::latest()->limit(100)->pluck('code', 'phone')->toArray());
		echo '</pre>';
	});

	/*
	|--------------------------------------------------------------------------
	| Frontend with backend
	|--------------------------------------------------------------------------
	*/

	Route::group(['namespace' => 'Frontend'], function() {

		// Home
		Route::get('/', 'PageController@index')->name('home');
		Route::post('/send-email', 'PageController@sendEmail');

		Route::get('/pass-recovery', 'PageController@passRecovery');

		//Видеоуроки
		Route::get('video', 'VideoController@index')->name('video.index');
		Route::get('video/{id}', 'VideoController@show')->name('video.show');

		// ProfiEducation
		Route::get('profi', 'ProfiController@index');
		Route::get('profi/teachers', 'ProfiController@teachers');
		Route::get('profi/about', 'ProfiController@about');

		// ВУЗы
		Route::get('university', 'UniversityController@index');
		Route::get('university/list', 'UniversityController@list');
		Route::get('university/show/{id}', 'UniversityController@show');

		Route::get('/terms-of-use', 'PageController@termsOfUse');

		// Cabinet (Vue SPA)
		Route::get('cabinet', 'CabinetController@index')
			  ->middleware(['auth'])
			  ->name('cabinet');
	});
});

/*
|--------------------------------------------------------------------------
| Payments routes
|--------------------------------------------------------------------------
|
| Routes for payments systems without checking csrf token
| Services: click, paynet, paycom
|
*/
Route::group(['prefix' => 'payments', 'namespace' => 'Payment'], function () {
	Route::any('click', 'ClickController@callbackRoute');
	Route::any('paynet', 'PaynetController@callbackRoute');
	Route::any('paycom', 'PaycomController@callbackRoute');
});

/*
|--------------------------------------------------------------------------
| OAuth routes
|--------------------------------------------------------------------------
|
| Additional routes for Laravel Passport package
|
*/
Route::group(['prefix' => 'oauth', 'namespace' => 'Auth'], function() {
	Route::post('send-sms', 'RegisterController@sendSms');
	Route::post('check-code', 'RegisterController@checkCode');
	Route::post('check-phone', 'RegisterController@checkPhone');
	Route::post('register', 'RegisterController@register');
	Route::get('verify/{token}', 'RegisterController@verifyUser');
	Route::get('resend-verify-mail', 'RegisterController@resendVerifyMail');
	Route::post('login', 'LoginController@handle');
	Route::get('logout', 'LoginController@logout');

	Route::post('send-reset-link', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password-reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password-update', 'ResetPasswordController@reset')->name('password.update');
});
