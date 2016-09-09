@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>{{ $professional->name }}</h1>
        <h2>From {{ $startAt->format('d/m/Y') }} to {{ $endAt->format('d/m/Y') }}</h2>
        <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
        <hr />

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Client</th>
                <th>Date</th>
                <th>Full Price</th>
                <th>Professional Receives</th>
                <th>Status</th>
                <th>Room</th>
                <th>Class</th>
                <th>Plan</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>{{ $total }}</td>
                <td>{{ $professional_total }}</td>
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
                  {{ $row->client->name }}
                </td>
                <td>
                  {{ $row->start_at }}
                </td>
                <td>
                  {{ $row->price }}
                </td>
                <td>
                  @if($row->classTypeStatus->pay_professional)
                    {{ $row->value_professional_receives }}
                    @if ($row->value_professional_receives > 0)
                      (=
                      {{ $professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value }}
                      @if($professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value_type == 'percentage')
                        %
                      @else
                        {{ $professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value_type }}
                      @endif
                      )
                    @endif
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
                  {{-- TODO: Include logic to show extra class  --}}
                  @if ($row->trial == true)
                    Trial
                  @else
                    {{ $row->clientPlanDetail != null ? $row->clientPlanDetail->clientPlan->plan->name : "" }}
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <h2>Registrar Pagamento</h2>
        <form action="/professionals/{{ $professional->id }}/payments/store" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="startAt" value="{{ $startAt }}">
          <input type="hidden" name="endAt" value="{{ $endAt }}">
          <div class="form-group">
            <label for="professional">Payment Method: </label>
            <select class="form-control" name="payment_method_id">
              @foreach($paymentMethods as $paymentMethod)
              <option value="{{ $paymentMethod->id }}" {{ (old('paymentMethod') == $paymentMethod->id ? "selected" : "") }}>{{ $paymentMethod->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Bank Account: </label>
            <select class="form-control" name="bank_account_id">
              @foreach($bankAccounts as $bankAccount)
              <option value="{{ $bankAccount->id }}" {{ (old('bankAccount') == $bankAccount->id ? "selected" : "") }}>{{ $bankAccount->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Payment Date: </label>
            <input class="form-control" name="date" type="date" value="{{ old('date') }}" id="end_at">
          </div>
          <div class="form-group">
            <label for="name">Value to pay the professional: </label>
            <input class="form-control" name="value" type="number" min="0" step="any" value="{{ old('value', $professional_total) }}" id="end_at">
          </div>
          <div class="form-group">
            <label for="name">Observation: </label>
            <textarea name="observation" class="form-control" value="{{ old('observation  ') }}" rows="4"></textarea>
          </div>

          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" value="Register Professional Payment">
          </div>
        </form>
      </div>
    </div>
  </div>
@stop
