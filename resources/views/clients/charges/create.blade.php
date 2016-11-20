@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Create a New Charge</h1>
    <a href="{{ action('ClientsController@index') }}">Back to Charges List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ClientsController@storeCharge') }}" method="post">
      {{ csrf_field() }}
      @include('clients.charges.form', ['submitButtonText' => 'Add New Charge'])
    </form>
  {{-- </div> --}}
@stop
