@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $room->name }}</h1>
    <a href="{{ action('ClientsController@index') }}">Back to Rooms List</a>
    <hr />

    <div class="row">
      <div class="col-md-12">
        <a href="{{ action('RoomsController@edit', [$room->id]) }}" class="btn btn-block btn-primary">Edit This Room</a>
      </div>
    </div>
  </div>

@stop