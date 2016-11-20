@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>
      Schedules
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('SchedulesController@create') }}" class="btn btn-success">Add New Schedule</a>
    </h1>

    <hr />

    @if (count($schedules) == 0)

    <h2>There no schedules yet. You can <a href="{{ action('SchedulesController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Class</th>
          <th>Client</th>
          <th>Room</th>
          <th>Professional</th>
          <th>Status</th>
          <th>Price</th>
          <th>Start At</th>
          <th>End At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($schedules as $key => $schedule)
        <tr>
          <td colspan="9">
            {{ $key }}
          </td>
        </tr>
          @foreach ($schedules[$key] as $schedule)
          <tr>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->classType->name }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->client->name }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->room->name }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->professional->name }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->classTypeStatus->name }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->price }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->start_at }}</a></td>
            <td><a href="{{ action('SchedulesController@show', [$schedule->id]) }}">{{ $schedule->end_at }}</a></td>
            <td>
              <a href="{{ action('SchedulesController@edit', [$schedule->id]) }}" class="btn pull-left">edit</a>
              <form action="{{ action('SchedulesController@destroy', [$schedule->id]) }}">
              {{ csrf_field() }}
              {{ method_field("DELETE") }}
              <button type="submit" class="btn btn-link pull-left">delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  {{-- </div> --}}
@stop
