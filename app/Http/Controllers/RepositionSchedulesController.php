<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ScheduleRequest;

use Session;

use App\Client;
use App\Schedule;
use App\ClassType;
use App\ClassTypeStatus;

use \Carbon\Carbon;

class RepositionSchedulesController extends Controller
{
    public function create()
    {
        $unscheduledStatusesIds = classTypeStatus::where('name', 'Desmarcou')->pluck('id');

        // List only class which are unscheduled and were not rescheduled alterady
        $clients = Client::whereHas('schedules', function ($query) use ($unscheduledStatusesIds) {
            $query->whereIn('class_type_status_id', $unscheduledStatusesIds)
                ->whereNull('parent_id');
        })
        ->groupBy('clients.id')
        ->get();

        $classTypes = ClassType::whereHas('schedules', function ($query) use ($unscheduledStatusesIds) {
            $query->whereIn('class_type_status_id', $unscheduledStatusesIds)->whereNull('parent_id');
        })
        ->with(['professionals' => function ($query) {
            $query->orderBy('name');
        }, 
        'rooms' => function ($query) {
            $query->orderBy('name');
        }])
        ->groupBy('class_types.id')
        ->orderBy('class_types.name')
        ->get();

        return view('schedules.reposition.create', compact('clients', 'classTypes'));
    }

    public function store(ScheduleRequest $request)
    {
        $unscheduledStatusId = classTypeStatus::where('name', 'Desmarcou')
                                    ->where('class_type_id', $request->class_type_id)
                                    ->pluck('id');

        $unscheduled = Schedule::where('client_id', $request->client_id)
                                ->where('class_type_status_id', $unscheduledStatusId)
                                ->orderBy('start_at', 'desc')
                                ->first();

        $repositionStatus = ClassTypeStatus::where('name', 'Reposição')
                                ->where('class_type_id', $request->class_type_id)
                                ->first();

        $classType = ClassType::FindOrFail($request->class_type_id);

        $request->request->add([
            'end_at' => Carbon::parse($request->start_at)->addMinutes($classType->duration)->toDateTimeString()
        ]);

        $schedule = new Schedule;

        $schedule->end_at = $request->end_at;
        $schedule->room_id = $request->room_id;
        $schedule->start_at = $request->start_at;
        $schedule->parent_id = $unscheduled->id;
        $schedule->client_id = $request->client_id;
        $schedule->observation = 'Reposition class.';
        $schedule->class_type_id = $request->class_type_id;
        $schedule->scheduable_id = $unscheduled->scheduable_id;
        $schedule->professional_id = $request->professional_id;
        $schedule->scheduable_type = $unscheduled->scheduable_type;
        $schedule->class_type_status_id = $repositionStatus->id;

        $schedule->save();

        Schedule::where('id', $unscheduled->id)->update(['parent_id' => $unscheduled->id]);

        Session::flash('message', 'Successfully added reposition schedule ' . $schedule->start_at);

        return redirect('calendar');
    }
}
