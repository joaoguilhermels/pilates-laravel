@extends('layouts/admin/admin')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h1>{{ $client->name }}</h1>
        <a href="{{ action('ClientsController@index') }}">Back to Clients List</a>
        <hr />
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Class</th>
                <th>Day of Week</th>
                <th>Hour</th>
                <th>Professional</th>
                <th>Room</th>
                <th>Date</th>
                <th>Price</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>{{ $total }}</td>
              </tr>
            </tfoot>
              @foreach ($rows as $key => $schedule)
              <tbody>
              <tr>
                <td colspan="7">
                  {{ $key }}
                </td>
              </tr>
              @foreach ($rows[$key] as $row)
              <tr>
                <td>
                  {{ $row->classType->name }}
                </td>
                <td>{{ $row->scheduable->day_of_week }}</td>
                <td>{{ $row->scheduable->hour }}</td>
                <td>{{ $row->scheduable->professional->name }}</td>
                <td>{{ $row->scheduable->room->name }}</td>
                <td>{{ $row->start_at }}</td>
                <td>{{ $row->price }}</td>
              </tr>
              @endforeach
              </tbody>
            @endforeach
          </table>
        </div>
      </div>
    </div>
  </div>
@stop
