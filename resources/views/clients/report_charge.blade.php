@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $client->name }}</h1>
    <a href="{{ action('ClientsController@index') }}">Back to Clients List</a>
    <hr />

    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Date</th>
              <th>Full Price</th>
              <th>Status</th>
              <th>Room</th>
              <th>Class</th>
              <th>Plan</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <td>&nbsp;</td>
              <td>{{ $total }}</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
          </tfoot>
          @foreach($rows as $row)
            <tbody>
            <tr>
              <td>
                {{ $row->client->name }}
              </td>
              <td>
                {{ $row->classType->name }}
              </td>
              <td>
                {{ $row->plan->name }}
              </td>
            </tr>
            @foreach($row->clientPlanDetails as $planDetail)
              <tr>
                <td>{{ $planDetail->day_of_week }}</td>
                <td>{{ $planDetail->hour }}</td>
                <td>{{ $planDetail->professional->name }}</td>
                <td>{{ $planDetail->room->name }}</td>
              </tr>
            @endforeach
            </tbody>
          @endforeach
        </table>
    </div>
  </div>

@stop
