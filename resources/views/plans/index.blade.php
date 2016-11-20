@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>
      Plans
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('PlansController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Plan</a>
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
          <td>{{ $plan->classType->name }}</td>
          <td>{{ $plan->price }} per {{ $plan->price_type }}</td>
          <td>{{ $plan->times }} per {{ $plan->times_type }}</td>
          <td>{{ $plan->duration }} {{ $plan->duration_type }}</td>
          <td>
            <a href="{{ action('PlansController@edit', [$plan->id]) }}" class="btn pull-left"><i class="fa fa-pencil"></i> edit</a>
            <form action="{{ action('PlansController@destroy', [$plan->id]) }}" method="post">
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
  {{-- </div> --}}
@stop
