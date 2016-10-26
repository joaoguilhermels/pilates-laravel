@extends('layouts/app')

@section('content')
  <div class="container" id="app">
  <h1>Create New Reposition</h1>
  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
  <hr />

  @include('errors.list')

  <form action="{{ action('RepositionSchedulesController@store') }}" method="POST">
    {{ csrf_field() }}
    <div class="form-group">
      <label for="name">Client:</label>
      <select name="client_id" class="form-control">
        @foreach($clients as $client)
          <option value="{{ $client->id }}">{{ $client->name }}</option>
        @endforeach
      </select>
    </div>

    <class-professional-room classes="{{ json_encode($classTypes) }}"></class-professional-room>

    <start-at></start-at>
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
@section('script_footer')
  <script src="/js/components/class-professional-room.js"></script>
@stop
