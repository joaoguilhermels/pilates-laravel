@extends('layouts/app')

@section('content')
  <div class="container">
  <h1>Edit {{ $classType->name }}</h1>
  
  <hr />
  
  @include('errors.list')
  
  {!! Form::model($classType, ['method' => 'PATCH', 'action' => ['ClassTypesController@update', $classType->id]]) !!}
    @include('classes.form', ['submitButtonText' => 'Update Class'])

  {!! Form::close() !!}  
  </div>
@stop