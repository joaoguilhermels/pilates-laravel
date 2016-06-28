@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Reposition</h1>
  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
  <hr />

  @include('errors.list')

  <form action="{{ action('SchedulesController@storeTrialClass') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="name">Client:</label>
      <select name="client_id" class="form-control">
        @foreach($clients as $client)
          <option value="{{ $client->id }}">{{ $client->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      {!! Form::label('class_type_id', 'Class: ') !!}
      {!! Form::select('class_type_id', $classTypes, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('professional_id', 'Professional: ') !!}
      {!! Form::select('professional_id', $professionals, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('room_id', 'Room: ') !!}
      {!! Form::select('room_id', $rooms, null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('start_at', 'Start: ') !!}
      {!! Form::text('start_at', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('end_at', 'End: ') !!}
      {!! Form::text('end_at', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      <input type="submit" value="Add Reposition Class" class="btn btn-primary form-control">
    </div>

  </form>
  </div>
@stop
