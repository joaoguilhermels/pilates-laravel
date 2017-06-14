<div class="form-group">
  <label for="client">Cliente:</label> {{ $clientPlan->client->name }}<br>
  <label for="class">Atendimento:</label> {{ $clientPlan->plan->classType->name }}<br>
  <label for="plan">Plano:</label> {{ $clientPlan->plan->name }}<br>
  <label for="plan">Início:</label> {{ $clientPlan->start_at }}<br>
  <label for="price">Preço:</label> {{ $clientPlan->plan->price }}/{{ $clientPlan->plan->price_type }}<br>
  <label for="plan">Duração:</label> {{ $clientPlan->plan->duration }} {{ $clientPlan->plan->duration_type }}
</div>

<plan-payment plan-duration="{{ $clientPlan->plan->duration }}" :payment-methods="{{ json_encode($paymentMethods) }}" :bank-accounts="{{ json_encode($bankAccounts) }}" selected-values="" price="{{ $clientPlan->plan->price }}" start-at="{{ $clientPlan->start_at }}"></plan-payment>

<div class="form-group">
  <label for="observation">Observação:</label>
  <textarea class="form-control" name="observation"></textarea>
</div>

<div class="form-group">
  <input type="submit" name="" value="{{ $submitButtonText }}" class="btn btn-success">
</div>