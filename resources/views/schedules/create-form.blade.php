<div class="form-group">
  <label for="client_id">Client:</label>
  <select name="client_id" class="form-control">
    @foreach($clients as $client)
    <option value="{{ $client->id }}">{{ $client->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="class_type_id">Class:</label>
  <select name="class_type_id" class="form-control">
    @foreach($classTypes as $classType)
    <option value="{{ $classType->id }}">{{ $classType->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="plan_id">Plan:</label>
  <select name="plan_id" class="form-control">
    <option></option>
    @foreach($plans as $plan)
    <option value="{{ $plan->id }}">{{ $plan->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="class_type_status_id">Status:</label>
  <select name="class_type_status_id" class="form-control">
    @foreach($classTypeStatuses as $classTypeStatus)
    <option value="{{ $classTypeStatus->id }}">{{ $classTypeStatus->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="professional_id">Professional:</label>
  <select name="professional_id" class="form-control">
    @foreach($professionals as $professional)
    <option value="{{ $professional->id }}">{{ $professional->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="room_id">Room:</label>
  <select name="room_id" class="form-control">
    @foreach($rooms as $room)
    <option value="{{ $room->id }}">{{ $room->name }}</option>
    @endforeach
  </select>
</div>
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