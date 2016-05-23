@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $charge->name }}</h1>
  <a href="{{ action('ClientsController@indexCharges') }}">Back to Charges List</a>
  <hr />

  @include('errors.list')

  {!! Form::model($charge, ['method' => 'PATCH', 'action' => ['ClientsController@updateCharge', $charge->id]]) !!}
    @include('clients.charges.form', ['submitButtonText' => 'Update Charge'])

  {!! Form::close() !!}
  </div>
@stop
