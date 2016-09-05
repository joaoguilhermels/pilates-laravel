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

class ExtraClassSchedulesController extends Controller
{
    public function create()
    {
        $clients    = Client::all();
        $classTypes = ClassType::with('professionals', 'rooms')->get();

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
            'price' => $classType->extra_class_price
        ]);

        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added extra class schedule ' . $schedule->start_at);

        return redirect('calendar');
    }
}
