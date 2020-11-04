<?php

namespace App\Http\Controllers;

use App\FinancialTransaction;
use App\FinancialTransactionDetail;
use App\Http\Requests;
use DB;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function cashJournal()
    {
        return view('reports.cashJournal.form');
    }

    public function showCashJournal(Request $request)
    {
        $yearMonth = \Carbon\Carbon::parse($request->{'year-month'});

        $financialTransactionDetails = FinancialTransactionDetail::whereYear('date', '=', $yearMonth->year)
            ->whereMonth('date', '=', $yearMonth->month)
            ->with('financialTransaction')
            ->get();

        $financialTransactionDetailsNew = DB::select("SELECT *, ROUND(IF(ftd.type = 'paid', @runtot :=  @runtot - ftd.value, @runtot :=  ftd.value + @runtot), 2) AS saldo FROM financial_transaction_details ftd, financial_transactions ft, (SELECT @runtot := 0) c WHERE ftd.financial_transaction_id = ft.id");

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
