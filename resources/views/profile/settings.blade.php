@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Settings</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Manage your application preferences and studio settings.</p>
      </div>
      <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Profile
      </a>
    </div>
  </div>

  <div class="space-y-6">
    <!-- Studio Information -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Studio Information</h3>
        
        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
          <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Studio Name</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ config('app.name', 'Pilates Studio') }}</dd>
          </div>
          
          <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Application Version</dt>
            <dd class="mt-1 text-sm text-gray-900 dark:text-white">Laravel {{ app()->version() }}</dd>
          </div>
          
          <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Environment</dt>
            <dd class="mt-1">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ config('app.env') === 'production' ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200' : 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200' }}">
                {{ ucfirst(config('app.env')) }}
              </span>
            </dd>
          </div>
          
          <div>
            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Debug Mode</dt>
            <dd class="mt-1">
              <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ config('app.debug') ? 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200' : 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200' }}">
                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
              </span>
            </dd>
          </div>
        </dl>
      </div>
    </div>

    <!-- System Statistics -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">System Statistics</h3>
        
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          <div class="bg-gray-50 dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Clients</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ \App\Models\Client::count() }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Professionals</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ \App\Models\Professional::count() }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total Sessions</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ \App\Models\Schedule::count() }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <div class="bg-gray-50 dark:bg-gray-700 overflow-hidden shadow-sm rounded-lg border border-gray-200 dark:border-gray-600">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="h-6 w-6 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                  </svg>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Rooms</dt>
                    <dd class="text-lg font-medium text-gray-900 dark:text-white">{{ \App\Models\Room::count() }}</dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
      <div class="px-4 py-5 sm:p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Quick Management</h3>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
          <a href="{{ route('classes.index') }}" class="relative group bg-white dark:bg-gray-800 p-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200">
            <div class="flex items-center space-x-3">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400 dark:text-gray-300 group-hover:text-gray-500 dark:group-hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Manage Class Types</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configure available classes</p>
              </div>
            </div>
          </a>

          <a href="{{ route('rooms.index') }}" class="relative group bg-white dark:bg-gray-800 p-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200">
            <div class="flex items-center space-x-3">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400 dark:text-gray-300 group-hover:text-gray-500 dark:group-hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Manage Rooms</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configure studio spaces</p>
              </div>
            </div>
          </a>

          <a href="{{ route('plans.index') }}" class="relative group bg-white dark:bg-gray-800 p-4 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-500 rounded-lg border border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500 transition-colors duration-200">
            <div class="flex items-center space-x-3">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-gray-400 dark:text-gray-300 group-hover:text-gray-500 dark:group-hover:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
              </div>
              <div>
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Manage Plans</h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">Configure membership plans</p>
              </div>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
