@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Client</h1>
  <a href="{{ action('ClientsController@index') }}">Back to Clients List</a>  
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'clients']) !!}
    @include('clients.form', ['submitButtonText' => 'Add New Client'])

  {!! Form::close() !!}
  </div>
@stop