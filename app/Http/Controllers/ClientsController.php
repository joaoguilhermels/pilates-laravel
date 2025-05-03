<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;

class ClientsController extends Controller
{
    /**
     * Display a listing of clients.
     */
    public function index(Request $request): View
    {
        $clients = Client::with(['schedules' => function ($query) {
            $query->join('class_type_statuses', 'schedules.class_type_status_id', '=', 'class_type_statuses.id')
                  ->where('class_type_statuses.name', '=', 'Desmarcou') // Usar State Pattern
                  ->whereNull('schedules.parent_id')
                  ->select('schedules.*');
        },
        'clientPlans'])
        ->filter($request->all())
        ->orderBy('name')
        ->paginate(20);

        $name = $request->name;

        return view('clients.index', compact('clients', 'name'));
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client): View
    {
        $client->load('schedules', 'clientPlans', 'clientPlans.clientPlanDetails', 'clientPlans.classType', 'clientPlans.financialTransactions');

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified client.
     */
    public function edit(Client $client): View
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Show the form for creating a new client.
     */
    public function create(): View
    {
        $client = new Client();
        return view('clients.create', compact('client'));
    }

    /**
     * Store a newly created client in storage.
     */
    public function store(ClientRequest $request): RedirectResponse
    {
        $client = Client::create($request->validated());

        Session::flash('message', 'Successfully created client '.$client->name);

        return redirect()->route('clients.index');
    }

    /**
     * Update the specified client in storage.
     */
    public function update(Client $client, ClientRequest $request): RedirectResponse
    {
        $client->update($request->validated());

        Session::flash('message', 'Successfully updated client '.$client->name);

        return redirect()->route('clients.index');
    }

    /**
     * Remove the specified client from storage.
     */
    public function destroy(Client $client): RedirectResponse
    {
        $client->delete();

        Session::flash('message', 'Successfully deleted client '.$client->name);

        return redirect()->route('clients.index');
    }
}
