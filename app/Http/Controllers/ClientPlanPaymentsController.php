<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\ClientPlan;
use App\Models\FinancialTransaction;
use App\Http\Requests\FinancialTransactionRequest;
use App\Models\PaymentMethod;
use Debugbar;
use Illuminate\Support\Arr;

class ClientPlanPaymentsController extends Controller
{
    public function create(ClientPlan $clientPlan)
    {
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();

        $clientPlan->load('client')
                    ->load('plan')
                    ->load('classType');

        return view('clientPlans.payment.create', compact('clientPlan', 'paymentMethods', 'bankAccounts'));
    }

    public function store(FinancialTransactionRequest $request, ClientPlan $clientPlan)
    {
        $request->request->add([
            'name' => 'Plan payment',
        ]);

        $financialTransaction = $clientPlan->financialTransactions()->create($request->all());

        $payments = collect($request->payments);
        $payments->map(function ($payment) use ($financialTransaction) {
            $payment = Arr::add($payment, 'type', 'received');
            $financialTransaction->financialTransactionDetails()->create($payment);
        });

        \Session::flash('message', 'Pagamento de plano adicionado com sucesso!');

        return redirect('clients');
    }

    public function edit(financialTransaction $financialTransaction)
    {
        $paymentMethods = PaymentMethod::all();
        $bankAccounts = BankAccount::all();
        $clientPlan = $financialTransaction->financiable;

        $financialTransaction->load('financialTransactionDetails');

        return view('clientPlans.payment.edit', compact('financialTransaction', 'clientPlan', 'paymentMethods', 'bankAccounts'));
    }

    public function update(FinancialTransactionRequest $request, FinancialTransaction $financialTransaction)
    {
        $request->request->add([
            'name' => 'Plan payment',
            'type' => 'received',
        ]);

        $financialTransaction->update($request->all());

        $payments = collect($request->payments);
        $payments->map(function ($payment) use ($financialTransaction) {
            $financialTransaction->financialTransactionDetails()->where('id', $payment['id'])->update($payment);
        });

        \Session::flash('message', 'Pagamento de plano atualizado com sucesso!');

        return redirect('clients');
    }

    public function show(FinancialTransaction $financialTransaction)
    {
        //dd($financialTransaction);
        Debugbar::info($financialTransaction);
        // Debugbar::error('Error!');
        // Debugbar::warning('Watch out…');
        // Debugbar::addMessage('Another message', 'mylabel');
        return view('clientPlans.payment.show', compact('financialTransaction'));
    }

    public function destroy()
    {
        // code...
    }
}
