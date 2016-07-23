@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $bankAccount->name }}</h1>
    <a href="{{ action('BankAccountsController@index') }}">Back to Bank Accounts List</a>
    <hr />

    <div class="row">
      <div class="col-md-12">
        <dl class="dl-horizontal">
          <dt>Bank:</dt>
          <dd>{{ $bankAccount->bank }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Agency:</dt>
          <dd>{{ $bankAccount->agency }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Account Number:</dt>
          <dd>{{ $bankAccount->account }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Balance:</dt>
          <dd>{{ $bankAccount->balance }}</dd>
        </dl>
        <a href="{{ action('BankAccountsController@edit', [$bankAccount->id]) }}" class="btn btn-block btn-success">Edit This Bank Account</a>
      </div>
    </div>
  </div>

@stop
