@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Create New Plan</h1>
    <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('PlansController@store') }}" method="POST">
      {{ csrf_field() }}
      @include('plans.form', ['submitButtonText' => 'Add New Plan', 'plan' => $plan, 'classTypes' => $classTypes])
    </form>
  {{-- </div> --}}
@stop
