@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $paymentMethod->name }}</h1>
  <a href="{{ action('PaymentMethodsController@index') }}">Back to Payment Methods List</a>
  <hr />
  
  @include('errors.list')
  {!! Form::model($paymentMethod, ['method' => 'PATCH', 'action' => ['PaymentMethodsController@update', $paymentMethod->id]]) !!}
    @include('paymentMethods.form', ['submitButtonText' => 'Update Payment Method'])

  {!! Form::close() !!}  
  </div>
@stop