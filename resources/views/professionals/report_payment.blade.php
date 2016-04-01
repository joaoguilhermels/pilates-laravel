@extends('layouts/app')

@section('content')

  <div class="container">
    <h1>{{ $professional->name }}</h1>
    <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
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
              <th>Relative</th>
              <th>Professional Receives</th>
              <th>Plan</th>
              <th>Client</th>
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
                {{ $row->price }}
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
                {{ $professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value }}
                {{ $professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value_type }}
              </td>
              <td>
                @if($row->classTypeStatus->pay_professional)
                  {{ $row->price * ($professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value / 100) }}
                @else
                  0
                @endif
              </td>
              <td>
                {{ $row->plan->name }}
              </td>
              <td>
                {{ $row->client->name }}
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
    </div>
  </div>

@stop