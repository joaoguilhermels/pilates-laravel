@extends('layouts/app')

@include('calendar.partials.stylesheet')

@section('content')

  <div class="container" id="app">
    <h1>Agenda</h1>

    <form class="form-inline" action="" method="post">
      <div class="form-group">
        <label for="professional_id">Professional: </label>
        <select class="form-control" name="professional_id">
          <option value="all">All</option>
          <option value="option">Bruna</option>
        </select>
      </div>

      <div class="form-group">
        <label for="professional_id">Class: </label>
        <select class="form-control" name="professional_id">
          <option value="all">All</option>
          <option value="option">Bruna</option>
        </select>
      </div>

      <div class="form-group">
        <label for="professional_id">Room: </label>
        <select class="form-control" name="professional_id">
          <option value="all">All</option>
          <option value="option">Bruna</option>
        </select>
      </div>
    </form>

    {!! $calendar->calendar() !!}
    <!-- use the modal component, pass in the prop -->
    <modal :show.sync="showModal" :header.sync="headerTitle">
      <!--
        you can use custom content here to overwrite
        default content
      -->
      <!--h3 slot="header">custom header</h3-->
    </modal>
  </div>

@stop

@include('calendar.partials.script')
