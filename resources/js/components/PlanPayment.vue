<template>
  <div class="space-y-6">
    <!-- Number of Payments -->
    <div>
      <label for="total_number_of_payments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        Number of Payments
      </label>
      <select 
        name="total_number_of_payments" 
        v-model="numberOfPayments"
        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      >
        <option v-for="n in 25" :key="n" :value="n">{{ n }}</option>
      </select>
    </div>

    <!-- Payment Details -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
      <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Payment Details</h3>
      </div>
      
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Payment Method
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Date
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Value
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                Observation
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
            <tr v-for="paymentNumber in numberOfPayments" :key="paymentNumber" class="hover:bg-gray-50 dark:hover:bg-gray-700">
              <td class="px-6 py-4 whitespace-nowrap">
                <input type="hidden" :name="paymentNumberName(paymentNumber)" :value="paymentNumber">
                <select 
                  v-if="paymentMethods.length > 1"
                  :name="paymentMethodName(paymentNumber)" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
                  <option value="">Select method...</option>
                  <option v-for="paymentMethod in paymentMethods" :key="paymentMethod.id" :value="paymentMethod.id">
                    {{ paymentMethod.name }}
                  </option>
                </select>
                <div v-else class="text-sm text-gray-900 dark:text-white">
                  {{ paymentMethods[0]?.name }}
                  <input type="hidden" :name="paymentMethodName(paymentNumber)" :value="paymentMethods[0]?.id">
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <input 
                  type="date" 
                  :name="paymentDateName(paymentNumber)" 
                  :value="startAtValue(startAt, paymentNumber)" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <span class="text-sm text-gray-500 dark:text-gray-400 mr-2">R$</span>
                  <input 
                    type="number" 
                    step="0.01"
                    :name="paymentValueName(paymentNumber)" 
                    :value="price" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  >
                </div>
              </td>
              <td class="px-6 py-4">
                <input 
                  type="text" 
                  :name="paymentObservationName(paymentNumber)" 
                  placeholder="Optional notes..."
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                >
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PlanPayment',
  props: {
    planDuration: {
      type: [String, Number],
      default: 1
    },
    selectedValues: {
      type: String,
      default: ''
    },
    paymentMethods: {
      type: Array,
      default: () => []
    },
    bankAccounts: {
      type: Array,
      default: () => []
    },
    price: {
      type: [String, Number],
      default: 0
    },
    startAt: {
      type: String,
      default: ''
    }
  },

  data() {
    return {
      numberOfPayments: parseInt(this.planDuration) || 1,
      payments: this.selectedValues === "" ? [] : this.parseSelectedValues(this.selectedValues),
    }
  },

  methods: {
    paymentNumberName(paymentNumber) {
      return `payments[${paymentNumber - 1}][payment_number]`;
    },
    paymentMethodName(paymentNumber) {
      return `payments[${paymentNumber - 1}][payment_method_id]`;
    },
    paymentDateName(paymentNumber) {
      return `payments[${paymentNumber - 1}][date]`;
    },
    paymentValueName(paymentNumber) {
      return `payments[${paymentNumber - 1}][value]`;
    },
    paymentObservationName(paymentNumber) {
      return `payments[${paymentNumber - 1}][observation]`;
    },
    parseSelectedValues(selectedValues) {
      try {
        return JSON.parse(selectedValues);
      } catch (e) {
        console.warn('Failed to parse selectedValues:', e);
        return [];
      }
    },
    startAtValue(startAt, paymentNumber) {
      if (!startAt) return '';
      
      if (paymentNumber > 1) {
        const date = new Date(startAt);
        date.setMonth(date.getMonth() + (paymentNumber - 1));
        return date.toISOString().split('T')[0];
      }
      return startAt;
    },
  }
}
</script>
