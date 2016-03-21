<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  <input type="text" class="form-control" name="name" value="{{ old('name') }}">
</div>
<div class="form-group">
  <label for="start_date">Date:</label>
  <input type="date" class="form-control" name="date" value="{{ old('date') }}">
</div>
<div class="form-group">
  {!! Form::label('price', 'Price: ') !!}
  <input type="number" class="form-control" name="price" value="{{ old('price') }}">
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>