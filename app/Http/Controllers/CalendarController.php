<?php

namespace App\Http\Controllers;

use App\ClassType;
use App\ClassTypeStatus;
use App\Http\Requests;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function setGroupTitle(Schedule $schedule)
    {
        return $schedule->classType->name.' - '.$schedule->professional->name;
    }

    public function setEventTitle(Schedule $schedule)
    {
        $badge = '';

        if ($schedule->trial) {
            $badge = '<span class="label label-warning">AE</span>';
        }

        if ($schedule->observation != '') {
            $badge .= ' <i class="fa fa-comment"></i>';
        }

        return $badge.' '.$schedule->client->name.' - '.$schedule->classType->name;
    }

    public function eventDescription(Schedule $schedule)
    {
        $description = '<strong>Client:</strong> '.$schedule->client->name.'<br>'.
                        '<strong>Class:</strong> '.$schedule->classType->name.'<br>'.
                        '<strong>Date/Time:</strong> '.$schedule->start_at->format('d/m/Y H:i').' to '.$schedule->end_at->format('H:i').'<br>'.
                        '<strong>Professional:</strong> '.$schedule->professional->name.'<br>'.
                        '<strong>Status:</strong> '.$schedule->classTypeStatus->name;

        if ($schedule->observation != '') {
            $description .= '<br><strong>Observation:</strong><br> '.$schedule->observation;
        }

        return $description;
    }

    public function calendarGroupEvents()
    {
        $start = empty($_GET['start']) ? Carbon::parse(date('Y-m-d')) : $_GET['start'];
        $end = empty($_GET['end']) ? Carbon::parse(date('Y-m-d'))->addMonths(1) : $_GET['end'];

        $schedules = \DB::table('schedules')
                        ->join('class_types', 'schedules.class_type_id', '=', 'class_types.id')
                        ->join('class_type_statuses', 'schedules.class_type_status_id', '=', 'class_type_statuses.id')
                        ->join('professionals', 'schedules.professional_id', '=', 'professionals.id')
                        ->join('clients', 'schedules.client_id', '=', 'clients.id')
                        ->join('rooms', 'schedules.room_id', '=', 'rooms.id')
                        ->select('schedules.id', 'schedules.room_id', 'schedules.class_type_id', 'schedules.professional_id', 'schedules.class_type_status_id', 'schedules.start_at AS start', 'schedules.end_at AS end', 'clients.name AS client_name', 'class_type_statuses.color AS color', 'clients.name AS description', 'professionals.name AS professional_name', 'rooms.name AS room_name', 'class_types.name as title')
                        ->whereDate('start_at', '>=', $start)
                        ->whereDate('end_at', '<=', $end)
                        ->groupBy('start_at', 'room_id')
                        ->get();

        return $schedules;
    }

    public function groupCalendar()
    {
        $has_available_trial_class = ClassType::WithTrial()->count() > 0;

        $start = empty($_GET['start']) ? date('Y-m-d') : $_GET['start'];
        $end = empty($_GET['end']) ? date('Y-m-d') : $_GET['end'];

        $schedules = $this->calendarGroupEvents($start, $end);

        return view('calendar.indexGroup', compact('schedules', 'has_available_trial_class'));
    }

    public function calendarEvents()
    {
        $start = empty($_GET['start']) ? Carbon::parse(date('Y-m-d')) : $_GET['start'];
        $end = empty($_GET['end']) ? Carbon::parse(date('Y-m-d'))->addMonths(1) : $_GET['end'];

        $schedules = \DB::table('schedules')
                        ->join('class_types', 'schedules.class_type_id', '=', 'class_types.id')
                        ->join('class_type_statuses', 'schedules.class_type_status_id', '=', 'class_type_statuses.id')
                        ->join('professionals', 'schedules.professional_id', '=', 'professionals.id')
                        ->join('clients', 'schedules.client_id', '=', 'clients.id')
                        ->join('rooms', 'schedules.room_id', '=', 'rooms.id')
                        ->select('schedules.id',
                            'schedules.room_id',
                            'schedules.class_type_id',
                            'schedules.professional_id',
                            'schedules.class_type_status_id',
                            'schedules.start_at AS start',
                            'schedules.end_at AS end',
                            'clients.name AS title',
                            'class_type_statuses.color AS color',
                            'clients.name AS description',
                            'professionals.name AS professional_name',
                            'rooms.name AS room_name',
                            'class_types.name as class_type_name')
                        ->whereDate('start_at', '>=', $start)
                        ->whereDate('end_at', '<=', $end)
                        ->get();

        return $schedules;
    }

    public function calendar()
    {
        $has_available_trial_class = ClassType::WithTrial()->count() > 0;

        $start = empty($_GET['start']) ? date('Y-m-d') : $_GET['start'];
        $end = empty($_GET['end']) ? date('Y-m-d') : $_GET['end'];

        $schedules = $this->calendarEvents($start, $end);

        return view('calendar.index', compact('schedules', 'has_available_trial_class'));
    }
}
