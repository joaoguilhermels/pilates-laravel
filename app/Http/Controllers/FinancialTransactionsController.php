<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;
use App\ClientPlan;
use App\ClientPlanDetail;
use App\PaymentMethod;
use App\BankAccount;
use App\FinancialTransaction;
use App\FinancialTransactionDetail;
use App\Http\Requests;
use App\Http\Requests\FinancialTransactionRequest;

class FinancialTransactionsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function createPlanPayment(ClientPlan $clientPlan)
    {
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();

        $clientPlan->load('client')
                    ->load('plan')
                    ->load('classType');

        return view('clientPlans.payment.create', compact('clientPlan', 'paymentMethods', 'bankAccounts'));
    }

    public function storePlanPayment(FinancialTransactionRequest $request, ClientPlan $clientPlan)
    {
        $request->request->add([
            'name' => 'Plan payment',
            'type' => 'received',
        ]);

        $financialTransaction = $clientPlan->financialTransactions()->create($request->all());

        $payments = collect($request->payments);
        $payments->map(function ($payment) use ($financialTransaction)
        {
            $financialTransaction->financialTransactionDetails()->create($payment);
        });

        /*$clientPlan->clientPlanDetails->map(function ($clientPlanDetail) use ($financialTransaction)
        {
            Schedule::where('scheduable_type', ClientPlanDetail::class)
                ->where('scheduable_id', $clientPlanDetail->id)
                ->update(['client_payment_financial_transaction_id' => $financialTransaction->id]);
        });*/

        \Session::flash('message', 'Successfully added Client Plan Payment');

        return redirect('clients');
    }

    public function editPlanPayment(financialTransaction $financialTransaction)
    {
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();
        $clientPlan = $financialTransaction->financiable;

        $financialTransaction->load('financialTransactionDetails');

        return view('clientPlans.payment.edit', compact('financialTransaction', 'clientPlan', 'paymentMethods', 'bankAccounts'));
    }

    public function updatePlanPayment(FinancialTransactionRequest $request, financialTransaction $financialTransaction)
    {
        $request->request->add([
            'name' => 'Plan payment',
            'type' => 'received',
        ]);

        $financialTransaction->update($request->all());

        $payments = collect($request->payments);
        $payments->map(function ($payment) use ($financialTransaction)
        {
            $financialTransaction->financialTransactionDetails()->where('id', $payment['id'])->update($payment);
        });

        \Session::flash('message', 'Successfully updated Client Plan Payment');

        return redirect('clients');
    }
}