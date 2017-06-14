<template id="plan-payment-template">
  <div>
    <div class="form-group">
      <label for="total_number_of_payments">Number of Payments:</label>
      <select name="total_number_of_payments" class="form-control" v-model="numberOfPayments">
        <option v-for="n in 25" :value="n">{{ n }}</option>
      </select>
    </div>
    <div id="details" class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Details</h3>
      </div>
      <div class="table-responsive">
        <table class="table table-striped">
          <tr v-for="paymentNumber in numberOfPayments">
            <td class="col-md-3">
              <input type="hidden" :name="paymentNumberName(paymentNumber)" :value="paymentNumber + 1">
              <label :for="paymentMethodName(paymentNumber)">Payment Method: </label>
              <select :name="paymentMethodName(paymentNumber)" class="form-control" v-if="paymentMethods.length > 1">
                <option value=""></option>
                <option v-for="paymentMethod in paymentMethods" :value="paymentMethod.id">{{ paymentMethod.name }}</option>
              </select>
              <div v-else>
                {{ paymentMethods[0].name }}
                <input type="hidden" :name="paymentMethodName(paymentNumber)" :value="paymentMethods[0].id">
              </div>
            </td>
            <td class="col-md-2">
              <label for="date">Date: </label>
              <input type="date" :name="paymentDateName(paymentNumber)" :value="startAtValue(startAt, paymentNumber)" class="form-control">
            </td>
            <td class="col-md-2">
              <label for="room">Value: </label>
              <input type="float" :name="paymentValueName(paymentNumber)" :value="price" class="form-control">
            </td>
            <td class="col-md-5">
              <label for="observation">Observation: </label>
              <input type="text" :name="paymentObservationName(paymentNumber)" class="form-control">
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['plan-duration', 'selected-values', 'payment-methods', 'bank-accounts', 'price', 'start-at'],

    data() {
      return {
          numberOfPayments: parseInt(this.planDuration) || 1,
          payments: this.selectedValues == "" ? "" : JSON.parse(this.selectedValues),
          paymentNumber: 0,
      }
    },

    methods: {
      paymentNumberName: function(paymentNumber) {
        return "payments[" + paymentNumber + "][payment_number]";
      },
      paymentMethodName: function(paymentNumber) {
        return "payments[" + paymentNumber + "][payment_method_id]";
      },
      paymentDateName: function(paymentNumber) {
        return "payments[" + paymentNumber + "][date]";
      },
      paymentValueName: function(paymentNumber) {
        return "payments[" + paymentNumber + "][value]";
      },
      paymentObservationName: function(paymentNumber) {
        return "payments[" + paymentNumber + "][observation]";
      },
      startAtValue(startAt, paymentNumber) {
        if (paymentNumber > 1) {
          var moment = require('moment');
          return moment(startAt).add(paymentNumber - 1, 'month').format('YYYY-MM-DD');
        }
        else {
          return startAt;
        }
      },
    }
  }
</script>