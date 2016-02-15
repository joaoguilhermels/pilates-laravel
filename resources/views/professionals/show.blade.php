@extends('layouts/app')

@section('content')

    <h1>{{ $professional->name }}</h1>

    <article>
      <h3>{{ $professional->phone }}</h3>
      <h3>{{ $professional->email }}</h3>
      <div class="body">
        {{ $professional->description }}
      </div>
    </article>
    
    <h5>Classes given by the professional:</h5>
    <ul>
      @foreach($professional->classTypes as $classType)
        <li>{{ $classType->name }}</li>
      @endforeach
    </ul>
@stop