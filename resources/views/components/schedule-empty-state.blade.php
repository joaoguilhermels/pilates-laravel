@props(['type', 'createRoute', 'createText'])

<div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 mb-6">
  <div class="flex items-start">
    <div class="flex-shrink-0">
      <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
      </svg>
    </div>
    <div class="ml-4 flex-1">
      <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
        {{ __('app.empty_state_' . $type . '_title') }}
      </h3>
      <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
        <p>{{ __('app.empty_state_' . $type . '_description') }}</p>
      </div>
      <div class="mt-4">
        <div class="flex space-x-3">
          <a href="{{ $createRoute }}" 
             class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-yellow-800 dark:text-yellow-200 bg-yellow-100 dark:bg-yellow-800/30 hover:bg-yellow-200 dark:hover:bg-yellow-800/50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            {{ $createText }}
          </a>
          @if($type === 'comprehensive')
            <a href="{{ route('home') }}" 
               class="inline-flex items-center px-3 py-2 border border-yellow-300 dark:border-yellow-600 text-sm leading-4 font-medium rounded-md text-yellow-700 dark:text-yellow-300 bg-white dark:bg-gray-800 hover:bg-yellow-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors duration-200">
              {{ __('app.setup_guide') }}
            </a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
