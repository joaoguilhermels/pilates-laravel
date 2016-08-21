<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Plan;
use App\ClassType;
use App\ClientPlan;
use App\Http\Requests;
use App\Http\Requests\PlanRequest;
use App\Http\Controllers\Controller;

class PlansController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $plans = Plan::all();

        return view('plans.index')->with('plans', $plans);
    }

    public function show(plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    public function edit(plan $plan)
    {
        $classTypes = ClassType::all();
        $plan->load('classType');

        return view('plans.edit', compact('plan', 'classTypes'));
    }

    public function create(Plan $plan)
    {
        $classTypes = ClassType::all();

        return view('plans.create', compact('classTypes', 'plan'));
    }

    public function store(planRequest $request)
    {
        $plan = plan::create($request->all());

        Session::flash('message', 'Successfully added plan ' . $plan->name);

        return redirect('plans');
    }

    public function update(plan $plan, planRequest $request)
    {
        $plan->update($request->all());

        Session::flash('message', 'Successfully updated plan ' . $plan->name);

        return redirect('plans');
    }

    public function destroy(plan $plan)
    {
        $plan->destroy($plan->id);

        Session::flash('message', 'Successfully deleted plan ' . $plan->name);

        return redirect('plans');
    }
}
