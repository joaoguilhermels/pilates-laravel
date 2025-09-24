@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="sm:flex sm:items-center">
    <div class="sm:flex-auto">
      <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Professionals</h1>
      <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Manage your studio instructors and staff members.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
      <a href="{{ route('professionals.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        Add Professional
      </a>
    </div>
  </div>

  @if (count($professionals) == 0)
    <!-- Empty State -->
    <div class="text-center py-12">
      <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
      </svg>
      <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No professionals</h3>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding your first instructor or staff member.</p>
      <div class="mt-6">
        <a href="{{ route('professionals.create') }}" class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          Add Professional
        </a>
      </div>
    </div>
  @else
    <!-- Cards Grid -->
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
      @foreach ($professionals as $professional)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg hover:shadow-md transition-shadow">
          <div class="px-4 py-5 sm:p-6">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="h-12 w-12 rounded-full bg-gradient-to-r from-purple-400 to-pink-400 flex items-center justify-center">
                  <span class="text-lg font-semibold text-white">{{ substr($professional->name, 0, 2) }}</span>
                </div>
              </div>
              <div class="ml-4 flex-1">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                  <a href="{{ route('professionals.show', $professional) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">{{ $professional->name }}</a>
                </h3>
                @if($professional->description)
                  <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ \Illuminate\Support\Str::limit($professional->description, 50) }}</p>
                @endif
              </div>
            </div>
            
            <div class="mt-4 space-y-2">
              @if($professional->phone)
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                  <svg class="flex-shrink-0 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  {{ $professional->phone }}
                </div>
              @endif
              
              @if($professional->email)
                <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                  <svg class="flex-shrink-0 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  {{ $professional->email }}
                </div>
              @endif
            </div>
          </div>
          
          <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6">
            <div class="flex justify-between items-center">
              <div class="flex space-x-3">
                <a href="{{ route('professionals.edit', $professional) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                  Edit
                </a>
                <a href="{{ route('professionals.show', $professional) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                  View Details
                </a>
              </div>
              <button type="button" 
                      data-delete-entity="professional"
                      data-delete-id="{{ $professional->id }}"
                      data-delete-name="{{ $professional->name }}"
                      data-delete-url="{{ route('professionals.destroy', $professional) }}"
                      class="text-sm font-medium text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300 transition-colors duration-200">
                Delete
              </button>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>

<!-- Smart Deletion Modal -->
<x-deletion-modal />

@push('scripts')
<script>
// Include deletion protection functionality
document.addEventListener('DOMContentLoaded', function() {
    // Wait a bit for all scripts to load
    setTimeout(function() {
        if (typeof DeletionProtection !== 'undefined') {
            new DeletionProtection();
            console.log('Deletion protection initialized');
        } else {
            console.error('DeletionProtection class not found');
        }
    }, 100);
});
</script>
@endpush
@endsection