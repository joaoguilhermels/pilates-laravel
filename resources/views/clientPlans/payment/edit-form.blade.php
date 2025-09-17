<!-- Plan Information -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
  <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Plan Details</h3>
  <dl class="grid grid-cols-1 gap-x-4 gap-y-4 sm:grid-cols-2">
    <div>
      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Client</dt>
      <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clientPlan->client->name }}</dd>
    </div>
    <div>
      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Class Type</dt>
      <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clientPlan->plan->classType->name }}</dd>
    </div>
    <div>
      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plan</dt>
      <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clientPlan->plan->name }}</dd>
    </div>
    <div>
      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Price</dt>
      <dd class="mt-1 text-sm text-gray-900 dark:text-white">R$ {{ number_format($clientPlan->plan->price, 2, ',', '.') }}/{{ $clientPlan->plan->price_type }}</dd>
    </div>
    <div>
      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Duration</dt>
      <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clientPlan->plan->duration }} {{ $clientPlan->plan->duration_type }}</dd>
    </div>
  </dl>
</div>

<!-- Payment Form -->
<div id="app" class="space-y-6">
  <plan-payment 
    plan-duration="{{ $clientPlan->plan->duration }}" 
    payment-methods="{{ $paymentMethods }}" 
    bank-accounts="{{ $bankAccounts }}" 
    selected-values="{{ $financialTransaction->financialTransactionDetails }}">
  </plan-payment>

  <template id="plan-payment-template">
    <!-- Number of Payments -->
    <div class="mb-6">
      <label for="total_number_of_payments" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
        Number of Payments
      </label>
      <select 
        name="total_number_of_payments" 
        class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
        v-model="numberOfPayments">
        <option v-for="n in 13" v-bind:value="n">@{{ n }}</option>
      </select>
    </div>

    <!-- Payment Details -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
      <div class="px-4 py-5 sm:px-6 bg-gray-50 dark:bg-gray-700">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Payment Details</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
          <thead class="bg-gray-50 dark:bg-gray-700">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment Method</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Bank Account</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Value</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Observation</th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
            <tr v-for="paymentNumber in numberOfPayments" class="hover:bg-gray-50 dark:hover:bg-gray-700">
              <td class="px-6 py-4 whitespace-nowrap">
                <input type="hidden" name="payments[@{{ paymentNumber }}][payment_number]" value="@{{ paymentNumber + 1 }}">
                <input type="hidden" name="payments[@{{ paymentNumber }}][financial_transaction_id]" v-bind:value="payments[paymentNumber].financial_transaction_id">
                <input type="hidden" name="payments[@{{ paymentNumber }}][id]" v-bind:value="payments[paymentNumber].id">
                <select 
                  name="payments[@{{ paymentNumber }}][payment_method_id]" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                  v-model="payments[paymentNumber].payment_method_id">
                  <option value="">Select...</option>
                  <option v-for="paymentMethod in paymentMethodsObjs" v-bind:value="paymentMethod.id">@{{ paymentMethod.name }}</option>
                </select>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <select 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                  name="payments[@{{ paymentNumber }}][bank_account_id]" 
                  v-model="payments[paymentNumber].bank_account_id">
                  <option value="">Select...</option>
                  <option v-for="bankAccount in bankAccountsObjs" v-bind:value="bankAccount.id">@{{ bankAccount.name }}</option>
                </select>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <input 
                  type="date" 
                  name="payments[@{{ paymentNumber }}][date]" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                  v-bind:value="payments[paymentNumber].date">
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <input 
                  type="number" 
                  step="0.01"
                  name="payments[@{{ paymentNumber }}][value]" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                  v-bind:value="payments[paymentNumber].value">
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <input 
                  type="text" 
                  name="payments[@{{ paymentNumber }}][observation]" 
                  class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                  v-bind:value="payments[paymentNumber].observation">
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>

  <!-- General Observation -->
  <div class="mb-6">
    <label for="observation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
      General Observation
    </label>
    <textarea 
      name="observation" 
      rows="3"
      class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
      placeholder="Add any additional notes about this payment...">{{ $financialTransaction->observation }}</textarea>
  </div>

  <!-- Submit Button -->
  <div class="flex justify-end">
    <button 
      type="submit" 
      class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
      <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
      </svg>
      {{ $submitButtonText }}
    </button>
  </div>
</div>
