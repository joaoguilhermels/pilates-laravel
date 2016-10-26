<div id="app">
  <div class="form-group">
    <label for="start_date">Start Date:</label>
    <start-at date="{{ \Carbon\Carbon::Now() }}" time="" v-bind:timepicker="false"></start-at>
  </div>

  <plans list="{{ json_encode($classTypePlans) }}" discounts="{{ json_encode($discounts) }}"></plans>

  <div class="form-group">
    <input type="submit" class="btn btn-success btn-block" value="{{ $submitButtonText }}">
  </div>
</div>
