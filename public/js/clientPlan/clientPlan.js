Vue.component('plans', {
    template: '#plans-template',

    props: ['list'],

    data: function() {
        return {
            selectedPlan: [],
            daysOfWeek: [0, 1, 2, 3, 4]
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
                return day < times
            })
        }
    }
});

Vue.config.debug = true

var vm = new Vue({
    el: '#app',
});
