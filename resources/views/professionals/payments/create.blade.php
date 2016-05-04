@extends('layouts/app')


@section('content')
  <div class="container">
  <h1>Create New Professional Payment</h1>
  <a href="{{ action('ProfessionalsController@indexPayments') }}">Back to Professional Payments List</a>
  <hr />
  
  @include('errors.list')

  <form action="{{ url('professionals/payments/review') }}" method="POST" class="form-horizontal">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="professional">Professional: </label>
      <select class="form-control" name="professional">
        @foreach($professionals as $professionalId => $professional)
        <option value="{{ $professionalId }}" {{ (old('professional') == $professionalId ? "selected" : "") }}>{{ $professional }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="name">Start Date: </label>
      <input class="form-control" name="start_at" type="date" value="{{ old('start_at') }}" id="start_at">
    </div>
    <div class="form-group">
      <label for="name">End Date: </label>
      <input class="form-control" name="end_at" type="date" value="{{ old('end_at') }}" id="end_at">
    </div>
    <div class="form-group">
      <input class="btn btn-primary form-control" type="submit" value="Generate Payment Report">
    </div>
  </form>
@stop