<div class="space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">{{ __('app.membership_plans') }}</h3>
    <a href="/clients/{{ $client->id }}/plans/create" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
      <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      {{ __('app.add_new_plan') }}
    </a>
  </div>

  @if($client->clientPlans->count() > 0)
    <!-- Plans Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
      @foreach($client->clientPlans as $clientPlan)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <!-- Plan Header -->
            <div class="flex items-center justify-between mb-4">
              <div>
                <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $clientPlan->plan->classType->name }}</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $clientPlan->plan->name }}</p>
              </div>
              <div class="flex items-center space-x-2">
                @if ($clientPlan->financialTransactions->count() > 0)
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200">
                    {{ __('app.paid') }}
                  </span>
                @else
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200">
                    {{ __('app.payment_pending') }}
                  </span>
                @endif
              </div>
            </div>

            <!-- Plan Details -->
            <div class="space-y-3">
              <div>
                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.start_date') }}</dt>
                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($clientPlan->start_at)->format('d/m/Y') }}</dd>
              </div>

              @if($clientPlan->clientPlanDetails->count() > 0)
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.schedule_details') }}</dt>
                  <dd class="mt-1 space-y-1">
                    @foreach($clientPlan->clientPlanDetails as $detail)
                      <div class="text-sm text-gray-900 dark:text-white bg-gray-50 dark:bg-gray-700 rounded-md px-3 py-2">
                        <div class="flex items-center justify-between">
                          <span class="font-medium">{{ ucfirst($detail->day_of_week) }}</span>
                          <span>{{ \Carbon\Carbon::parse($detail->hour)->format('H:i') }}</span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                          {{ $detail->professional->name }} • {{ $detail->room->name }}
                        </div>
                      </div>
                    @endforeach
                  </dd>
                </div>
              @endif

              @if($client->schedules->where('client_id', $client->id)->count() > 0)
                <div>
                  <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.last_session') }}</dt>
                  <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                    {{ $client->schedules->sortByDesc('start_at')->first()->start_at->format('d/m/Y H:i') }}
                  </dd>
                </div>
              @endif
            </div>
          </div>

          <!-- Actions -->
          <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6">
            <div class="flex items-center justify-between">
              <div class="flex space-x-3">
                @if ($clientPlan->financialTransactions->count() == 0)
                  <a href="{{ action('ClientPlanPaymentsController@create', [$clientPlan->id]) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
                    {{ __('app.add_payment') }}
                  </a>
                @else
                  <a href="{{ action('ClientPlanPaymentsController@show', [$clientPlan->financialTransactions->first()->id]) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
                    {{ __('app.view_payment') }}
                  </a>
                  <a href="{{ action('ClientPlanPaymentsController@edit', [$clientPlan->financialTransactions->first()->id]) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
                    {{ __('app.edit_payment') }}
                  </a>
                @endif
                <a href="{{ action('ClientPlansController@edit', [$clientPlan->id]) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
                  {{ __('app.edit_plan') }}
                </a>
              </div>
              <form action="{{ action('ClientPlansController@destroy', [$clientPlan->id]) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('app.delete_plan_confirmation') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300 transition-colors duration-200">
                  {{ __('app.delete') }}
                </button>
              </form>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <!-- Empty State -->
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('app.no_membership_plans') }}</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('app.get_started_membership_plan') }}</p>
      <div class="mt-6">
        <a href="/clients/{{ $client->id }}/plans/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          {{ __('app.add_first_plan') }}
        </a>
      </div>
    </div>
  @endif
</div>
