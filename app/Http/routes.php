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

Route::get('/home', function() {
    return redirect('/');
});

Route::auth();

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::post('/monthly-tracking', 'MonthlyTrackingController@saveRecord');
    Route::get('/monthly-tracking/delete/{id}', 'MonthlyTrackingController@deleteRecord');

    Route::post('/monthly-budget', 'MonthlyBudgetController@saveRecord');


    Route::post('/financial-goals', 'FinancialGoalsController@saveRecord');
    Route::get('/financial-goals/delete/{id}', 'FinancialGoalsController@deleteRecord');

    Route::post('/financial-ratios', 'FinancialRatiosController@saveRecord');

    Route::post('/retirement-needs', 'RetirementNeedsController@saveRecord');

    Route::post('/life-insurance', 'LifeInsuranceController@saveRecord');

    Route::post('/revolving-savings', 'RevolvingSavingsController@saveRecord');

    Route::group([
        'middleware' => ['viewUserData']
    ], function() {
        Route::get('/monthly-tracking/{user_id?}', ['uses'=>'MonthlyTrackingController@index', 'as'=>'monthly-tracking']);
        Route::get('/monthly-budget/{user_id?}', ['uses'=>'MonthlyBudgetController@index', 'as'=>'monthly-budget']);
        Route::get('/revolving-savings/{user_id?}', ['uses'=>'RevolvingSavingsController@index', 'as'=>'revolving-savings']);
        Route::get('/income-and-expense-statement/{user_id?}', ['uses'=>'MonthlyBudgetController@ieStatement', 'as'=>'income-and-expense-statement']);
        Route::get('/net-worth-statement/{user_id?}', ['uses'=>'MonthlyBudgetController@netWorthStatement', 'as'=>'net-worth-statement']);
        Route::get('/financial-goals/{user_id?}', ['uses'=>'FinancialGoalsController@index', 'as'=>'financial-goals']);
        Route::get('/financial-ratios/{user_id?}', ['uses'=>'FinancialRatiosController@index', 'as'=>'financial-ratios']);
        Route::get('/retirement-needs/{user_id?}', ['uses'=>'RetirementNeedsController@index', 'as'=>'retirement-needs']);
        Route::get('/life-insurance/{user_id?}', ['uses'=>'LifeInsuranceController@index', 'as'=>'life-insurance']);
        Route::get('/categories/{type}', ['uses' => 'MonthlyTrackingController@categories', 'as' => 'tracking-categories']);
        Route::get('/month/{id}', ['uses' => 'MonthlyTrackingController@deleteMonth', 'as' => 'delete-tracked-month']);
    });
});

Route::group([
    'prefix' => '/admin',
    'middleware' => ['web', 'auth', 'roles'],
    'roles' => ['administrator', 'grader']
], function() {
    Route::get('/', ['uses'=>'AdminController@index']);
    Route::post('/grade', ['uses'=>'AdminController@grade']);

});

Route::group([
    'prefix' => '/admin',
    'middleware' => ['web', 'auth', 'roles'],
    'roles' => ['administrator']
], function() {
    Route::post('/group/add/user/{id}', ['uses'=>'AdminController@addGroupUser']);
    Route::get('/group/delete/{userID}/{semesterID}', ['uses'=>'AdminController@deleteGroupUser']);
});

Route::group([
    'prefix' => '/admin',
    'middleware' => ['web', 'auth', 'roles'],
    'roles' => ['root']
], function() {
    Route::get('/groups', ['uses'=>'AdminController@groups']);
    Route::post('/groups', ['uses'=>'AdminController@saveGroups']);
    Route::post('/user/role/{userID}', ['uses' => 'AdminController@saveRole']);
});
