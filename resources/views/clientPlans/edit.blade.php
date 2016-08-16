@extends('layouts/app')

@section('content')
  <div class="container">
	<h1>Edit {{ $plan->name }}</h1>
	<a href="{{ action('PlansController@index') }}">Back to Plans List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('PlansController@update', [$plan->id]) }}" method="POST">
		{{ csrf_field() }}
		{{ method_field("PATCH") }}
		@include('plans.form', ['submitButtonText' => 'Update Plan'])
	</form>
  </div>
@stop