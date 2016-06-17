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
    return redirect()->route('monthly-tracking');
});

Route::auth();

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/monthly-tracking', ['uses'=>'MonthlyTrackingController@index', 'as'=>'monthly-tracking']);
    Route::post('/monthly-tracking', 'MonthlyTrackingController@saveRecord');
    Route::get('/monthly-tracking/delete/{id}', 'MonthlyTrackingController@deleteRecord');

    Route::get('/monthly-budget', ['uses'=>'MonthlyBudgetController@index', 'as'=>'monthly-budget']);
    Route::post('/monthly-budget', 'MonthlyBudgetController@saveRecord');

    Route::get('/income-and-expense-statement', ['uses'=>'MonthlyBudgetController@ieStatement', 'as'=>'income-and-expense-statement']);
    Route::get('/net-worth-statement', ['uses'=>'MonthlyBudgetController@netWorthStatement', 'as'=>'net-worth-statement']);

    Route::get('/financial-goals', ['uses'=>'FinancialGoalsController@index', 'as'=>'financial-goals']);
    Route::post('/financial-goals', 'FinancialGoalsController@saveRecord');
    Route::get('/financial-goals/delete/{id}', 'FinancialGoalsController@deleteRecord');

    Route::get('/financial-ratios', ['uses'=>'FinancialRatiosController@index', 'as'=>'financial-ratios']);
    Route::post('/financial-ratios', 'FinancialRatiosController@saveRecord');

    Route::get('/retirement-needs', ['uses'=>'RetirementNeedsController@index', 'as'=>'retirement-needs']);
    Route::post('/retirement-needs', 'RetirementNeedsController@saveRecord');

    Route::get('/life-insurance', ['uses'=>'LifeInsuranceController@index', 'as'=>'life-insurance']);
    Route::post('/life-insurance', 'LifeInsuranceController@saveRecord');

});
