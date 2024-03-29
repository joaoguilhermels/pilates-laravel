<div id="app">
  <div class="form-group">
    <label for="start_date">Start Date:</label>
    <start-at date="{{ \Carbon\Carbon::Now() }}" time="" :timepicker="false"></start-at>
  </div>

  <plans :class_types="{{ $classTypePlans }}" :client_plan="{{ $clientPlan }}" :discounts="{{ $discounts }}"></plans>

  <div class="form-group">
    <input type="submit" class="btn btn-success btn-block" value="{{ $submitButtonText }}">
  </div>
</div>
