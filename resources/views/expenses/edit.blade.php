@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $expense->name }}</h1>
  <a href="{{ action('ExpensesController@index') }}">Back to Expenses List</a>
  <hr />
  
  @include('errors.list')
  {!! Form::model($expense, ['method' => 'PATCH', 'action' => ['ExpensesController@update', $expense->id]]) !!}
    @include('expenses.form', ['submitButtonText' => 'Update Expense'])

  {!! Form::close() !!}  
  </div>
@stop