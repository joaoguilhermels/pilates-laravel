<template id="plans-template">
  <div class="form-group">
    <label for="plans">Plan: </label>
    <select name="plan_id" class="form-control" v-model="selectedPlan">
      <option value=""></option>
        <optgroup v-bind:label="class.name" v-for="class in list">
          <option v-for="(index, plan) in class.plans" v-bind:value="plan.id">{{ plan.name }} ({{ plan.times }}/{{ plan.times_type }})</option>
        </optgroup>
    </select>
  </div>

  <div class="form-group">
    <label for="discounts">Discount: </label>
    <select name="discount_id" class="form-control">
      <option value=""></option>
      <option v-for="discount in discounts" v-bind:value="discount.id">{{ discount.name }} ({{ discount.value }}/{{ discount.value_type }})</option>
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
            <label for="daysOfWeek[{{ day.number }}][day_of_week]">Days of the week: </label>
            <select name="daysOfWeek[{{ day.number }}][day_of_week]" class="form-control">
              <option value=""></option>
              <option v-for="(index, dayOfWeek) in daysOfWeek" value="{{ dayOfWeek.number }}">{{ dayOfWeek.name }}</option>
            </select>
          </td>
          <td class="col-md-3">
            <label for="daysOfWeek[{{ day.number }}][hour]">Time:</label>
            <select class="form-control" name="daysOfWeek[{{ day.number }}][hour]">
              <option value=""></option>
              <option v-for="time in times" value="{{ time }}">{{ time }}:00</option>
            </select>
          </td>
          <td class="col-md-3">
            <label for="daysOfWeek[{{ day.number }}][professional_id]">Professional: </label>
            <select class="form-control" name="daysOfWeek[{{ day.number }}][professional_id]" v-if="selectedClass.professionals.length > 1">
              <option value=""></option>
              <option v-for="professional in selectedClass.professionals" v-bind:value="professional.id">{{ professional.name }}</option>
            </select>
            <div v-else>
              {{ selectedClass.professionals[0].name }}
              <input type="hidden" name="daysOfWeek[{{ day.number }}][professional_id]" v-bind:value="selectedClass.professionals[0].id">
            </div>
          </td>
          <td class="col-md-3">
            <label for="daysOfWeek[{{ day.number }}][room_id]">Room: </label>
            <select class="form-control" name="daysOfWeek[{{ day.number }}][room_id]" v-if="selectedClass.rooms.length > 1">
              <option value=""></option>
              <option v-for="room in selectedClass.rooms" v-bind:value="room.id">{{ room.name }}</option>
            </select>
            <div v-else>
              {{ selectedClass.rooms[0].name }}
              <input type="hidden" name="daysOfWeek[{{ day.number }}][room_id]" v-bind:value="selectedClass.rooms[0].id">
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>
<script>
  export default {
    props: ['list', 'discounts'],

    data: function() {
        return {
            selectedPlan: [],
            selectedDaysOfWeek: [],
            selectedClass: '',
            daysOfWeek: [
              { number: 1, name: 'Monday' },
              { number: 2, name: 'Tuesday' },
              { number: 3, name: 'Wednesday' },
              { number: 4, name: 'Thursday' },
              { number: 5, name: 'Friday' },
            ],
            times: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
        }
    },

    created () {
        this.list = JSON.parse(this.list);
        this.discounts = JSON.parse(this.discounts);
    },

    filters: {
        filterNumberOfDays: function(daysOfWeek) {
            var times = 0,
                self = this

            if (typeof self.selectedPlan !== 'object') {
                self.list.forEach(function(classType) {
                    classType.plans.forEach(function(classTypePlan) {
                        if (classTypePlan.id == self.selectedPlan) {
                            self.selectedClass = classType;
                            times = classTypePlan.times
                        }
                    })
                })
            }

            return daysOfWeek.filter(function(day) {
                return day.number <= times
            })
        },
        filterByClassType: function(discounts) {
            var self = this;

            if (typeof self.selectedPlan !== 'object' && discount.class_types.length > 0) {
                return discounts.filter(function(discount) {
                    return discount.class_types.filter(function(class_type) {
                        return class_type.id == self.selectedClass.id;
                    });
                });
            }
        },
        filterByPlan: function(discounts) {
            var self = this;

            if (typeof self.selectedPlan !== 'object' && discount.plans.length > 0) {
                return discounts.filter(function(discount) {
                    return discount.plans.filter(function(plan) {
                        return plan.id == self.selectedPlan;
                    });
                });
            }
        }
    }
  }
</script>