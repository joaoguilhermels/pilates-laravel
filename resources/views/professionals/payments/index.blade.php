@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>
      Professionals Payments
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ProfessionalsPaymentsController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Professional Payment</a>
    </h1>

    <hr />

    @if (count($financialTransactions) == 0)

    <h2>There no payments to professional registered yet. You can <a href="{{ action('ProfessionalsPaymentsController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Professional</th>
            <th>Payment Date</th>
            <th>Ammount Paid</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($financialTransactions as $financialTransaction)
          <tr>
            <td>{{ $financialTransaction->financiable->name }}</td>
            <td>{{ $financialTransaction->FinancialTransactionDetails()->first()->date }}</td>
            <td>{{ $financialTransaction->FinancialTransactionDetails()->first()->value }}</td>
            <td>
              <a href="{{ action('ProfessionalsPaymentsController@edit', [$financialTransaction->id]) }}" class="btn pull-left"><i class="fa fa-pencil"></i> edit</a>
              <form action="{{ action('ProfessionalsPaymentsController@destroy', [$financialTransaction->id]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
              <button type="submit" class="btn btn-link pull-left"><i class="fa fa-times"></i> delete</button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif
  {{-- </div> --}}
@stop
