@extends('layouts/app')

@section('content')
  <div class="container">
    <h1></h1>
    <a href="{{ action('ClientsController@index') }}">Back to Schedules List</a>
    <hr />

    <div>{{ $schedule->client->name }}</div>
    <div>{{ $schedule->clientPlanDetail->clientPlan->plan->name }}</div>
    <div>{{ $schedule->classType->name }}</div>
    <div>{{ $schedule->professional->name }}</div>
    <div>{{ $schedule->room->name }}</div>
    <div>{{ $schedule->classTypeStatus->name }}</div>

    <div>{{ $schedule->price }}</div>
    <div>{{ $schedule->start_at }}</div>
    <div>{{ $schedule->end_at }}</div>

    <div class="row">
      <div class="col-md-12">
        <a href="{{ action('SchedulesController@edit', [$schedule->id]) }}" class="btn btn-block btn-success">Edit This Schedule</a>
      </div>
    </div>
  </div>
@stop