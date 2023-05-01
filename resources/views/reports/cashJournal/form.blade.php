@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Cash Journal
    </h1>
    <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
    <hr />

    @include('errors.list')

    <form action="{{ action('ReportsController@showCashJournal') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="name">Month/Year:</label>
        <select name="year-month" class="form-control">
          <option></option>
          <option value="2016-07-01">July 2016</option>
          <option value="2016-08-01">August 2016</option>
          <option value="2016-09-01">September 2016</option>
        </select>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-success btn-block" value="Generate Report">
      </div>
    </form>
  </div>
@stop
