<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ClientPlansController;
use App\Http\Controllers\ClientPlanPaymentsController;
use App\Http\Controllers\ProfessionalsPaymentsController;
use App\Http\Controllers\SchedulesController;
use App\Http\Controllers\TrialSchedulesController;
use App\Http\Controllers\RepositionSchedulesController;
use App\Http\Controllers\ExtraClassSchedulesController;
use App\Http\Controllers\GroupSchedulesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProfessionalsController;
use App\Http\Controllers\ClassTypesController;
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\PaymentMethodsController;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index']);

    Route::get('calendar', [CalendarController::class, 'calendar']);
    Route::get('calendar/data', [CalendarController::class, 'calendarEvents']);
    Route::get('calendar/group', [CalendarController::class, 'groupCalendar']);
    Route::get('calendar/group/data', [CalendarController::class, 'calendarGroupEvents']);

    Route::get('reports/cash-journal', [ReportsController::class, 'cashJournal']);
    Route::post('reports/cash-journal', [ReportsController::class, 'showCashJournal']);

    Route::get('clients/{client}/plans/create', [ClientPlansController::class, 'create']);
    Route::post('clients/{client}/plans/create', [ClientPlansController::class, 'reviewClientPlan']);
    Route::post('clients/{client}/plans/review', [ClientPlansController::class, 'store']);
    Route::delete('clients/plans/{clientPlan}/delete', [ClientPlansController::class, 'destroy']);
    Route::get('client-plans/{clientPlan}/edit', [ClientPlansController::class, 'edit']);
    Route::patch('client-plans/{clientPlan}/edit', [ClientPlansController::class, 'update']);

    ////////////////////////////////////////////////////////////////////////////////////////////////
    /*Route::get('clients/charges', [ClientsController::class, 'indexCharges']);
    Route::get('clients/charges/create', [ClientsController::class, 'createCharge']);
    Route::post('clients/charges/review', [ClientsController::class, 'reviewCharge']);
    Route::post('clients/charges/store', [ClientsController::class, 'storeCharge']);

    Route::get('clients/charges/{financial_transactions}/edit', [ClientsController::class, 'editCharge']);
    Route::put('clients/charges/{financial_transactions}/edit', [ClientsController::class, 'updateCharge']);

    Route::delete('clients/{clients}/plans/{clientPlans}/delete', [ClientPlansController::class, 'destroy']);

    Route::get('clients/{clients}/charges/report', [ClientsController::class, 'reportCharge']);*/

    // These routes look wrong. Names are inconsistent too.
    Route::get('client-plans/{clientPlan}/payment', [ClientPlanPaymentsController::class, 'create']);
    Route::post('client-plans/{clientPlan}/payment', [ClientPlanPaymentsController::class, 'store']);
    Route::delete('client-plans/{clientPlan}/delete', [ClientPlanPaymentsController::class, 'destroy']);
    Route::get('payment/{financialTransactions}/edit', [ClientPlanPaymentsController::class, 'edit']);
    Route::patch('payment/{financialTransactions}', [ClientPlanPaymentsController::class, 'update']);
    Route::get('payment/{financialTransactions}', [ClientPlanPaymentsController::class, 'show']);

    ////////////////////////////////////////////////////////////////////////////////////////////////

    //Route::get('professionals/{professionals}/payments/report', [ProfessionalsController::class, 'reportPayment']);
    Route::get('professionals/payments', [ProfessionalsPaymentsController::class, 'index']);
    Route::get('professionals/payments/create', [ProfessionalsPaymentsController::class, 'create']);
    Route::post('professionals/payments/review', [ProfessionalsPaymentsController::class, 'generatePaymentReport']);
    Route::post('professionals/{professional}/payments/store', [ProfessionalsPaymentsController::class, 'store']);
    Route::get('professionals/payments/{financialTransaction}/edit', [ProfessionalsPaymentsController::class, 'edit']);
    Route::patch('professionals/payments/{financialTransaction}/update', [ProfessionalsPaymentsController::class, 'update']);
    Route::delete('professionals/payments/{financialTransaction}/delete', [ProfessionalsPaymentsController::class, 'destroy']);

    Route::get('schedules/{start_at}/{room}/group', [SchedulesController::class, 'showGroup']);
    Route::get('schedules/{start_at}/{room}', [SchedulesController::class, 'showSchedule']);
    Route::get('schedules/create', [SchedulesController::class, 'create']);
    Route::post('schedules/create', [SchedulesController::class, 'store']);
    Route::get('schedules/trial/create', [TrialSchedulesController::class, 'create']);
    Route::post('schedules/trial/create', [TrialSchedulesController::class, 'store']);
    Route::get('schedules/reposition/create', [RepositionSchedulesController::class, 'create']);
    Route::post('schedules/reposition/create', [RepositionSchedulesController::class, 'store']);
    Route::get('schedules/extra/create', [ExtraClassSchedulesController::class, 'create']);
    Route::post('schedules/extra/create', [ExtraClassSchedulesController::class, 'store']);

    Route::get('schedules/class/{classType}/professional/{professionals}/room/{rooms}/date/{date}/time/{time}', [GroupSchedulesController::class, 'edit']);

    Route::resource('rooms', RoomsController::class);
    Route::resource('plans', PlansController::class);
    Route::resource('clients', ClientsController::class);
    Route::resource('schedules', SchedulesController::class);
    Route::resource('professionals', ProfessionalsController::class);

    Route::resource('classes', ClassTypesController::class)->parameters([
        'classes' => 'classType',
    ]);
    Route::resource('bank-accounts', BankAccountsController::class)->parameters([
        'bank-accounts' => 'bankAccount',
    ]);
    Route::resource('payment-methods', PaymentMethodsController::class)->parameters([
        'payment-methods' => 'paymentMethod',
    ]);
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
