<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Session;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::with(['schedules' => function ($query) {
            $query->join('class_type_statuses', 'schedules.class_type_status_id', '=', 'class_type_statuses.id')
                                            ->where('class_type_statuses.name', '=', 'Desmarcou') // Usar State Pattern
                                            ->whereNull('schedules.parent_id')
                                            ->select('schedules.*');
        },
                                'clientPlans', ])
                                ->filter($request->all())
                                ->orderBy('name')
                                ->paginate(20);

        $name = $request->name;

        return view('clients.index', compact('clients', 'name'));
    }

    public function show(Client $client)
    {
        $client->load('schedules', 'clientPlans', 'clientPlans.clientPlanDetails', 'clientPlans.classType', 'clientPlans.financialTransactions');

        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function create(Client $client)
    {
        return view('clients.create', compact('client'));
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create($request->all());

        Session::flash('message', 'Successfully created client '.$client->name);

        return redirect('clients');
    }

    public function update(Client $client, ClientRequest $request)
    {
        $client->update($request->all());

        Session::flash('message', 'Successfully updated client '.$client->name);

        return redirect('clients');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        Session::flash('message', 'Successfully deleted client '.$client->name);

        return redirect('clients');
    }
}
