<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('ficheck');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/monthly-tracking', ['uses'=>'MonthlyTrackingController@index', 'as'=>'monthly-tracking']);
    Route::post('/monthly-tracking', 'MonthlyTrackingController@saveRecord');
    Route::get('/monthly-tracking/delete/{id}', 'MonthlyTrackingController@deleteRecord');

    Route::get('/financial-goals', ['uses'=>'FinancialGoalsController@index', 'as'=>'financial-goals']);
    Route::post('/financial-goals', 'FinancialGoalsController@saveRecord');
    Route::get('/financial-goals/delete/{id}', 'FinancialGoalsController@deleteRecord');

    Route::get('/financial-ratios', ['uses'=>'FinancialRatiosController@index', 'as'=>'financial-ratios']);
    // Route::post('/financial-goals', 'FinancialGoalsController@saveRecord');
    // Route::get('/financial-goals/delete/{id}', 'FinancialGoalsController@deleteRecord');
});
