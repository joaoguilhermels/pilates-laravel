@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Payment Methods
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('PaymentMethodsController@create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Payment Method</a>
    </h1>

    <hr />

    @if (count($paymentMethods) == 0)

    <h2>There no Payment Methods yet. You can <a href="{{ action('PaymentMethodsController@create') }}">add one here.</a>

    @else

    <div class="table-responsive">
    <table class="table table-striped table-hover">
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
            <a href="{{ action('PaymentMethodsController@edit', [$paymentMethod->id]) }}" class="btn pull-left"><i class="fa fa-pencil"></i> edit</a>
            <form action="{{ action('PaymentMethodsController@destroy', [$paymentMethod->id]) }}" method="POST">
              {{ csrf_field() }}
              {{ method_field("DELETE") }}
              <button type="submit" class="btn btn-link pull-left"><i class="fa fa-times"></i> delete</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  </div>
@stop
