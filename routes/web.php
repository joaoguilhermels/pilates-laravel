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

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/dashboard', 'HomeController@index');

    Route::get('/calendar', 'CalendarController@calendar');
    Route::get('/calendar/group', 'CalendarController@groupCalendar');

    Route::get('reports/cash-journal', 'ReportsController@cashJournal');
    Route::post('reports/cash-journal', 'ReportsController@showCashJournal');

    Route::get('clients/{clients}/plans/create', 'ClientPlansController@create');
    Route::post('clients/{clients}/plans/create', 'ClientPlansController@reviewClientPlan');
    Route::post('clients/{clients}/plans/review', 'ClientPlansController@store');

    ////////////////////////////////////////////////////////////////////////////////////////////////
    /*Route::get('clients/charges', 'ClientsController@indexCharges');
    Route::get('clients/charges/create', 'ClientsController@createCharge');
    Route::post('clients/charges/review', 'ClientsController@reviewCharge');
    Route::post('clients/charges/store', 'ClientsController@storeCharge');

    Route::get('clients/charges/{financial_transactions}/edit', 'ClientsController@editCharge');
    Route::put('clients/charges/{financial_transactions}/edit', 'ClientsController@updateCharge');

    Route::delete('clients/{clients}/plans/{clientPlans}/delete', 'ClientPlansController@destroy');

    Route::get('clients/{clients}/charges/report', 'ClientsController@reportCharge');*/

    Route::get('client-plans/{client_plans}/payment', 'FinancialTransactionsController@createPlanPayment');
    Route::post('client-plans/{client_plans}/payment', 'FinancialTransactionsController@storePlanPayment');
    Route::get('payment/{financial_transactions}', 'FinancialTransactionsController@editPlanPayment');
    Route::put('payment/{financial_transactions}', 'FinancialTransactionsController@updatePlanPayment');

    ////////////////////////////////////////////////////////////////////////////////////////////////

    //Route::get('professionals/{professionals}/payments/report', 'ProfessionalsController@reportPayment');
    Route::get('professionals/payments', 'ProfessionalsPaymentsController@index');
    Route::get('professionals/payments/create', 'ProfessionalsPaymentsController@create');
    Route::post('professionals/payments/review', 'ProfessionalsPaymentsController@generatePaymentReport');
    Route::post('professionals/{professionals}/payments/store', 'ProfessionalsPaymentsController@store');
    Route::delete('professionals/payments/{financial_transactions}/delete', 'ProfessionalsPaymentsController@destroy');


    Route::get('schedules/trial/create', 'TrialSchedulesController@create');
    Route::post('schedules/trial/create', 'TrialSchedulesController@store');
    Route::get('schedules/reposition/create', 'RepositionSchedulesController@create');
    Route::post('schedules/reposition/create', 'RepositionSchedulesController@store');
    Route::get('schedules/extra/create', 'ExtraClassSchedulesController@create');
    Route::post('schedules/extra/create', 'ExtraClassSchedulesController@store');

    Route::resource('payment-methods', 'PaymentMethodsController');
    Route::resource('bank-accounts', 'BankAccountsController');
    Route::post('clients/search', 'ClientsController@search');
    Route::resource('clients', 'ClientsController');
    Route::resource('professionals', 'ProfessionalsController');
    Route::resource('rooms', 'RoomsController');
    Route::resource('classes', 'ClassTypesController');
    Route::resource('plans', 'PlansController');
    Route::resource('schedules', 'SchedulesController');
    Route::resource('expenses', 'ExpensesController');
});
