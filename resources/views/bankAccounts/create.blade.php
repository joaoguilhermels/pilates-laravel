@extends('layouts/app')


@section('content')
  <div class="container">
    <h1>
      Create New Bank Account
    </h1>
    <a href="{{ action('BankAccountsController@index') }}">Back to Bank Accounts List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('BankAccountsController@store') }}">
      {{ csrf_field() }}
      @include('bankAccounts.form', ['submitButtonText' => 'Add New Bank Account'])
    </form>
  </div>
@stop
