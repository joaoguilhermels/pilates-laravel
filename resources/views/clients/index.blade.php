@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Clients</h1>
    
    <hr />
  
    <div class="table-responsive">          
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Phone</th>
          <th>E-mail</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($clients as $client)
        <tr>
          <td><a href="{{ action('ClientsController@show', [$client->id]) }}">{{ $client->name }}</a></td>
          <td>{{ $client->phone }}</td>
          <td>{{ $client->mail }}</td>
          <td>{{ $client->description }}</td>
          <td><a href="{{ action('ClientsController@edit', [$client->id]) }}">edit</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>    
  </div>
@stop