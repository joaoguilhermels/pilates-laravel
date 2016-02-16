@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Clients
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ClientsController@create') }}" class="btn btn-primary">Add New Client</a>
    </h1>
    
    <hr />

    @if (count($clients) == 0)
  
    <h2>There no clients yet. You can <a href="{{ action('ClientsController@create') }}">add one here.</a>
  
    @else
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
          <td>
            <a href="{{ action('ClientsController@edit', [$client->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-link pull-left">delete</button>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  </div>
@stop