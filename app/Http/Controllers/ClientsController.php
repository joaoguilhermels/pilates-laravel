<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Session;
use App\Client;
use App\Http\Requests;
use App\Http\Requests\ClientRequest;
use App\Http\Controllers\Controller;

class ClientsController extends Controller
{

    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index() {
      $clients = Client::all();
      
      return view('clients.index', compact('clients')); // or view('clients.index')->with('clients', $clients);
    }
    
    public function show(Client $client)
    {
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
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
