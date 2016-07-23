@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Class</h1>
  <a href="{{ action('ClassTypesController@index') }}">Back to Classes List</a>
  <hr />

  @include('errors.list')

  {!! Form::open(['url' => 'classes']) !!}
    @include('classes.form', ['submitButtonText' => 'Add New Class'])

    </form>
  </div>
@stop
