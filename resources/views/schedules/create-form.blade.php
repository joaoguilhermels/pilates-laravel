<div class="form-group">
  <label for="client_id">Client:</label>
  {!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="class_type_id">Class:</label>
  {!! Form::select('class_type_id', $classTypes, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="plan_id">Plan:</label>
  {!! Form::select('plan_id', $plans, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="class_type_status_id">Status:</label>
  {!! Form::select('class_type_status_id', $classTypeStatuses, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="professional_id">Professional:</label>
  {!! Form::select('professional_id', $professionals, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="room_id">Room:</label>
  {!! Form::select('room_id', $rooms, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="price">Price:</label>
  {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="start_at">Start:</label>
  {!! Form::text('start_at', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="end_at">End:</label>
  {!! Form::text('end_at', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="email">Observation:</label>
  <textarea name="observation" class="form-control"></textarea>
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
