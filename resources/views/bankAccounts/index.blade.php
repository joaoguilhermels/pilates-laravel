@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Bank Accounts
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('BankAccountsController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Bank Account</a>
    </h1>

    <hr />

    @if (count($bankAccounts) == 0)

    <h2>There no bank accounts yet. You can <a href="{{ action('BankAccountsController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Name</th>
          <th>Bank</th>
          <th>Agency</th>
          <th>Account</th>
          <th>Balance</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($bankAccounts as $bankAccount)
        <tr>
          <td><a href="{{ action('BankAccountsController@show', [$bankAccount->id]) }}">{{ $bankAccount->name }}</a></td>
          <td>{{ $bankAccount->bank }}</td>
          <td>{{ $bankAccount->agency }}</td>
          <td>{{ $bankAccount->account }}</td>
          <td>{{ $bankAccount->balance }}</td>
          <td>
            <a href="{{ action('BankAccountsController@edit', [$bankAccount->id]) }}" class="btn pull-left"><i class="fa fa-pencil"></i> edit</a>
            <form action="{{ action('BankAccountsController@destroy', [$bankAccount->id]) }}" method="post">
            {{ csrf_field() }}
            {{ method_field("DELETE") }}
            <button type="submit" class="btn btn-link pull-left"><i class="fa fa-times"></i> delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  </div>
@stop
