@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $client->name }}</h1>
  
  <hr />
  
  @include('errors.list')
  
  {!! Form::model($client, ['method' => 'PATCH', 'action' => ['ClientsController@update', $client->id]]) !!}
    @include('clients.form', ['submitButtonText' => 'Update Client'])

  {!! Form::close() !!}  
  </div>
@stop