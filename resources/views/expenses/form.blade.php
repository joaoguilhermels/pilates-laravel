<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  <input type="text" class="form-control" name="name" value="@if(isset($expense)){{ $expense->name }}@else{{ old('name') }}@endif">
</div>
<div class="form-group">
  <label for="start_date">Date:</label>
  <input type="date" class="form-control" name="date" value="@if(isset($expense)){{ $expense->date }}@else{{ old('date') }}@endif">
</div>
<div class="form-group">
  {!! Form::label('price', 'Price: ') !!}
  <input type="number" class="form-control" name="price" value="@if(isset($expense)){{ $expense->price }}@else{{ old('price') }}@endif">
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>