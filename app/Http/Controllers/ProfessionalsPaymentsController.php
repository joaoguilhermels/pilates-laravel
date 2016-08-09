<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Http\Requests;
use App\FinancialTransaction;
use App\BankAccount;
use App\PaymentMethod;
use App\Schedule;
use App\Professional;

use App\Http\Requests\PaymentReportRequest;

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
        $professionals = Professional::all();

        return view('professionals.payments.create', compact('professionals'));
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
    public function store(ProfessionalPaymentStoreRequest $request, Professional $professional)
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

    public function destroy(FinancialTransaction $financialTransaction)
    {
        Session::flash('message', 'Successfully deleted professional payment.');

        // Check if we can't do this in the migration on something like onDelete('set 0') or something like that
        Schedule::where('professional_payment_financial_transaction_id', $financialTransaction->id)
                    ->update(['professional_payment_financial_transaction_id' => null]);

        $financialTransaction->financialTransactionDetails()->delete();
        $financialTransaction->delete();

        return redirect('professionals/payments');
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

    public function reportPayment(Professional $professional) {
        $rows = Schedule::where('professional_id', $professional->id)
                        ->get();

        $total = Schedule::where('professional_id', $professional->id)
                          ->sum('price');

        return view('professionals.report_payment', compact('professional', 'rows', 'total'));
    }
}
