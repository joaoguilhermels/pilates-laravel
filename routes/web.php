<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ClientPlansController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfessionalsPaymentsController;
use App\Http\Controllers\TrialSchedulesController;
use App\Http\Controllers\ExtraClassSchedulesController;
use App\Http\Controllers\RepositionSchedulesController;
use App\Http\Controllers\GroupSchedulesController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\PlansController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ClientPlanPaymentsController;
use App\Http\Controllers\ProfessionalsController;
use App\Http\Controllers\ClassTypesController;
use App\Http\Controllers\BankAccountsController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchedulesController;

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

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/onboarding/complete-step', [HomeController::class, 'completeOnboardingStep'])->name('onboarding.complete-step');
    Route::post('/onboarding/skip', [HomeController::class, 'skipOnboarding'])->name('onboarding.skip');
    Route::post('/onboarding/start', [HomeController::class, 'startOnboarding'])->name('onboarding.start');
    
    // Test route for Alpine.js debugging
    Route::get('/test-alpine', function () {
        return view('test-alpine');
    })->name('test.alpine');

    // User Profile Routes
    Route::get('/profile', [UserController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [UserController::class, 'editPassword'])->name('profile.password.edit');
    Route::patch('/profile/password', [UserController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');

    // Role Management Routes (Only for System Admin and Studio Owner)
    Route::middleware(['role:system_admin,studio_owner'])->group(function () {
        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::post('/roles/assign', [RoleController::class, 'assignRole'])->name('roles.assign');
        Route::delete('/roles/remove', [RoleController::class, 'removeRole'])->name('roles.remove');
    });

    Route::get('calendar', [CalendarController::class, 'calendar'])->name('calendar');
    Route::get('calendar/data', [CalendarController::class, 'calendarEvents'])->name('calendar.data');
    Route::get('calendar/group', [CalendarController::class, 'groupCalendar'])->name('calendar.group');
    Route::get('calendar/group/data', [CalendarController::class, 'calendarGroupEvents'])->name('calendar.group.data');

    Route::get('reports/cash-journal', [ReportsController::class, 'cashJournal'])->name('reports.cash-journal');
    Route::post('reports/cash-journal', [ReportsController::class, 'showCashJournal'])->name('reports.cash-journal.show');

    Route::get('clients/{client}/plans/create', [ClientPlansController::class, 'create'])->name('clients.plans.create');
    Route::post('clients/{client}/plans/create', [ClientPlansController::class, 'reviewClientPlan'])->name('clients.plans.review');
    Route::post('clients/{client}/plans', [ClientPlansController::class, 'store'])->name('clients.plans.store');
    Route::delete('clients/plans/{clientPlan}/delete', [ClientPlansController::class, 'destroy'])->name('clients.plans.destroy');
    Route::get('client-plans/{clientPlan}/edit', [ClientPlansController::class, 'edit'])->name('client-plans.edit');
    Route::put('client-plans/{clientPlan}', [ClientPlansController::class, 'update'])->name('client-plans.update');
    Route::patch('client-plans/{clientPlan}', [ClientPlansController::class, 'update']);

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
    Route::get('client-plans/{clientPlan}/payment', [ClientPlanPaymentsController::class, 'create'])->name('client-plans.payment.create');
    Route::post('client-plans/{clientPlan}/payment', [ClientPlanPaymentsController::class, 'store'])->name('client-plans.payment.store');
    Route::delete('client-plans/{clientPlan}/delete', [ClientPlanPaymentsController::class, 'destroy'])->name('client-plans.payment.destroy');
    Route::get('payment/{financialTransactions}/edit', [ClientPlanPaymentsController::class, 'edit'])->name('payment.edit');
    Route::patch('payment/{financialTransactions}', [ClientPlanPaymentsController::class, 'update'])->name('payment.update');
    Route::get('payment/{financialTransactions}', [ClientPlanPaymentsController::class, 'show'])->name('payment.show');

    ////////////////////////////////////////////////////////////////////////////////////////////////

    //Route::get('professionals/{professionals}/payments/report', [ProfessionalsController::class, 'reportPayment']);
    Route::get('professionals/payments', [ProfessionalsPaymentsController::class, 'index'])->name('professionals.payments.index');
    Route::get('professionals/payments/create', [ProfessionalsPaymentsController::class, 'create'])->name('professionals.payments.create');
    Route::post('professionals/payments/review', [ProfessionalsPaymentsController::class, 'generatePaymentReport'])->name('professionals.payments.review');
    Route::post('professionals/{professional}/payments/store', [ProfessionalsPaymentsController::class, 'store'])->name('professionals.payments.store');
    Route::get('professionals/payments/{financialTransaction}/edit', [ProfessionalsPaymentsController::class, 'edit'])->name('professionals.payments.edit');
    Route::patch('professionals/payments/{financialTransaction}/update', [ProfessionalsPaymentsController::class, 'update'])->name('professionals.payments.update');
    Route::delete('professionals/payments/{financialTransaction}/delete', [ProfessionalsPaymentsController::class, 'destroy'])->name('professionals.payments.destroy');

    // Specific schedule routes MUST come before the resource route
    Route::get('schedules/trial/create', [TrialSchedulesController::class, 'create'])->name('schedules.trial.create');
    Route::post('schedules/trial/create', [TrialSchedulesController::class, 'store'])->name('schedules.trial.store');
    Route::get('schedules/reposition/create', [RepositionSchedulesController::class, 'create'])->name('schedules.reposition.create');
    Route::post('schedules/reposition/create', [RepositionSchedulesController::class, 'store'])->name('schedules.reposition.store');
    Route::get('schedules/extra/create', [ExtraClassSchedulesController::class, 'create'])->name('schedules.extra.create');
    Route::post('schedules/extra/create', [ExtraClassSchedulesController::class, 'store'])->name('schedules.extra.store');
    Route::get('schedules/create', [SchedulesController::class, 'create'])->name('schedules.create');
    Route::post('schedules/create', [SchedulesController::class, 'store'])->name('schedules.store');
    Route::get('schedules/class/{classType}/professional/{professionals}/room/{rooms}/date/{date}/time/{time}', [GroupSchedulesController::class, 'edit'])->name('schedules.group.edit');
    
    // Resource route for schedules (must come before the timestamp-based routes)
    Route::resource('schedules', SchedulesController::class);
    
    // Timestamp-based routes with constraints to avoid conflicts
    Route::get('schedules/{start_at}/{room}/group', [SchedulesController::class, 'showGroup'])
        ->where('start_at', '[0-9]+')
        ->where('room', '[0-9]+')
        ->name('schedules.group');
    Route::get('schedules/{start_at}/{room}', [SchedulesController::class, 'showSchedule'])
        ->where('start_at', '[0-9]+')
        ->where('room', '[0-9]+')
        ->name('schedules.show-schedule');

    Route::resource('rooms', RoomsController::class)->middleware('onboarding');
    Route::resource('plans', PlansController::class)->middleware('onboarding');
    Route::resource('clients', ClientsController::class)->middleware('onboarding');
    Route::resource('professionals', ProfessionalsController::class)->middleware('onboarding');

    Route::resource('classes', ClassTypesController::class)->parameters([
        'classes' => 'classType',
    ])->middleware('onboarding');
    Route::resource('bank-accounts', BankAccountsController::class)->parameters([
        'bank-accounts' => 'bankAccount',
    ]);
    Route::resource('payment-methods', PaymentMethodsController::class)->parameters([
        'payment-methods' => 'paymentMethod',
    ]);
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
