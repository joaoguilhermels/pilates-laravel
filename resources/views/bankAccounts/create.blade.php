@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>
    Create New Bank Account
  </h1>
  <a href="{{ action('BankAccountsController@index') }}">Back to Bank Accounts List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'bank-accounts']) !!}
    @include('bankAccounts.form', ['submitButtonText' => 'Add New Bank Account'])

  {!! Form::close() !!}  
  </div>
@stop