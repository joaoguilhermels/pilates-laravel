@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>
    Create New Expense
  </h1>
  <a href="{{ action('ExpensesController@index') }}">Back to Expenses List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'expenses']) !!}
    @include('expenses.form', ['submitButtonText' => 'Add New Expense'])

  {!! Form::close() !!}  
  </div>
@stop