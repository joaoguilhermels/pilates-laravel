<div class="form-group">
  <label for="name">Name:</label>
  <input type="text" class="form-control" name="name" value="@if(isset($bankAccount)){{ $bankAccount->name }}@else{{ old('name') }}@endif">
</div>
<div class="form-group">
  <label for="bank">Bank:</label>
  <input type="text" class="form-control" name="bank" value="@if(isset($bankAccount)){{ $bankAccount->bank }}@else{{ old('bank') }}@endif">
</div>
<div class="form-group">
  <label for="agency">Agency:</label>
  <input type="text" class="form-control" name="agency" value="@if(isset($bankAccount)){{ $bankAccount->agency }}@else{{ old('agency') }}@endif">
</div>
<div class="form-group">
  <label for="account">Account:</label>
  <input type="text" class="form-control" name="account" value="@if(isset($bankAccount)){{ $bankAccount->account }}@else{{ old('account') }}@endif">
</div>
<div class="form-group">
  <label for="balance">Balance:</label>
  <input type="number" class="form-control" name="balance" value="@if(isset($bankAccount)){{ $bankAccount->balance }}@else{{ old('balance') }}@endif">
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success">
</div>
