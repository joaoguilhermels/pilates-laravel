@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="sm:flex sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Membership Plans</h1>
        <p class="mt-1 text-sm text-gray-600">Manage your studio's membership plans and pricing.</p>
      </div>
      <div class="mt-4 sm:mt-0">
        <a href="{{ route('plans.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add New Plan
        </a>
      </div>
    </div>
  </div>

  @if(count($plans) == 0)
    <!-- Empty State -->
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900">No plans</h3>
      <p class="mt-1 text-sm text-gray-500">Get started by creating your first membership plan.</p>
      <div class="mt-6">
        <a href="{{ route('plans.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add Plan
        </a>
      </div>
    </div>
  @else
    <!-- Plans Grid -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2 xl:grid-cols-3">
      @foreach($plans as $plan)
        <div class="bg-white overflow-hidden shadow rounded-lg border border-gray-200">
          <div class="p-6">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-900">
                  <a href="{{ route('plans.show', $plan) }}" class="hover:text-indigo-600">
                    {{ $plan->name }}
                  </a>
                </h3>
                <p class="text-sm text-gray-500 mt-1">{{ $plan->classType->name ?? 'General' }}</p>
              </div>
              <div class="flex-shrink-0">
                <div class="h-10 w-10 bg-green-100 rounded-lg flex items-center justify-center">
                  <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
              </div>
            </div>
            
            <div class="mt-4 space-y-2">
              <div class="flex justify-between text-sm">
                <span class="text-gray-500">Price:</span>
                <span class="font-medium">${{ number_format($plan->price, 2) }} per {{ $plan->price_type ?? 'session' }}</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-500">Sessions:</span>
                <span class="font-medium">{{ $plan->times }} per {{ $plan->times_type ?? 'month' }}</span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-500">Duration:</span>
                <span class="font-medium">{{ $plan->duration }} {{ $plan->duration_type ?? 'days' }}</span>
              </div>
            </div>
            
            <div class="mt-6 flex justify-between items-center">
              <div class="flex space-x-2">
                <a href="{{ route('plans.edit', $plan) }}" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  Edit
                </a>
                <form action="{{ route('plans.destroy', $plan) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this plan?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 shadow-sm text-xs font-medium rounded text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="-ml-0.5 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
