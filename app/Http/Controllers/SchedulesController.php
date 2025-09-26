<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use App\Models\ClassTypeStatus;
use App\Models\Client;
use App\Models\ClientPlanDetail;
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
        $professionals = \App\Models\Professional::orderBy('name')->get();
        $rooms = Room::orderBy('name')->get();

        return view('schedules.create', compact('clients', 'classTypes', 'professionals', 'rooms'));
    }

    public function store(ScheduleRequest $request)
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
        // Safely get the plan name with proper polymorphic relationship checking
        $plan = '';
        try {
            // Check if the scheduable is a ClientPlanDetail and has the required relationships
            if ($schedule->scheduable instanceof ClientPlanDetail &&
                $schedule->scheduable->clientPlan && 
                $schedule->scheduable->clientPlan->plan) {
                $plan = $schedule->scheduable->clientPlan->plan->name;
            }
        } catch (\Exception $e) {
            // If there's any error accessing the relationship, just use empty string
            $plan = '';
        }

        // Safely get related data with null checking
        $rooms = $schedule->classType ? $schedule->classType->rooms : collect();
        $professionals = $schedule->classType ? $schedule->classType->professionals : collect();
        $classTypeStatuses = $schedule->classType ? $schedule->classType->statuses : collect();

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
        $schedule->delete();

        Session::flash('message', 'Successfully deleted schedule '.$schedule->start_at);

        return redirect('calendar');
    }
}
