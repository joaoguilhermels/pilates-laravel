@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Clients
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ClientsController@create') }}" class="btn btn-primary">Add New Client</a>
    </h1>

    <hr />

    @if ($total == 0)

    <h2>There no clients yet. You can <a href="{{ action('ClientsController@create') }}">add one here.</a>

    @else
    <div class="well">
      <form action="{{ action('ClientsController@search') }}" method="POST" class="form-inline">
        <fieldset>
          <legend>Search</legend>
          {{ csrf_field() }}
          <div class="form-group">
            <label class="sr-only" for="name">Name</label>
            <input type="text" name="name" value="{{ $name }}" class="form-control" placeholder="Name">
            <label class="sr-only" for="name">Phone</label>
            <input type="text" name="phone" value="{{ $phone }}" class="form-control" placeholder="Phone">
            <label class="sr-only" for="name">Email</label>
            <input type="text" name="email" value="{{ $email }}" class="form-control" placeholder="Email">
          </div>
          <div class="form-group">
            <input type="submit" value="search" class="btn btn-default">
          </div>
        </fieldset>
      </form>
    </div>
    <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Phone</th>
          <th>E-mail</th>
          <th>Observation</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @if (count($clients) > 0)
          @foreach ($clients as $client)
          <tr>
            <td><a href="{{ action('ClientsController@show', [$client->id]) }}">{{ $client->name }}</a></td>
            <td>{{ $client->phone }}</td>
            <td>{{ $client->email }}</td>
            <td>{{ $client->observation }}</td>
            <td>
              <a href="{{ action('ClientsController@edit', [$client->id]) }}" class="btn pull-left">edit</a>
              {!! Form::open(['route' => ['clients.destroy', $client->id], 'method' => 'delete']) !!}
              <button type="submit" class="btn btn-link pull-left">delete</button>
              {!! Form::close() !!}
            </td>
          </tr>
          @endforeach
        @else
          <tr>
            <td colspan="5">No results found</td>
          </tr>
        @endif
      </tbody>
    </table>

    <div class="text-center">
    {!! $clients->render() !!}
    </div>
    </div>
    @endif
  </div>
@stop
