<div class="form-group">
  <label for="client">Client:</label> {{ $clientPlan->client->name }}<br>
  <label for="class">Class:</label> {{ $clientPlan->classType->name }}<br>
  <label for="plan">Plan:</label> {{ $clientPlan->plan->name }}<br>
  <label for="price">Price:</label> {{ $clientPlan->plan->price }}/{{ $clientPlan->plan->price_type }}<br>
  <label for="plan">Duration:</label> {{ $clientPlan->plan->duration }} {{ $clientPlan->plan->duration_type }}
</div>

<div id="app">
  <plan-payment plan-duration="{{ $clientPlan->plan->duration }}" payment-methods="{{ $paymentMethods }}" bank-accounts="{{ $bankAccounts }}" selected-values="{{ $financialTransaction->financialTransactionDetails }}"></plan-payment>

  <template id="plan-payment-template">
    <div class="form-group">
    <label for="total_number_of_payments">Number of Payments:</label>
    <select name="total_number_of_payments" class="form-control" v-model="numberOfPayments">
      <option v-for="n in 13" v-bind:value="n">@{{ n }}</option>
    </select>
    </div>

    <div id="details" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr v-for="paymentNumber in numberOfPayments">
            <td class="col-md-2">
              <input type="hidden" name="payments[@{{ paymentNumber }}][payment_number]" value="@{{ paymentNumber + 1 }}">
              <input type="hidden" name="payments[@{{ paymentNumber }}][financial_transaction_id]" v-bind:value="payments[paymentNumber].financial_transaction_id">
              <input type="hidden" name="payments[@{{ paymentNumber }}][id]" v-bind:value="payments[paymentNumber].id">
              <label for="payments[@{{ paymentNumber }}][payment_method_id]">Payment Method: </label>
              <select name="payments[@{{ paymentNumber }}][payment_method_id]" class="form-control" v-model="payments[paymentNumber].payment_method_id">
                <option value=""></option>
                <option v-for="paymentMethod in paymentMethodsObjs" v-bind:value="paymentMethod.id">@{{ paymentMethod.name }}</option>
              </select>
            </td>
            <td class="col-md-3">
              <label for="payments[@{{ paymentNumber }}][bank_account_id]">Bank Account:</label>
              <select class="form-control" name="payments[@{{ paymentNumber }}][bank_account_id]" v-model="payments[paymentNumber].bank_account_id">
                <option value=""></option>
                <option v-for="bankAccount in bankAccountsObjs" v-bind:value="bankAccount.id">@{{ bankAccount.name }}</option>
              </select>
            </td>
            <td class="col-md-2">
              <label for="date">Date: </label>
              <input type="date" name="payments[@{{ paymentNumber }}][date]" class="form-control" v-bind:value="payments[paymentNumber].date">
            </td>
            <td class="col-md-2">
              <label for="room">Value: </label>
              <input type="float" name="payments[@{{ paymentNumber }}][value]" class="form-control" v-bind:value="payments[paymentNumber].value">
            </td>
            <td class="col-md-3">
              <label for="observation">Observation: </label>
              <input type="text" name="payments[@{{ paymentNumber }}][observation]" class="form-control" v-bind:value="payments[paymentNumber].observation">
            </td>
          </tr>
        </table>
      </div>
    </div>

  </template>

  <div class="form-group">
    <label for="observation">Observation:</label>
    <textarea name="observation" class="form-control">{{ $financialTransaction->observation }}</textarea>
  </div>

  <div class="form-group">
    <input type="submit" class="btn btn-success btn-block" value="{{ $submitButtonText }}">
  </div>
</div>
