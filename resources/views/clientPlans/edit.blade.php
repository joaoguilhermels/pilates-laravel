@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $plan->name }}</h1>
  <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::model($plan, ['method' => 'PATCH', 'action' => ['PlansController@update', $plan->id]]) !!}
    @include('plans.form', ['submitButtonText' => 'Update Plan'])

  {!! Form::close() !!}  
  </div>
@stop