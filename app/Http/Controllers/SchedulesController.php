<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
use App\Client;
use App\ClassType;
use App\ClassTypeStatus;
use App\Room;
use App\Plan;
use App\Professional;
use App\Http\Requests;
use App\Http\Requests\ScheduleRequest;
use App\Http\Controllers\Controller;

class SchedulesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }
    
    public function index() {
      $schedules = Schedule::all();
      
      return view('schedules.index')->with('schedules', $schedules);
    }
    
    public function show(schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    public function edit(schedule $schedule)
    {
        $rooms              = Room::lists('name', 'id');
        $plans              = Plan::lists('name', 'id');
        $clients            = Client::lists('name', 'id');
        $classTypes         = ClassType::lists('name', 'id');
        $professionals      = Professional::lists('name', 'id');
        $classTypeStatuses  = ClassTypeStatus::lists('name', 'id');

        $schedule->load('client');
        $schedule->load('plan');
        $schedule->load('classType');
        $schedule->load('room');
        $schedule->load('professional');

        return view('schedules.edit', compact('schedule', 'plans', 'clients', 'classTypes', 'rooms', 'professionals', 'classTypeStatuses'));
    }
    
    public function create()
    {   
        $rooms              = Room::lists('name', 'id');
        $plans              = Plan::lists('name', 'id');
        $clients            = Client::lists('name', 'id');
        $classTypes         = ClassType::lists('name', 'id');
        $professionals      = Professional::lists('name', 'id');
        $classTypeStatuses  = ClassTypeStatus::lists('name', 'id');

        return view('schedules.create', compact('plans', 'clients', 'classTypes', 'rooms', 'professionals', 'classTypeStatuses'));
    }
    
    public function store(scheduleRequest $request)
    {
        $schedule = schedule::create($request->all());
      
        return redirect('schedules');
    }

    public function update(schedule $schedule, scheduleRequest $request)
    {
        $schedule->update($request->all());

        return redirect('schedules');
    }

    public function destroy(schedule $schedule)
    {
        $schedule->destroy($schedule->id);

        return redirect('schedules');
    }
}
