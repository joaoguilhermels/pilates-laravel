@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>
      Rooms
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('RoomsController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Room</a>
    </h1>

    <hr />

    @if (count($rooms) == 0)

    <h2>There no rooms yet. You can <a href="{{ action('RoomsController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
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
            <a href="{{ action('RoomsController@edit', [$room->id]) }}" class="btn pull-left"><i class="fa fa-pencil"></i> edit</a>
            <form action="{{ action('RoomsController@destroy', [$room->id]) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field("DELETE") }}
            <button type="submit" class="btn btn-link pull-left"><i class="fa fa-times"></i> delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  {{-- </div> --}}
@stop
