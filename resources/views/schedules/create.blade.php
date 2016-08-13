@extends('layouts/app')


@section('content')
  <div class="container">
    <h1>Create New Schedule</h1>
    <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('SchedulesController@store') }}" method="POST">
      {{ csrf_field() }}
      @include('schedules.create-form', ['submitButtonText' => 'Add New Schedule'])
    </form>
  </div>
@stop
