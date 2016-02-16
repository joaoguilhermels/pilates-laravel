@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $room->name }}</h1>
  <a href="{{ action('RoomsController@index') }}">Back to Rooms List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::model($room, ['method' => 'PATCH', 'action' => ['RoomsController@update', $room->id]]) !!}
    @include('rooms.form', ['submitButtonText' => 'Update Room'])

  {!! Form::close() !!}  
  </div>
@stop