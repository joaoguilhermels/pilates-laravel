<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ClientPlan;
use App\PaymentMethod;
use App\BankAccount;
use App\Http\Requests;

class FinancialTransactionsController extends Controller
{
    public function createPlanPayment(ClientPlan $clientPlan)
    {
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();

        return view('clientPlans.payment.create', compact('clientPlan', 'paymentMethods', 'bankAccounts'));
    }

    public function storePlanPayment(planRequest $request)
    {
        $plan = plan::create($request->all());

        return redirect('plans');
    }
}
