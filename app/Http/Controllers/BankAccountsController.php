<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\BankAccount;
use App\Http\Requests;
use App\Http\Requests\BankAccountRequest;
use App\Http\Controllers\Controller;

class BankAccountsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bankAccounts = BankAccount::all();

        return view('bankAccounts.index', compact('bankAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(BankAccount $bankAccount)
    {
        return view('bankAccounts.create', compact('bankAccount'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountRequest $request)
    {
        $bankAccount = BankAccount::create($request->all());

        Session::flash('message', 'Successfully created bank account ' . $bankAccount->name);

        return redirect('bank-accounts');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        return view('bankAccounts.show', compact('bankAccount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        return view('bankAccounts.edit', compact('bankAccount'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankAccountRequest $request, BankAccount $bankAccount)
    {
        $bankAccount->update($request->all());

        Session::flash('message', 'Successfully updated bank account ' . $bankAccount->name);

        return redirect('bank-accounts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $bankAccount->delete();

        Session::flash('message', 'Successfully deleted bank account ' . $bankAccount->name);

        return redirect('bank-accounts');
    }
}
