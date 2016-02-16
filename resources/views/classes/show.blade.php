@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $classType->name }}</h1>
    <a href="{{ action('ClassTypesController@index') }}">Back to Classes List</a>
    <hr />

    <div class="row">
      <div class="col-md-8">
        <dl class="dl-horizontal">
          <dt>Max Number of Clients:</dt>
          <dd>{{ $classType->max_number_of_clients }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Duration:</dt>
          <dd>{{ $classType->duration }}</dd>
        </dl>
        <a href="{{ action('ClassTypesController@edit', [$classType->id]) }}" class="btn btn-block btn-primary">Edit This Class</a>
      </div>
      <div class="col-md-4">
        @include('classes.partials.professionals-block')

        @include('classes.partials.rooms-block')
      </div>
    </div>
  </div>

@stop