@extends('layouts/app')

@section('content')
<div class="container" id="app">
  <h1>Create New Extra Class</h1>
  <a href="{{ action('SchedulesController@index') }}">Back to Schedules List</a>
  <hr />

  @include('errors.list')

  <form action="{{ action('SchedulesController@storeExtraClass') }}" method="POST">
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

    <template id="class-professional-room-template">
      <div class="form-group">
        <label for="class_type_id">Class: </label>
        <select name="class_type_id" class="form-control" v-model="selectedClassId" v-on:change="selectClass" v-if="classes.length > 1">
          <option value=""></option>
          <option v-for="(index, class) in classes" v-bind:value="class.id">@{{ class.name }}</option>
        </select>
        <div v-else>
          @{{ classes[0].name }}
          <input type="hidden" name="class_type_id" v-bind:value="classes[0].id" v-model="selectedClassId">
        </div>
      </div>

      <div class="form-group" v-if="selectedClass">
        <label for="professional_id">Professional: </label>
        <select name="professional_id" class="form-control" v-if="selectedClass.professionals.length > 1">
          <option value=""></option>
          <option v-for="professional in selectedClass.professionals" v-bind:value="professional.id">@{{ professional.name }}</option>
        </select>
        <div v-else>
          @{{ selectedClass.professionals[0].name }}
          <input type="hidden" name="professional_id" v-bind:value="selectedClass.professionals[0].id">
        </div>
      </div>
      <div class="form-group" v-if="selectedClass">
        <label for="room_id">Room: </label>
        <select name="room_id" class="form-control" v-if="selectedClass.rooms.length > 1">
          <option value=""></option>
          <option v-for="room in selectedClass.rooms" v-bind:value="room.id">@{{ room.name }}</option>
        </select>
        <div v-else>
          @{{ selectedClass.rooms[0].name }}
          <input type="hidden" name="room_id" v-bind:value="selectedClass.rooms[0].id">
        </div>
      </div>
    </template>

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

@section('script_footer')
  <script src="/js/components/class-professional-room.js"></script>
@stop
