@props(['professional', 'impactAnalysis'])

@if($impactAnalysis['hasImpact'])
<div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg p-6 mb-6">
  <div class="flex items-start">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
      </svg>
    </div>
    <div class="ml-3 flex-1">
      <h3 class="text-sm font-medium text-amber-800 dark:text-amber-200">Impact Warning</h3>
      <div class="mt-2 text-sm text-amber-700 dark:text-amber-300">
        <p class="mb-3">Changing this professional's class types will affect existing schedules:</p>
        
        @if($impactAnalysis['futureSchedules'] > 0)
        <div class="bg-white dark:bg-amber-900/40 rounded-md p-3 mb-3">
          <div class="flex items-center">
            <svg class="h-4 w-4 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span class="font-medium">{{ $impactAnalysis['futureSchedules'] }} future classes</span>
            <span class="ml-2">will be affected</span>
          </div>
          
          @if(count($impactAnalysis['affectedClassTypes']) > 0)
          <div class="mt-2">
            <p class="text-xs text-amber-600 dark:text-amber-400 mb-1">Affected class types:</p>
            <div class="flex flex-wrap gap-1">
              @foreach($impactAnalysis['affectedClassTypes'] as $classType)
              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 dark:bg-amber-800 text-amber-800 dark:text-amber-200">
                {{ $classType['name'] }} ({{ $classType['count'] }} classes)
              </span>
              @endforeach
            </div>
          </div>
          @endif
        </div>
        @endif
        
        @if($impactAnalysis['orphanedSchedules'] > 0)
        <div class="bg-red-50 dark:bg-red-900/40 rounded-md p-3 mb-3">
          <div class="flex items-center">
            <svg class="h-4 w-4 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="font-medium text-red-700 dark:text-red-300">{{ $impactAnalysis['orphanedSchedules'] }} schedules</span>
            <span class="ml-2 text-red-700 dark:text-red-300">will become orphaned</span>
          </div>
          <p class="mt-1 text-xs text-red-600 dark:text-red-400">
            These classes are for class types being removed from this professional
          </p>
        </div>
        @endif
        
        <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/40 rounded-md">
          <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">What happens next?</h4>
          <ul class="text-xs text-blue-700 dark:text-blue-300 space-y-1">
            <li>• Affected schedules will be flagged for review</li>
            <li>• You can reassign classes to other professionals</li>
            <li>• Clients will be notified of any changes</li>
            <li>• Financial records will be preserved</li>
          </ul>
        </div>
        
        <div class="mt-4 flex items-center space-x-3">
          <label class="flex items-center">
            <input type="checkbox" name="confirm_changes" required 
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded">
            <span class="ml-2 text-sm text-amber-700 dark:text-amber-300">
              I understand the impact and want to proceed
            </span>
          </label>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

@if($impactAnalysis['hasRecommendations'])
<div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-6">
  <div class="flex items-start">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
      </svg>
    </div>
    <div class="ml-3">
      <h3 class="text-sm font-medium text-green-800 dark:text-green-200">Recommendations</h3>
      <div class="mt-2 text-sm text-green-700 dark:text-green-300">
        @foreach($impactAnalysis['recommendations'] as $recommendation)
        <div class="flex items-start mb-2">
          <span class="inline-block w-1 h-1 bg-green-400 rounded-full mt-2 mr-2 flex-shrink-0"></span>
          <span>{{ $recommendation }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif
