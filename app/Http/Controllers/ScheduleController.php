<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedule::all();
        return response()->json($schedules);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Create form']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'class_type_id' => 'required|exists:class_types,id',
            'professional_id' => 'required|exists:professionals,id',
            'room_id' => 'required|exists:rooms,id',
            'class_type_status_id' => 'required|exists:class_type_statuses,id',
            'price' => 'required|numeric|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'trial' => 'boolean',
            'observation' => 'nullable|string',
        ]);

        $schedule = Schedule::create($request->all());
        return response()->json($schedule, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        return response()->json($schedule);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'class_type_id' => 'required|exists:class_types,id',
            'professional_id' => 'required|exists:professionals,id',
            'room_id' => 'required|exists:rooms,id',
            'class_type_status_id' => 'required|exists:class_type_statuses,id',
            'price' => 'required|numeric|min:0',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:start_at',
            'trial' => 'boolean',
            'observation' => 'nullable|string',
        ]);

        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->all());
        return response()->json($schedule);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return response()->json(['message' => 'Schedule deleted successfully']);
    }
}
