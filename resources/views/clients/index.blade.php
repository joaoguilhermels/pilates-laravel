@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('app.clients') }}</h1>
      <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ __('app.manage_clients') }}</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
      <a href="{{ route('clients.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        {{ __('app.add_client') }}
      </a>
    </div>
  </div>

  @if ($clients->total() == 0)
    <!-- Empty State -->
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">No clients</h3>
      <p class="mt-1 text-sm text-gray-500">Get started by creating your first client.</p>
      <div class="mt-6">
        <a href="{{ route('clients.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add Client
        </a>
      </div>
    </div>
  @else
    <!-- Search Bar -->
    <div class="mt-8 mb-6">
      <form action="{{ route('clients.index') }}" method="GET" class="flex gap-4">
        <div class="flex-1">
          <label for="name" class="sr-only">Search clients</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
              </svg>
            </div>
            <input type="text" name="name" value="{{ $name ?? '' }}" class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Search clients by name...">
          </div>
        </div>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Search
        </button>
      </form>
    </div>

    <!-- Table -->
    <div class="mt-8 flex flex-col">
      <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 dark:ring-gray-600 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white sm:pl-6">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Email</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Reschedules</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Plans</th>
                  <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 dark:divide-gray-600 bg-white dark:bg-gray-800">
                @forelse ($clients as $client)
                  <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                      <div class="flex items-center">
                        <div class="h-10 w-10 flex-shrink-0">
                          <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                            <span class="text-sm font-medium text-indigo-700">{{ substr($client->name, 0, 2) }}</span>
                          </div>
                        </div>
                        <div class="ml-4">
                          <div class="font-medium text-gray-900 dark:text-white">
                            <a href="{{ route('clients.show', $client) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">{{ $client->name }}</a>
                          </div>
                          @if (!empty($client->phone))
                            <div class="text-gray-500 dark:text-gray-400">{{ $client->phone }}</div>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $client->email }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                      @if($client->schedules->count() > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                          {{ $client->schedules->count() }} pending
                        </span>
                      @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          Up to date
                        </span>
                      @endif
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400">
                      @if($client->clientPlans->count() > 0)
                        <div class="space-y-1">
                          @foreach($client->clientPlans->take(2) as $clientPlan)
                            @php
                              $startDate = \Carbon\Carbon::parse($clientPlan->start_at);
                              $isRecent = $startDate->isAfter(now()->subMonths(3));
                              $badgeColor = $isRecent ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800';
                            @endphp
                            <div class="flex items-center space-x-2">
                              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $badgeColor }}">
                                {{ $clientPlan->plan->name ?? 'Unknown Plan' }}
                              </span>
                              <span class="text-xs text-gray-400">
                                {{ $startDate->format('M Y') }}
                              </span>
                              @if($isRecent)
                                <span class="inline-flex items-center text-xs text-green-600">
                                  <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                  </svg>
                                  Active
                                </span>
                              @endif
                            </div>
                          @endforeach
                          @if($client->clientPlans->count() > 2)
                            <div class="text-xs text-gray-400">
                              +{{ $client->clientPlans->count() - 2 }} more plans
                            </div>
                          @endif
                        </div>
                      @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                          No plans
                        </span>
                      @endif
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                      <div class="flex justify-end space-x-2">
                        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-900" title="View client details and plans">View</a>
                        <a href="{{ route('clients.plans.create', $client) }}" class="text-indigo-600 hover:text-indigo-900" title="Add new plan">Add Plan</a>
                        <a href="{{ route('clients.edit', $client) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit client information">Edit</a>
                        <button type="button" 
                                data-delete-entity="client"
                                data-delete-id="{{ $client->id }}"
                                data-delete-name="{{ $client->name }}"
                                data-delete-url="{{ route('clients.destroy', $client) }}"
                                class="text-red-600 hover:text-red-900 transition-colors duration-200" 
                                title="Delete client">
                          Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No clients found</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $clients->links() }}
    </div>
  @endif
</div>

<!-- Smart Deletion Modal -->
<x-deletion-modal />

@push('scripts')
<script>
// Include deletion protection functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize deletion protection
    if (typeof DeletionProtection !== 'undefined') {
        new DeletionProtection();
    }
});
</script>
@endpush
@endsection
