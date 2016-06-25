Vue.component('plan-payment', {
    template: '#plan-payment-template',

    props: ['plan-duration'],

    data: function() {
        return {
            numberOfPayments: parseInt(this.planDuration) || 1
        }
    },
});

var vm = new Vue({
    el: '#app',
});
