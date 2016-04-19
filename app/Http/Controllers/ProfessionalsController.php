<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
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

    public function reportPayment(Professional $professional) {
        $rows = Schedule::where('professional_id', $professional->id)
                        ->whereMonth('start_at', '=', 3)
                        ->whereYear('start_at', '=', 2016)
                        ->get();
                        
        $total = Schedule::where('professional_id', $professional->id)
                          ->whereMonth('start_at', '=', 3)
                          ->whereYear('start_at', '=', 2016)
                          ->sum('price');

        //{{ $row->price * ($professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value / 100) }}

        return view('professionals.report_payment', compact('professional', 'rows', 'total'));
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
        $classTypeList = $request->input('class_type_list');
        
        foreach($classTypeList as $key => $classType)
        {
            if (!isset($classType['class_type_id']))
            {
                unset($classTypeList[$key]);
            }
        }

        $professional = Professional::create($request->all());

        //$professional->classTypes()->sync($request->input('class_type_list'));
        $professional->classTypes()->sync($classTypeList);

        return redirect('professionals');
    }

    public function update(Professional $professional, ProfessionalRequest $request)
    {
        $professional->update($request->all());

        $classTypeList = $request->input('class_type_list');
        
        foreach($classTypeList as $key => $classType)
        {
            if (!isset($classType['class_type_id']))
            {
                unset($classTypeList[$key]);
            }
        }

        //$professional->classTypes()->sync($request->input('class_type_list'));
        $professional->classTypes()->sync($classTypeList);

        return redirect('professionals');
    }

    public function destroy(Professional $professional)
    {      
        $professional->delete();

        return redirect('professionals');
    }
}
