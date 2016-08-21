<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Expense;
use App\FinancialTransaction;
use App\Http\Requests;
use App\Http\Requests\ExpenseRequest;
use App\Http\Controllers\Controller;

class ExpensesController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index() {
      //$expenses = Expense::all();
      $expenses = Expense::all();

      dd($expenses->financialTransactions());

      return view('expenses.index', compact('expenses'));
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        return view('expenses.edit', compact('expense'));
    }

    public function create()
    {
        return view('expenses.create');
    }

    public function store(ExpenseRequest $request, Expense $expense)
    {
        //$expense = Expense::create($request->all());

        /*$request->request->add([
            'type' => 'paid',
            'payment_number' => 1,
            'total_number_of_payments' => 1,
            'status' => 1, // Define how these statuses will work
            'confirmed_value' => $request->input('value'),
            'confirmed_date' => Carbon::now(),
            'oberservation' => ''
        ]);*/

        //$professional->financialTransactions()->create($request->all());

        $request->request->add([
            'type' => 'paid', // paid or received - Expenses are always paid obviously
            'payment_method_id' => 1, // Fixed 'dinheiro'. Add a payment method dropdown and define if it is avaiable for payments from clients and from the studio
            'bank_account_id' => 1, // Show a dropdown of the bank accounts
            'value' => $request->get('price'),
            'date' => $request->get('date'),
            'payment_number' => 1,
            'total_number_of_payments' => 1,
            'status' => 1, // We need a new table for finantial transaction statuses
            'confirmed_value' => $request->get('price'),
            'confirmed_date' => $request->get('date'),
            'observation' => 'Expense observation'
        ]);

        /*$financialTransaction = array(
            //'entity_id' => $expense->id,
            //'entity_type' => 'expense',
            'type' => 'paid', // paid or received - Expenses are always paid obviously
            'payment_method_id' => 1, // Fixed 'dinheiro'. Add a payment method dropdown and define if it is avaiable for payments from clients and from the studio
            'bank_account_id' => 1, // Show a dropdown of the bank accounts
            'date' => $expense->date,
            'value' => $expense->price,
            'payment_number' => 1,
            'total_number_of_payments' => 1,
            'status' => 1, // We need a new table for finantial transaction statuses
            'confirmed_value' => $expense->price,
            'confirmed_date' => $expense->date,
            'observation' => 'Expense observation'
        );*/

        //FinancialTransaction::create($request->all());
        $expense->financialTransactions()->create($request->all());

        return redirect('expenses');
    }

    public function update(Expense $expense, ExpenseRequest $request)
    {
        $expense->update($request->all());

        return redirect('expenses');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect('expenses');
    }
}
