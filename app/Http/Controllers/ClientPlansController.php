<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\ClassType;
use App\ClassTypeStatus;
use App\Client;
use App\ClientPlan;
use App\ClientPlanDetail;
use App\Discount;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ClientPlanRequest;
use App\Plan;
use App\Professional;
use App\Room;
use App\Schedule;
use Illuminate\Http\Request;
use Session;

class ClientPlansController extends Controller
{
    protected $daysOfWeek = [
                  0 => 'Sunday',
                  1 => 'Monday',
                  2 => 'Tuesday',
                  3 => 'Wednesday',
                  4 => 'Thursday',
                  5 => 'Friday',
                  6 => 'Saturday',
              ];

    public function create(Client $client)
    {
        $form = $this->prepareCreateForm();

        $rooms = $form['rooms'];
        $discounts = $form['discounts'];
        $professionals = $form['professionals'];
        $classTypePlans = $form['classTypePlans'];
        $clientPlan = new ClientPlan();

        return view('clientPlans.create', compact('client', 'rooms', 'classTypePlans', 'professionals', 'discounts', 'clientPlan'));
    }

    public function edit(ClientPlan $clientPlan)
    {
        $form = $this->prepareCreateForm();

        $rooms = $form['rooms'];
        $discounts = $form['discounts'];
        $professionals = $form['professionals'];
        $classTypePlans = $form['classTypePlans'];

        return view('clientPlans.edit', compact('client', 'rooms', 'classTypePlans', 'professionals', 'discounts', 'clientPlan'));
    }

    public function prepareCreateForm()
    {
        $form['rooms'] = Room::orderBy('name')->get();
        $form['daysOfWeek'] = $this->daysOfWeek;
        $form['classTypePlans'] = ClassType::with(['plans' => function ($query) {
            $query->orderBy('name');
        }, 'professionals', 'rooms', 'discounts'])
                                    ->has('plans')
                                    ->orderBy('name')
                                    ->get();

        $form['discounts'] = Discount::get();
        $form['classTypes'] = ClassType::orderBy('name')->get();
        $form['professionals'] = Professional::orderBy('name')->get();

        return $form;
    }

    public function reviewClientPlan(ClientPlanRequest $request, Client $client)
    {
        $classType = ClassType::with(['statuses', 'plans' => function ($query) use ($request) {
            return $query->where('id', $request->plan_id);
        }])->findOrFail($request->class_type_id);

        $plan = $classType->plans->first();

        $rooms = Room::all()->lists('name_with_classes', 'id');
        $classTypePlans = ClassType::with('plans')->get()->toArray();

        $startDate = \Carbon\Carbon::parse($request->start_date);
        $startDateMonth = $startDate->formatLocalized('%B');
        $startDateYear = $startDate->formatLocalized('%Y');

        $dates = [];

        foreach ($request->daysOfWeek as $dayOfWeek) {
            $nameOfDayOfWeek = Arr::get($this->daysOfWeek, $dayOfWeek['dayOfWeek']);

            $values = new \DatePeriod(
                \Carbon\Carbon::parse('first '.$nameOfDayOfWeek.' of '.$startDateMonth.' '.$startDateYear),
                \Carbon\CarbonInterval::week(),
                \Carbon\Carbon::parse('first '.$nameOfDayOfWeek.' of '.$startDateMonth.' '.$startDateYear.' + '.$plan->duration.' '.$plan->duration_type)
            );

            foreach ($values as $date) {
                $dates[] = $date->format('d-m-Y');
            }
        }

        // Sort dates
        usort($dates, [$this, 'date_compare']);

        $datesGrouped = [];

        foreach ($dates as $date) {
            $dateObj = date_create($date);
            list($year, $month) = explode(' ', $dateObj->format('F Y'));

            $datesGrouped[$year.' '.$month][] = $dateObj->format('d-m-Y');
        }

        return view('clientPlans.review', compact('datesGrouped', 'request', 'client', 'classType', 'plan'));
    }

