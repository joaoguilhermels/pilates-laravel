@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Plans
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('PlansController@create') }}" class="btn btn-success">Add New Plan</a>
    </h1>

    <hr />

    @if (count($plans) == 0)

    <h2>There no plans yet. You can <a href="{{ action('PlansController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Class</th>
          <th>Price</th>
          <th>Times</th>
          <th>Plan Duration</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($plans as $plan)
        <tr>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->name }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->classType->name }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->price }} per {{ $plan->price_type }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->times }} per {{ $plan->times_type }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->duration }} {{ $plan->duration_type }}</a></td>
          <td>
            <a href="{{ action('PlansController@edit', [$plan->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['plans.destroy', $plan->id], 'method' => 'delete']) !!}
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
