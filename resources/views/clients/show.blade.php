@extends('layouts/app')

@section('content')

    <h1>{{ $client->name }}</h1>

    <article>
      <h3>{{ $client->phone }}</h3>
      <h3>{{ $client->mail }}</h3>
      <div class="body">
        {{ $client->description }}
      </div>
    </article>
@stop