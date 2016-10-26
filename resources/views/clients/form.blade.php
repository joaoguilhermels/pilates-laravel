<div class="form-group @if ($errors->has('name')) has-error @endif">
  <label for="name">Name:</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}">
  <small class="text-danger">{{ $errors->first('name') }}</small>
</div>
<div class="form-group @if ($errors->has('phone')) has-error @endif">
  <label for="phone">Phone:</label>
  <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
  <small class="text-danger">{{ $errors->first('phone') }}</small>
</div>
<div class="form-group @if ($errors->has('email')) has-error @endif">
  <label for="email">Email:</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
  <small class="text-danger">{{ $errors->first('email') }}</small>
</div>
<div class="form-group @if ($errors->has('observation')) has-error @endif">
  <label for="observation">Observation:</label>
  <textarea name="observation" class="form-control">{{ old('observation', $client->observation) }}</textarea>
  <small class="text-danger">{{ $errors->first('observation') }}</small>
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success btn-block">
</div>
