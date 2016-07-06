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
  <label for="class_type_list">Classes given by the professional:</label>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <td>Class</td>
          <td>Value</td>
          <td>Type</td>
        </tr>
      </thead>
      <tbody>
        @foreach($classTypes as $classType)
        <tr>
          <td>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="class_type_list[{{ $classType->id }}][class_type_id]" value="{{ $classType->id }}" @if($professional->classTypes->contains($classType->id)) checked @endif>
                {{ $classType->name }}
              </label>
            </div>
          </td>
          <td>
            <input type="number" name="class_type_list[{{ $classType->id }}][value]" class="form-control" value="{{ $classType->professionals->first() == null ? '' : $classType->professionals->first()->pivot->value }}">
          </td>
          <td>
            <select name="class_type_list[{{ $classType->id }}][value_type]" class="form-control">
              <option value="percentage">%</option>
              <option value="value_per_client">Per Client</option>
              <option value="value_per_class">Per Class</option>
            </select>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-primary btn-block">
</div>
