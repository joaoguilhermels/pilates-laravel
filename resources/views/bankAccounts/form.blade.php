<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  <input type="text" class="form-control" name="name" value="@if(isset($bankAccount)){{ $bankAccount->name }}@else{{ old('name') }}@endif">
</div>
<div class="form-group">
  {!! Form::label('name', 'Bank: ') !!}
  <input type="text" class="form-control" name="bank" value="@if(isset($bankAccount)){{ $bankAccount->bank }}@else{{ old('bank') }}@endif">
</div>
<div class="form-group">
  {!! Form::label('name', 'Agency: ') !!}
  <input type="text" class="form-control" name="agency" value="@if(isset($bankAccount)){{ $bankAccount->agency }}@else{{ old('agency') }}@endif">
</div>
<div class="form-group">
  {!! Form::label('name', 'Account: ') !!}
  <input type="text" class="form-control" name="account" value="@if(isset($bankAccount)){{ $bankAccount->account }}@else{{ old('account') }}@endif">
</div>
<div class="form-group">
  {!! Form::label('price', 'Balance: ') !!}
  <input type="number" class="form-control" name="balance" value="@if(isset($bankAccount)){{ $bankAccount->balance }}@else{{ old('balance') }}@endif">
</div>
<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>