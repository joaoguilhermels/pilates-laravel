@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
	<h1>Edit {{ $room->name }}</h1>
	<a href="{{ action('RoomsController@index') }}">Back to Rooms List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('RoomsController@update', [$room->id]) }}" method="POST">
		{{ csrf_field() }}
		{{ method_field('PATCH') }}
	@include('rooms.form', ['submitButtonText' => 'Update Room'])

	</form>
  {{-- </div> --}}
@stop