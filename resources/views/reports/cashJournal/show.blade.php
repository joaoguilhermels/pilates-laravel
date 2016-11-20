@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Cash Journal Report</h1>
    <hr />

    <table class="table table-hover table-striped">
      <thead>
        <th>
          Date
        </th>
        <th>
          Description
        </th>
        <th>
          Debit
        </th>
        <th>
          Credit
        </th>
        <th>
          Saldo
        </th>
      </thead>
      <tbody>
        @foreach($financialTransactionDetails as $financialTransactionDetail)
          <tr>
            <td>
              {{ $financialTransactionDetail->date }}
            </td>
            <td>
              {{ $financialTransactionDetail->financialTransaction->name }} ({{ $financialTransactionDetail->payment_number }} of {{ $financialTransactionDetail->financialTransaction->total_number_of_payments }}) {{ $financialTransactionDetail->observation }}
            </td>
            <td>
              @if($financialTransactionDetail->type == 'paid')
                {{ $financialTransactionDetail->value }}
              @endif
            </td>
            <td>
              @if($financialTransactionDetail->type == 'received')
                {{ $financialTransactionDetail->value }}
              @endif
            </td>
            <td>
              {{ $financialTransactionDetail->saldo }}
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th>
            {{ $debitSum }}
          </th>
          <th colspan="3">
            {{ $creditSum }}
          </th>
        </tr>
      </tfoot>
    </table>
  {{-- </div> --}}
@stop
