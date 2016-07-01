<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
use App\Client;
use App\ClassType;
use App\ClassTypeStatus;
use App\ClientPlanDetail;
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

    public function calendar() {
        $events = [];

        //$schedules = Schedule::all();
        $schedules = Schedule::with(['ClassType', 'ClassTypeStatus', 'Professional'])->get();

        foreach($schedules as $schedule) {
            $events[] = \Calendar::event(
              $this->setEventTitle($schedule), //event title
              false, //full day event?
              $schedule->start_at, //start time (you can also use Carbon instead of DateTime)
              $schedule->end_at, //end time (you can also use Carbon instead of DateTime)
              $schedule->id, //optionally, you can specify an event ID
              [
                'color' => $schedule->classTypeStatus->color,
                'url' => '/schedules/' . $schedule->id . '/edit',
                'description' => $this->eventDescription($schedule)
              ]
            );
        }

        $calendar = \Calendar::addEvents($events);

        $calendar = \Calendar::setOptions(array(
            'allDaySlot' => false,
            'defaultView' => 'agendaWeek', // Add custom option
            'weekends' => false, // Add custom option
            'businessHours' => array(
              'start' => '07:00',
              'end' => '20:30',
              //'dow' => array(1, 2, 3, 4, 5)
            ),
            'nowIndicator' => true,
            'minTime' => '07:00:00',
            'maxTime' => '21:00:00',
            'contentHeight' => 'auto'
            //'lang' => 'pt-BR',

        ));

        $calendar = \Calendar::setCallbacks(array(
            'dayClick' => 'function (date, jsEvent, view) {
                vm.showModalNow(date.format());
            }',
            'eventClick' => 'function (calEvent, jsEvent, view) {
                // change the border color just for fun
                $(this).css(\'border-color\', \'red\');
            }',
            'eventRender' => 'function(event, element) {
                var ntoday = Math.round(new Date().getTime() / 1000),
                    eventEnd = event.end.unix(),
                    eventStart = event.start.unix();

                if (eventEnd < ntoday){
                    element.addClass(\'past-event\');
                }

                element.qtip({
                    prerender: true,
                    content: {
                        \'text\': event.description
                    },
                    position: {
                  			at: \'top left\',
                  			my: \'bottom right\',
                  			target: \'mouse\',
                  			viewport: $(\'#fullcalendar\'),
                  			adjust: {
                  				mouse: true,
                  				scroll: true
                  			}
                		},
                		style: {
                        classes: \'qtip-bootstrap qtip-shadow\'
                    }
                });
                element.find(\'div.fc-title\').html(element.find(\'div.fc-title\').text());
            }',
        ));

        return view('calendar.index', compact('calendar'));
    }

    public function setEventTitle(Schedule $schedule)
    {
        $badge = "";

        if ($schedule->trial) {
            $badge = "<span class=\"label label-warning\">AE</span>";
        }

        return $badge . ' ' . $schedule->client->name . ' - ' . $schedule->classType->name;
    }

    public function eventDescription(Schedule $schedule)
    {
        $description =  '<strong>Client:</strong> ' . $schedule->client->name . '<br>' .
                        '<strong>Class:</strong> ' . $schedule->classType->name . '<br>' .
                        '<strong>Date/Time:</strong> ' . $schedule->start_at->format("d/m/Y H:i") . ' to ' . $schedule->end_at->format("H:i") . '<br>' .
                        '<strong>Professional:</strong> ' . $schedule->professional->name . '<br>' .
                        '<strong>Status:</strong> ' . $schedule->classTypeStatus->name;

        return $description;
    }

    /*public function groupCalendar() {
        $events = [];

        //$schedules = Schedule::all();
        $schedules = DB::table('schedules')
                          ->groupBy('account_id')

        //select class_type_id, group_concat(client_id) from schedules group by class_type_id, professional_id, room_id, date_format(start_At,'%Y-%m-%d %H:%i:00');

        foreach($schedules as $schedule) {
            $events[] = \Calendar::event(
              $schedule->client->name, //event title
              false, //full day event?
              $schedule->start_at, //start time (you can also use Carbon instead of DateTime)
              $schedule->end_at, //end time (you can also use Carbon instead of DateTime)
              $schedule->id //optionally, you can specify an event ID
            );
        }

        $calendar = \Calendar::addEvents($events);

        $calendar = \Calendar::setOptions(array(
            'allDaySlot' => false,
            'defaultView' => 'agendaWeek', // Add custom option
            'weekends' => false, // Add custom option
            'businessHours' => array(
              'start' => '07:00',
              'end' => '20:00',
              //'dow' => array(1, 2, 3, 4, 5)
            ),
            'nowIndicator' => true,
            //'minTime' => '06:00:00',
            //'maxTime' => '21:00:00',
            //'lang' => 'pt-BR',

        ));

        $calendar = \Calendar::setCallbacks(array(
            'dayClick' => 'function (date, jsEvent, view) {
                alert(\'Clicked on: \' + date.format());
            }',
            'eventClick' => 'function (calEvent, jsEvent, view) {
                alert(\'Event: \' + calEvent.title);
                alert(\'Coordinates: \' + jsEvent.pageX + \',\' + jsEvent.pageY);
                alert(\'View: \' + view.name);

                // change the border color just for fun
                $(this).css(\'border-color\', \'red\');
            }',
            'eventRender' => 'function(event, element) {
                element.qtip({
                    prerender: true,
                    content: {
                        \'text\': event.title
                    },
                    position: {
                  			at: \'top left\',
                  			my: \'bottom right\',
                  			target: \'mouse\',
                  			viewport: $(\'#fullcalendar\'),
                  			adjust: {
                  				mouse: true,
                  				scroll: true
                  			}
                		},
                		style: {
                        classes: \'qtip-bootstrap qtip-shadow\'
                    }
                });
            }',
        ));

        return view('calendar.index', compact('calendar'));
    }*/

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
        $schedule = Schedule::create($request->all());

        return redirect('schedules');
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
        $unscheduledStatusId = classTypeStatus::where('name', 'Desmarcou')->where('class_type_id', $request->class_type_id)->pluck('id');

        $unscheduled = Schedule::where('client_id', $request->client_id)->whereIn('class_type_status_id', $unscheduledStatusId)->first();

        $repositionStatus = ClassTypeStatus::where('name', 'Reposição')->where('class_type_id', $request->class_type_id)->first();

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

        return redirect('schedules');
    }

    public function createTrialClass()
    {
        //$classTypes         = ClassType::where('free_trial', true)->with('professionals', 'rooms', 'statuses')->get();

        $rooms              = Room::all();
        $classTypes         = ClassType::all();
        $professionals      = Professional::all();

        return view('schedules.trial.create', compact('plans', 'classTypes', 'rooms', 'professionals'));
    }

    public function storeTrialClass(ScheduleRequest $request)
    {
        $request->request->add([
            'observation' => 'New client. Scheduled a trial class.',
        ]);

        $client = Client::create($request->all());

        $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)->where('name', 'OK')->first();

        $request->request->add([
            'trial' => true,
            'client_id' => $client->id,
            'class_type_status_id' => $classTypeStatus->id
        ]);

        $schedule = Schedule::create($request->all());

        return redirect('schedules');
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
        $classTypeStatus = ClassTypeStatus::where('class_type_id', $request->class_type_id)->where('name', 'OK')->first();

        $request->request->add([
            'class_type_status_id' => $classTypeStatus->id,
            'observation' => 'Extra Class.',
            'price' => $classType->extra_class_price
        ]);

        $schedule = Schedule::create($request->all());

        return redirect('schedules');
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

        return redirect('schedules');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->destroy($schedule->id);

        return redirect('schedules');
    }
}
