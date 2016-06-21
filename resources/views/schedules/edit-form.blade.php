<div class="form-group">
  <label for="client">Client: </label>
  {{ $schedule->client->name }}
</div>
<div class="form-group">
  <label for="plan_id">Plan: </label>
  {{ $schedule->clientPlanDetail->clientPlan->plan->name }}
</div>
<div class="form-group">
  <label for="class_type_id">Class: </label>
  {{ $schedule->classType->name }}
</div>
<div class="form-group">
  <label for="class_type_status_id">Status: </label>
  <select class="form-control" id="class_type_status_id" name="class_type_status_id">
    @foreach ($classTypeStatuses as $classTypeStatus)
    <option value="{{ $classTypeStatus->id }}">{{ $classTypeStatus->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="professional_id">Professional: </label>
  <select class="form-control" id="professional_id" name="professional_id">
    @foreach ($professionals as $professional)
    <option value="{{ $professional->id }}">{{ $professional->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="room_id">Room: </label>
  <select class="form-control" id="room_id" name="room_id">
    @foreach ($rooms as $room)
    <option value="{{ $room->id }}">{{ $room->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="price">Price: </label>
  {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="start_at">Start: </label>
  {!! Form::text('start_at', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="end_at">End: </label>
  {!! Form::text('end_at', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
