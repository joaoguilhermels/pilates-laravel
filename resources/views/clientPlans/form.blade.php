<div id="app">
  <div class="form-group">
    {!! Form::label('classType', 'Class: ') !!}
    <select class="form-control" name="class_type_id">
      <option value=""></option>
      @foreach($classTypes as $id => $classType)
        <option value="{{ $id }}">{{ $classType }}</option>
      @endforeach
    </select>
  </div>
  
  <div class="form-group">
    <label for="start_date">Start Date:</label>
    <input type="date" class="form-control" name="start_at">
  </div>
  
  
  <plans list="{{ json_encode($classTypePlans) }}"></plans>
  
  <template id="plans-template">
    <div class="form-group">
    <label for="plans">Plan: </label>
    <select name="plan_id" class="form-control" v-model="selectedPlan">
      <option value=""></option>
        <optgroup label="@{{ class.name }}" v-for="class in list">
          <option v-for="plan in class.plans" v-bind:value="plan.id">@{{ plan.name }}</option>
        </optgroup>
    </select>
    </div>

    <div id="details" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr v-for="day in daysOfWeek | selectPlan">
            <td class="col-md-3">
              <label>Days of the week: </label>
              <select name="daysOfWeek[@{{ day }}][day_of_week]" class="form-control">
                <option value=""></option>
                @foreach($daysOfWeek as $key => $dayOfWeek)
                  <option value="{!! $key !!}">{!! Form::label('daysOfWeek', $dayOfWeek) !!}</option>
                @endforeach
              </select>
            </td>
            <td class="col-md-3">
              <label>Time:</label>
              <select class="form-control" name="daysOfWeek[@{{ day }}][hour]">
                <option value=""></option>
                @for($time = 6; $time < 22; $time++)
                  <option value="{{ $time }}">{{ $time }}:00</option>
                @endfor
              </select>
            </td>
            <td class="col-md-3">
              <label for="professional">Professional: </label>
              <select class="form-control" name="daysOfWeek[@{{ day }}][professional_id]">
                <option value=""></option>
                @foreach($professionals as $id => $professional)
                  <option value="{{ $id }}">{{ $professional }}</option>
                @endforeach
              </select>
            </td>
            <td class="col-md-3">
              <label for="room">Room: </label>
              <select class="form-control" name="daysOfWeek[@{{ day }}][room_id]">
                <option value=""></option>
                @foreach($rooms as $id => $room)
                  <option value="{{ $id }}">{{ $room }}</option>
                @endforeach
              </select>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </template>

  <div class="form-group">
    {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
  </div>
</div>