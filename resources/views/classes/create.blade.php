@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Class</h1>
  
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'classes']) !!}
    @include('classes.form', ['submitButtonText' => 'Add New Class'])

  {!! Form::close() !!}  
  </div>
@stop