@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Client</h1>
  
  <hr />
  
  @include('errors.list')
  
  {!! Form::open(['url' => 'clients']) !!}
    @include('clients.form', ['submitButtonText' => 'Add New Client'])

  {!! Form::close() !!}  
  </div>
@stop