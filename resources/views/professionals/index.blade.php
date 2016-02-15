@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Professionals</h1>
    
    <hr />
  
    <div class="table-responsive">          
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Phone</th>
          <th>E-mail</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($professionals as $professional)
        <tr>
          <td><a href="{{ action('ProfessionalsController@show', [$professional->id]) }}">{{ $professional->name }}</a></td>
          <td>{{ $professional->phone }}</td>
          <td>{{ $professional->email }}</td>
          <td>{{ $professional->description }}</td>
          <td><a href="{{ action('ProfessionalsController@edit', [$professional->id]) }}">edit</a></td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>    
  </div>
@stop