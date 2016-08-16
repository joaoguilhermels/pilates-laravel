@extends('layouts/app')


@section('content')
  <div class="container">
    <h1>
      Create New Payment Method
    </h1>
    <a href="{{ action('PaymentMethodsController@index') }}">Back to Payment Methods List</a>
    <hr />
    
    @include('errors.list')

    <form action="{{ action('PaymentMethodsController@store') }}">
      {{ csrf_field() }}
      @include('paymentMethods.form', ['submitButtonText' => 'Add New Payment Method'])
    </form>
  </div>
@stop