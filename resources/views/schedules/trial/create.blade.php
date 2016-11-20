@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container" id="app"> --}}
  <div id="app">
    <h1>Create New Trial Class</h1>
    <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('TrialSchedulesController@store') }}" method="POST">
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

      <class-professional-room classes="{{ json_encode($classTypes) }}"></class-professional-room>

      <start-at></start-at>
      
      <div class="form-group">
        <label for="email">Observation:</label>
        <textarea name="observation" class="form-control"></textarea>
      </div>
      <div class="form-group">
        <input type="submit" value="Add Trial Class" class="btn btn-success form-control">
      </div>
    </form>
  </div>
@stop

@section('script_footer')
  <script src="/js/components/class-professional-room.js"></script>
@stop