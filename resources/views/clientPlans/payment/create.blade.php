@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Plan Payment</h1>
  <hr />

  @include('errors.list')

  <form action="{{ action('FinancialTransactionsController@storePlanPayment', [$clientPlan->id]) }}" method="post">
    {{ csrf_field() }}
    @include('clientPlans.payment.form', ['submitButtonText' => 'Add Plan Payment'])
  </form>
  </div>
@stop

@section('script_footer')
  <script src="/js/clientPlanPayment/clientPlanPayment.js"></script>
@stop
