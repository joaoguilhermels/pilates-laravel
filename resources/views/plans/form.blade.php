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
    {!! Form::text('times', null, ['class' => 'form-control']) !!}
    {!! Form::label('times_type', 'per ') !!}
    {!! Form::select('times_type', array('week' => 'week', 'month' => 'month'), 'week', ['class' => 'form-control']) !!}
    {!! Form::label('duration', 'and the plan will last for ') !!} {!! Form::text('duration', null, ['class' => 'form-control']) !!}
    {!! Form::select('duration_type', array('week' => 'week', 'month' => 'month'), 'month', ['class' => 'form-control']) !!}
  </div>
</div>
<div class="form-group">
  {!! Form::label('price', 'Price: ') !!}
  {!! Form::text('price', null, ['class' => 'form-control']) !!}
  {!! Form::label('price', 'per ') !!}
  {!! Form::select('price_type', array('class' => 'class', 'month' => 'month'), 'class', ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>