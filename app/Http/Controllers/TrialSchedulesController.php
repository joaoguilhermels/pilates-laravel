<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use App\Models\ClassTypeStatus;
use App\Models\Client;
use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use Carbon\Carbon;
use Session;

class TrialSchedulesController extends Controller
{
    public function create()
    {
        $classTypes = ClassType::WithTrial()->with('professionals', 'rooms')->get();

        return view('schedules.trial.create', compact('classTypes'));
    }

    public function store(ScheduleRequest $request)
    {
        $request->request->add([
            'observation' => 'New client. Scheduled a trial class.',
        ]);

        $client = Client::create($request->all());

        $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)
                                ->where('name', 'OK')
                                ->first();

        $classType = ClassType::FindOrFail($request->class_type_id);

        $request->request->add([
            'trial' => true,
            'end_at' => Carbon::parse($request->start_at)->addMinutes($classType->duration)->toDateTimeString(),
            'client_id' => $client->id,
            'class_type_status_id' => $classTypeStatus->id,
        ]);

        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added trial schedule '.$schedule->start_at);

        return redirect('calendar');
    }
}
