@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Smart Breadcrumbs -->
  <x-smart-breadcrumbs :items="[
    ['title' => __('app.clients'), 'url' => route('clients.index')],
    ['title' => $client->name, 'url' => '']
  ]" />

  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $client->name }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('app.client_information_and_plans') }}</p>
      </div>
      <div class="flex space-x-3">
        <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          {{ __('app.back_to_clients') }}
        </a>
        <a href="{{ route('clients.edit', $client) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          {{ __('app.edit_client') }}
        </a>
      </div>
    </div>
  </div>

  <!-- Tabs -->
  <div class="border-b border-gray-200 dark:border-gray-600">
    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
      <button onclick="showTab('info')" id="info-tab" class="border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm tab-button active transition-colors duration-200">
        {{ __('app.client_information') }}
      </button>
      <button onclick="showTab('plans')" id="plans-tab" class="border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:border-gray-300 dark:hover:border-gray-500 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm tab-button transition-colors duration-200">
        {{ __('app.membership_plans') }}
      </button>
    </nav>
  </div>

  <!-- Tab Content -->
  <div class="mt-8">
    <!-- Client Information Tab -->
    <div id="info-content" class="tab-content">
      <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">{{ __('app.client_information') }}</h3>
          <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.name') }}</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->name }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.phone') }}</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->phone ?: __('app.not_provided') }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.email') }}</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->email ?: __('app.not_provided') }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.member_since') }}</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->created_at->format('d/m/Y') }}</dd>
            </div>
            @if($client->observation)
            <div class="sm:col-span-2">
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('app.notes') }}</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->observation }}</dd>
            </div>
            @endif
          </dl>
        </div>
      </div>
    </div>

    <!-- Plans Tab -->
    <div id="plans-content" class="tab-content hidden">
      @include('clients.partials.plans')
    </div>
  </div>
</div>

@push('scripts')
<script>
function showTab(tabName) {
  // Hide all tab contents
  document.querySelectorAll('.tab-content').forEach(content => {
    content.classList.add('hidden');
  });
  
  // Remove active class from all tabs
  document.querySelectorAll('.tab-button').forEach(button => {
    button.classList.remove('active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
    button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
  });
  
  // Show selected tab content
  document.getElementById(tabName + '-content').classList.remove('hidden');
  
  // Add active class to selected tab
  const activeTab = document.getElementById(tabName + '-tab');
  activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
  activeTab.classList.add('active', 'border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
}
</script>
@endpush

@push('styles')
<style>
.tab-button.active {
  border-color: #4F46E5;
  color: #4F46E5;
}

.dark .tab-button.active {
  border-color: #4F46E5;
  color: #818CF8;
}
</style>
@endpush
@endsection