<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
      
      //return view('clients.index', compact('clients')); // or view('clients.index')->with('clients', $clients);
      return view('clients.index')->with('clients', $clients);
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
        Client::create($request->all());
      
        return redirect('clients');
    }

    public function update(Client $client, ClientRequest $request)
    {        
        $client->update($request->all());

        return redirect('clients');
    }
}
