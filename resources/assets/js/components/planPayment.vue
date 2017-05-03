<template id="plan-payment-template">
  <div>
    <div class="form-group">
      <label for="total_number_of_payments">Number of Payments:</label>
      <select name="total_number_of_payments" class="form-control" v-model="numberOfPayments">
        <option v-for="n in 25" v-bind:value="n">{{ n }}</option>
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
              <input type="hidden" :name="payments[paymentNumber][payment_number]" :value="paymentNumber + 1">
              <label :for="payments[paymentNumber][payment_method_id]">Payment Method: </label>
              <select :name="payments[paymentNumber][payment_method_id]" class="form-control" v-if="paymentMethodsObjs.length > 1">
                <option value=""></option>
                <option v-for="paymentMethod in paymentMethodsObjs" :value="paymentMethod.id">{{ paymentMethod.name }}</option>
              </select>
              <div v-else>
                {{ paymentMethodsObjs[0].name }}
                <input type="hidden" :name="payments[paymentNumber][payment_method_id]" :value="paymentMethodsObjs[0].id">
              </div>
            </td>
            <td class="col-md-2">
              <label for="date">Date: </label>
              <input type="date" :name="payments[paymentNumber][date]" :value="startAt" class="form-control">
            </td>
            <td class="col-md-2">
              <label for="room">Value: </label>
              <input type="float" :name="payments[paymentNumber][value]" :value="price" class="form-control">
            </td>
            <td class="col-md-5">
              <label for="observation">Observation: </label>
              <input type="text" :name="payments[paymentNumber][observation]" class="form-control">
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

    data: function() {
      return {
          numberOfPayments: parseInt(this.planDuration) || 1,
          paymentMethodsObjs: JSON.parse(this.paymentMethods),
          bankAccountsObjs: JSON.parse(this.bankAccounts),
          payments: this.selectedValues == "" ? "" : JSON.parse(this.selectedValues),
          startAt: this.startAt
      }
    }
  }
</script>