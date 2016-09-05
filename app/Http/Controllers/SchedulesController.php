<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Room;
use App\Plan;
use App\Schedule;
use App\Client;
use App\ClassType;
use App\ClassTypeStatus;
use App\ClientPlanDetail;
use App\Professional;
use App\Http\Requests;
use App\Http\Requests\ScheduleRequest;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class SchedulesController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('start_at', 'asc')
          ->get()
          ->groupBy(function ($item, $key) {
            return date_create($item->start_at)->format("F Y");
          });

        return view('schedules.index')->with('schedules', $schedules);
    }

    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    public function create()
    {
        $rooms              = Room::all();
        $plans              = Plan::all();
        $clients            = Client::orderBy('name')->get();
        $classTypes         = ClassType::orderBy('name')->get();
        $professionals      = Professional::orderBy('name')->get();
        $classTypeStatuses  = ClassTypeStatus::all();

        return view('schedules.create', compact('plans', 'clients', 'classTypes', 'rooms', 'professionals', 'classTypeStatuses'));
    }

    public function store(scheduleRequest $request)
    {
        $classType = ClassType::find($request->class_type_id);
        
        $request->request->add([
            'end_at' => Carbon::parse($request->start_at)->addMinutes($classType->duration)
        ]);
dd($request->all());
        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added schedule ' . $schedule->start_at);

        return redirect('calendar');
    }

    public function edit(Schedule $schedule)
    {
        //$plan               = is_null($schedule->clientPlanDetail) ? "" : $schedule->clientPlanDetail->clientPlan->plan->name;
        $plan               = $schedule->clientPlanDetail->clientPlan->plan->name ?? "";
        $rooms              = $schedule->classType->rooms;
        $professionals      = $schedule->classType->professionals;
        $classTypeStatuses  = $schedule->classType->statuses;

        $schedule->load('client')
                  ->load('scheduable');

        return view('schedules.edit', compact('schedule', 'plan', 'rooms', 'professionals', 'classTypeStatuses'));
    }

    public function update(Schedule $schedule, ScheduleRequest $request)
    {
        $schedule->update($request->all());

        Session::flash('message', 'Successfully updated schedule ' . $schedule->start_at);

        return redirect('calendar');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->destroy($schedule->id);

        Session::flash('message', 'Successfully deleted schedule ' . $schedule->start_at);

        return redirect('calendar');
    }
}
