<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index() {
      $professionals = Professional::all();

      return view('professionals.index')->with('professionals', $professionals);
    }

    public function indexPayments() {
      $financialTransactions = FinancialTransaction::where('financiable_type', 'App\Professional')
                                    ->get();

      return view('professionals.payments.index', compact('financialTransactions'));
    }

    public function reportPayment(Professional $professional) {
        $rows = Schedule::where('professional_id', $professional->id)
                        ->get();
//                        ->whereMonth('start_at', '=', 3)
//                        ->whereYear('start_at', '=', 2016)

        $total = Schedule::where('professional_id', $professional->id)
                          ->sum('price');
//                          ->whereMonth('start_at', '=', 3)
//                          ->whereYear('start_at', '=', 2016)

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

    public function createProfessionalPayment() {
        $professionals = Professional::lists('name', 'id');

        return view('professionals.payments.create', compact('professionals'));
    }

    public function generatePaymentReport(PaymentReportRequest $request) {
        //$requestAll     = $request->all();
        //$professionalId = $requestAll['professional'];
        $startAt        = Carbon::parse($request->get('start_at'));
        $professional   = Professional::findOrFail($request->get('professional'));
        $bankAccounts   = BankAccount::all();
        $paymentMethods = PaymentMethod::all();

        $rows = Schedule::where('professional_id', $request->get('professional'))
                          ->whereMonth('start_at', '=', $startAt->month)
                          ->whereYear('start_at', '=', $startAt->year)
                          ->get();

        $total = Schedule::where('professional_id', $request->get('professional'))
                            ->whereMonth('start_at', '=', $startAt->month)
                            ->whereYear('start_at', '=', $startAt->year)
                            ->sum('price');

        return view('professionals.report_payment', compact('professional', 'bankAccounts', 'paymentMethods', 'rows', 'total'));
    }

    public function storeProfessionalPayment(ProfessionalPaymentStoreRequest $request, Professional $professional) {
        /*$extraData = array(
            'entity_type' => 'professional_payment',
            'type' => 'paid',
            'payment_number' => 1,
            'total_number_of_payments' => 1,
            'status' => 1, // Define how these statuses will work
            'confirmed_value' => $requestAll['value'],
            'confirmed_date' => Carbon::now(),
            'oberservation' => '',
        );

        $requestAll = array_merge($requestAll, $extraData);*/

        $request->request->add([
            'type' => 'paid',
            'payment_number' => 1,
            'total_number_of_payments' => 1,
            'status' => 1, // Define how these statuses will work
            'confirmed_value' => $request->input('value'),
            'confirmed_date' => Carbon::now(),
            'oberservation' => ''
        ]);

        //$financialTransaction = FinancialTransaction::create($request->all());

        $professional->financialTransactions()->create($request->all());

        return redirect('professionals/payments');
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

    /**
     * Deletes a professional
     * @param  Professional $professional [description]
     * @return [type]                     [description]
     */
    public function destroy(Professional $professional)
    {
        $professional->delete();

        return redirect('professionals');
    }

    public function getPricePerClass(Professional $professional, ClassType $classType, Plan $plan, $classPrice)
    {
        return null;
    }
}
