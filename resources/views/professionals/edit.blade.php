@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $professional->name }}</h1>
  <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
  <hr />
  
  @include('errors.list')

  {!! Form::model($professional, ['method' => 'PATCH', 'action' => ['ProfessionalsController@update', $professional->id]]) !!}
    @include('professionals.form', ['submitButtonText' => 'Update Professional'])

  {!! Form::close() !!}  
  </div>
@stop