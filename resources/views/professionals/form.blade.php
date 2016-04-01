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
          <?php $value = '';?>
          @if(isset($professional))
          @foreach($professional->classTypes->where('id', $id) as $professionalClassType)
              <?php $value = $professionalClassType->pivot->value; ?>
          @endforeach
          @endif
        <tr>
          <td>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="class_type_list[{{ $id }}][class_type_id]" value="{{ $id }}" @if(isset($professional) && $professional->classTypes->contains($id)) checked @endif>
                {{ $classType }}
              </label>
            </div>
          </td>
          <td>
            <input type="number" name="class_type_list[{{ $id }}][value]" class="form-control" value="{{ $value }}">
          </td>
          <td>
            <select name="class_type_list[{{ $id }}][value_type]" class="form-control">
              <option value="percentage">%</option>
              <option value="value_per_client">Per Client</option>
              <option value="value_per_class">Per Class</option>
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