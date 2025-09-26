@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  @php
    $user = Auth::user();
    $isStudioOwner = method_exists($user, 'hasRole') && $user->hasRole('studio_owner');
    $isProfessional = method_exists($user, 'hasRole') && $user->hasRole('studio_professional');
    $needsOnboarding = !$user->onboarding_completed;
  @endphp

  <!-- Page Header with Context -->
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
          @if($needsOnboarding)
            {{ __('app.welcome_pilatesflow') }}
          @else
            {{ __('app.dashboard') }}
          @endif
        </h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
          @if($needsOnboarding)
            {{ __('app.setup_studio_steps') }}
          @else
            {{ __('app.welcome') }}, {{ $user->name }}! 
            @if($isStudioOwner)
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 dark:bg-purple-900/20 text-purple-800 dark:text-purple-200 ml-2">
                {{ __('app.studio_owner') }}
              </span>
            @elseif($isProfessional)
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200 ml-2">
                {{ __('app.professional_badge') }}
              </span>
            @endif
          @endif
        </p>
      </div>
      
      @if(!$needsOnboarding)
        <div class="flex items-center space-x-3">
          <a href="{{ route('calendar') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
            <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            {{ __('app.calendar') }}
          </a>
        </div>
      @endif
    </div>
  </div>

  <!-- Session Messages -->
  @if (session('status'))
    <div class="mb-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-green-800 dark:text-green-200">{{ session('status') }}</p>
        </div>
      </div>
    </div>
  @endif

  @if (session('onboarding_success'))
    <div class="mb-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ session('onboarding_success') }}</p>
        </div>
      </div>
    </div>
  @endif

  @if($needsOnboarding)
    <!-- Onboarding Flow - Priority #1 -->
    <div class="mb-8">
      <x-onboarding-wizard :onboarding-status="$onboardingStatus" />
      <div class="mt-6">
        <x-onboarding-progress :user="$user" />
      </div>
    </div>
  @else
    <!-- Main Dashboard Content -->
    <div class="space-y-6">
      
      <!-- Smart Insights -->
      <x-smart-insights />
      
      <!-- Today's Overview Card -->
      <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
          <div>
            <h2 class="text-lg font-semibold">{{ __('app.today_date', ['date' => now()->format('d/m/Y')]) }}</h2>
            <p class="text-indigo-100 mt-1">
              @if($stats['today_schedules'] > 0)
                {{ trans_choice('app.classes_scheduled_today', $stats['today_schedules'], ['count' => $stats['today_schedules']]) }}
              @else
                {{ __('app.no_classes_today') }}
              @endif
            </p>
          </div>
          <div class="text-right">
            <div class="text-2xl font-bold">{{ $stats['today_schedules'] }}</div>
            <div class="text-indigo-100 text-sm">{{ __('app.classes_today') }}</div>
          </div>
        </div>
        @if($stats['upcoming_schedules'] > 0)
          <div class="mt-4 pt-4 border-t border-indigo-400">
            <p class="text-indigo-100 text-sm">
              {{ __('app.upcoming_classes_days', ['count' => $stats['upcoming_schedules']]) }}
            </p>
          </div>
        @endif
      </div>

      @if($isStudioOwner)
        <!-- Studio Owner Dashboard -->
        
        <!-- Key Metrics Row -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <!-- Clients Card -->
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['clients'] }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.clients') }}</div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
              <a href="{{ route('clients.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('app.view_all') }} →
              </a>
            </div>
          </div>

          <!-- Professionals Card -->
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['professionals'] }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.professionals') }}</div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
              <a href="{{ route('professionals.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('app.view_all') }} →
              </a>
            </div>
          </div>

          <!-- Plans Card -->
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow duration-200">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['plans'] }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.plans') }}</div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
              <a href="{{ route('plans.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('app.view_all') }} →
              </a>
            </div>
          </div>
        </div>

        <!-- Feature Limits for Studio Owners -->
        <x-feature-limits :user="$user" />

      @elseif($isProfessional)
        <!-- Professional Dashboard -->
        
        <!-- Professional Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <!-- My Clients -->
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['clients'] }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.my_clients') }}</div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
              <a href="{{ route('clients.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('app.view_clients') }} →
              </a>
            </div>
          </div>

          <!-- My Schedule -->
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-4 flex-1">
                  <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['upcoming_schedules'] }}</div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.upcoming_classes') }}</div>
                </div>
              </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
              <a href="{{ route('schedules.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                {{ __('app.view_schedule') }} →
              </a>
            </div>
          </div>
        </div>

      @endif

      <!-- Quick Actions Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
          <div class="px-6 py-5">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('app.quick_actions') }}</h3>
            <div class="space-y-3">
              @if($isStudioOwner)
                <a href="{{ route('clients.create') }}" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                  <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                      <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.add_client') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('app.register_new_client') }}</p>
                  </div>
                </a>
                <a href="{{ route('professionals.create') }}" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                  <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                      <svg class="h-4 w-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                      </svg>
                    </div>
                  </div>
                  <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.add_professional') }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('app.register_new_instructor') }}</p>
                  </div>
                </a>
              @endif
              
              <a href="{{ route('schedules.create') }}" class="flex items-center p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <div class="flex-shrink-0">
                  <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                    <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                  </div>
                </div>
                <div class="ml-3">
                  <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.new_class') }}</p>
                  <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('app.schedule_new_session') }}</p>
                </div>
              </a>
            </div>
          </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
          <div class="px-6 py-5">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('app.upcoming_classes_section') }}</h3>
            
            @if(count($recentActivity['upcoming_schedules']) > 0)
              <div class="space-y-3">
                @foreach($recentActivity['upcoming_schedules'] as $schedule)
                  <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="flex items-center space-x-3">
                      <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/20 rounded-full flex items-center justify-center">
                          <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                        </div>
                      </div>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                          {{ $schedule->classType->name ?? __('app.class_fallback') }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                          {{ $schedule->client->name ?? __('app.client_not_defined') }}
                          @if($schedule->professional)
                            • {{ $schedule->professional->name }}
                          @endif
                        </p>
                      </div>
                    </div>
                    <div class="text-right">
                      <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $schedule->start_at->format('d/m') }}
                      </p>
                      <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $schedule->start_at->format('H:i') }}
                      </p>
                    </div>
                  </div>
                @endforeach
              </div>
              <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('schedules.index') }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                  {{ __('app.view_all_classes') }} →
                </a>
              </div>
            @else
              <div class="text-center py-6">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('app.no_classes_scheduled') }}</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('app.start_first_class') }}</p>
                <div class="mt-4">
                  <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('app.schedule_class') }}
                  </a>
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
@endsection
