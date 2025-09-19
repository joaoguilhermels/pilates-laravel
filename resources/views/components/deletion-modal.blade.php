{{-- Smart Deletion Confirmation Modal Component --}}
@props([
    'title' => 'Confirm Deletion',
    'entityName' => '',
    'entityType' => '',
    'dependencies' => [],
    'warnings' => [],
    'canDelete' => true,
    'deleteUrl' => '',
    'alternativeActions' => []
])

<div x-data="{ open: false }" x-on:open-deletion-modal.window="open = true">
  <!-- Modal Backdrop -->
  <div x-show="open" 
       x-transition:enter="ease-out duration-300" 
       x-transition:enter-start="opacity-0" 
       x-transition:enter-end="opacity-100" 
       x-transition:leave="ease-in duration-200" 
       x-transition:leave-start="opacity-100" 
       x-transition:leave-end="opacity-0"
       class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"
       x-cloak>
  </div>

  <!-- Modal Dialog -->
  <div x-show="open" 
       x-transition:enter="ease-out duration-300" 
       x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
       x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
       x-transition:leave="ease-in duration-200" 
       x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
       x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
       class="fixed inset-0 z-50 overflow-y-auto"
       x-cloak>
    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
      <div class="relative transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
        
        <!-- Warning Icon -->
        <div class="sm:flex sm:items-start">
          <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full {{ $canDelete ? 'bg-red-100 dark:bg-red-900/20' : 'bg-yellow-100 dark:bg-yellow-900/20' }} sm:mx-0 sm:h-10 sm:w-10">
            @if($canDelete)
              <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
              </svg>
            @else
              <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
              </svg>
            @endif
          </div>
          
          <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
            <!-- Title -->
            <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
              {{ $canDelete ? 'Delete ' . $entityType : 'Cannot Delete ' . $entityType }}
            </h3>
            
            <!-- Entity Name -->
            @if($entityName)
              <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                <strong>{{ $entityName }}</strong>
              </p>
            @endif
            
            <!-- Dependencies Warning -->
            @if(count($dependencies) > 0)
              <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md">
                <div class="flex">
                  <svg class="h-5 w-5 text-yellow-400 mr-2 mt-0.5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                  </svg>
                  <div>
                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                      This {{ $entityType }} has dependencies:
                    </h4>
                    <ul class="mt-1 text-sm text-yellow-700 dark:text-yellow-300 list-disc list-inside">
                      @foreach($dependencies as $dependency)
                        <li>{{ $dependency }}</li>
                      @endforeach
                    </ul>
                  </div>
                </div>
              </div>
            @endif
            
            <!-- Additional Warnings -->
            @if(count($warnings) > 0)
              <div class="mt-3 space-y-2">
                @foreach($warnings as $warning)
                  <div class="p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded text-sm text-red-700 dark:text-red-300">
                    {{ $warning }}
                  </div>
                @endforeach
              </div>
            @endif
            
            <!-- Deletion Message -->
            @if($canDelete)
              <div class="mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                  @if(count($dependencies) > 0)
                    Deleting this {{ $entityType }} will also affect the related items listed above. This action cannot be undone.
                  @else
                    Are you sure you want to delete this {{ $entityType }}? This action cannot be undone.
                  @endif
                </p>
              </div>
            @else
              <div class="mt-3">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                  This {{ $entityType }} cannot be deleted because it has active dependencies. Please consider the alternative actions below.
                </p>
              </div>
            @endif
            
            <!-- Alternative Actions -->
            @if(count($alternativeActions) > 0)
              <div class="mt-4 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-md">
                <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200 mb-2">
                  Alternative Actions:
                </h4>
                <div class="space-y-1">
                  @foreach($alternativeActions as $action)
                    <a href="{{ $action['url'] }}" 
                       class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">
                      <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                      </svg>
                      {{ $action['label'] }}
                    </a>
                  @endforeach
                </div>
              </div>
            @endif
          </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
          @if($canDelete)
            <form action="{{ $deleteUrl }}" method="POST" class="inline">
              @csrf
              @method('DELETE')
              <button type="submit" 
                      class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:ml-3 sm:w-auto transition-colors duration-200">
                Delete {{ $entityType }}
              </button>
            </form>
          @endif
          
          <button type="button" 
                  @click="open = false"
                  class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 sm:mt-0 sm:w-auto transition-colors duration-200">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
