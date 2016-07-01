@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Create New Trial Class</h1>
  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
  <hr />

  @include('errors.list')

  <form action="{{ action('SchedulesController@storeTrialClass') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" name="name" class="form-control">
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="text" name="phone" class="form-control">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
      <label for="class_type_id">Class:</label>
      <select name="class_type_id" class="form-control">
        @foreach($classTypes as $classType)
          <option value="{{ $classType->id }}">{{ $classType->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="professional_id">Professional:</label>
      <select name="professional_id" class="form-control">
        @foreach($professionals as $professional)
          <option value="{{ $professional->id }}">{{ $professional->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="room_id">Room:</label>
      <select name="room_id" class="form-control">
        @foreach($rooms as $room)
          <option value="{{ $room->id }}">{{ $room->name }}</option>
        @endforeach
      </select>
    </div>  
    <div class="form-group">
      <label for="start_at">Start:</label>
      {!! Form::text('start_at', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      <label for="end_at">End:</label>
      {!! Form::text('end_at', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
      <input type="submit" value="Add Trial Class" class="btn btn-primary form-control">
    </div>

  </form>
  </div>
@stop
