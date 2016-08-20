@extends('layouts/app')

@include('calendar.partials.stylesheet')

@section('content')

  <div class="container-fluid">
    <h1>Agenda (by group)</h1>
    {!! $calendar->calendar() !!}
  </div>

@stop

@include('calendar.partials.script')