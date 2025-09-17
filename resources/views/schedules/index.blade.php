@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Schedules</h1>
      <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Manage class schedules and sessions for your studio.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
      <a href="{{ route('schedules.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add Schedule
      </a>
    </div>
  </div>

  @if (count($schedules) == 0)
    <!-- Empty State -->
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No schedules</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first class schedule.</p>
      <div class="mt-6">
        <a href="{{ route('schedules.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add Schedule
        </a>
      </div>
    </div>
  @else
    <!-- Timeline View -->
    <div class="mt-8">
      @foreach ($schedules as $date => $daySchedules)
        <div class="mb-8">
          <!-- Date Header -->
          <div class="flex items-center mb-4">
            <div class="flex-shrink-0">
              <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
              </div>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $date }}</h3>
              <p class="text-sm text-gray-500 dark:text-gray-400">{{ count($daySchedules) }} sessions scheduled</p>
            </div>
          </div>

          <!-- Sessions List -->
          <div class="ml-16 space-y-4">
            @foreach ($daySchedules as $schedule)
              <div class="bg-white dark:bg-gray-800 shadow rounded-lg hover:shadow-md transition-shadow">
                <div class="px-6 py-4">
                  <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                      <!-- Time -->
                      <div class="flex-shrink-0">
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                          {{ \Carbon\Carbon::parse($schedule->start_at)->format('H:i') }}
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                          {{ \Carbon\Carbon::parse($schedule->end_at)->format('H:i') }}
                        </div>
                      </div>

                      <!-- Class Info -->
                      <div class="flex-1 min-w-0">
                        <div class="flex items-center space-x-2">
                          <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                            <a href="{{ route('schedules.show', $schedule) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                              {{ $schedule->classType->name ?? 'Class' }}
                            </a>
                          </h4>
                          @if($schedule->classTypeStatus)
                            @php
                              $statusColors = [
                                'scheduled' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'pending' => 'bg-yellow-100 text-yellow-800'
                              ];
                              $statusClass = $statusColors[strtolower($schedule->classTypeStatus->name)] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                              {{ $schedule->classTypeStatus->name }}
                            </span>
                          @endif
                        </div>
                        <div class="mt-1 flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                          @if($schedule->client)
                            <span class="flex items-center">
                              <svg class="flex-shrink-0 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                              </svg>
                              {{ $schedule->client->name }}
                            </span>
                          @endif
                          @if($schedule->professional)
                            <span class="flex items-center">
                              <svg class="flex-shrink-0 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                              </svg>
                              {{ $schedule->professional->name }}
                            </span>
                          @endif
                          @if($schedule->room)
                            <span class="flex items-center">
                              <svg class="flex-shrink-0 mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                              </svg>
                              {{ $schedule->room->name }}
                            </span>
                          @endif
                        </div>
                      </div>

                      <!-- Price -->
                      @if($schedule->price)
                        <div class="flex-shrink-0">
                          <span class="text-sm font-medium text-gray-900">${{ number_format($schedule->price, 2) }}</span>
                        </div>
                      @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                      <a href="{{ route('schedules.edit', $schedule) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                        Edit
                      </a>
                      <form action="{{ route('schedules.destroy', $schedule) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium">
                          Delete
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection
