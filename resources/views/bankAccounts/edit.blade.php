@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $bankAccount->name }}</h1>
  <a href="{{ action('BankAccountsController@index') }}">Back to Bank Accounts List</a>
  <hr />
  
  @include('errors.list')
  {!! Form::model($bankAccount, ['method' => 'PATCH', 'action' => ['BankAccountsController@update', $bankAccount->id]]) !!}
    @include('bankAccounts.form', ['submitButtonText' => 'Update Bank Account'])

  {!! Form::close() !!}  
  </div>
@stop