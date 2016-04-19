@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Bank Accounts
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('BankAccountsController@create') }}" class="btn btn-primary">Add New Bank Account</a>
    </h1>
    
    <hr />
  
    @if (count($bankAccounts) == 0)
  
    <h2>There no bank accounts yet. You can <a href="{{ action('BankAccountsController@create') }}">add one here.</a>
  
    @else

    <div class="table-responsive">
    <table class="table">
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
            <a href="{{ action('BankAccountsController@edit', [$bankAccount->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['bank-accounts.destroy', $bankAccount->id], 'method' => 'delete']) !!}
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