<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FinancialTransaction;
use App\FinancialTransactionDetail;
use App\Http\Requests;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cashJournal() {
        return view('reports.cashJournal.form');
    }

    public function showCashJournal(Request $request) {
        $yearMonth = \Carbon\Carbon::parse($request->{"year-month"});

        $financialTransactionDetails = FinancialTransactionDetail::whereYear('date', '=', $yearMonth->year)
            ->whereMonth('date', '=', $yearMonth->month)
            ->with('financialTransaction')
            ->get();

        $creditSum = FinancialTransactionDetail::whereYear('date', '=', $yearMonth->year)
            ->whereMonth('date', '=', $yearMonth->month)
            ->where('type', '=', 'received')
            ->sum('value');

        $debitSum = FinancialTransactionDetail::whereYear('date', '=', $yearMonth->year)
            ->whereMonth('date', '=', $yearMonth->month)
            ->where('type', '=', 'paid')
            ->sum('value');

        return view('reports.cashJournal.show', compact('financialTransactionDetails', 'creditSum', 'debitSum'));
    }
}
