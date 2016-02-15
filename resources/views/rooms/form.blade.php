<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('class_type_list', 'Classes given on this room: ') !!}
  {!! Form::select('class_type_list[]', $classTypes, null, ['class' => 'form-control', 'multiple']) !!}
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>