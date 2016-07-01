<div class="form-group">
  <label for="client">Client: </label>
  {{ $schedule->client->name }}
</div>
@if ($plan)
<div class="form-group">
  <label for="plan_id">Plan: </label>
  {{ $plan }}
</div>
@endif
<div class="form-group">
  <label for="class_type_id">Class: </label>
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
<div class="form-group">
  <label for="start_at">Start: </label>
  <input type="text" name="start_at" class="form-control" value="{{ $schedule->start_at }}">
</div>
<div class="form-group">
  <label for="end_at">End: </label>
  <input type="text" name="end_at" class="form-control" value="{{ $schedule->end_at }}">
</div>
<div class="form-group">
  <label for="email">Observation:</label>
  <textarea name="observation" class="form-control">{{ $schedule->observation }}</textarea>
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
