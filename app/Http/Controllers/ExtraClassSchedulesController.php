<?php

namespace App\Http\Controllers;

use App\ClassType;
use App\ClassTypeStatus;
use App\Client;
use App\Http\Requests;
use App\Http\Requests\ScheduleRequest;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;

class ExtraClassSchedulesController extends Controller
{
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $classTypes = ClassType::with('professionals', 'rooms')->orderBy('name')->get();

        return view('schedules.extra.create', compact('clients', 'classTypes'));
    }

    public function store(ScheduleRequest $request)
    {
        $classType = ClassType::findOrFail($request->class_type_id);
        $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)
                            ->where('name', 'OK')
                            ->first();

        $request->request->add([
            'class_type_status_id' => $classTypeStatus->id,
            'observation' => 'Extra Class.',
            'price' => $classType->extra_class_price,
        ]);

        $request->request->add([
            'end_at' => Carbon::parse($request->start_at)->addMinutes($classType->duration)->toDateTimeString(),
        ]);

        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added extra class schedule '.$schedule->start_at);

        return redirect('calendar');
    }
}
