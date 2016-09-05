<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Schedule;
use App\Professional;
use App\ClassType;
use App\FinancialTransaction;
use App\BankAccount;
use App\PaymentMethod;
use App\Http\Requests;
use App\Http\Requests\ProfessionalRequest;
use App\Http\Requests\PaymentReportRequest;
use App\Http\Requests\ProfessionalPaymentStoreRequest;
use App\Http\Controllers\Controller;

use Carbon\Carbon;

class ProfessionalsController extends Controller
{
    public function index()
    {
        $professionals = Professional::all();

        return view('professionals.index', compact('professionals'));
    }

    public function show(Professional $professional)
    {
        return view('professionals.show', compact('professional'));
    }

    public function edit(Professional $professional)
    {
        $classTypes = ClassType::with(['professionals' => function ($query) use ($professional) {
            $query->where('id', $professional->id);
        }])->get();

        return view('professionals.edit', compact('professional', 'classTypes'));
    }

    public function create(Professional $professional)
    {
        $classTypes = ClassType::all();

        return view('professionals.create', compact('professional', 'classTypes'));
    }

    public function store(ProfessionalRequest $request)
    {
        $classTypeList = $request->class_type_list;

        foreach ($classTypeList as $key => $classType) {
            if (!isset($classType['class_type_id'])) {
                unset($classTypeList[$key]);
            }
        }

        $professional = Professional::create($request->all());

        $professional->classTypes()->sync($classTypeList);

        Session::flash('message', 'Successfully added professional ' . $professional->name);

        return redirect('professionals');
    }

    public function update(Professional $professional, ProfessionalRequest $request)
    {
        $professional->update($request->all());

        $classTypeList = $request->class_type_list;

        foreach ($classTypeList as $key => $classType) {
            if (!isset($classType['class_type_id'])) {
                unset($classTypeList[$key]);
            }
        }

        $professional->classTypes()->sync($classTypeList);

        Session::flash('message', 'Successfully updated professional ' . $professional->name);

        return redirect('professionals');
    }

    /**
     * Deletes a professional
     * @param  Professional $professional [description]
     * @return [type]                     [description]
     */
    public function destroy(Professional $professional)
    {
        $professional->delete();

        Session::flash('message', 'Successfully deleted professional ' . $professional->name);

        return redirect('professionals');
    }

    /**
     * [getPricePerClass description]
     * @param  Professional $professional [description]
     * @param  ClassType    $classType    [description]
     * @param  Plan         $plan         [description]
     * @param  [type]       $classPrice   [description]
     * @return [type]                     [description]
     */
    public function getPricePerClass(Professional $professional, ClassType $classType, Plan $plan, $classPrice)
    {
        return null;
    }
}