    // Static function used to sort dates used on review
    public static function date_compare($date1, $date2)
    {
        $t1 = strtotime($date1);
        $t2 = strtotime($date2);

        return $t1 - $t2;
    }

    public function store(ClientPlanRequest $request, Client $client)
    {
        $clientPlan = new ClientPlan;

        $clientPlan->start_at = $request->start_at;
        $clientPlan->plan_id = $request->plan_id;

        $clientPlan = $client->clientPlans()->save($clientPlan);

        $groupedDates = $this->getGroupedDates($request);

        foreach ($request->daysOfWeek as $dayOfWeek) {
            $this->setSchedules($request, $clientPlan, $client, $dayOfWeek, $groupedDates);
        }

        Session::flash('message', 'Successfully added a plan to '.$client->name);

        return redirect('clients');
    }

    public function update(ClientPlanRequest $request, ClientPlan $clientPlan)
    {
        $clientPlan->start_at = $request->start_at;
        $clientPlan->plan_id = $request->plan_id;

        $clientPlan = $client->clientPlans()->save($clientPlan);

        $groupedDates = $this->getGroupedDates($request);

        foreach ($request->daysOfWeek as $dayOfWeek) {
            $this->setSchedules($request, $clientPlan, $client, $dayOfWeek, $groupedDates);
        }

        Session::flash('message', 'Successfully update the plan to '.$client->name);

        return redirect('clients');
    }

    public function getGroupedDates(ClientPlanRequest $request)
    {
        $startDate = \Carbon\Carbon::parse($request->start_at);
        $endDate = clone $startDate;

        $plan = Plan::where('id', $request->plan_id)->first();

        $endDate->addMonths($plan->duration - 1);

        $daysOfWeek = collect($request->daysOfWeek);

        $datesGrouped = $daysOfWeek->map(function ($dayOfWeek) use ($startDate, $endDate, $plan) {
            $nameOfDayOfWeek = Arr::get($this->daysOfWeek, $dayOfWeek['day_of_week']);

            // User for 30 days calculation
            /*$dates = new \DatePeriod(
                \Carbon\Carbon::parse($startDate . " next " . $nameOfDayOfWeek),
                \Carbon\CarbonInterval::week(),
                \Carbon\Carbon::parse($startDate . " last " . $nameOfDayOfWeek . " + " . $plan->duration . " " . $plan->duration_type)
            );*/

            $dates = [];

            // To have the month of starting date plus X months remove the "- 1"
            $month = $endDate->format('n');
            $year = $endDate->format('Y');

            $beginDate = strtotime('first day of '.$startDate->format('Y').'-'.$startDate->format('n'));
            $endDate = strtotime('last day of '.$year.'-'.$month);

            for ($date = strtotime($nameOfDayOfWeek, $beginDate); $date <= $endDate; $date = strtotime('+1 week', $date)) {
                $dates[] = new \Carbon\Carbon(date('Y-m-d', $date));
            }

            /*$dates = new \DatePeriod(
                \Carbon\Carbon::parse($startDate),
                \Carbon\CarbonInterval::week(),
                \Carbon\Carbon::parse("last day of " . $startDate->format("Y") . "-" . $month)
            );*/

            //return iterator_to_array($dates);
            return $dates;
        })
        ->flatten()
        ->map(function ($item) {
            $item = [
                'month_year' => $item->format('m-Y'),
                'day_of_week' => $item->format('l'),
                'date' => $item,
            ];

            return $item;
        });

        return $datesGrouped;
    }

