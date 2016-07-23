@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $plan->name }}</h1>
    <a href="{{ action('PlansController@index') }}">Back to Plans List</a>
    <hr />

    <div>{{ $plan->classType->name }}</div>
    <div>{{ $plan->times }}x per {{ $plan->times_type }}</div>
    <div>{{ $plan->price }} per {{ $plan->price_type }}</div>
    <div>{{ $plan->duration }} {{ $plan->duration_type }}</div>

    <div class="row">
      <div class="col-md-12">
        <a href="{{ action('PlansController@edit', [$plan->id]) }}" class="btn btn-block btn-success">Edit This Plan</a>
      </div>
    </div>
  </div>

@stop