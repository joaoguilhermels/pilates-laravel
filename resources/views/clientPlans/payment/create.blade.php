@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Plan Payment</h1>
    <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ClientPlanPaymentsController@store', [$clientPlan->id]) }}" method="post">
      {{ csrf_field() }}
      @include('clientPlans.payment.create-form', ['submitButtonText' => 'Add Plan Payment'])
    </form>
  {{-- </div> --}}
@stop

@section('script_footer')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
@stop
