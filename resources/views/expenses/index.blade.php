@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Expenses
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ExpensesController@create') }}" class="btn btn-success">Add New Expense</a>
    </h1>

    <hr />

    @if (count($expenses) == 0)

    <h2>There no expenses yet. You can <a href="{{ action('ExpensesController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Date</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($expenses as $expense)
        <tr>
          <td><a href="{{ action('ExpensesController@show', [$expense->id]) }}">{{ $expense->name }}</a></td>
          <td>{{ $expense->date }}</td>
          <td>{{ $expense->value }}</td>
          <td>
            <a href="{{ action('ExpensesController@edit', [$expense->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['expenses.destroy', $expense->id], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-link pull-left">delete</button>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  </div>
@stop
