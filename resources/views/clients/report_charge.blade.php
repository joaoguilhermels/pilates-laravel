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
          <tbody>
          @foreach($rows as $row)
            <tr>
              <td>
                {{ $row->start_at }}
              </td>
              <td>
                @if($row->classTypeStatus->charge_client)
                  {{ $row->price }}
                @else
                  0
                @endif
              </td>
              <td>
                {{ $row->classTypeStatus->name }}
              </td>
              <td>
                {{ $row->room->name }}
              </td>
              <td>
                {{ $row->classType->name }}
              </td>
              <td>
                {{ $row->plan->name }}
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
    </div>
  </div>

@stop