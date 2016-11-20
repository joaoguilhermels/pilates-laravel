@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>
      Charges
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ClientsController@createCharge') }}" class="btn btn-success">Add New Charge</a>
    </h1>

    <hr />

    @if (count($charges) == 0)

    <h2>There no charges yet. You can <a href="{{ action('ClientsController@createCharge') }}">add one here.</a>

    @else
    <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Payment Method</th>
          <th>Bank Account</th>
          <th>Date</th>
          <th>Value</th>
          <th>Number of payment</th>
          <th>Observation</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($charges as $charge)
        <tr>
          <td><a href="#">{{ $charge->name }}</a></td>
          <td>{{ $charge->paymentMethod->name }}</td>
          <td>{{ $charge->bankAccount->name }}</td>
          <td>{{ $charge->date }}</td>
          <td>{{ $charge->value }}</td>
          <td>{{ $charge->payment_number }} of {{ $charge->total_number_of_payments }}</td>
          <td>{{ $charge->observation }}</td>
          <td>
            <a href="{{ action('ClientsController@editCharge', [$charge->id]) }}" class="btn pull-left">edit</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="text-center">
    {!! $charges->render() !!}
    </div>
    </div>
    @endif
  {{-- </div> --}}
@stop
