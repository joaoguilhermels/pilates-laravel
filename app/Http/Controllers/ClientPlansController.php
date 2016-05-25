<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;
use App\Room;
use App\Client;
use App\ClientPlan;
use App\ClientPlanDetail;
use App\ClassType;
use App\ClassTypeStatus;
use App\Professional;
use App\Schedule;
use App\Http\Requests;
use App\Http\Requests\ClientPlanRequest;
use App\Http\Controllers\Controller;

class ClientPlansController extends Controller
{
    protected $daysOfWeek = array(
                  0 => 'Sunday',
                  1 => 'Monday',
                  2 => 'Tuesday',
                  3 => 'Wednesday',
                  4 => 'Thursday',
                  5 => 'Friday',
                  6 => 'Saturday'
              );

    public function createClientPlan(Client $client)
    {
        $form = $this->prepareCreateForm();

        $daysOfWeek = $form['daysOfWeek'];
        $rooms = $form['rooms'];
        $classTypePlans = $form['classTypePlans'];
        $classTypes = $form['classTypes'];
        $professionals = $form['professionals'];

        return view('clientPlans.create', compact('client', 'daysOfWeek', 'rooms', 'classTypePlans', 'classTypes', 'professionals'));
    }

    public function prepareCreateForm()
    {
        $form['daysOfWeek'] = $this->daysOfWeek;
        $form['rooms'] = Room::all()->lists('name_with_classes', 'id');
        $form['classTypePlans'] = ClassType::with('plans')->get()->toArray();
        //$plans = Plan::all()->lists('name_with_class', 'id');
        $form['classTypes'] = ClassType::lists('name', 'id');

        $form['professionals'] = Professional::all()->lists('name_with_classes', 'id');

        return $form;
    }

    public function reviewClientPlan(ClientPlanRequest $request, Client $client)
    {
        $requestAll = $request->all();

        $classType = ClassType::with('statuses', 'plans')->findOrFail($requestAll['classType']);

        $plan = $classType->plans()->where('id', '=', $requestAll['plan'])->first();

        $rooms = Room::all()->lists('name_with_classes', 'id');
        $classTypePlans = ClassType::with('plans')->get()->toArray();

        $startDate = \Carbon\Carbon::parse($requestAll['start_date']);
        $startDateMonth = $startDate->formatLocalized('%B');
        $startDateYear = $startDate->formatLocalized('%Y');

        $dates = array();

        foreach($requestAll['daysOfWeek'] as $dayOfWeek) {
          $nameOfDayOfWeek = array_get($this->daysOfWeek, $dayOfWeek['dayOfWeek']);

          $values = new \DatePeriod(
              \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear),
              \Carbon\CarbonInterval::week(),
              \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear . " + " . $plan->duration . " " . $plan->duration_type)
          );

