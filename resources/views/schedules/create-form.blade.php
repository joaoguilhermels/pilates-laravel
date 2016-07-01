<div class="form-group">
  {!! Form::label('client_id', 'Client: ') !!}
  {!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('class_type_id', 'Class: ') !!}
  {!! Form::select('class_type_id', $classTypes, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('plan_id', 'Plan: ') !!}
  {!! Form::select('plan_id', $plans, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('class_type_status_id', 'Status: ') !!}
  {!! Form::select('class_type_status_id', $classTypeStatuses, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('professional_id', 'Professional: ') !!}
  {!! Form::select('professional_id', $professionals, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('room_id', 'Room: ') !!}
  {!! Form::select('room_id', $rooms, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('price', 'Price: ') !!}
  {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('start_at', 'Start: ') !!}
  {!! Form::text('start_at', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('end_at', 'End: ') !!}
  {!! Form::text('end_at', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="email">Observation:</label>
  <textarea name="observation" class="form-control"></textarea>
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
