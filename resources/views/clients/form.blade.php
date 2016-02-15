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
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>