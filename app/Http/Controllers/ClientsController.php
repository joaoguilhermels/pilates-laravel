<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Client;
use App\Schedule;
use App\ClientPlan;
use App\Http\Requests;
use App\Http\Requests\ClientRequest;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $clients = Client::paginate(10);

        return view('clients.index', compact('clients'));
    }

    public function show(Client $client)
    {
        //$plans = Client::with('clientPlans', 'clientPlans.clientPlanDetails')->get();
        $client->load('clientPlans', 'clientPlans.clientPlanDetails', 'clientPlans.classType');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function reportCharge(Client $client) {
        $rows = Schedule::where('client_id', $client->id)
                        ->get();
                        //->whereMonth('start_at', '=', 3)
                        //->whereYear('start_at', '=', 2016)

        $total = Schedule::where('client_id', $client->id)
                          ->sum('price');
                          //->whereMonth('start_at', '=', 3)
                          //->whereYear('start_at', '=', 2016)

        //{{ $row->price * ($professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value / 100) }}

        $rows = ClientPlan::where('client_id', $client->id)->get();

        return view('clients.report_charge', compact('client', 'rows', 'total'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all());

        Session::flash('message', 'Successfully created client ' . $client->name);

        return redirect('clients');
    }

    public function update(Client $client, ClientRequest $request)
    {
        $client->update($request->all());

        Session::flash('message', 'Successfully updated client ' . $client->name);

        return redirect('clients');
    }

    public function destroy(Client $client)
    {
        Session::flash('message', 'Successfully deleted client ' . $client->name);

        $client->delete();

        return redirect('clients');
    }
}
