@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>Create New Plan Payment</h1>
    <a href="{{ back() }}">Back</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ProfessionalsPaymentsController@store', [$professional->id]) }}" method="POST">
      {{ csrf_field() }}
      @include('plans.payment.form', ['submitButtonText' => 'Add New Plan'])
    </form>
  {{-- </div> --}}
@stop
