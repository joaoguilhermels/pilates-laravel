<div id="app">
  <div class="form-group">
    <label for="start_date">Start Date:</label>
    <input type="date" class="form-control" name="start_at">
  </div>

  <plans list="{{ json_encode($classTypePlans) }}"></plans>

  <div class="form-group">
    <input type="submit" class="btn btn-success btn-block" value="{{ $submitButtonText }}">
  </div>
</div>
