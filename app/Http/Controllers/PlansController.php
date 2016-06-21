<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function index() {
      $plans = Plan::all();

      return view('plans.index')->with('plans', $plans);
    }

    public function show(plan $plan)
    {
        return view('plans.show', compact('plan'));
    }

    public function edit(plan $plan)
    {
        $classTypes = ClassType::lists('name', 'id');

        return view('plans.edit', compact('plan', 'classTypes'));
    }

    public function create()
    {
        $classTypes = ClassType::lists('name', 'id');

        return view('plans.create', compact('classTypes'));
    }

    public function store(planRequest $request)
    {
        $plan = plan::create($request->all());

        return redirect('plans');
    }

    public function update(plan $plan, planRequest $request)
    {
        $plan->update($request->all());

        return redirect('plans');
    }

    public function destroy(plan $plan)
    {
        $plan->destroy($plan->id);

        return redirect('plans');
    }
}
