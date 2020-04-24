<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'API'
], function () {
    
    // Тесты
    Route::get('test/demo/{sub1}/{sub2}/{sub3}', 'TestController@demo');
    Route::get('test/direction/{sub1}/{sub2}/{sub3}', 'TestController@direction');
    Route::post('test/get-result', 'TestController@getResult');
    Route::get('test/statistics', 'TestController@statistics');
    Route::get('test/mistakes/{id}', 'TestController@mistakes');
    Route::get('test/thematic/{id}', 'TestController@getThematic');
    Route::get('test/thematic-select', 'TestController@thematicSelect');

    // Пользователь
    Route::get('user/info', 'UserController@info');
    Route::get('user/profile-data', 'UserController@profileData');
    Route::post('user/update-general', 'UserController@updateGeneral');
    Route::post('user/update-direction', 'UserController@updateDirection');
    Route::post('user/change-password', 'UserController@changePassword');

    // История операций
    Route::get('account', 'AccountController@list');

    // Цены
    Route::get('price', 'PriceController@list');
    
    // Тикеты
    Route::get('ticket', 'TicketController@list');
    Route::post('ticket', 'TicketController@create');
    Route::post('ticket/send', 'TicketController@send');
    Route::post('ticket/close', 'TicketController@close');
    Route::get('ticket/{id}/messages', 'TicketController@messages');

    Route::post('pay/send-click-invoice', 'PayController@sendClickInvoice');
    Route::post('pay/buy-from-account', 'PayController@buyFromAccount');
});



