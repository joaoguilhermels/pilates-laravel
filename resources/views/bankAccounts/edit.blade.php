@extends('layouts/app')

@section('content')
  <div class="container">
	<h1>Edit {{ $bankAccount->name }}</h1>
	<a href="{{ action('BankAccountsController@index') }}">Back to Bank Accounts List</a>
	<hr />

	@include('errors.list')

	<form action="{{ action('BankAccountsController@update', [$bankAccount->id]) }}" method="POST">
	  {{ csrf_field() }}
	  {{ method_field("PATCH") }}
	  @include('bankAccounts.form', ['submitButtonText' => 'Update Bank Account'])
	</form>
  </div>
@stop
