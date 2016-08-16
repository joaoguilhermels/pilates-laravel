<div id="app">
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
          <optgroup v-bind:label="class.name" v-for="class in list">
            <option v-for="plan in class.plans" v-bind:value="plan.id">@{{ plan.name }} (@{{ plan.times }}/@{{ plan.times_type }})</option>
          </optgroup>
      </select>
    </div>

    <div id="details" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr v-for="day in daysOfWeek | filterNumberOfDays">
            <td class="col-md-3">
              <label for="daysOfWeek[@{{ day.number }}][day_of_week]">Days of the week: </label>
              <select name="daysOfWeek[@{{ day.number }}][day_of_week]" class="form-control">
                <option value=""></option>
                <option v-for="(index, dayOfWeek) in daysOfWeek" value="@{{ dayOfWeek.number }}">@{{ dayOfWeek.name }}</option>
              </select>
            </td>
            <td class="col-md-3">
              <label for="daysOfWeek[@{{ day.number }}][hour]">Time:</label>
              <select class="form-control" name="daysOfWeek[@{{ day.number }}][hour]">
                <option value=""></option>
                <option v-for="time in times" value="@{{ time }}">@{{ time }}:00</option>
              </select>
            </td>
            <td class="col-md-3">
              <label for="daysOfWeek[@{{ day.number }}][professional_id]">Professional: </label>
              <select class="form-control" name="daysOfWeek[@{{ day.number }}][professional_id]" v-if="selectedClass.professionals.length > 1">
                <option value=""></option>
                <option v-for="professional in selectedClass.professionals" v-bind:value="professional.id">@{{ professional.name }}</option>
              </select>
              <div v-else>
                @{{ selectedClass.professionals[0].name }}
                <input type="hidden" name="daysOfWeek[@{{ day.number }}][professional_id]" v-bind:value="selectedClass.professionals[0].id">
              </div>
            </td>
            <td class="col-md-3">
              <label for="daysOfWeek[@{{ day.number }}][room_id]">Room: </label>
              <select class="form-control" name="daysOfWeek[@{{ day.number }}][room_id]" v-if="selectedClass.rooms.length > 1">
                <option value=""></option>
                <option v-for="room in selectedClass.rooms" v-bind:value="room.id">@{{ room.name }}</option>
              </select>
              <div v-else>
                @{{ selectedClass.rooms[0].name }}
                <input type="hidden" name="daysOfWeek[@{{ day.number }}][room_id]" v-bind:value="selectedClass.rooms[0].id">
              </div>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </template>

  <div class="form-group">
    <input type="submit" class="btn btn-success btn-block" value="{{ $submitButtonText }}">
  </div>
</div>
