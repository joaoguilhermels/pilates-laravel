@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit This Charge</h1>
  <a href="{{ action('ClientsController@indexCharges') }}">Back to Charges List</a>
  <hr />

  @include('errors.list')

  {!! Form::model($client, ['method' => 'PATCH', 'action' => ['ClientsController@updateCharge', $charge->id]]) !!}
    @include('clients.form', ['submitButtonText' => 'Update Client'])

  {!! Form::close() !!}
  </div>
@stop
