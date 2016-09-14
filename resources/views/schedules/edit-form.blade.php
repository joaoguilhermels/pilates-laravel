<div class="form-group">
  <label for="client">Client: </label>
  {{ $schedule->client->name }}
  <input type="hidden" name="client_id" value="{{ $schedule->client_id }}">
</div>
@if ($plan)
<div class="form-group">
  <label for="plan_id">Plan: </label>
  <input type="hidden" name="plan_id" value="{{ $schedule->clientPlanDetail->clientPlan->plan->id }}">
  {{ $plan }}
</div>
@endif
<div class="form-group">
  <label for="class_type_id">Class: </label>
  <input type="hidden" name="class_type_id" value="{{ $schedule->class_type_id }}">
  {{ $schedule->classType->name }}
</div>
<div class="form-group">
  <label for="class_type_status_id">Status: </label>
  <select class="form-control" id="class_type_status_id" name="class_type_status_id">
    @foreach ($classTypeStatuses as $classTypeStatus)
    <option value="{{ $classTypeStatus->id }}" {{ $classTypeStatus->id == $schedule->class_type_status_id ? 'selected' : '' }}>{{ $classTypeStatus->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="professional_id">Professional: </label>
  <select class="form-control" id="professional_id" name="professional_id">
    @foreach ($professionals as $professional)
    <option value="{{ $professional->id }}" {{ $professional->id == $schedule->professional_id ? 'selected' : '' }}>{{ $professional->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="room_id">Room: </label>
  <select class="form-control" id="room_id" name="room_id">
    @foreach ($rooms as $room)
    <option value="{{ $room->id }}" {{ $room->id == $schedule->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
    @endforeach
  </select>
</div>
<start-at date="{{ $schedule->start_at->toDateString() }}" time="{{ $schedule->start_at->format('h:i:s') }}"></start-at>
<div class="form-group">
  <label for="observation">Observation:</label>
  <textarea name="observation" class="form-control">{{ $schedule->observation }}</textarea>
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success">
</div>
