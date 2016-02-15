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

    /*Route::get('clients', 'ClientsController@index');
    Route::get('clients/create', 'ClientsController@create');
    Route::get('clients/{id}', 'ClientsController@show');
    Route::post('clients', 'ClientsController@store');
    Route::edit('clients/{id}/edit', 'ClientsController@edit');*/
    Route::resource('clients', 'ClientsController');
    Route::resource('professionals', 'ProfessionalsController');
    Route::resource('rooms', 'RoomsController');
    Route::resource('classes', 'ClassTypesController');
});
