<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', $expense->name, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="start_date">Date:</label>
  <input type="date" class="form-control" name="date" value="{{ $expense->date }}">
</div>
<div class="form-group">
  {!! Form::label('price', 'Price: ') !!}
  <input type="number" class="form-control" name="price" value="{{ $expense->price }}">
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>