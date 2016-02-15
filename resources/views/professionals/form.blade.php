<?php
  //dd(get_defined_vars());
?>
<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('phone', 'Phone: ') !!}
  {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('email', 'E-mail: ') !!}
  {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('class_type_list', 'Classes given by the professional: ') !!}
  {!! Form::select('class_type_list[]', $classTypes, null, ['class' => 'form-control', 'multiple']) !!}
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>