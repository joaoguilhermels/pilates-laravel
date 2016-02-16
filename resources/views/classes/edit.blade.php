@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Edit {{ $classType->name }}</h1>
    <a href="{{ action('ClassTypesController@index') }}">Back to Classes List</a>
    <hr />
  
    @include('errors.list')

    <div class="row">
      <div class="col-md-8">
      {!! Form::model($classType, ['method' => 'PATCH', 'action' => ['ClassTypesController@update', $classType->id]]) !!}
        @include('classes.form', ['submitButtonText' => 'Update Class'])
    
      {!! Form::close() !!}
      </div>
      <div class="col-md-4">
        @include('classes.partials.professionals-block')

        @include('classes.partials.rooms-block')
      </div>
    </div>
  </div>
@stop