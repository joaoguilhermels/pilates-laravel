<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use Carbon\Carbon;

use App\Http\Requests;
use App\FinancialTransaction;
use App\FinancialTransactionDetail;
use App\BankAccount;
use App\PaymentMethod;
use App\Schedule;
use App\Professional;

use App\Http\Requests\PaymentReportRequest;
use App\Http\Requests\ProfessionalPaymentRequest;

class ProfessionalsPaymentsController extends Controller
{
    public function index()
    {
        $financialTransactions = FinancialTransaction::where('financiable_type', 'App\Professional')
                                      ->with('financialTransactionDetails')
                                      ->get();

        return view('professionals.payments.index', compact('financialTransactions'));
    }

    public function create()
    {
        $professionals = Professional::orderBy('name')->get();

        return view('professionals.payments.create', compact('professionals'));
    }

    /**
     * Stores Professional payment by creating a FinancialTransaction and a
     * FinancialTransactionDetail. Once this is done the function also
     * updates the schedules to make a relationship with the FinancialTransaction
     *
     * @param  ProfessionalPaymentRequest $request      [description]
     * @param  Professional               $professional [The proessional to associate with the FinancialTransaction (payment)]
     * @return redirect                   [Redirects the user to the list of Professional Payments]
     */
    public function store(ProfessionalPaymentRequest $request, Professional $professional)
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
                        ->whereDate('start_at', '>=', $startAt)
                        ->whereDate('end_at', '<=', $endAt)
                        ->update(['professional_payment_financial_transaction_id' => $financialTransaction->id]);

        Session::flash('message', 'Successfully added payment to professional ' . $professional->name);

        return redirect('professionals/payments');
    }

    public function edit(FinancialTransaction $financialTransaction)
    {
        $rows = Schedule::where('professional_payment_financial_transaction_id', $financialTransaction->id)
                        ->orderBy('start_at')
                        ->get();
        
        $total = $rows->sum('price');
        $endAt = $rows->max('start_at');
        $startAt = $rows->min('start_at');
        $professional = $financialTransaction->financiable;

        $bankAccounts   = BankAccount::orderBy('name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();
        $financialTransactionDetail = $financialTransaction->financialTransactionDetails->first();
        $professional_total = $financialTransactionDetail->value;

        return view('professionals.payments.review', compact('professional', 'bankAccounts', 'paymentMethods', 'rows', 'total', 'professional_total', 'startAt', 'endAt', 'financialTransactionDetail'));
    }

    public function update(ProfessionalPaymentRequest $request, Professional $professional)
    {
        # code...
    }

    public function destroy(FinancialTransaction $financialTransaction)
    {
        Session::flash('message', 'Successfully deleted professional payment.');

        // Delete cascades Financial Transaction Details
        // And onDelete set null on schedules
        $financialTransaction->delete(); 

        return redirect('professionals/payments');
    }

    public function generatePaymentReport(PaymentReportRequest $request, FinancialTransaction $financialTransaction)
    {
        $startAt        = Carbon::parse($request->start_at);
        $endAt          = Carbon::parse($request->end_at);
        $professional   = Professional::findOrFail($request->professional);
        $bankAccounts   = BankAccount::orderBy('name')->get();
        $paymentMethods = PaymentMethod::orderBy('name')->get();

        $rows = Schedule::where('professional_id', $request->professional)
                        ->whereNull('professional_payment_financial_transaction_id')
                        ->whereDate('start_at', '>=', $startAt)
                        ->whereDate('end_at', '<=', $endAt)
                        ->orderBy('start_at')
                        ->get();

        $total = $rows->sum('price');
        $professional_total = $rows->sum('value_professional_receives');
        $financialTransactionDetail = $financialTransaction->financialTransactionDetails->first() ?? new FinancialTransactionDetail();

        return view('professionals.payments.review', compact('professional', 'bankAccounts', 'paymentMethods', 'rows', 'total', 'professional_total', 'startAt', 'endAt', 'financialTransactionDetail'));
    }
}
