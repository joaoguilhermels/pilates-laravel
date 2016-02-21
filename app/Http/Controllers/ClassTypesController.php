<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClassType;
use App\ClassTypeStatus;
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
        $statuses = $classType->statuses;
        dd($statuses);
      
        return view('classes.edit', compact('classType', 'statuses'));
    }
    
    public function create()
    {
      //$statuses = ClassTypeStatus::all();

        $statusOk = new ClassTypeStatus([
          'name' => 'OK',
          'charge_client' => '0',
          'pay_professional' => '1',
          'color' => '#99cc00'
        ]);

        $statusDesmarcou = new ClassTypeStatus([
          'name' => 'Desmarcou',
          'charge_client' => '0',
          'pay_professional' => '0',
          'color' => '#fcf100'
        ]);
        
        $statusFaltou = new ClassTypeStatus([
          'name' => 'Faltou',
          'charge_client' => '1',
          'pay_professional' => '0',
          'color' => '#ff0000'
        ]);
      
        $statuses = collect([$statusOk, $statusDesmarcou, $statusFaltou]);

        return view('classes.create', compact('statuses'));
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
    
    /*
     * Additional Functions
     */
    public function defaultStatuses() {
        $statusOk = new ClassTypeStatus([
          'name' => 'OK',
          'charge_client' => '0',
          'pay_professional' => '1',
          'color' => '#99cc00'
        ]);

        $statusDesmarcou = new ClassTypeStatus([
          'name' => 'Desmarcou',
          'charge_client' => '0',
          'pay_professional' => '0',
          'color' => '#fcf100'
        ]);
        
        $statusFaltou = new ClassTypeStatus([
          'name' => 'Faltou',
          'charge_client' => '1',
          'pay_professional' => '0',
          'color' => '#ff0000'
        ]);
      
        $statuses = collect([$statusOk, $statusDesmarcou, $statusFaltou]);
        
        return $statuses;
    }
}
