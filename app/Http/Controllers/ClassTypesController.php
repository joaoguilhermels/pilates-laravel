<?php

namespace App\Http\Controllers;

use App\ClassType;
use App\ClassTypeStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\ClassTypeRequest;
use App\Http\Requests\ClassTypeStatusRequest;
use DB;
use Illuminate\Http\Request;
use Session;

class ClassTypesController extends Controller
{
    public function index()
    {
        $classTypes = ClassType::all();

        return view('classes.index', compact('classTypes'));
    }

    public function show(ClassType $classType)
    {
        // Eager loading class type statuses;
        $classType->load('statuses');

        return view('classes.show', compact('classType'));
    }

    public function edit(ClassType $classType)
    {
        $classType->load('statuses');

        return view('classes.edit', compact('classType'));
    }

    public function create(ClassType $classType)
    {
        $statuses = $this->create_default_statuses();

        $classType->statuses = $statuses;

        return view('classes.create', compact('classType'));
    }

    public function store(ClassTypeRequest $request)
    {
        $classType = ClassType::create($request->all());

        foreach ($request->status as $status) {
            $classType->statuses()->create($status);
        }

        Session::flash('message', 'Successfully created class '.$classType->name);

        return redirect('classes');
    }

    public function update(ClassType $classType, ClassTypeRequest $request)
    {
        $classType->update($request->all());

        foreach ($request->status as $status) {
            $classType->statuses()->find($status['id'])->update($status);
        }

        Session::flash('message', 'Successfully updated class '.$classType->name);

        return redirect('classes');
    }

    public function destroy(ClassType $classType)
    {
        $classType->delete();

        Session::flash('message', 'Successfully deleted class '.$classType->name);

        return redirect('classes');
    }

    public function create_default_statuses()
    {
        $statusOk = new ClassTypeStatus([
          'name' => 'OK',
          'charge_client' => true,
          'pay_professional' => true,
          'color' => '#6FCB6D',
        ]);

        $statusDesmarcou = new ClassTypeStatus([
          'name' => 'Desmarcou',
          'charge_client' => null,
          'pay_professional' => null,
          'color' => '#685DFF',
        ]);

        $statusFaltou = new ClassTypeStatus([
          'name' => 'Faltou',
          'charge_client' => true,
          'pay_professional' => null,
          'color' => '#FF1E00',
        ]);

        $statusReposicao = new ClassTypeStatus([
          'name' => 'Reposição',
          'charge_client' => true,
          'pay_professional' => true,
          'color' => '#00B9FE',
        ]);

        $statuses = collect([$statusOk, $statusDesmarcou, $statusReposicao, $statusFaltou]);

        return $statuses;
    }
}
