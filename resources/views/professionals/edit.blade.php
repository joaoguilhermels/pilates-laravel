@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Edit {{ $professional->name }}</h1>
    <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ProfessionalsController@update', [$professional->id]) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('PATCH') }}
      @include('professionals.form', [$professional, 'submitButtonText' => 'Update Professional'])

    </form>
  {{-- </div> --}}
@stop
