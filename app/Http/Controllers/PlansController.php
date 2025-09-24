<?php

namespace App\Http\Controllers;

use App\Models\ClassType;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Session;

class PlansController extends Controller
{
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
        
        // Get popular plans (most used plans based on client_plans count)
        $popularPlans = [];
        if (request('onboarding')) {
            $popularPlans = Plan::withCount('clientPlans')
                ->having('client_plans_count', '>', 0)
                ->orderBy('client_plans_count', 'desc')
                ->take(3)
                ->get()
                ->map(function ($plan) {
                    return [
                        'id' => $plan->id,
                        'name' => $plan->name,
                        'times' => $plan->times,
                        'times_type' => $plan->times_type,
                        'duration' => $plan->duration,
                        'duration_type' => $plan->duration_type,
                        'price' => $plan->price,
                        'price_type' => $plan->price_type,
                        'description' => $plan->description,
                        'usage_count' => $plan->client_plans_count,
                        'class_type_name' => $plan->classType->name ?? null
                    ];
                });
        }

        return view('plans.create', compact('classTypes', 'plan', 'popularPlans'));
    }

    public function store(planRequest $request)
    {
        $plan = plan::create($request->all());

        Session::flash('message', 'Successfully added plan '.$plan->name);

        return redirect('plans');
    }

    public function update(plan $plan, planRequest $request)
    {
        $plan->update($request->all());

        Session::flash('message', 'Successfully updated plan '.$plan->name);

        return redirect('plans');
    }

    public function destroy(plan $plan)
    {
        $plan->delete();

        Session::flash('message', 'Successfully deleted plan '.$plan->name);

        return redirect('plans');
    }
}
