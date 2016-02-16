@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $client->name }}</h1>
  <a href="{{ action('ClientsController@index') }}">Back to Clients List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::model($client, ['method' => 'PATCH', 'action' => ['ClientsController@update', $client->id]]) !!}
    @include('clients.form', ['submitButtonText' => 'Update Client'])

  {!! Form::close() !!}  
  </div>
@stop