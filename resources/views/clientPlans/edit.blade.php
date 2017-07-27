@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
	<h1>Edit {{ $clientPlan }}</h1>
	<a href="{{ action('PlansController@index') }}">Back to Plans List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('ClientPlansController@update', [$clientPlan->id]) }}" method="POST">
		{{ csrf_field() }}
		{{ method_field("PATCH") }}
		@include('clientPlans.form', ['submitButtonText' => 'Atualizar Plano', 'clientPlan'])
	</form>
  {{-- </div> --}}
@stop