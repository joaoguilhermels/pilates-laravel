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
              $schedule->client->name . ' - ' . $schedule->classType->name, //event title
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
                vm.showModalNow(date.format());
            }',
            'eventClick' => 'function (calEvent, jsEvent, view) {
                // change the border color just for fun
                $(this).css(\'border-color\', \'red\');
            }',
            'eventRender' => 'function(event, element) {
                var ntoday = new Date().getTime();
                var eventEnd = moment( event.end ).valueOf();
                var eventStart = moment( event.start ).valueOf();
                if (!event.end){
                    if (eventStart < ntoday){
                        element.addClass(\'past-event\');
                        element.children().addClass(\'past-event\');
                    }
                } else {
                    if (eventEnd < ntoday){
                        element.addClass(\'past-event\');
                    }
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
            }',
        ));

        return view('calendar.index', compact('calendar'));
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
        //$classTypes         = ClassType::where('free_trial', true)->with('professionals', 'rooms', 'statuses')->get();

        $clients            = Client::whereHas('schedules.classTypeStatus', function ($query) {
          $query->where('name', '=', 'Desmarcou');
        })
        ->get();

        $rooms              = Room::lists('name', 'id');
        $classTypes         = ClassType::lists('name', 'id');
        $professionals      = Professional::lists('name', 'id');
        $classTypeStatuses  = ClassTypeStatus::lists('name', 'id');

        return view('schedules.reposition.create', compact('clients', 'classTypes', 'rooms', 'professionals', 'classTypeStatuses'));
    }

    public function storeReposition(ScheduleRequest $request)
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

    public function createTrialClass()
    {
        //$classTypes         = ClassType::where('free_trial', true)->with('professionals', 'rooms', 'statuses')->get();

        $rooms              = Room::lists('name', 'id');
        $classTypes         = ClassType::lists('name', 'id');
        $professionals      = Professional::lists('name', 'id');
        $classTypeStatuses  = ClassTypeStatus::lists('name', 'id');

        return view('schedules.trial.create', compact('plans', 'classTypes', 'rooms', 'professionals', 'classTypeStatuses'));
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

    public function edit(Schedule $schedule)
    {
        $rooms              = $schedule->classType->rooms;
        $professionals      = $schedule->classType->professionals;
        $classTypeStatuses  = $schedule->classType->statuses;

        $schedule->load('client')
                  ->load('scheduable');

        return view('schedules.edit', compact('schedule', 'rooms', 'professionals', 'classTypeStatuses'));
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
