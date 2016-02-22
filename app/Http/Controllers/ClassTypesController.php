<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('classes.show', compact('classType'));
    }

    public function edit(ClassType $classType)
    {
        $statuses = $classType->statuses;
      
        return view('classes.edit', compact('classType', 'statuses'));
    }
    
    public function create()
    {
        $statusOk = new ClassTypeStatus([
          'id' => '1',
          'name' => 'OK',
          'charge_client' => '0',
          'pay_professional' => '1',
          'color' => '#6FCB6D'
        ]);

        $statusDesmarcou = new ClassTypeStatus([
          'id' => '2',
          'name' => 'Desmarcou',
          'charge_client' => '0',
          'pay_professional' => '0',
          'color' => '#685DFF'
        ]);
        
        $statusFaltou = new ClassTypeStatus([
          'id' => '3',
          'name' => 'Faltou',
          'charge_client' => '1',
          'pay_professional' => '0',
          'color' => '#00B9FE'
        ]);

        $statusReposicao = new ClassTypeStatus([
          'id' => '4',
          'name' => 'Reposição',
          'charge_client' => '1',
          'pay_professional' => '0',
          'color' => '#FF1E00'
        ]);
      
        $statuses = collect([$statusOk, $statusDesmarcou, $statusReposicao, $statusFaltou]);

        return view('classes.create', compact('statuses'));
    }
    
    public function store(ClassTypeRequest $request, ClassTypeStatusRequest $requestStatus)
    {
        dd($request->all());
        //ClassType::create($request->all());

        return redirect('classes');
    }

    public function update(ClassType $classType, ClassTypeRequest $request)
    {
        dd($request->all());
      
        $classType->update($request->all());

        return redirect('classes');
    }

    public function destroy(ClassType $classType)
    {       
        $classType->delete();

        return redirect('classes');
    }
}
