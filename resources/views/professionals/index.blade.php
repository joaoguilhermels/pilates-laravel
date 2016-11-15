@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Professionals
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ProfessionalsController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Professional</a>
    </h1>

    <hr />

    @if (count($professionals) == 0)

    <h2>There no professionals yet. You can <a href="{{ action('ProfessionalsController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
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
        @foreach ($professionals as $professional)
        <tr>
          <td><a href="{{ action('ProfessionalsController@show', [$professional->id]) }}">{{ $professional->name }}</a></td>
          <td>{{ $professional->phone }}</td>
          <td>{{ $professional->email }}</td>
          <td>{{ $professional->description }}</td>
          <td>
            <a href="{{ action('ProfessionalsController@edit', [$professional->id]) }}" class="btn pull-left"><i class="fa fa-pencil"></i> edit</a>
            <form action="{{ action('ProfessionalsController@destroy', [$professional->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field("DELETE") }}
            <button type="submit" class="btn btn-link pull-left"><i class="fa fa-times"></i> delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  </div>
@stop
