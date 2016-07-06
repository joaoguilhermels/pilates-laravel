<div class="form-group @if ($errors->has('name')) has-error @endif">
  <label for="name">Name:</label>
  <input type="text" name="name" value="{{ old('name', $classType->name) }}" class="form-control">
</div>
<div class="form-group @if ($errors->has('max_number_of_clients')) has-error @endif">
  <label for="max_number_of_clients">Max Number of Clients: </label>
  <input type="number" min="0" max="100" name="max_number_of_clients" value="{{ old('max_number_of_clients', $classType->max_number_of_clients) }}" class="form-control">
</div>
<div class="form-group @if ($errors->has('duration')) has-error @endif">
  <label for="duration">Duration (Mins): </label>
  <input type="number" name="duration" min="0" max="120" value="{{ old('duration', $classType->duration) }}" class="form-control">
</div>
<div class="form-group @if ($errors->has('extra_class_price')) has-error @endif">
  <label for="extra_class_price">Extra class price: </label>
  <input type="number" name="extra_class_price" min="0" value="{{ old('extra_class_price', $classType->extra_class_price) }}" class="form-control">
</div>
<div class="form-group">
    <label for="trial">Does this class offers a free trial? </label>
    <select name="trial" class="form-control">
      <option value="1" {{ $classType->trial == 1 ? "selected" : "" }}>Yes</option>
      <option value="0" {{ $classType->trial == 0 ? "selected" : "" }}>No</option>
    </select>
</div>

<div class="form-group">
  @if (count($classType->statuses) == 0)
    empty
  @else
    <div class="table-responsive">
      <table class="table" id="status_table">
        <thead>
          <tr>
            <th>Status</th>
            <th>Charge Client?</th>
            <th>Pay Professional?</th>
            <th>Color</th>
            <!--th></th-->
          </tr>
        </thead>
        <tbody>
        @foreach ($classType->statuses as $key => $status)
          <tr>
            <td>
              <input type="hidden" name="status[{{ $key }}][id]" value="{{ $status->id == null ? NULL : $status->id }}">
              <input type="hidden" name="status[{{ $key }}][name]" value="{{ $status->name }}">
              {{ $status->name }}
            </td>
            <td>
              <div class="checkbox">
                <label>
                  <input type="hidden" name="status[{{ $key }}][charge_client]" value="0">
                  {!! Form::checkbox('status[' . $key . '][charge_client]', $status->charge_client == false ? NULL : 'on', $status->charge_client, ['id' => 'charge_client.' . $key]) !!}
                  Yes
                </label>
              </div>
            </td>
            <td>
              <div class="checkbox">
                <label>
                  <input type="hidden" name="status[{{ $key }}][pay_professional]" value="0">
                  {!! Form::checkbox('status[' . $key . '][pay_professional]', $status->pay_professional == false ? NULL : 'on', $status->pay_professional, ['id' => 'pay_professional.' . $key]) !!}
                  Yes
                </label>
              </div>
            </td>
            <td>
              <input type="color" name="status[{{ $key }}][color]" value="{{ $status->color }}" class="form-control" id="color.{{ $key }}">
            </td>
            <!--td>
              <button value="<?php print 'status.' . $status->id; ?>" id="<?php print 'btn.status.' . $status->id; ?>">delete</button>
            </td-->
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    <!--button type="button" class="btn btn-default" aria-label="Left Align" id="add_new_status">
      Add new status
    </button-->
  @endif
</div>

<div class="form-group">
  <input type="submit" value="{{ $submitButtonText }}" class="btn btn-primary">
</div>
