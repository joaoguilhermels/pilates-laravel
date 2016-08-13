@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Clients
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ClientsController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Client</a>
    </h1>

    <hr />

    @if ($total == 0)

    <h2>There no clients yet. You can <a href="{{ action('ClientsController@create') }}">add one here.</a>

    @else
    <div class="well well-sm">
      <form action="{{ action('ClientsController@search') }}" method="POST" class="form-inline">
        <fieldset>
          {{ csrf_field() }}
          <div class="form-group">
            <label class="sr-only" for="name">Name</label>
            <input type="text" name="name" value="{{ $name }}" class="form-control" placeholder="Name">
          </div>
          <div class="form-group">
            <button type="submit" value="search" class="btn btn-default"><i class="fa fa-search"></i></button>
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
            <td>
              <a href="{{ action('ClientPlansController@create', [$client->id]) }}" class="pull-left">Create Plan</a>
              <a href="{{ action('ClientsController@edit', [$client->id]) }}" class="btn btn-sm btn-primary pull-left">
                <i class="fa fa-pencil"></i>
              </a>
              <form action="{{ action('ClientsController@destroy', [$client->id]) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button type="submit" class="btn btn-sm btn-danger pull-left"><i class="fa fa-remove"></i></button>
              </form>
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
