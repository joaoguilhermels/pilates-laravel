<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use App\Models\ClassTypeStatus;
use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\ScheduleRequest;
use App\Models\Room;
use App\Models\Schedule;
use Carbon\Carbon;
use Session;

class SchedulesController extends Controller
{
    public function index()
    {
        $schedules = Schedule::orderBy('start_at', 'asc')
                    ->get()
                    ->groupBy(function ($item, $key) {
                        return date_create($item->start_at)->format('F Y');
                    });

        return view('schedules.index')->with('schedules', $schedules);
    }

    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    public function showSchedule(Schedule $schedule, $start_at, Room $room)
    {
        $start_at = \Carbon\Carbon::createFromTimestamp($start_at)->format('Y-m-d H:i:s');

        $schedules = Schedule::where('start_at', '=', $start_at)
                      ->where('room_id', '=', $room->id)
                      ->with('client', 'classTypeStatus')
                      ->get();

        $description = 'Class: '.$schedules->first()->classType->name.'<br>'.
                        'Professional: '.$schedules->first()->professional->name.'<br>'.
                        'Date/Time: '.$start_at.' to '.$schedules->first()->end_at->format('H:i').'<br>'.
                        'Client: '.$this->statusLabel($schedules->first()->classTypeStatus).' '.$schedules->first()->client->name.''.'<br>';

        return $description;
    }

    public function showGroup($start_at, Room $room)
    {
        $start_at = \Carbon\Carbon::createFromTimestamp($start_at)->format('Y-m-d H:i:s');

        $schedules = Schedule::where('start_at', '=', $start_at)
                          ->where('room_id', '=', $room->id)
                          ->with('client', 'classTypeStatus')
                          ->get();

        $description = 'Class: '.$schedules->first()->classType->name.'<br>'.
                        'Professional: '.$schedules->first()->professional->name.'<br>'.
                        'Date/Time: '.$start_at.' to '.$schedules->first()->end_at->format('H:i').'<br>'.
                        'Clients:<br>';

        foreach ($schedules as $schedule) {
            $description .= $this->statusLabel($schedule->classTypeStatus).' '.$schedule->client->name.''.'<br>';
        }

        return $description;
    }

    public function statusLabel(classTypeStatus $classTypeStatus)
    {
        return '<span class="label" style="background-color: '.$classTypeStatus->color.'">'.$classTypeStatus->name.'</span>';
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $classTypes = ClassType::with('professionals', 'rooms', 'statuses')->orderBy('name')->get();

        return view('schedules.create', compact('clients', 'classTypes'));
    }

    public function store(scheduleRequest $request)
    {
        $classType = ClassType::find($request->class_type_id);

        $request->request->add([
            'end_at' => Carbon::parse($request->start_at)
                ->addMinutes($classType->duration)
                ->toDateTimeString(),
        ]);

        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added schedule '.$schedule->start_at);

        return redirect('calendar');
    }

    public function edit(Schedule $schedule)
    {
        $plan = $schedule->clientPlanDetail->clientPlan->plan->name ?? '';
        $rooms = $schedule->classType->rooms;
        $professionals = $schedule->classType->professionals;
        $classTypeStatuses = $schedule->classType->statuses;

        $schedule->load('client')
                  ->load('scheduable');

        return view('schedules.edit', compact('schedule', 'plan', 'rooms', 'professionals', 'classTypeStatuses'));
    }

    public function update(Schedule $schedule, ScheduleRequest $request)
    {
        $classType = ClassType::find($request->class_type_id);

        $request->request->add([
            'end_at' => Carbon::parse($request->start_at)->addMinutes($classType->duration)->toDateTimeString(),
        ]);

        $schedule->update($request->all());

        Session::flash('message', 'Successfully updated schedule '.$schedule->start_at);

        return redirect('calendar');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->destroy($schedule->id);

        Session::flash('message', 'Successfully deleted schedule '.$schedule->start_at);

        return redirect('calendar');
    }
}
