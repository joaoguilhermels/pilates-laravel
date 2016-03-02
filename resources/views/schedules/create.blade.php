@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Schedule</h1>
  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'schedules']) !!}
    {!! Form::hidden('class_type_status_id', 53) !!}
    @include('schedules.form', ['submitButtonText' => 'Add New Schedule'])

  {!! Form::close() !!}  
  </div>
@stop