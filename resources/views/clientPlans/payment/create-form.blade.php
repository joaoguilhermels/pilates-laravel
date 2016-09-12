<div class="form-group">
  <label for="client">Client:</label> {{ $clientPlan->client->name }}<br>
  <label for="class">Class:</label> {{ $clientPlan->plan->classType->name }}<br>
  <label for="plan">Plan:</label> {{ $clientPlan->plan->name }}<br>
  <label for="price">Price:</label> {{ $clientPlan->plan->price }}/{{ $clientPlan->plan->price_type }}<br>
  <label for="plan">Duration:</label> {{ $clientPlan->plan->duration }} {{ $clientPlan->plan->duration_type }}
</div>
<div id="app">
  <plan-payment plan-duration="{{ $clientPlan->plan->duration }}" payment-methods="{{ $paymentMethods }}" bank-accounts="{{ $bankAccounts }}" selected-values="" price="{{ $clientPlan->plan->price }}"></plan-payment>

  <div class="form-group">
    <label for="observation">Observation:</label>
    <textarea class="form-control" name="observation"></textarea>
  </div>

  <div class="form-group">
    <input type="submit" name="" value="{{ $submitButtonText }}" class="btn btn-success">
  </div>
</div>
