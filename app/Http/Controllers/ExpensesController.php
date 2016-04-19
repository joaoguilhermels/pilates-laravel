<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Expense;
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
      $expenses = Expense::all();
      
      return view('expenses.index')->with('expenses', $expenses);
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
    
    public function store(ExpenseRequest $request)
    {      
        $expense = Expense::create($request->all());
      
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
