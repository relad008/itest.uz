<?php

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register backend routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middlewares group.
|
*/

Route::group(['middleware' => 'roles:admin,main_teacher,teacher'], function() {
    
    Route::get('user/list', 'UserController@index');
    Route::get('user/data', 'UserController@userData');
    Route::post('user/form', 'UserController@form');
    Route::get('user/student', 'UserController@student');
    Route::get('user/student-data', 'UserController@studentData');
    Route::post('user/student-form', 'UserController@studentForm');
    Route::post('user/delete', 'UserController@delete');
    
    // Категории
    Route::get('category/{parent_id?}', 'CategoryController@index');
    Route::get('category/form/{parent_id?}/{id?}', 'CategoryController@form');
    Route::get('category/delete/{parent_id?}/{id?}', 'CategoryController@delete');

    // Вопросы
    Route::get('question/search', 'QuestionController@findQuestion');
    Route::post('question/do-action', 'QuestionController@doAction');
    Route::get('question/edit', 'QuestionController@edit');
    Route::get('question/remove/{id}', 'QuestionController@remove');
    Route::get('question/{filter?}', 'QuestionController@index');

    // Цены
    Route::get('price', 'PriceController@index');
    Route::get('price/data', 'PriceController@data');
    Route::post('price/form', 'PriceController@form');
    Route::get('price/edit/{id?}', 'PriceController@edit'); // TO DO
    Route::post('price/delete', 'PriceController@delete');

    // ВУЗы
    Route::get('university', 'UniversityController@index');
    Route::get('university/data', 'UniversityController@data');
    Route::post('university/form', 'UniversityController@form');
    Route::post('university/delete', 'UniversityController@delete');

    // Рефералы
    Route::get('referal-stat', 'PageController@referalStat');
    Route::get('referal-stat/data', 'PageController@referalStatData');

    // Платежи
    Route::get('payment', 'PaymentController@index');
    Route::get('payment/data', 'PaymentController@data');

});

Route::group(['middleware' => 'roles:admin,moderator'], function() {
    // Отзывы
    Route::get('review', 'ReviewController@index');
    Route::get('review/data', 'ReviewController@data');
    Route::post('review/form', 'ReviewController@form');
    Route::post('review/delete', 'ReviewController@delete');

});

Route::group(['middleware' => 'roles:admin,main_teacher,teacher,moderator'], function() {

    // Видеоуроки
    Route::get('video', 'VideoController@index');
    Route::get('video/data', 'VideoController@data');
    Route::post('video/form', 'VideoController@form');
    Route::post('video/delete', 'VideoController@delete');

    // Категории блога
    Route::get('blog-category', 'BlogCategoryController@index');
    Route::get('blog-category/data', 'BlogCategoryController@data');
    Route::post('blog-category/form', 'BlogCategoryController@form');
    Route::post('blog-category/delete', 'BlogCategoryController@delete');

    // Блог
    Route::get('blog', 'BlogController@index');
    Route::get('blog/data', 'BlogController@data');
    Route::get('blog/form/{id?}', 'BlogController@form');
    Route::post('blog/form/{id?}', 'BlogController@handleForm');
    Route::post('blog/delete', 'BlogController@delete');

    Route::get('user/profile', 'UserController@profile');
    Route::post('user/profile', 'UserController@saveProfile');

    // Тикеты
    Route::get('ticket', 'TicketController@index');
    Route::get('ticket/data', 'TicketController@data');
    Route::get('ticket/{id}/messages', 'TicketController@messages');
    Route::post('ticket/send', 'TicketController@send');

    // Dashboard
    Route::get('/{cat1?}/{cat2?}/{cat3?}', 'PageController@dashboard')->name('backend.dashboard');
});