@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Rooms
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('RoomsController@create') }}" class="btn btn-primary">Add New Room</a>
    </h1>

    <hr />
  
    @if (count($rooms) == 0)
  
    <h2>There no rooms yet. You can <a href="{{ action('RoomsController@create') }}">add one here.</a>
  
    @else
  
    <div class="table-responsive">          
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($rooms as $room)
        <tr>
          <td><a href="{{ action('RoomsController@show', [$room->id]) }}">{{ $room->name }}</a></td>
          <td>
            <a href="{{ action('RoomsController@edit', [$room->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['rooms.destroy', $room->id], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-link pull-left">delete</button>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  </div>
@stop