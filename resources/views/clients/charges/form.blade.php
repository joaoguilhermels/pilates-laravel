<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="total_number_of_payments">Total Number of Payments</label>
  <input type="number" name="total_number_of_payments" class="form-control" value="">
</div>
<div class="form-group">
  <label for="payment_number">Payment Number</label>
  <input type="number" name="payment_number" class="form-control" value="">
</div>
<div class="form-group">
  <label for="payment_method_id">Payment Method: </label>
  <select class="form-control" name="payment_method_id">
    <option>- Select a payment method -</option>
    @foreach($paymentMethods as $paymentMethod)
    <option value="{{ $paymentMethod->id }}" {{ (old('paymentMethod') == $paymentMethod->id ? "selected" : "") }}>{{ $paymentMethod->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="name">Bank Account: </label>
  <select class="form-control" name="bank_account_id">
    <option>- Select a bank -</option>
    @foreach($bankAccounts as $bankAccount)
    <option value="{{ $bankAccount->id }}" {{ (old('bankAccount') == $bankAccount->id ? "selected" : "") }}>{{ $bankAccount->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="date">Date</label>
  <input type="date" name="date"  class="form-control" value="">
</div>
<div class="form-group">
  <label for="value">Value</label>
  <input type="number" name="value"  class="form-control" value="">
</div>
<div class="form-group">
  <label for="observation">Observation</label>
  <textarea name="observation" class="form-control"></textarea>
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
