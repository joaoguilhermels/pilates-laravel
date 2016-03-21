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
        $requestAll = $request->all();

        $clientPlan = new ClientPlan;

        $clientPlan->class_id = $request->class_id;
        $clientPlan->plan_id = $request->plan_id;
        $clientPlan->start_at = $request->start_at;

        $clientPlan->save();

        foreach($request->daysOfWeek as $dayOfWeek) {
          $clientPlanDetail = new ClientPlanDetail;
  
          $clientPlanDetail->client_plan_id = $clientPlan->plan_id;
          $clientPlanDetail->day_of_week = $dayOfWeek['day_of_week'];
          $clientPlanDetail->hour = $dayOfWeek['hour'] . ':00';
          $clientPlanDetail->professional_id = $dayOfWeek['professional_id'];
          $clientPlanDetail->room_id = $dayOfWeek['room_id'];
  
          $clientPlanDetail->save();
        }


        /***********************************************************************************/


        $classType = ClassType::with('statuses', 'plans')->findOrFail($requestAll['class_id']);

        $plan = $classType->plans()->where('id', '=', $requestAll['plan_id'])->first();
        $statuses = $classType->statuses;

        $rooms = Room::all()->lists('name_with_classes', 'id');

        $startDate = \Carbon\Carbon::parse($requestAll['start_at']);
        $startDateMonth = $startDate->formatLocalized('%B');
        $startDateYear = $startDate->formatLocalized('%Y');

        $dates = array();

        foreach($requestAll['daysOfWeek'] as $key => $dayOfWeek)
        {
            $nameOfDayOfWeek = array_get($this->daysOfWeek, $dayOfWeek['day_of_week']);
            
            $values = new \DatePeriod(
                \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear),
                \Carbon\CarbonInterval::week(),
                \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear . " + " . $plan->duration . " " . $plan->duration_type)
            );
  
            foreach($values as $date)
            {
                $dates[] = $date->format("d-m-Y");
  
                $dateObj = date_create($date);
  
                list($year, $month) = explode(" ", $dateObj->format("F Y"));
  
                $datesGrouped[$year . " " . $month][] = $dateObj->format("d-m-Y");
            }
        }

        foreach($requestAll['daysOfWeek'] as $key => $dayOfWeek)
        {
            $nameOfDayOfWeek = array_get($this->daysOfWeek, $dayOfWeek['day_of_week']);

            $values = new \DatePeriod(
                \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear),
                \Carbon\CarbonInterval::week(),
                \Carbon\Carbon::parse("first " . $nameOfDayOfWeek . " of " . $startDateMonth . " " . $startDateYear . " + " . $plan->duration . " " . $plan->duration_type)
            );

            foreach($values as $date) {
                //$dates[] = $date->format("d-m-Y");
    
                $dateObj = date_create($date);
                $dateObj->setTime($dayOfWeek['hour'], 0);
    
                $dateEndObj = date_create($date);
                $dateEndObj->setTime($dayOfWeek['hour'] + ($classType->duration / 60), 0);
                
                $schedule = new Schedule;
    
                $schedule->client_id            = $client->id;
                $schedule->price                = $this->setPrice($plan, $dateObj, $datesGrouped);
                $schedule->plan_id              = $request->plan_id;
                $schedule->class_type_id        = $request->class_id;
                $schedule->room_id              = $dayOfWeek['room_id'];
                $schedule->professional_id      = $dayOfWeek['professional_id'];
                $schedule->start_at             = $dateObj->format("Y-m-d H:i:s");
                $schedule->end_at               = $dateEndObj->format("Y-m-d H:i:s");
                $schedule->class_type_status_id = $statuses->where('name', 'OK')->first()->id;
    
                $schedule->save();
            }
        }

      
        return redirect('clients');
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
}
