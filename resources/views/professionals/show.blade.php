@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $professional->name }}</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Professional Details</p>
      </div>
      <div class="flex items-center space-x-3">
        <a href="{{ route('professionals.edit', $professional->id) }}" 
           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          Edit {{ $professional->name }}
        </a>
        <a href="{{ route('professionals.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Back to Professionals
        </a>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Professional Information -->
    <div class="lg:col-span-2">
      <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Professional Information</h2>
        </div>
        <div class="px-6 py-6">
          <dl class="space-y-6">
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                @if($professional->phone)
                  <a href="tel:{{ $professional->phone }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                    {{ $professional->phone }}
                  </a>
                @else
                  <span class="text-gray-400 dark:text-gray-500">Not provided</span>
                @endif
              </dd>
            </div>
            
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                @if($professional->email)
                  <a href="mailto:{{ $professional->email }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
                    {{ $professional->email }}
                  </a>
                @else
                  <span class="text-gray-400 dark:text-gray-500">Not provided</span>
                @endif
              </dd>
            </div>
            
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Observation</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                @if($professional->description)
                  <p class="whitespace-pre-wrap">{{ $professional->description }}</p>
                @else
                  <span class="text-gray-400 dark:text-gray-500">No observations</span>
                @endif
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </div>

    <!-- Classes Sidebar -->
    <div class="lg:col-span-1">
      @include('professionals.partials.classes-block')
    </div>
  </div>
</div>
@endsection