    public function setSchedules(ClientPlanRequest $request, ClientPlan $clientPlan, Client $client, $dayOfWeek, $groupedDates)
    {
        $clientPlanDetail = new ClientPlanDetail;

        $clientPlanDetail->hour = $dayOfWeek['hour'].':00';
        $clientPlanDetail->room_id = $dayOfWeek['room_id'];
        $clientPlanDetail->day_of_week = $dayOfWeek['day_of_week'];
        $clientPlanDetail->professional_id = $dayOfWeek['professional_id'];

        $clientPlanDetail = $clientPlan->clientPlanDetails()->save($clientPlanDetail);

        $classType = ClassType::with([
            'plans' => function ($query) use ($request) {
                return $query->where('id', $request->plan_id);
            },
            'statuses' => function ($query) {
                return $query->where('name', 'OK');
            },
            'professionals' => function ($query) use ($clientPlanDetail) {
                return $query->where('professional_id', $clientPlanDetail->professional_id);
            },
        ])
        ->findOrFail($clientPlan->plan->class_type_id);

        $clientPlanDetail->load('professional');
        $clientPlanDetail->professional->load('classTypes');

        $professionalClass = $clientPlanDetail->professional->classTypes->first()->pivot;

        $plan = $classType->plans->first();

        $classTypeStatusOkId = $classType->statuses->first()->id;

        $nameOfDayOfWeek = Arr::get($this->daysOfWeek, $dayOfWeek['day_of_week']);

        $dates = $groupedDates->where('day_of_week', $nameOfDayOfWeek);

        foreach ($dates as $date) {
            if (strtotime($date['date']) < strtotime($request->start_at)) {
                continue;
            }

            $dateStart = $date['date'];
            $dateStart->setTime($dayOfWeek['hour'], 0);

            $dateEnd = clone $date['date'];
            $dateEnd->setTime($dayOfWeek['hour'] + ($classType->duration / 60), 0);

            $classPrice = $this->setPrice($plan, $dateStart, $groupedDates);

            $schedule = new Schedule;

            $schedule->price = $classPrice;
            $schedule->trial = false;
            $schedule->end_at = $dateEnd->format('Y-m-d H:i:s');
            $schedule->room_id = $clientPlanDetail->room_id;
            $schedule->start_at = $dateStart->format('Y-m-d H:i:s');
            $schedule->client_id = $client->id;
            $schedule->class_type_id = $clientPlan->plan->class_type_id;
            $schedule->professional_id = $clientPlanDetail->professional_id;
            $schedule->class_type_status_id = $classTypeStatusOkId;
            $schedule->value_professional_receives = $this->setProfessionalValue($professionalClass, $classPrice);

            $clientPlanDetail->schedules()->save($schedule);
        }
    }

    public function setPrice(Plan $plan, $date, $groupedDates)
    {
        if ($plan->price_type == 'class') {
            return $plan->price;
        } else { // per month
            $daysCount = $groupedDates->where('month_year', $date->format('m-Y'))->count();

            return round($plan->price / $daysCount, 2);
        }
    }

    /**
     * Returns the value the professional receives for one specific class.
     *
     * Undocumented function long description
     *
     * @param type var Description
     * @return float
     */
    public function setProfessionalValue($class_type_professional, $price)
    {
        // Move this to a professional controller
        if ($class_type_professional->value_type == 'percentage') {
            return round($price * ($class_type_professional->value / 100), 2);
        }

        switch ($class_type_professional->value_type) {
            case 'percentage':
                return round($price * ($class_type_professional->value / 100), 2);
                break;
            case 'value_per_client':
                return $class_type_professional->value;
                break;
        }
    }

    public function destroy(ClientPlan $clientPlan)
    {
        Session::flash('message', 'Successfully deleted client plan '.$clientPlan->name);

        // Check if all items can be deleted

        // Move this to the migration to cascade delete ?
        $clientPlan->financialTransactions->map(function ($financialTransaction) {
            $financialTransaction->financialTransactionDetails->map(function ($financialTransactionDetail) {
                $financialTransactionDetail->delete();
            });
            $financialTransaction->delete();
        });

        // Move this to the migration to cascade delete ?
        $clientPlan->clientPlanDetails->map(function ($clientPlanDetail) {
            $clientPlanDetail->schedules->map(function ($schedule) {
                $schedule->delete();
            });
            $clientPlanDetail->delete();
        });

        $clientPlan->delete();

        return redirect('clients');
    }
}
