@extends('layouts/app')

@section('content')
  <div class="container">
	<h1>Edit This Client</h1>
	<a href="{{ action('ClientsController@index') }}">Back to Clients List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('ClientsController@update', [$client->id]) }}" method="POST">
		{{ csrf_field() }}
		{{ method_field("PATCH") }}
		@include('clients.form', ['submitButtonText' => 'Update Client'])
	</form>
  </div>
@stop
