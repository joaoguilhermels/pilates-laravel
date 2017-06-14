<div id="planos" class="tab-pane fade">
  <h3>
    Planos &nbsp; &nbsp; <a href="/clients/{{ $client->id }}/plans/create" class="btn btn-success" data-turbolinks="false">Add a New Plan</a>
  </h3>

  <table class="table table-stripped">
    <thead>
      <tr>
        <th>
          Class
        </th>
        <th>
          Plan
        </th>
        <th>
          Start At
        </th>
        <th>
          Details
        </th>
        <th>
          Status
        </th>
        <th>
          Payment Status
        </th>
        <th>
          Actions
        </th>
      </tr>
    </thead>
  @foreach($client->clientPlans as $clientPlan)
    <tr>
      <td>{{ $clientPlan->plan->classType->name }}</td>
      <td>{{ $clientPlan->plan->name }}</td>
      <td>{{ $clientPlan->start_at }}</td>
      <td>
        @foreach($clientPlan->clientPlanDetails as $clientPlanDetail)
          {{ $clientPlanDetail->day_of_week }} - {{ $clientPlanDetail->hour }} - {{ $clientPlanDetail->professional->name }} - {{ $clientPlanDetail->room->name }}<br>
        @endforeach
      </td>
      <td>
        {{ $client->schedules->last()->start_at }}
      </td>
      <td>
        @if ($clientPlan->financialTransactions->count() > 0)
            Payment Added
        @else
            Missing Payment
        @endif
      </td>
      <td>
        @if ($clientPlan->financialTransactions->count() == 0)
        <a href="{{ action('ClientPlanPaymentsController@create', [$clientPlan->id]) }}" class="btn btn-info btn-sm">Add Payment</a>
        @else
        <a href="{{ action('ClientPlanPaymentsController@edit', [$clientPlan->financialTransactions->first()->id]) }}" class="btn btn-info btn-sm">Edit Payment</a>
        <a href="{{ action('ClientPlanPaymentsController@show', [$clientPlan->financialTransactions->first()->id]) }}" class="btn btn-info btn-sm">View Payment</a>
        @endif
        <a href="{{ action('ClientPlansController@edit', [$clientPlan->id]) }}">edit</a>
        <form action="{{ action('ClientPlansController@destroy', [$clientPlan->id]) }}" method="POST">
          {{ csrf_field() }}
          {{ method_field("DELETE") }}
          <button type="submit" class="btn btn-link pull-left">delete</button>
        </form>
      </td>
    </tr>
  @endforeach
  </table>
</div>
