<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ClassTypeStatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
