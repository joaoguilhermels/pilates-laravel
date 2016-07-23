@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Create New Reposition</h1>
  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
  <hr />

  @include('errors.list')

  <form action="{{ action('SchedulesController@storeReposition') }}" method="POST">
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
      <input type="datetime" name="start_at" class="form-control">
    </div>
    <div class="form-group">
      <label for="end_at">End:</label>
      <input type="datetime" name="end_at" class="form-control">
    </div>
    <div class="form-group">
      <label for="email">Observation:</label>
      <textarea name="observation" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <input type="submit" value="Add Reposition Class" class="btn btn-success form-control">
    </div>

  </form>
  </div>
@stop
