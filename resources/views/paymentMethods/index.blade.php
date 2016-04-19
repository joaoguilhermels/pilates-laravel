@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Payment Methods
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('PaymentMethodsController@create') }}" class="btn btn-primary">Add New Payment Method</a>
    </h1>
    
    <hr />
  
    @if (count($paymentMethods) == 0)
  
    <h2>There no Payment Methods yet. You can <a href="{{ action('PaymentMethodsController@create') }}">add one here.</a>
  
    @else
    
    <div class="table-responsive">          
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Enabled</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($paymentMethods as $paymentMethod)
        <tr>
          <td><a href="{{ action('PaymentMethodsController@show', [$paymentMethod->id]) }}">{{ $paymentMethod->name }}</a></td>
          <td>{{ $paymentMethod->enabled == 1 ? 'Yes' : 'No' }}</td>
          <td>
            <a href="{{ action('PaymentMethodsController@edit', [$paymentMethod->id]) }}" class="btn pull-left">edit</a>
            {!! Form::open(['route' => ['payment-methods.destroy', $paymentMethod->id], 'method' => 'delete']) !!}
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