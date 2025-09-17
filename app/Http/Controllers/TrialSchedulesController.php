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
        // Combine date and time into start_at
        $startAt = Carbon::parse($request->start_date . ' ' . $request->start_time);
        
        // Create the client first
        $client = Client::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'observation' => $request->observation,
        ]);

        // Find the appropriate status (try 'Agendado' first, then 'OK', then first available)
        $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)
                                ->where('name', 'Agendado')
                                ->first();
        
        if (!$classTypeStatus) {
            $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)
                                    ->where('name', 'OK')
                                    ->first();
        }
        
        if (!$classTypeStatus) {
            $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)
                                    ->first();
        }

        $classType = ClassType::findOrFail($request->class_type_id);

        // Create the schedule
        $schedule = Schedule::create([
            'client_id' => $client->id,
            'class_type_id' => $request->class_type_id,
            'professional_id' => $request->professional_id,
            'room_id' => $request->room_id,
            'class_type_status_id' => $classTypeStatus->id,
            'trial' => true,
            'price' => $classType->trial_class_price,
            'start_at' => $startAt->toDateTimeString(),
            'end_at' => $startAt->addMinutes($classType->duration)->toDateTimeString(),
            'observation' => $request->observation,
        ]);

        Session::flash('message', 'Successfully scheduled trial class for ' . $client->name . ' on ' . $schedule->start_at->format('M j, Y \a\t g:i A'));

        return redirect('calendar');
    }
}
