@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>{{ $paymentMethod->name }}</h1>
    <a href="{{ action('PaymentMethodsController@index') }}">Back to Payment Methods List</a>

    <hr />

    <div class="row">
      <div class="col-md-12">
        <dl class="dl-horizontal">
          <dt>Enabled:</dt>
          <dd>{{ $paymentMethod->enabled }}</dd>
        </dl>
        <a href="{{ action('PaymentMethodsController@edit', [$paymentMethod->id]) }}" class="btn btn-block btn-success">Edit This Payment Method</a>
      </div>
    </div>
  {{-- </div> --}}
@stop