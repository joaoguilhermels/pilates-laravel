Vue.component('plan-payment', {
    template: '#plan-payment-template',

    props: ['plan-duration', 'selected-values', 'payment-methods', 'bank-accounts'],

    data: function() {
        return {
            numberOfPayments: parseInt(this.planDuration) || 1,
            paymentMethodsObjs: JSON.parse(this.paymentMethods),
            bankAccountsObjs: JSON.parse(this.bankAccounts),
            payments: JSON.parse(this.selectedValues)
        }
    },
});

var vm = new Vue({
    el: '#app',
});
