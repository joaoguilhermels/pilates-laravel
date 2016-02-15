<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('max_number_of_clients', 'Max Number of Clients: ') !!}
  {!! Form::text('max_number_of_clients', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('duration', 'Duration (Mins): ') !!}
  {!! Form::text('duration', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>