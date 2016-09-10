<template id="plan-payment-template">
  <div class="form-group">
    <label for="total_number_of_payments">Number of Payments:</label>
    <select name="total_number_of_payments" class="form-control" v-model="numberOfPayments">
      <option v-for="n in 25" v-bind:value="n">{{ n }}</option>
    </select>
  </div>

  <div id="details" class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Details</h3>
    </div>
    <div class="table-responsive">
      <table class="table table-striped">
        <tr v-for="paymentNumber in numberOfPayments">
          <td class="col-md-3">
            <input type="hidden" name="payments[{{ paymentNumber }}][payment_number]" value="{{ paymentNumber + 1 }}">
            <label for="payments[{{ paymentNumber }}][payment_method_id]">Payment Method: </label>
            <select name="payments[{{ paymentNumber }}][payment_method_id]" class="form-control">
              <option value=""></option>
              @foreach($paymentMethods as $paymentMethod)
                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
              @endforeach
            </select>
          </td>
          <td class="col-md-2">
            <label for="date">Date: </label>
            <input type="date" name="payments[{{ paymentNumber }}][date]" value="{{ old('date') }}" class="form-control">
          </td>
          <td class="col-md-2">
            <label for="room">Value: </label>
            <input type="float" name="payments[{{ paymentNumber }}][value]" class="form-control" value="{{ $clientPlan->plan->price }}">
          </td>
          <td class="col-md-5">
            <label for="observation">Observation: </label>
            <input type="text" name="payments[{{ paymentNumber }}][observation]" class="form-control">
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>