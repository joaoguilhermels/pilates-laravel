<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use App\ClassType;
use App\ClassTypeStatus;
use App\Http\Requests;
use App\Http\Requests\ClassTypeRequest;
use App\Http\Requests\ClassTypeStatusRequest;
use App\Http\Controllers\Controller;

class ClassTypesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
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
    
    public function create()
    {
        $statuses = $this->create_default_statuses();
        
        $classType = new ClassType;
        
        $classType->statuses = $statuses;

        return view('classes.create', compact('classType'));
    }
    
    public function store(ClassTypeRequest $request)
    {
        $classType = ClassType::create($request->all());

        foreach($request->get('status') as $status) {
            $classType->statuses()->create($status);
        }

        return redirect('classes');
    }

    public function update(ClassType $classType, ClassTypeStatus $classTypeStatus, ClassTypeRequest $request)
    {
        $classType->update($request->all());

        foreach($request->get('status') as $status) {
            $classType->statuses()->find($status['id'])->update($status);
        }

        return redirect('classes');
    }

    public function destroy(ClassType $classType)
    {       
        $classType->delete();

        return redirect('classes');
    }

    public function create_default_statuses() {
        $statusOk = new ClassTypeStatus([
          'name' => 'OK',
          'charge_client' => TRUE,
          'pay_professional' => TRUE,
          'color' => '#6FCB6D'
        ]);

        $statusDesmarcou = new ClassTypeStatus([
          'name' => 'Desmarcou',
          'charge_client' => NULL,
          'pay_professional' => NULL,
          'color' => '#00B9FE'
        ]);
        
        $statusFaltou = new ClassTypeStatus([
          'name' => 'Faltou',
          'charge_client' => TRUE,
          'pay_professional' => NULL,
          'color' => '#FF1E00'
        ]);

        $statusReposicao = new ClassTypeStatus([
          'name' => 'Reposição',
          'charge_client' => TRUE,
          'pay_professional' => TRUE,
          'color' => '#685DFF'
        ]);
      
        $statuses = collect([$statusOk, $statusDesmarcou, $statusReposicao, $statusFaltou]);
        
        return $statuses;
    }

}
