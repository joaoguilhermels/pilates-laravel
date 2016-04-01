<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/home', 'HomeController@index');

    Route::get('/calendar', 'SchedulesController@calendar');
    Route::get('/calendar/group', 'SchedulesController@groupCalendar');

    Route::get('clients/{clients}/plans/new', 'ClientPlansController@createClientPlan');
    Route::post('clients/{clients}/plans/new', 'ClientPlansController@reviewClientPlan');
    Route::post('clients/{clients}/plans/review', 'ClientPlansController@store');

    Route::get('professionals/{professionals}/payments/report', 'ProfessionalsController@reportPayment');

    Route::get('clients/{clients}/charges/report', 'ClientsController@reportCharge');

    Route::resource('clients', 'ClientsController');
    Route::resource('professionals', 'ProfessionalsController');
    Route::resource('rooms', 'RoomsController');
    Route::resource('classes', 'ClassTypesController');
    Route::resource('plans', 'PlansController');
    Route::resource('schedules', 'SchedulesController');
    Route::resource('expenses', 'ExpensesController');
});
