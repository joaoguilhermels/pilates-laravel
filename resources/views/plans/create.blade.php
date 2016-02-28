@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Plan</h1>
  <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'plans']) !!}
    @include('plans.form', ['submitButtonText' => 'Add New Plan'])

  {!! Form::close() !!}  
  </div>
@stop