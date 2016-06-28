<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('max_number_of_clients', 'Max Number of Clients: ') !!}
  {!! Form::text('max_number_of_clients', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="duration">Duration (Mins): </label>
  {!! Form::text('duration', 60, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="duration">Extra class price: </label>
  {!! Form::text('extra_class_price', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  <label for="free_trial">Does this class offers a free trial? </label>
  <select name="free_trial" class="form-control">
    <option value="1" {{ $classType->free_trial == 1 ? "selected" : "" }}>Yes</option>
    <option value="0" {{ $classType->free_trial == 0 ? "selected" : "" }}>No</option>
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
              {!! Form::input('color', 'status[' . $key . '][color]', $status->color, null, ['class' => 'form-control', 'id' => 'color.' . $key]) !!}
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
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>
