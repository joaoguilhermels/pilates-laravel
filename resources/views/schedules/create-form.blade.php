@section('css')
<link rel="stylesheet" type="text/css" href="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css" href="http://jonthornton.github.io/jquery-timepicker/lib/bootstrap-datepicker.css" />
@stop

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
<div id="datepairExample" class="form-inline form-group">
  <label for="start_at">Date:</label>
  <input type="text" name="date_start_at" class="form-control date start">
  <label for="start_at">Time:</label>
  <input type="text" name="time_start_at" class="form-control time start">
  <label for="start_at">until:</label>
  <input type="hidden" name="date_end_at" class="form-control date end">
  <input type="text" name="time_end_at" class="form-control time end">
</div>
<div class="form-group">
  <label for="email">Observation:</label>
  <textarea name="observation" class="form-control"></textarea>
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-success">
</div>

@section('script_footer')
<script src="http://jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<script src="http://jonthornton.github.io/jquery-timepicker/lib/bootstrap-datepicker.js"></script>
<script src="http://jonthornton.github.io/Datepair.js/dist/datepair.js"></script>
<script src="http://jonthornton.github.io/Datepair.js/dist/jquery.datepair.js"></script>
<script>
    // initialize input widgets first
    $('#datepairExample .time').timepicker({
        'showDuration': true,
        'timeFormat': 'g:ia'
    });

    $('#datepairExample .date').datepicker({
        'format': 'dd-mm-yyyy',
        'autoclose': true
    });

    // initialize datepair
    $('#datepairExample').datepair();
</script>
@stop