<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Schedule;

use App\Http\Requests;

class DashboardFinancialController extends Controller
{
    public function ClientPlaymentsBox()
    {
        //select date_format(start_at, '%Y%m'), sum(price) from schedules group by date_format(start_at, '%Y%m');

        $rows = DB::table('schedules')->select(DB::raw('DATE_FORMAT(start_at, \'%Y%m\'), sum(price)'))->groupBy();
    }
}
