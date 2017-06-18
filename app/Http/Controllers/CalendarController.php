<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Schedule;
use App\ClassType;
use App\ClassTypeStatus;

class CalendarController extends Controller
{
    public function calendar()
    {
        $events = [];

        $has_available_trial_class = ClassType::WithTrial()->count() > 0;

        $schedules = Schedule::with(['ClassType', 'ClassTypeStatus', 'Professional'])->get();

        foreach ($schedules as $schedule) {
            $events[] = \Calendar::event(
                $this->setEventTitle($schedule), //event title
                false, //full day event?
                $schedule->start_at, //start time (you can also use Carbon instead of DateTime)
                $schedule->end_at, //end time (you can also use Carbon instead of DateTime)
                $schedule->id, //optionally, you can specify an event ID
                [
                    'color' => $schedule->classTypeStatus->color,
                    'url' => '/schedules/' . $schedule->id . '/edit',
                    'description' => $this->eventDescription($schedule),
                    'textColor' => '#0A0A0A'
                ]
            );
        }

        // The following lines can be used to block specific times on the calendar
        /*$manual_event = \Calendar::event(
          "event title", //event title
          false, //full day event?
          "2016-07-19 07:00:00", //start time (you can also use Carbon instead of DateTime)
          "2016-07-19 12:00:00", //end time (you can also use Carbon instead of DateTime)
          null, //optionally, you can specify an event ID
          [
            'rendering' => 'background'
          ]
        );

        $events = array_add($events, 57, $manual_event);*/

        // The following lines can be used to add recurring events on the calendar
        /*$manual_event = \Calendar::event(
          "recurring event title", //event title
          false, //full day event?
          "07:00:00", //start time (you can also use Carbon instead of DateTime)
          "08:00:00", //end time (you can also use Carbon instead of DateTime)
          null, //optionally, you can specify an event ID
          [
            'dow' => array(1, 4)
          ]
        );

        $events = array_add($events, 57, $manual_event);*/

        $calendar = \Calendar::addEvents($events);

        $calendar = \Calendar::setOptions([
            'allDaySlot' => false,
            'defaultView' => 'agendaWeek', // Add custom option
            'weekends' => false, // Add custom option
            'businessHours' => [
              'start' => '07:00',
              'end' => '20:30',
              //'dow' => array(1, 2, 3, 4, 5)
            ],
            'nowIndicator' => true,
            'minTime' => '07:00:00',
            'maxTime' => '21:00:00',
            'contentHeight' => 'auto',
            'slotEventOverlap' => false,
            'locale' => 'pt-BR',
            'eventLimit' => false,
            'navLinks' => true,
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay,listYear',
            ],
        ]);

