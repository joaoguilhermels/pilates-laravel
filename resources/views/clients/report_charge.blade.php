@extends('layouts/app')

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

      <form action="/professionals/{{ $professional->id }}/payments/store" method="POST">
        {{ csrf_field() }}
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
          <label for="name">Value: </label>
          <input class="form-control" name="value" type="number" value="{{ old('value') }}" id="end_at">
        </div>

        <div class="form-group">
          <label for="name">Send copy by email ? </label>
        </div>

        <div class="form-group">
          <input class="btn btn-primary form-control" type="submit" value="Register Professional Payment">
        </div>
      </form>

    </div>
  </div>

@stop
