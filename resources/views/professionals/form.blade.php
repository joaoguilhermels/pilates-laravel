<?php
  //dd(get_defined_vars());
?>
<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('phone', 'Phone: ') !!}
  {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('email', 'E-mail: ') !!}
  {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('class_type_list', 'Classes given by the professional: ') !!}
  {!! Form::select('class_type_list[]', $classTypes, null, ['class' => 'form-control', 'multiple']) !!}
</div>

<div class="form-group">
  {!! Form::label('class_type_list', 'Classes given by the professional: ') !!}
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <td>Class</td>
          <td>Value</td>
          <td>Type</td>
        </tr>
      </thead>
      <tbody>
        @foreach($classTypes as $id => $classType)
        <tr>
          <td>
            <div class="checkbox">
              <label><input type="checkbox" name="class_type_list[{{ $id }}]" value="{{ $id }}">{{ $classType }}</label>
              {!! Form::checkbox('class_type_list[' . $id . ']', $status->charge_client == false ? NULL : 'on', $status->charge_client, ['id' => 'charge_client.' . $key]) !!}
            </div>
          </td>
          <td><input type="text" name="class_type_list[{{ $id }}][value]" class="form-control" value="{{ $id }}" ></td>
          <td>
            <select name="class_type_list[{{ $id }}][value_type]" class="form-control">
              <option value="percentage">%</option>
              <option value="value">Value</option>
            </select>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>