<div class="form-group @if ($errors->has('name')) has-error @endif">
  <label for="name">Name:</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $client->name) }}">
</div>
<div class="form-group @if ($errors->has('phone')) has-error @endif">
  <label for="phone">Phone:</label>
  <input type="text" name="phone" class="form-control" value="{{ old('phone', $client->phone) }}">
</div>
<div class="form-group @if ($errors->has('email')) has-error @endif">
  <label for="email">Email:</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-primary btn-block">
</div>
