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

Route::get('/admin', function () {
    return view('admin');
});

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
Route::auth();

//Route::group(['middleware' => 'auth', 'domain' => '{account}.pilates-laravel.dev'], function () {
Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index');

    Route::get('calendar', 'CalendarController@calendar');
    Route::get('calendar/data', 'CalendarController@calendarEvents');
    Route::get('calendar/group', 'CalendarController@groupCalendarNew');
    Route::get('calendar/group/data', 'CalendarController@groupCalendarEventsNew');

    Route::get('reports/cash-journal', 'ReportsController@cashJournal');
    Route::post('reports/cash-journal', 'ReportsController@showCashJournal');

    Route::get('clients/{client}/plans/create', 'ClientPlansController@create');
    Route::post('clients/{client}/plans/create', 'ClientPlansController@reviewClientPlan');
    Route::post('clients/{client}/plans/review', 'ClientPlansController@store');
    Route::delete('clients/plans/{clientPlan}/delete', 'ClientPlansController@destroy');
    Route::get('client-plans/{clientPlan}/edit', 'ClientPlansController@edit');
    Route::patch('client-plans/{clientPlan}/edit', 'ClientPlansController@update');

    ////////////////////////////////////////////////////////////////////////////////////////////////
    /*Route::get('clients/charges', 'ClientsController@indexCharges');
    Route::get('clients/charges/create', 'ClientsController@createCharge');
    Route::post('clients/charges/review', 'ClientsController@reviewCharge');
    Route::post('clients/charges/store', 'ClientsController@storeCharge');

    Route::get('clients/charges/{financial_transactions}/edit', 'ClientsController@editCharge');
    Route::put('clients/charges/{financial_transactions}/edit', 'ClientsController@updateCharge');

    Route::delete('clients/{clients}/plans/{clientPlans}/delete', 'ClientPlansController@destroy');

    Route::get('clients/{clients}/charges/report', 'ClientsController@reportCharge');*/

    // These routes look wrong. Names are inconsistent too.
    Route::get('client-plans/{clientPlan}/payment', 'ClientPlanPaymentsController@create');
    Route::post('client-plans/{clientPlan}/payment', 'ClientPlanPaymentsController@store');
    Route::delete('client-plans/{clientPlan}/delete', 'ClientPlanPaymentsController@destroy');
    Route::get('payment/{financialTransactions}/edit', 'ClientPlanPaymentsController@edit');
    Route::patch('payment/{financialTransactions}', 'ClientPlanPaymentsController@update');
    Route::get('payment/{financialTransactions}', 'ClientPlanPaymentsController@show');

    ////////////////////////////////////////////////////////////////////////////////////////////////

    //Route::get('professionals/{professionals}/payments/report', 'ProfessionalsController@reportPayment');
    Route::get('professionals/payments', 'ProfessionalsPaymentsController@index');
    Route::get('professionals/payments/create', 'ProfessionalsPaymentsController@create');
    Route::post('professionals/payments/review', 'ProfessionalsPaymentsController@generatePaymentReport');
    Route::post('professionals/{professional}/payments/store', 'ProfessionalsPaymentsController@store');
    Route::get('professionals/payments/{financialTransaction}/edit', 'ProfessionalsPaymentsController@edit');
    Route::patch('professionals/payments/{financialTransaction}/update', 'ProfessionalsPaymentsController@update');
    Route::delete('professionals/payments/{financialTransaction}/delete', 'ProfessionalsPaymentsController@destroy');

    Route::get('schedules/{start_at}/{room}/group', 'SchedulesController@showGroup');
    Route::get('schedules/create', 'SchedulesController@create');
    Route::post('schedules/create', 'SchedulesController@store');
    Route::get('schedules/trial/create', 'TrialSchedulesController@create');
    Route::post('schedules/trial/create', 'TrialSchedulesController@store');
    Route::get('schedules/reposition/create', 'RepositionSchedulesController@create');
    Route::post('schedules/reposition/create', 'RepositionSchedulesController@store');
    Route::get('schedules/extra/create', 'ExtraClassSchedulesController@create');
    Route::post('schedules/extra/create', 'ExtraClassSchedulesController@store');

    Route::get('schedules/class/{classType}/professional/{professionals}/room/{rooms}/date/{date}/time/{time}', 'GroupSchedulesController@edit');
    
    Route::resource('rooms', 'RoomsController');
    Route::resource('plans', 'PlansController');
    Route::resource('clients', 'ClientsController');
    Route::resource('schedules', 'SchedulesController');
    Route::resource('professionals', 'ProfessionalsController');
    
    Route::resource('classes', 'ClassTypesController', ['parameters' => [
        'classes' => 'classType'
    ]]);
    Route::resource('bank-accounts', 'BankAccountsController', ['parameters' => [
        'bank-accounts' => 'bankAccount'
    ]]);
    Route::resource('payment-methods', 'PaymentMethodsController', ['parameters' => [
        'payment-methods' => 'paymentMethod'
    ]]);
});
