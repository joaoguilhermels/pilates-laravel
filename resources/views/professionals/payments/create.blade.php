@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>Create New Professional Payment</h1>
        <a href="{{ action('ProfessionalsPaymentsController@index') }}">Back to Professional Payments List</a>
        <hr />

        @include('errors.list')

        <form action="{{ url('professionals/payments/review') }}" method="POST" class="form-horizontal">
          {{ csrf_field() }}
          <div class="form-inline">
            <div class="form-group">
              <label for="professional">Gerar relatório de pagamento para </label>
              <select class="form-control" name="professional">
                <option>-- Select a professional -- </option>
                @foreach($professionals as $professional)
                <option value="{{ $professional->id }}" {{ (old('professional') == $professional->id ? "selected" : "") }}>{{ $professional->name }}</option>
                @endforeach
              </select>

              <label for="name">do dia </label>
              <input class="form-control" name="start_at" type="date" value="{{ old('start_at', \Carbon\Carbon::now()->firstOfMonth()->format('Y-m-d')) }}" id="start_at">

              <label for="name"> até </label>
              <input class="form-control" name="end_at" type="date" value="{{ old('end_at', \Carbon\Carbon::now()->lastOfMonth()->format('Y-m-d')) }}" id="end_at">
            </div>
            <div class="form-group">
              <input class="btn btn-success form-control" type="submit" value="Generate Payment Report">
            </div>
          </div>
        </form>
      </div>
    </div>
  {{-- </div> --}}
@stop
