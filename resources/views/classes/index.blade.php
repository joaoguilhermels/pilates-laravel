@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Classes
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('ClassTypesController@create') }}" class="btn btn-primary">Add New Class</a>
    </h1>
    <hr />
  
    @if (count($classTypes) == 0)
  
    <h2>There no classes yet. You can <a href="{{ action('ClassTypesController@create') }}">add one here.</a>
  
    @else
  
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
          <td>
            <a href="{{ action('ClassTypesController@edit', [$classType->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['classes.destroy', $classType->id], 'method' => 'delete']) !!}
            <button type="submit" class="btn btn-link pull-left">delete</button>
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>    
    @endif
  </div>
@stop