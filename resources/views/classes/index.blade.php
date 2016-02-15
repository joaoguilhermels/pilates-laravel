@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Classes</h1>
    
    <hr />
  
    <div class="table-responsive">          
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($classTypes as $classType)
        <tr>
          <td><a href="{{ action('ClassTypesController@show', [$classType->id]) }}">{{ $classType->name }}</a></td>
          <td><a href="{{ action('ClassTypesController@edit', [$classType->id]) }}">edit</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>    
  </div>
@stop