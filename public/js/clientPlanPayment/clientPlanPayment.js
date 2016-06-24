Vue.component('plan-payment', {
    template: '#plan-payment-template',

    data: function() {
        return {
            numberOfPayments: 1
        }
    },
});

var vm = new Vue({
    el: '#app',
});
