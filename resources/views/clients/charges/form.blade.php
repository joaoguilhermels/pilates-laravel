<div class="form-group">
  <label for="name">Name</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $charge->name) }}">
</div>
<div class="form-group">
  <label for="total_number_of_payments">Total Number of Payments</label>
  <input type="number" name="total_number_of_payments" class="form-control" value="{{ old('total_number_of_payments', $charge->total_number_of_payments) }}">
</div>
<div class="row">
  <div class="col-md-1 form-group">
    <label for="payment_number">Payment #</label>
    <input type="number" name="payment_number" class="form-control" value="{{ old('payment_number', $charge->payment_number) }}">
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="payment_method_id">Payment Method: </label>
      <select class="form-control" name="payment_method_id">
        <option>- Select a payment method -</option>
        @foreach($paymentMethods as $paymentMethod)
        <option value="{{ $paymentMethod->id }}" {{ (old('payment_method_id', $charge->payment_method_id) == $paymentMethod->id ? "selected" : "") }}>{{ $paymentMethod->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="name">Bank Account: </label>
      <select class="form-control" name="bank_account_id">
        <option>- Select a bank -</option>
        @foreach($bankAccounts as $bankAccount)
        <option value="{{ $bankAccount->id }}" {{ (old('bank_account_id', $charge->bank_account_id) == $bankAccount->id ? "selected" : "") }}>{{ $bankAccount->name }}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="date">Date</label>
      <input type="date" name="date"  class="form-control" value="{{ old('date', $charge->date) }}">
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <label for="value">Value</label>
      <input type="number" name="value"  class="form-control" value="@{{ payment.observation }}">
    </div>
  </div>
  <div class="col-md-3">
    <div class="form-group">
      <label for="observation">Observation</label>
      <textarea name="observation" class="form-control">{{ old('observation', $charge->observation) }}</textarea>
    </div>
  </div>
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
