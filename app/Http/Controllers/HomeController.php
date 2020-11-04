<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests;
use App\Professional;
use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $month = money_format('%i', $month);
        $year = money_format('%i', $year);

        return view('home', compact('clients', 'professionals', 'month', 'year', 'unscheduled'));
    }
}
