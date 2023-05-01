<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Professional;
use App\Models\Schedule;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = 'Dashboard';
        $clients = Client::count();
        $professionals = Professional::count();
        $month = Schedule::whereMonth('start_at', Carbon::now()->month)
                    ->whereYear('start_at', Carbon::now()->year)
                    ->sum('price');

        $year = Schedule::whereYear('start_at', Carbon::now()->year)
                    ->sum('price');

        $unscheduled = Schedule::Unscheduled(Carbon::now()->month, Carbon::now()->year);
        //dd($unscheduled);
        //$fmt = new NumberFormatter( 'de_DE', NumberFormatter::CURRENCY );
        //echo $fmt->formatCurrency(1234567.891234567890000, "EUR")."\n";

        //$month = money_format('%i', $month);
        //$year = money_format('%i', $year);

        return view('home', compact('clients', 'professionals', 'month', 'year', 'unscheduled'));
    }
}
