<div class="form-group">
  {!! Form::label('classType', 'Class: ') !!}
  <select class="form-control" name="class_id">
    <option value=""></option>
    @foreach($classTypes as $id => $classType)
      <option value="{{ $id }}">{{ $classType }}</option>
    @endforeach
  </select>
</div>
<div class="form-group">
  {!! Form::label('plans', 'Plan: ') !!}
  <select name="plan_id" class="form-control">
    <option value=""></option>
    @foreach ($classTypePlans as $classTypePlan)
      <optgroup value="{{ $classTypePlan['id'] }}" label="{{ $classTypePlan['name'] }}">
      @foreach ($classTypePlan['plans'] as $plans)
        <option value="{{ $plans['id'] }}" data-times="{{ $plans['times'] }}" data-times-type="{{ $plans['times_type'] }}">{{ $plans['name'] }}</option>
      @endforeach
      </optgroup>
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="start_date">Start Date:</label>
  <input type="date" class="form-control" name="start_at">
</div>


<div id="details" class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Details</h3>
  </div>

  <div class="table-responsive">
    <table class="table table-striped">
      @for($i = 0; $i < 7; $i++)
        <?php
          if ($i > 1) {
            $disabled = 'disabled';
          }
          else {
            $disabled = '';
          }
        ?>
      <tr>
        <td class="col-md-3">
          <label>Days of the week: </label>
          <select name="daysOfWeek[{{ $i }}][day_of_week]" class="form-control" {{ $disabled }}>
            <option value=""></option>
            @foreach($daysOfWeek as $key => $dayOfWeek)
              <option value="{!! $key !!}">{!! Form::label('daysOfWeek', $dayOfWeek) !!}</option>
            @endforeach
          </select>
        </td>
        <td class="col-md-3">
          <label>Time:</label>
          <select class="form-control" name="daysOfWeek[{{ $i }}][hour]" {{ $disabled }}>
            <option value=""></option>
            @for($time = 6; $time < 22; $time++)
              <option value="{{ $time }}">{{ $time }}:00</option>
            @endfor
          </select>
        </td>
        <td class="col-md-3">
          {!! Form::label('professional', 'Professional: ') !!}
          <select class="form-control" name="daysOfWeek[{{ $i }}][professional_id]" {{ $disabled }}>
            <option value=""></option>
            @foreach($professionals as $id => $professional)
              <option value="{{ $id }}">{{ $professional }}</option>
            @endforeach
          </select>
        </td>
        <td class="col-md-3">
          {!! Form::label('room', 'Room: ') !!}
          <select class="form-control" name="daysOfWeek[{{ $i }}][room_id]" {{ $disabled }}>
            <option value=""></option>
            @foreach($rooms as $id => $room)
              <option value="{{ $id }}">{{ $room }}</option>
            @endforeach
          </select>
        </td>
      </tr>
      @endfor
    </table>
  </div>
</div>

<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>