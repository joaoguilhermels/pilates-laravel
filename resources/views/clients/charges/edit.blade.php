@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Edit {{ $charge->name }}</h1>
    <a href="{{ action('ClientsController@indexCharges') }}">Back to Charges List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ClientsController@update', [$charge->id]) }}" method="POST">
      {{ csrf_field() }}
      {{ method_field("PATCH") }}
      @include('clients.charges.form', ['submitButtonText' => 'Update Charge'])
    </form>
  </div>
@stop
