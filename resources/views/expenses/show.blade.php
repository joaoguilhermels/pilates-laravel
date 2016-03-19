@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $expense->name }}</h1>
    <a href="{{ action('ExpensesController@index') }}">Back to Expenses List</a>
    <hr />

    <div class="row">
      <div class="col-md-12">
        <dl class="dl-horizontal">
          <dt>Date:</dt>
          <dd>{{ $expense->date }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Price:</dt>
          <dd>{{ $expense->price }}</dd>
        </dl>
        <a href="{{ action('ExpensesController@edit', [$expense->id]) }}" class="btn btn-block btn-primary">Edit This Expense</a>
      </div>
    </div>
  </div>

@stop