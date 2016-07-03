@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit This Charge</h1>
  <a href="{{ action('ClientsController@index') }}">Back to Charges List</a>
  <hr />

  @include('errors.list')

  {!! Form::model($client, ['method' => 'PATCH', 'action' => ['ClientsController@update', $client->id]]) !!}
    @include('clients.form', ['submitButtonText' => 'Update Client'])

  </form>
  </div>
@stop
