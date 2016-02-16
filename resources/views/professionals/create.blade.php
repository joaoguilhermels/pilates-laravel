@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>
    Create New Professional
  </h1>
  <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'professionals']) !!}
    @include('professionals.form', ['submitButtonText' => 'Add New Professional'])

  {!! Form::close() !!}  
  </div>
@stop