          foreach($values as $date) {
            $dates[] = $date->format("d-m-Y");
          }
        }

        // Sort dates
        usort($dates, array($this, 'date_compare'));

        $datesGrouped = array();

        foreach($dates as $date) {
          $dateObj = date_create($date);
          list($year, $month) = explode(" ", $dateObj->format("F Y"));

          $datesGrouped[$year . " " . $month][] = $dateObj->format("d-m-Y");
        }

        return view('clientPlans.review', compact('datesGrouped', 'request', 'client', 'classType', 'plan'));
    }

    // Static function used to sort dates used on review
    static function date_compare($date1, $date2)
    {
        $t1 = strtotime($date1);
        $t2 = strtotime($date2);

        return $t1 - $t2;
    }

    public function store(ClientPlanRequest $request, Client $client)
    {
        $clientPlan = new ClientPlan;

        $clientPlan->class_type_id  = $request->class_type_id;
        $clientPlan->start_at       = $request->start_at;
        $clientPlan->plan_id        = $request->plan_id;

        $clientPlan = $client->clientPlans()->save($clientPlan);

        $groupedDates = $this->getGroupedDates($request);

        foreach($request->daysOfWeek as $dayOfWeek) {
          $clientPlanDetail = new ClientPlanDetail;

          $clientPlanDetail->professional_id = $dayOfWeek['professional_id'];
          $clientPlanDetail->day_of_week = $dayOfWeek['day_of_week'];
          $clientPlanDetail->room_id = $dayOfWeek['room_id'];
          $clientPlanDetail->hour = $dayOfWeek['hour'] . ':00';

          $clientPlanDetail = $clientPlan->clientPlanDetails()->save($clientPlanDetail);

          $this->setSchedules($request, $client, $clientPlanDetail, $dayOfWeek, $groupedDates);
        }

        return redirect('clients');
    }

    public function getGroupedDates(ClientPlanRequest $request)
    {
        $classType = ClassType::with('statuses', 'plans')->findOrFail($request->get('class_type_id'));
        //$plan = $classType->plans()->where('id', '=', $request->get('plan_id'))->first();
        $plan = $classType->plans->first();

        $startDate = \Carbon\Carbon::parse($request->get('start_at'));
        $startDateMonth = $startDate->formatLocalized('%B');
        $startDateYear = $startDate->formatLocalized('%Y');

        $datesGrouped = array();

        foreach($request->get('daysOfWeek') as $key => $dayOfWeek)
        {
            $nameOfDayOfWeek = array_get($this->daysOfWeek, $dayOfWeek['day_of_week']);

            $values = new \DatePeriod(
                \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear),
                \Carbon\CarbonInterval::week(),
                \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear . " + " . $plan->duration . " " . $plan->duration_type)
            );

            foreach($values as $date)
            {
                $dateObj = date_create($date);
                list($year, $month) = explode(" ", $dateObj->format("F Y"));
                $datesGrouped[$year . " " . $month][] = $dateObj->format("d-m-Y");
            }
        }

        return collect($datesGrouped);
    }

    public function setSchedules(ClientPlanRequest $request, Client $client, ClientPlanDetail $clientPlanDetail, $dayOfWeek, $groupedDates)
    {
        $classType = ClassType::with('statuses', 'plans')->findOrFail($request->get('class_type_id'));
        $plan = $classType->plans->first();

        $classTypeStatusOkId = $classType->statuses->where('name', 'OK')->first()->id;

        // Get only dates relative to the day of the week being processed (all mondays for example)
        $dates = $groupedDates->flatten()->filter(function ($value, $key) use ($dayOfWeek) {
                    $nameOfDayOfWeek = array_get($this->daysOfWeek, $dayOfWeek['day_of_week']);
                    return $nameOfDayOfWeek == date('l', strtotime($value));
                  })->all();

        foreach($dates as $date) {
            $dateObj = date_create($date);
            $dateObj->setTime(str_replace(':00', '', $clientPlanDetail->hour), 0);

            $dateEndObj = date_create($date);
            $dateEndObj->setTime($clientPlanDetail->hour + ($classType->duration / 60), 0);

            $schedule = new Schedule;

            $schedule->trial                 = false;
            $schedule->client_id             = $client->id;
            $schedule->room_id               = $clientPlanDetail->room_id;
            $schedule->class_type_id         = $request->class_type_id;
            $schedule->professional_id       = $clientPlanDetail->professional_id;
            $schedule->start_at              = $dateObj->format("Y-m-d H:i:s");
            $schedule->end_at                = $dateEndObj->format("Y-m-d H:i:s");
            $schedule->class_type_status_id  = $classTypeStatusOkId;
            $schedule->price                 = $this->setPrice($plan, $dateObj, $groupedDates->all());

            $clientPlanDetail->schedules()->save($schedule);
        }
    }

    public function setPrice (Plan $plan, $dateObj, Array $datesGrouped)
    {
        if ($plan->price_type == 'class')
        {
            return $plan->price;
        }
        else
        {
            $key = $dateObj->format("F Y");
            $daysCount = count($datesGrouped[$key]);
            return $plan->price / $daysCount;
        }

    }

    public function destroy(ClientPlan $clientPlan)
    {
        Session::flash('message', 'Successfully deleted client ' . $client->name);

        $clientPlan->clientPlanDetails()->schedules()->delete();
        $clientPlan->clientPlanDetails()->delete();
        $clientPlan->delete();

        return redirect('clients');
    }
}
