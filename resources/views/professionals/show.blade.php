@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>{{ $professional->name }}</h1>
    <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
    <hr />

    <div class="row">
      <div class="col-md-8">
        <dl class="dl-horizontal">
          <dt>Phone:</dt>
          <dd>{{ $professional->phone }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Email:</dt>
          <dd>{{ $professional->email }}</dd>
        </dl>
        <dl class="dl-horizontal">
          <dt>Observation:</dt>
          <dd>{{ $professional->description }}</dd>
        </dl>
        <a href="{{ action('ProfessionalsController@edit', [$professional->id]) }}" class="btn btn-block btn-success">Edit {{ $professional->name }}</a>
      </div>
      <div class="col-md-4">
        @include('professionals.partials.classes-block')
      </div>
    </div>
  </div>
@stop