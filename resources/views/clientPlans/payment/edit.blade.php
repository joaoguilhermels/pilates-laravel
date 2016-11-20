@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Edit Plan Payment</h1>
    <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('FinancialTransactionsController@updatePlanPayment', [$financialTransaction->id]) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
      @include('clientPlans.payment.edit-form', ['submitButtonText' => 'Update Plan Payment'])
    </form>
  {{-- </div> --}}
@stop

@section('script_footer')
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
  <script src="/js/clientPlanPayment/clientPlanPayment.js"></script>
@stop
