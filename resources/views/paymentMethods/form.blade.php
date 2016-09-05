<div class="form-group">
  <label for="name">Name:</label>
  <input type="text" class="form-control" name="name" value="@if(isset($paymentMethod)){{ $paymentMethod->name }}@else{{ old('name') }}@endif">
</div>
<div class="form-group">
  <div class="checkbox">
    <input type="hidden" name="enabled" value="0">
    <label><input type="checkbox" name="enabled" value="1" @if(isset($paymentMethod)){{ $paymentMethod->enabled == 1 ? 'checked' : ''}}@else{{ old('enabled') }}@endif>Enabled</label>
  </div>
</div>
<div class="form-group">
  <input type="submit" name="{{ $submitButtonText }}" class="btn btn-success" id="submit">
</div>