<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Client;
use App\Schedule;
use App\Professional;

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

        $month = money_format('%i', $month);
        $year = money_format('%i', $year);

        return view('home', compact('clients', 'professionals', 'month', 'year'));
    }
}
