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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
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
        $clients            = Client::all();
        $classTypes         = ClassType::all();
        $professionals      = Professional::all();
        $classTypeStatuses  = ClassTypeStatus::all();

        return view('schedules.create', compact('plans', 'clients', 'classTypes', 'rooms', 'professionals', 'classTypeStatuses'));
    }

    public function store(scheduleRequest $request)
    {
        $request->request->add([
            'start_at' => Carbon::parse($request->date_start_at . ' ' . $request->time_start_at),
            'end_at' => Carbon::parse($request->date_end_at . ' ' . $request->time_end_at)
        ]);

        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added schedule ' . $schedule->start_at);

        return redirect('calendar');
    }

    public function edit(Schedule $schedule)
    {
        $plan               = is_null($schedule->clientPlanDetail) ? "" : $schedule->clientPlanDetail->clientPlan->plan->name;
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

    public function createReposition()
    {
        $unscheduledStatusesIds = classTypeStatus::where('name', 'Desmarcou')->pluck('id');

        // List only class which are unscheduled and were not rescheduled alterady
        $clients            = Client::whereHas('schedules', function ($query) use($unscheduledStatusesIds) {
            $query->whereIn('class_type_status_id', $unscheduledStatusesIds)->where('parent_id', '=', '0');
        })
        ->groupBy('clients.id')
        ->get();

        $classTypes = ClassType::whereHas('schedules', function ($query) use($unscheduledStatusesIds) {
            $query->whereIn('class_type_status_id', $unscheduledStatusesIds)->where('parent_id', '=', '0');
        })
        ->groupBy('class_types.id')
        ->get();

        $rooms              = Room::all();
        $professionals      = Professional::all();

        return view('schedules.reposition.create', compact('clients', 'classTypes', 'rooms', 'professionals'));
    }

    public function storeReposition(ScheduleRequest $request)
    {
        $unscheduledStatusId = classTypeStatus::where('name', 'Desmarcou')
                                    ->where('class_type_id', $request->class_type_id)
                                    ->pluck('id');

        $unscheduled = Schedule::where('client_id', $request->client_id)
                            ->whereIn('class_type_status_id', $unscheduledStatusId)
                            ->first();

        $repositionStatus = ClassTypeStatus::where('name', 'Reposição')
                                ->where('class_type_id', $request->class_type_id)
                                ->first();

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

    public function createTrialClass()
    {
        //$rooms = Room::WhereClassesAllowTrials()->get();
        $classTypes = ClassType::WithTrial()->with('professionals', 'rooms')->get();
        //$professionals = Professional::GivingTrialClasses()->get();

        return view('schedules.trial.create', compact('classTypes'));
    }

    public function storeTrialClass(ScheduleRequest $request)
    {
        $request->request->add([
            'observation' => 'New client. Scheduled a trial class.',
        ]);

        $client = Client::create($request->all());

        $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)
                                ->where('name', 'OK')
                                ->first();

        $request->request->add([
            'trial' => true,
            'client_id' => $client->id,
            'class_type_status_id' => $classTypeStatus->id
        ]);

        $schedule = Schedule::create($request->all());

        Session::flash('message', 'Successfully added trial schedule ' . $schedule->start_at);

        return redirect('calendar');
    }

    public function createExtraClass()
    {
        $rooms              = Room::all();
        $clients            = Client::all();
        $classTypes         = ClassType::all();
        $professionals      = Professional::all();

        return view('schedules.extra.create', compact('clients', 'plans', 'classTypes', 'rooms', 'professionals'));
    }

    public function storeExtraClass(ScheduleRequest $request)
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
