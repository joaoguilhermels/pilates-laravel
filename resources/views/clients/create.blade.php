@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
	<h1>Create New Client</h1>
	<a href="{{ action('ClientsController@index') }}">Back to Clients List</a>  
	<hr />

	@include('errors.list')

	<form action="{{ action('ClientsController@store') }}" method="POST">
		{{ csrf_field() }}
	@include('clients.form', ['submitButtonText' => 'Add New Client'])
	</form>
  {{-- </div> --}}
@stop