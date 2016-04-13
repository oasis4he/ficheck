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
Route::get('/monthly-tracking', 'MonthlyTrackingController@index');
Route::post('/monthly-tracking', 'MonthlyTrackingController@saveRecord');
Route::get('/monthly-tracking/delete/{id}', 'MonthlyTrackingController@deleteRecord');
