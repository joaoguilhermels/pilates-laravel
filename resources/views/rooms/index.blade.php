@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Rooms</h1>
    
    <hr />
  
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
          <td><a href="{{ action('RoomsController@edit', [$room->id]) }}">edit</a></td>
          <td>
          {!! Form::open(['route' => ['rooms.destroy', $room->id], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-link">delete</button>
          {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>    
  </div>
@stop