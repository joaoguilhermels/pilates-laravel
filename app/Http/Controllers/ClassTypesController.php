<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClassType;
use App\Http\Requests;
use App\Http\Requests\ClassTypeRequest;
use App\Http\Controllers\Controller;

class ClassTypesController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }  

    public function index() {
      $classTypes = ClassType::all();

      return view('classes.index')->with('classTypes', $classTypes);
    }
    
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
    }
    
    public function store(ClassTypeRequest $request)
    {
        ClassType::create($request->all());
      
        return redirect('classes');
    }

    public function update(ClassType $classType, ClassTypeRequest $request)
    {       
        $classType->update($request->all());

        return redirect('classes');
    }
}
