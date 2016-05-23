@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create a New Charge</h1>
  <a href="{{ action('ClientsController@index') }}">Back to Charges List</a>
  <hr />

  @include('errors.list')

  {!! Form::open(['url' => 'clients']) !!}
  <form action="clients" method="post">
    {{ csrf_token(); }}
    @include('clients.charges.form', ['submitButtonText' => 'Add New Charge'])
  </form>
  </div>
@stop
