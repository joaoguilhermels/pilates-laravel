@extends('layouts/app')

@section('content')
  <div class="container">
	  <h1>Edit {{ $schedule->name }}</h1>
	  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
	  <hr />

	  @include('errors.list')

	  <form action="{{ action('SchedulesController@update', [$schedule->id]) }}">
	  	{{ csrf_field() }}
	  	{{ method_field('PATCH') }}
	    @include('schedules.edit-form', ['submitButtonText' => 'Update Schedule'])

	  </form>
  </div>
@stop
