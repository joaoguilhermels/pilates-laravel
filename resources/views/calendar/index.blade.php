@extends('layouts/app')

@include('calendar.partials.stylesheet')

@section('content')

  <div class="container" id="app">
    <h1>Agenda</h1>
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
