@extends('layouts/app')

@section('content')
  <div class="container">
	<h1>Create New Room</h1>
	<a href="{{ action('RoomsController@index') }}">Back to Rooms List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('RoomsController@store') }}" method="POST">
		{{ csrf_field() }}
	@include('rooms.form', ['submitButtonText' => 'Add New Room'])

	</form>
  </div>
@stop