@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Associate a New Plan for {{ $client->name }}</h1>
  <hr />
  
  @include('errors.list')

  {!! Form::open(array('action' => array('ClientPlansController@reviewClientPlan', $client->id))) !!}
    @include('clientPlans.form', ['submitButtonText' => 'Add New Plan for this Client'])

  {!! Form::close() !!}
  </div>
@stop