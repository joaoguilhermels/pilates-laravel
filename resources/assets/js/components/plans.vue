<template id="plans-template">
  <div>
    <div class="form-group">
      <label for="plans">Plan: </label>
      <select name="plan_id" class="form-control" v-model="selectedPlan">
        <option value=""></option>
          <optgroup :label="class_type.name" v-for="class_type in list">
            <option v-for="(plan, index) in class_type.plans" :value="plan.id">{{ plan.name }} ({{ plan.times }}/{{ plan.times_type }})</option>
          </optgroup>
      </select>
    </div>

    <div class="form-group">
      <label for="discounts">Discount: </label>
      <select name="discount_id" class="form-control">
        <option value=""></option>
        <option v-for="discount in discounts" :value="discount.id">{{ discount.name }} ({{ discount.value }}/{{ discount.value_type }})</option>
      </select>
    </div>

    <div id="details" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr v-for="day in daysOfWeek">
            <td class="col-md-3">
              <label :for="dayOfWeekField(day.number, 'day_of_week')">Days of the week: </label>
              <select :name="dayOfWeekField(day.number, 'day_of_week')" class="form-control">
                <option value=""></option>
                <option v-for="dayOfWeek in daysOfWeekArr" :value="dayOfWeek.number">{{ dayOfWeek.name }}</option>
              </select>
            </td>
            <td class="col-md-3">
              <label :for="dayOfWeekField(day.number, 'professional_id')">Professional: </label>
              <select class="form-control" :name="dayOfWeekField(day.number, 'professional_id')" v-if="selectedClass.professionals.length > 1">
                <option value=""></option>
                <option v-for="professional in selectedClass.professionals" :value="professional.id">{{ professional.name }}</option>
              </select>
              <div v-else>
                {{ selectedClass.professionals[0].name }}
                <input type="hidden" :name="dayOfWeekField(day.number, 'professional_id')" :value="selectedClass.professionals[0].id">
              </div>
            </td>
            <td class="col-md-3">
              <label :for="dayOfWeekField(day.number, 'hour')">Time:</label>
              <select class="form-control" :name="dayOfWeekField(day.number, 'hour')">
                <option value=""></option>
                <option v-for="time in times" :value="time">{{ time }}:00</option>
              </select>
            </td>
            <td class="col-md-3">
              <label :for="dayOfWeekField(day.number, 'room_id')">Room: </label>
              <select class="form-control" :name="dayOfWeekField(day.number, 'room_id')" v-if="selectedClass.rooms.length > 1">
                <option value=""></option>
                <option v-for="room in selectedClass.rooms" :value="room.id">{{ room.name }}</option>
              </select>
              <div v-else>
                {{ selectedClass.rooms[0].name }}
                <input type="hidden" name="dayOfWeekField(day.number, 'room_id')" :value="selectedClass.rooms[0].id">
              </div>
            </td>
          </tr>
        </table>
      </div>
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
            daysOfWeekArr: [
              { number: 1, name: 'Monday' },
              { number: 2, name: 'Tuesday' },
              { number: 3, name: 'Wednesday' },
              { number: 4, name: 'Thursday' },
              { number: 5, name: 'Friday' },
            ],
            times: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
        }
    },

    computed: {
        daysOfWeek: function() {
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

            return this.daysOfWeekArr.filter(function(day) {
                return day.number <= times
            })
        }
    },

    methods: {
      dayOfWeekField: function(id, name) {
        return "daysOfWeek[" + id + "][" + name + "]";
      },
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