@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Edit {{ $classType->name }}</h1>
    <a href="{{ action('ClassTypesController@index') }}">Back to Classes List</a>
    <hr />

    @include('errors.list')

    <div class="row">
      <div class="col-md-12">
        <form action="{{ action('ClassTypesController@update', [$classType->id]) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field("PATCH") }}
          @include('classes.form', ['submitButtonText' => 'Update Class'])
        </form>
      </div>
    </div>
  </div>
@stop
