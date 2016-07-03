@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Professionals Payments
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ProfessionalsController@createProfessionalPayment') }}" class="btn btn-primary">Add New Professional Payment</a>
    </h1>

    <hr />

    @if (count($financialTransactions) == 0)

    <h2>There no payments to professional registered yet. You can <a href="{{ action('ProfessionalsController@createProfessionalPayment') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Professional</th>
          <th>Date</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($financialTransactions as $financialTransaction)
        <tr>
          <td>{{ $financialTransaction->financiable->name }}</td>
          <td>{{ $financialTransaction->date }}</td>
          <td>
            <a href="{{ action('ProfessionalsController@edit', [$financialTransaction->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['professionals.destroy', $financialTransaction->id], 'method' => 'delete']) !!}
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
