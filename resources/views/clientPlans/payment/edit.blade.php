@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Edit Plan Payment</h1>
    <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('FinancialTransactionsController@updatePlanPayment', [$financialTransaction->id]) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('UPDATE') }}
      @include('clientPlans.payment.form', ['submitButtonText' => 'Update Plan Payment'])
    </form>
  </div>
@stop
