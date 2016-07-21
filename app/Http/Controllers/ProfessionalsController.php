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

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $professionals = Professional::all();

        return view('professionals.index', compact('professionals'));
    }

    public function indexPayments()
    {
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
        return view('professionals.show', compact('professional'));
    }

    public function edit(Professional $professional)
    {
        //$classTypes = ClassType::with('professionals')->wherePivot('professional_id', '=', $professional->id)->get();
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

    public function createProfessionalPayment()
    {
        $professionals = Professional::all();

        return view('professionals.payments.create', compact('professionals'));
    }

    public function generatePaymentReport(PaymentReportRequest $request)
    {
        $startAt        = Carbon::parse($request->start_at);
        $endAt          = Carbon::parse($request->end_at);
        $professional   = Professional::findOrFail($request->professional);
        $bankAccounts   = BankAccount::all();
        $paymentMethods = PaymentMethod::all();

        $rows = Schedule::where('professional_id', $request->professional)
                    ->where('professional_payment_financial_transaction_id', '=', 0)
                    ->whereDay('start_at', '>=', $startAt->day)
                    ->whereMonth('start_at', '>=', $startAt->month)
                    ->whereYear('start_at', '>=', $startAt->year)
                    ->whereDay('end_at', '<=', $endAt->day)
                    ->whereMonth('end_at', '<=', $endAt->month)
                    ->whereYear('end_at', '<=', $endAt->year)
                    ->orderBy('start_at')
                    ->get();

        $total = Schedule::where('professional_id', $request->professional)
                    ->where('professional_payment_financial_transaction_id', '=', 0)
                    ->whereDay('start_at', '>=', $startAt->day)
                    ->whereMonth('start_at', '>=', $startAt->month)
                    ->whereYear('start_at', '>=', $startAt->year)
                    ->whereDay('end_at', '<=', $endAt->day)
                    ->whereMonth('end_at', '<=', $endAt->month)
                    ->whereYear('end_at', '<=', $endAt->year)
                    ->sum('price');

        $professional_total = Schedule::where('professional_id', $request->professional)
                                  ->where('professional_payment_financial_transaction_id', '=', 0)
                                  ->whereDay('start_at', '>=', $startAt->day)
                                  ->whereMonth('start_at', '>=', $startAt->month)
                                  ->whereYear('start_at', '>=', $startAt->year)
                                  ->whereDay('end_at', '<=', $endAt->day)
                                  ->whereMonth('end_at', '<=', $endAt->month)
                                  ->whereYear('end_at', '<=', $endAt->year)
                                  ->sum('value_professional_receives');

        return view('professionals.report_payment', compact('professional', 'bankAccounts', 'paymentMethods', 'rows', 'total', 'professional_total', 'startAt', 'endAt'));
    }

    /**
     * Stores Professional payment by creating a FinancialTransaction and a
     * FinancialTransactionDetail. Once this is done the function also
     * updates the schedules to make a relationship with the FinancialTransaction
     *
     * @param  ProfessionalPaymentStoreRequest $request      [description]
     * @param  Professional                    $professional [The proessional to associate with the FinancialTransaction (payment)]
     * @return redirect                                      [Redirects the user to the list of Professional Payments]
     */
    public function storeProfessionalPayment(ProfessionalPaymentStoreRequest $request, Professional $professional)
    {
        $startAt = Carbon::parse($request->startAt);
        $endAt = Carbon::parse($request->endAt);

        $request->request->add([
            'total_number_of_payments' => 1,
            'name' => 'Professional Payment'
        ]);

        $financialTransaction = $professional->financialTransactions()->create($request->all());

        $request->request->add([
            'type' => 'paid'
        ]);

        $financialTransaction->financialTransactionDetails()->create($request->all());

        $schedules = Schedule::where('professional_id', $professional->id)
                        ->whereYear('start_at', '>=', $startAt->year)
                        ->whereYear('end_at', '<=', $endAt->year)
                        ->whereMonth('start_at', '>=', $startAt->month)
                        ->whereMonth('end_at', '<=', $endAt->month)
                        ->whereDay('start_at', '>=', $startAt->day)
                        ->whereDay('end_at', '<=', $endAt->day)
                        ->update(['professional_payment_financial_transaction_id' => $financialTransaction->id]);

        Session::flash('message', 'Successfully added payment to professional ' . $professional->name);

        return redirect('professionals/payments');
    }

    public function destroyProfessionalPayment(FinancialTransaction $financialTransaction)
    {
        Session::flash('message', 'Successfully deleted professional payment.');

        // Check if we can't do this in the migration on something like onDelete('set 0') or something like that
        Schedule::where('professional_payment_financial_transaction_id', $financialTransaction->id)
                    ->update(['professional_payment_financial_transaction_id' => null]);

        $financialTransaction->financialTransactionDetails()->delete();
        $financialTransaction->delete();

        return redirect('professionals/payments');
    }

    public function store(ProfessionalRequest $request)
    {
        $classTypeList = $request->class_type_list;

        foreach($classTypeList as $key => $classType)
        {
            if (!isset($classType['class_type_id']))
            {
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

        foreach($classTypeList as $key => $classType)
        {
            if (!isset($classType['class_type_id']))
            {
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
