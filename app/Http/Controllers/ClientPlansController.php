<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Plan;
use App\Room;
use App\Client;
use App\ClassType;
use App\ClassTypeStatus;
use App\Professional;
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
            $dates[] = $date->format("d-m-Y l");
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

    public function store(ClientPlanRequest $request)
    {
        $requestAll = $request->all();
        
        dd($request->all());
        

        //$clientPlan = clientPlan::create($request->all());
      
        //return redirect('clients');
    }
}
