@extends('layouts/app')


@section('content')
  <div class="container">
    <h1>
      Create New Professional
    </h1>
    <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ProfessionalsController@store', [$professional->id]) }}" method="post">
      {{ csrf_field() }}
      @include('professionals.form', ['submitButtonText' => 'Add New Professional'])
    </form>
  </div>
@stop
