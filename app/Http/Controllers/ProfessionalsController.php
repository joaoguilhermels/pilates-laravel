<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Professional;
use App\ClassType;
use App\Http\Requests;
use App\Http\Requests\ProfessionalRequest;
use App\Http\Controllers\Controller;

class ProfessionalsController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index() {
      $professionals = Professional::all();
      
      return view('professionals.index')->with('professionals', $professionals);
    }
    
    public function show(Professional $professional)
    {
        // Not needed because we are using route model binding on RouteServiceProvider::boot
        //$professional = Professional::findOrFail($id);

        return view('professionals.show', compact('professional'));
    }

    public function edit(Professional $professional)
    {
        $classTypes = ClassType::lists('name', 'id');

        return view('professionals.edit', compact('professional', 'classTypes'));
    }
    
    public function create()
    {
        $classTypes = ClassType::lists('name', 'id');
        
        return view('professionals.create', compact('classTypes'));
    }
    
    public function store(ProfessionalRequest $request)
    {      
        $professional = Professional::create($request->all());
        
        $professional->classTypes()->sync($request->input('class_type_list'));
      
        return redirect('professionals');
    }

    public function update(Professional $professional, ProfessionalRequest $request)
    {      
        $professional->update($request->all());
        
        $professional->classTypes()->sync($request->input('class_type_list'));

        return redirect('professionals');
    }
}
