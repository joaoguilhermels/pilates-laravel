@extends('layouts/app')

@section('content')
  <div class="container">
	  <h1>Edit {{ $expense->name }}</h1>
	  <a href="{{ action('ExpensesController@index') }}">Back to Expenses List</a>
	  <hr />
	  
	  @include('errors.list')

	  <form action="{{ action('ExpensesController@update', [$expense->id]) }}" method="POST">
		{{ csrf_field() }}
		{{ method_field("PATCH") }}
	    @include('expenses.form', ['submitButtonText' => 'Update Expense'])
	  </form>
  </div>
@stop