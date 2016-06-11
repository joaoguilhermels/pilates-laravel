<div class="form-group">
  {!! Form::label('class_type_id', 'Class related to this plan: ') !!}
  {!! Form::select('class_type_id', $classTypes, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-inline">
  <div class="form-group">
    {!! Form::label('times', 'The client will go ') !!}
    {!! Form::text('times', null, ['class' => 'form-control input-sm', 'size' => 5]) !!}
    {!! Form::label('times_type', ' times per ') !!}
    {!! Form::select('times_type', array('week' => 'week(s)', 'month' => 'month(s)'), 'week', ['class' => 'form-control input-sm']) !!}
    {!! Form::label('duration', ', the plan will last for ') !!} {!! Form::text('duration', null, ['class' => 'form-control input-sm', 'size' => 5]) !!}
    {!! Form::select('duration_type', array('week' => 'week(s)', 'month' => 'month(s)'), 'month', ['class' => 'form-control input-sm']) !!}
    {!! Form::label('price', ' and the price is ') !!}
    {!! Form::text('price', null, ['class' => 'form-control input-sm', 'size' => 5]) !!}
    {!! Form::label('price', 'per ') !!}
    {!! Form::select('price_type', array('class' => 'class', 'month' => 'month'), 'class', ['class' => 'form-control input-sm']) !!}
  </div>
</div>
<div>&nbsp;</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
