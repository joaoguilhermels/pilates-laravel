<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;

class ClassTypeStatusesController extends Controller
{
    // TODO: List only statuses of the current class
    /*public function index() {
      $classTypes = ClassType::all();

      return view('classes.index')->with('classTypes', $classTypes);
    }

    // Show only statuses of the current class
    public function show(ClassType $classType)
    {
        return view('classes.show', compact('classType'));
    }

    public function edit(ClassType $classType)
    {
        return view('classes.edit', compact('classType'));
    }

    public function create()
    {
      return view('classes.create');
    }*/

    public function store(ClassTypeStatusRequest $request)
    {
        dd('asdf');
        ClassType::create($request->all());

        return redirect('classes');
    }

    public function update(ClassType $classType, ClassTypeRequest $request)
    {
        dd('fdsa');
        $classType->update($request->all());

        return redirect('classes');
    }
}
