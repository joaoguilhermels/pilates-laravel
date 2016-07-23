<div class="form-group">
  <label for="class_type_id">Class related to this plan:</label>
  <select name="class_type_id" class="form-control">
    <option value=""></option>
    @foreach($classTypes as $classType)
      <option value="{{ $classType->id }}" @if(old('class_type_id', isset($plan->classType->id) ? $plan->classType->id : "" ) == $classType->id) selected @endif>{{ $classType->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="name">Name:</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $plan->name) }}">
</div>
<div class="form-inline">
  <div class="form-group">
    <label for="times">The client will go </label>
    <input type="number" min="0" name="times" class="form-control input-sm" size="5" value="{{ old('time', $plan->times) }}">
    <label for="times_type"> times per </label>
    <select name="times_type" class="form-control input-sm">
      <option value="week" @if(old('times_type', $plan->times_type) == "week") selected @endif>week</option>
      <option value="month" @if(old('times_type', $plan->times_type) == "month") selected @endif>month</option>
    </select>
    <label for="duration"> , the plan will last for </label> <input type="number" min="0" name="duration" class="form-control input-sm" size="5" value="{{ old('duration', $plan->duration) }}">
    <select name="duration_type" class="form-control input-sm">
      <option value="month" @if(old('duration_type', $plan->duration_type) == "month") selected @endif>month(s)</option>
      <option value="week" @if(old('duration_type', $plan->duration_type) == "week") selected @endif>week(s)</option>
    </select>
    <label for="price"> and the price is </label>
    <input type="number" min="0" name="price" class="form-control input-sm" size="5" value="{{ old('time', $plan->price) }}">
    <label for="price_type">per </label>
    <select name="price_type" class="form-control input-sm">
      <option value="class" @if(old('price_type', $plan->price_type) == "class") selected @endif>class</option>
      <option value="month" @if(old('price_type', $plan->price_type) == "month") selected @endif>month</option>
    </select>
  </div>
</div>
<div>&nbsp;</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success btn-block">
</div>
