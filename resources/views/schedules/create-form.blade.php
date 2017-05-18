<div class="form-group">
  <label for="client_id">Client:</label>
  <select name="client_id" class="form-control">
    @foreach($clients as $client)
    <option value="{{ $client->id }}">{{ $client->name }}</option>
    @endforeach
  </select>
</div>

<class-professional-room-status classes="{{ json_encode($classTypes) }}"></class-professional-room-status>

<div class="form-group">
  <label for="price">Price:</label>
  <input type="text" name="price" class="form-control">
</div>
<start-at></start-at>
<div class="form-group">
  <label for="email">Observation:</label>
  <textarea name="observation" class="form-control"></textarea>
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success">
</div>