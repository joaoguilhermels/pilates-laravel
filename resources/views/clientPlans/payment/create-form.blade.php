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
      <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</dt>
      <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($clientPlan->start_at)->format('F j, Y') }}</dd>
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

<!-- Payment Component -->
<div class="mb-6">
  <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Payment Information</h3>
  <plan-payment 
    plan-duration="{{ $clientPlan->plan->duration }}" 
    :payment-methods="{{ json_encode($paymentMethods) }}" 
    :bank-accounts="{{ json_encode($bankAccounts) }}" 
    selected-values="" 
    price="{{ $clientPlan->plan->price }}" 
    start-at="{{ $clientPlan->start_at }}">
  </plan-payment>
</div>

<!-- Observation Field -->
<div class="mb-6">
  <label for="observation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
    Observation
  </label>
  <textarea 
    id="observation"
    name="observation" 
    rows="3"
    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
    placeholder="Add any additional notes about this payment...">{{ old('observation') }}</textarea>
</div>

<!-- Submit Button -->
<div class="flex justify-end">
  <button 
    type="submit" 
    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>