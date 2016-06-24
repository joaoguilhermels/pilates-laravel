<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClientPlan;
use App\PaymentMethod;
use App\BankAccount;
use App\FinancialTransaction;
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

    public function storePlanPayment(FinancialTransactionRequest $request)
    {
        dd($request->all());
        //$plan = plan::create($request->all());

        //return redirect('plans');
    }
}
