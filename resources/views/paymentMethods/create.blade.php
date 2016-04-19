@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>
    Create New Payment Method
  </h1>
  <a href="{{ action('PaymentMethodsController@index') }}">Back to Payment Methods List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'payment-methods']) !!}
    @include('paymentMethods.form', ['submitButtonText' => 'Add New Payment Method'])

  {!! Form::close() !!}  
  </div>
@stop