        $calendar = \Calendar::setCallbacks([
            'click' => 'function () {
                alert(\'clicked the custom button!\');
            }',
            'dayClick' => 'function (date, jsEvent, view) {
                if (!jsEvent.target.classList.contains(\'fc-bgevent\')) {
                    //Vue.showModalNow(date.format());
                    $(\'#modal-options\').modal(\'show\');
                }
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
                  			},
                        method: \'none shift\'
                		},
                		style: {
                        classes: \'qtip-bootstrap qtip-shadow\'
                    }
                });
                element.find(\'div.fc-title\').html(element.find(\'div.fc-title\').text());
                element.find(\'span.fc-title\').html(element.find(\'span.fc-title\').text());
            }',
        ]);

        return view('calendar.index', compact('calendar', 'has_available_trial_class'));
    }

    public function setGroupTitle(Schedule $schedule)
    {
        return $schedule->classType->name . ' - ' . $schedule->professional->name;
    }

    public function setEventTitle(Schedule $schedule)
    {
        $badge = "";

        if ($schedule->trial) {
            $badge = "<span class=\"label label-warning\">AE</span>";
        }

        if ($schedule->observation <> '') {
            $badge .= " <i class=\"fa fa-comment\"></i>";
        }

        return $badge . ' ' . $schedule->client->name . ' - ' . $schedule->classType->name;
    }

    public function groupDescription(Schedule $schedule)
    {
        $schedules   = Schedule::where('start_at', '=', $schedule->start_at)
                          ->where('room_id', '=', $schedule->room_id)
                          ->with('client', 'classTypeStatus')
                          ->get();

        $description =  '<strong>Class:</strong> ' . $schedule->classType->name . '<br>' .
                        '<strong>Professional:</strong> ' . $schedule->professional->name . '<br>' .
                        '<strong>Date/Time:</strong> ' . $schedule->start_at->format("d/m/Y H:i") . ' to ' . $schedule->end_at->format("H:i") . '<br>' .
                        '<strong>Clients:</strong><br>';

        foreach ($schedules as $schedule) {
            $description .= $this->statusLabel($schedule->classTypeStatus) . ' ' . $schedule->client->name . '' . '<br>';
        }

        return $description;
    }

    public function statusLabel(classTypeStatus $classTypeStatus)
    {
        return '<span class="label" style="background-color: ' . $classTypeStatus->color . '">' . $classTypeStatus->name . '</span>';
    }

    public function eventDescription(Schedule $schedule)
    {
        $description =  '<strong>Client:</strong> ' . $schedule->client->name . '<br>' .
                        '<strong>Class:</strong> ' . $schedule->classType->name . '<br>' .
                        '<strong>Date/Time:</strong> ' . $schedule->start_at->format("d/m/Y H:i") . ' to ' . $schedule->end_at->format("H:i") . '<br>' .
                        '<strong>Professional:</strong> ' . $schedule->professional->name . '<br>' .
                        '<strong>Status:</strong> ' . $schedule->classTypeStatus->name;

        if ($schedule->observation <> '') {
            $description .= '<br><strong>Observation:</strong><br> ' . $schedule->observation;
        }

        return $description;
    }

    public function groupCalendar()
    {
        $events = [];

        $has_available_trial_class = ClassType::WithTrial()->count() > 0;

        $schedules = Schedule::with(['ClassType', 'ClassTypeStatus', 'Professional'])->groupBy('start_at', 'room_id')->get();

        foreach ($schedules as $schedule) {
            $events[] = \Calendar::event(
                $this->setGroupTitle($schedule), //event title
                false, //full day event?
                $schedule->start_at, //start time (you can also use Carbon instead of DateTime)
                $schedule->end_at, //end time (you can also use Carbon instead of DateTime)
                $schedule->id, //optionally, you can specify an event ID
                [
                    'color' => $schedule->classTypeStatus->color,
                    //'url' => '/schedules/' . $schedule->id . '/edit',
                    //'url' => 'schedules/class/' . $schedule->classType->id . '/professional/' . $schedule->professional->id . '/room/' . $schedule->room->id . '/date/' . {date} . '/time/' . {time},
                    'description' => $this->groupDescription($schedule),
                    'textColor' => '#0A0A0A',
                    'class_type_id' => $schedule->class_type_id,
                    'professional_id' => $schedule->professional_id,
                    'room_id' => $schedule->room_id
                ]
            );
        }

        $calendar = \Calendar::addEvents($events);

        $calendar = \Calendar::setOptions([
            'allDaySlot' => false,
            'defaultView' => 'agendaWeek', // Add custom option
            'weekends' => false, // Add custom option
            'businessHours' => [
              'start' => '07:00',
              'end' => '20:30',
              //'dow' => array(1, 2, 3, 4, 5)
            ],
            'nowIndicator' => true,
            'minTime' => '07:00:00',
            'maxTime' => '21:00:00',
            'contentHeight' => 'auto',
            'slotEventOverlap' => false,
            'locale' => 'pt-BR',
            'eventLimit' => false,
            'navLinks' => true,
            'header' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay,listWeek',
            ],
        ]);

        $calendar = \Calendar::setCallbacks([
            'dayClick' => 'function (date, jsEvent, view) {
                $(\'#modal\').on(\'show.bs.modal\', function (event) {
                    var modal = $(this);
                    modal.find(\'.modal-title\').text("O que você gostaria de agendar?");
                    modal.find(\'.modal-body\').html(
                        "<a href=\"/schedules/create\" class=\"btn btn-info\">Atendimento</a>" +
                        "<a href=\"/schedules/trial/create\" class=\"btn btn-info\">Aula experimental</a>" +
                        "<a href=\"/schedules/reposition/create\" class=\"btn btn-info\">Reposição</a>" +
                        "<a href=\"/schedules/extra/create\" class=\"btn btn-info\">Aula extra</a>" +
                        "<a href=\"\" class=\"btn btn-info\">Prática (sem profissional)</a>"
                    );
                });

                $(\'#modal\').modal(\'show\');
            }',
            'eventClick' => 'function(calEvent, jsEvent, view) {
                $(\'#modal\').on(\'show.bs.modal\', function (event) {
                    var modal = $(this);
                    modal.find(\'.modal-title\').text(calEvent.title);
                    modal.find(\'.modal-body\').html(
                        "<br>Professional: " + calEvent.professional_id +
                        "<br>Room: " + calEvent.room_id +
                        "<br>Class Type: " + calEvent.class_type_id
                    );
                });

                $(\'#modal\').modal(\'show\');
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
                            },
                        method: \'none shift\'
                        },
                        style: {
                        classes: \'qtip-bootstrap qtip-shadow\'
                    }
                });
                element.find(\'div.fc-title\').html(element.find(\'div.fc-title\').text());
                element.find(\'span.fc-title\').html(element.find(\'span.fc-title\').text());
            }',
        ]);

        return view('calendar.index', compact('calendar', 'has_available_trial_class'));
    }
}
