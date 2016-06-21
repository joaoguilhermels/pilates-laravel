Vue.component('plan-payment', {
    template: '#plan-payment-template',

    data: function() {
        return {
            numberOfPayments: 1
        }
    },

    filters: {
        selectNumberOfPayments: function(numberOfPayments) {
            return this.numberOfPayments.filter(function(day) {
                return day < numberOfPayments
            })
        }
    }
});

var vm = new Vue({
    el: '#app',
});
