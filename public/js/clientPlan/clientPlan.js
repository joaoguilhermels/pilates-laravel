Vue.component('plans', {
    template: '#plans-template',

    props: ['list'],

    data: function() {
        return {
            selectedPlan: [],
            daysOfWeek: [
              { number: 0, name: 'Monday' },
              { number: 1, name: 'Tuesday' },
              { number: 2, name: 'Wednesday' },
              { number: 3, name: 'Thursday' },
              { number: 4, name: 'Friday' },
            ],
            times: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]
        }
    },

    created () {
        this.list = JSON.parse(this.list);
    },

    filters: {
        selectPlan: function(plan) {
            var times = 0,
                self = this

            if (typeof self.selectedPlan !== 'object') {
                self.list.forEach(function(classType) {
                    classType.plans.forEach(function(classTypePlan) {
                        if (classTypePlan.id == self.selectedPlan) {
                            times = classTypePlan.times
                        }
                    })
                })
            }

            return plan.filter(function(day) {
                return day.number < times
            })
        }
    }
});

var vm = new Vue({
    el: '#app',
});
