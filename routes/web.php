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
Route::auth();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/home', 'HomeController@index');

    Route::get('/calendar', 'CalendarController@calendar');
    Route::get('/calendar/group', 'CalendarController@groupCalendar');

    Route::get('reports/cash-journal', 'ReportsController@cashJournal');
    Route::post('reports/cash-journal', 'ReportsController@showCashJournal');

    Route::get('clients/{client}/plans/create', 'ClientPlansController@create');
    Route::post('clients/{client}/plans/create', 'ClientPlansController@reviewClientPlan');
    Route::post('clients/{client}/plans/review', 'ClientPlansController@store');

    ////////////////////////////////////////////////////////////////////////////////////////////////
    /*Route::get('clients/charges', 'ClientsController@indexCharges');
    Route::get('clients/charges/create', 'ClientsController@createCharge');
    Route::post('clients/charges/review', 'ClientsController@reviewCharge');
    Route::post('clients/charges/store', 'ClientsController@storeCharge');

    Route::get('clients/charges/{financial_transactions}/edit', 'ClientsController@editCharge');
    Route::put('clients/charges/{financial_transactions}/edit', 'ClientsController@updateCharge');

    Route::delete('clients/{clients}/plans/{clientPlans}/delete', 'ClientPlansController@destroy');

    Route::get('clients/{clients}/charges/report', 'ClientsController@reportCharge');*/

    Route::get('client-plans/{clientPlan}/payment', 'FinancialTransactionsController@createPlanPayment');
    Route::post('client-plans/{clientPlan}/payment', 'FinancialTransactionsController@storePlanPayment');
    Route::post('client-plans/{clientPlan}/delete', 'ClientPlansController@destroy');
    Route::get('payment/{financialTransaction}', 'FinancialTransactionsController@editPlanPayment');
    Route::put('payment/{financialTransaction}', 'FinancialTransactionsController@updatePlanPayment');

    ////////////////////////////////////////////////////////////////////////////////////////////////

    //Route::get('professionals/{professionals}/payments/report', 'ProfessionalsController@reportPayment');
    Route::get('professionals/payments', 'ProfessionalsPaymentsController@index');
    Route::get('professionals/payments/create', 'ProfessionalsPaymentsController@create');
    Route::post('professionals/payments/review', 'ProfessionalsPaymentsController@generatePaymentReport');
    Route::post('professionals/{professional}/payments/store', 'ProfessionalsPaymentsController@store');
    Route::get('professionals/payments/{financialTransaction}/edit', 'ProfessionalsPaymentsController@edit');
    Route::patch('professionals/payments/{financialTransaction}/update', 'ProfessionalsPaymentsController@update');
    Route::delete('professionals/payments/{financialTransaction}/delete', 'ProfessionalsPaymentsController@destroy');

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
    Route::resource('expenses', 'ExpensesController');
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