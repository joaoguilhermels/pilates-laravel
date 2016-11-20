@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
	<h1>Create New Class</h1>
	<a href="{{ action('ClassTypesController@index') }}">Back to Classes List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('ClassTypesController@store') }}" method="POST">
	{{ csrf_field() }}
	@include('classes.form', ['submitButtonText' => 'Add New Class'])
	</form>
  {{-- </div> --}}
@stop
