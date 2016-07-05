@section('css')
    <link href="/vendor/multiselect/css/multi-select.css" rel="stylesheet">
@stop

<div class="form-group">
  <label for="name">Name:</label>
  <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}">
</div>
<div class="form-group">
  <label for="class_type_list">Classes given on this room:</label>
  <select multiple="multiple" name="class_type_list[]" class="form-control" id="class_type_list">
    @foreach($classTypes as $classType)
      <option value="{{ $classType->id }}" @if(isset($room)) {{ $room->classTypes->where('id', $classType->id)->count() == 1 ? 'selected' : '' }} @endif>{{ $classType->name }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-primary btn-block">
</div>

@section('script_footer')
    <script src="/vendor/multiselect/js/jquery.multi-select.js"></script>
    <script type="text/javascript">
      $('#class_type_list').multiSelect({
          selectableHeader: "<div class='custom-header'>Available Rooms</div>",
          selectionHeader: "<div class='custom-header'>Selected Rooms</div>"
      });
    </script>
@stop
