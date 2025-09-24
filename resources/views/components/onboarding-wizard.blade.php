{{-- Onboarding Wizard Component --}}
@props(['onboardingStatus'])

@if($onboardingStatus['needsOnboarding'])
<div class="mb-8">
  
  @if($onboardingStatus['isNewUser'])
    <!-- Simplified Welcome Banner -->
    <div id="onboarding-banner" 
         class="mb-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg overflow-hidden">
      <div class="px-6 py-4">
        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <div class="ml-4">
              <h3 class="text-lg font-semibold text-white">
                Welcome to Your Pilates Studio! 🎉
              </h3>
              <p class="text-indigo-100 text-sm">
                Let's get your studio set up in just a few minutes.
              </p>
            </div>
          </div>
          <div class="flex items-center space-x-3">
            <button onclick="startOnboarding()" 
                    class="px-4 py-2 text-sm font-medium text-indigo-600 bg-white rounded-md hover:bg-gray-50 transition-colors duration-200">
              Get Started
            </button>
            <button onclick="skipOnboarding()" 
                    class="text-indigo-200 hover:text-white text-sm">
              Skip for now
            </button>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Setup Progress Card -->
  <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg overflow-hidden">
    <div class="px-6 py-4">
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-lg font-semibold text-white">
              Studio Setup Progress
            </h3>
            <p class="text-indigo-100">
              {{ $onboardingStatus['completedCount'] }} of {{ $onboardingStatus['totalSteps'] }} steps completed
            </p>
          </div>
        </div>
        
        <div class="text-right">
          <div class="text-2xl font-bold text-white">{{ $onboardingStatus['progress'] }}%</div>
          <div class="w-24 bg-indigo-400 rounded-full h-2 mt-1">
            <div class="bg-white rounded-full h-2 transition-all duration-500" 
                 style="width: {{ $onboardingStatus['progress'] }}%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @if(count($onboardingStatus['nextSteps']) > 0)
    <!-- Simplified Setup Steps -->
    <div id="setup-steps" class="mt-6">
      <div class="mb-4">
        <h4 class="text-lg font-medium text-gray-900 dark:text-white">Quick Setup</h4>
        <p class="text-sm text-gray-600 dark:text-gray-400">
          Complete these essential steps to get started.
        </p>
      </div>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach($onboardingStatus['nextSteps'] as $index => $step)
            <div class="relative group">
              <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-indigo-300 dark:hover:border-indigo-500 transition-all duration-200 hover:shadow-md">
                <div class="flex items-start">
                  <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                      @switch($step['icon'])
                        @case('users')
                          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                          </svg>
                          @break
                        @case('home')
                          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
                          </svg>
                          @break
                        @case('academic-cap')
                          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                          </svg>
                          @break
                        @case('currency-dollar')
                          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                          </svg>
                          @break
                        @case('user-group')
                          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                          </svg>
                          @break
                        @case('calendar')
                          <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                          </svg>
                          @break
                      @endswitch
                    </div>
                  </div>
                  <div class="ml-3 flex-1">
                    <h5 class="text-sm font-medium text-gray-900 dark:text-white">
                      {{ $step['title'] }}
                    </h5>
                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                      {{ $step['description'] }}
                    </p>
                    <div class="mt-3">
                      <a href="{{ $step['url'] }}?onboarding=1" 
                       class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">
                      {{ $step['action'] }}
                      </a>
                      <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                      </svg>
                    </div>
                  </div>
                </div>
                
                <!-- Step Number Badge -->
                <div class="absolute -top-2 -right-2 w-6 h-6 bg-indigo-500 text-white rounded-full flex items-center justify-center text-xs font-bold">
                  {{ $index + 1 }}
                </div>
              </div>
            </div>
          @endforeach
        </div>
        
        <!-- Quick Action Buttons -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
          <div class="flex flex-wrap gap-3">
            <a href="{{ route('professionals.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors duration-200">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
              </svg>
              Quick Start: Add Instructor
            </a>
            <a href="{{ route('rooms.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors duration-200">
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
              </svg>
              Add Room
            </a>
            <button type="button" 
                    @click="if(confirm('Are you sure you want to skip the setup guide? You can access it later from the help menu.')) { skipOnboarding(); }"
                    class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors duration-200">
              Skip Setup Guide
            </button>
          </div>
        </div>
      </div>
    </div>
  @else
    <!-- Setup Complete -->
    <div class="mt-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
      <div class="flex items-center">
        <div class="flex-shrink-0">
          <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <div class="ml-4">
          <h3 class="text-lg font-medium text-green-800 dark:text-green-200">
            🎉 Setup Complete! Your studio is ready to go.
          </h3>
          <p class="text-green-700 dark:text-green-300 mt-1">
            You've completed all the essential setup steps. Your Pilates studio management system is now fully configured and ready for daily operations.
          </p>
        </div>
      </div>
    </div>
  @endif
</div>

{{-- JavaScript functions are now defined globally in app.js --}}
@endif
