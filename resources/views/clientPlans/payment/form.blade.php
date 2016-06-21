<div id="app">
  <plan-payment></plan-payment>

  <template id="plan-payment-template">
    <div class="form-group">
    <label for="number_of_payments">Number of Payments:</label>
    <select name="number_of_payments" class="form-control" v-model="numberOfPayments">
      <option value=""></option>
      <option v-for="n in 10" v-bind:value="n">@{{ n }}</option>
    </select>
    </div>

    <div id="details" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr v-for="paymentNumber in numberOfPayments | selectNumberOfPayments">
            <td class="col-md-3">
              <label>Payment Method: </label>
              <select name="payments[@{{ paymentNumber }}][day_of_week]" class="form-control">
                <option value=""></option>
                @foreach($paymentMethods as $key => $paymentMethod)
                  <option value="{!! $key !!}">{{ $paymentMethod->name }}</option>
                @endforeach
              </select>
            </td>
            <td class="col-md-3">
              <label>Bank Account:</label>
              <select class="form-control" name="payments[@{{ paymentNumber }}][hour]">
                <option value=""></option>
                @foreach($bankAccounts as $key => $bankAccount)
                  <option value="{{ $key }}">{{ $bankAccount->name }}</option>
                @endforeach
              </select>
            </td>
            <td class="col-md-3">
              <label for="date">Date: </label>
              <input type="date" name="date" value="{{ old('date') }}" class="form-control">
            </td>
            <td class="col-md-3">
              <label for="room">Value: </label>
              <input type="float" name="value" class="form-control">
            </td>
            <td class="col-md-3">
              <label for="observation">Observation: </label>
              <input type="text" name="payments[@{{ paymentNumber }}][observation]">
            </td>
          </tr>
        </table>
      </div>
    </div>

  </template>

  <div class="form-group">
    <label for="observation">Observation:</label>
    <textarea class="form-control" name="observation"></textarea>
  </div>

  <div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
  </div>
</div>
