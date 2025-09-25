<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Api\DependencyController;
use App\Http\Controllers\Api\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // API Resources for testing
    Route::apiResource('schedules', ScheduleController::class);
    Route::apiResource('clients', ClientController::class);
    
    Route::get('/calendar/group', 'CalendarController@groupCalendarEventsNew');
    
    // Global Search
    Route::get('/search', [SearchController::class, 'search']);
    
    // Dependency checking and deletion protection
    Route::get('/check-dependencies/{entityType}/{entityId}', [DependencyController::class, 'checkDependencies']);
    Route::post('/check-schedule-conflicts', [DependencyController::class, 'checkScheduleConflicts']);
});
