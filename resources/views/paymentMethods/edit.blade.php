@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
	<h1>Edit {{ $paymentMethod->name }}</h1>
	<a href="{{ action('PaymentMethodsController@index') }}">Back to Payment Methods List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('PaymentMethodsController@update', [$paymentMethod->id]) }}" method="POST">
	{{ csrf_field() }}
	{{ method_field("PATCH") }}
	@include('paymentMethods.form', ['submitButtonText' => 'Update Payment Method'])
	</form>
  {{-- </div> --}}
@stop