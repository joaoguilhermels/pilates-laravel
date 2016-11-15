<div class="form-group">
  <label for="name">Name:</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $professional->name) }}">
</div>
<div class="form-group">
  <label for="phone">Phone:</label>
  <input type="text" name="phone" class="form-control" value="{{ old('phone', $professional->phone) }}">
</div>
<div class="form-group">
  <label for="email">Email:</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $professional->email) }}">
</div>
<div class="form-group">
  <label for="email">Fixed Salary:</label>
  <input type="number" min="0" step="any" name="salary" class="form-control" value="{{ old('salary', $professional->salary) }}">
</div>

<professional-classes-percentage-value classes="{{ json_encode($classTypes) }}" professional_classes="{{ json_encode($professionalClassTypes) }}"></professional-classes-percentage-value>

<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success btn-block">
</div>
