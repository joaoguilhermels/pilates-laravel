@extends('layouts.dashboard')

@section('content')T
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Smart Breadcrumbs -->
  <x-smart-breadcrumbs :items="[
    ['title' => __('app.schedules'), 'url' => route('schedules.index')],
    ['title' => __('app.extra_class_breadcrumb'), 'url' => '']
  ]" />
  
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('app.create_new_extra_class') }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('app.schedule_additional_class') }}</p>
      </div>
      <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ __('app.back_to_schedules') }}
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <form action="{{ route('schedules.extra.store') }}" method="POST" class="space-y-6 p-6">
      @csrf
      
      <!-- Client Selection -->
      <x-smart-select 
        name="client_id"
        :label="__('app.client')"
        :required="true"
        :items="$clients ?? collect()"
        empty-type="client"
        :create-route="route('clients.create')"
        :create-text="__('app.add_client')"
        :selected="old('client_id')" />

      <!-- Class Type Selection -->
      <x-smart-select 
        name="class_type_id"
        :label="__('app.class_type')"
        :required="true"
        :items="$classTypes ?? collect()"
        empty-type="class_type"
        :create-route="route('classes.create')"
        :create-text="__('app.add_class_type')"
        :selected="old('class_type_id')" />

      <!-- Professional Selection -->
      <x-smart-select 
        name="professional_id"
        :label="__('app.professional')"
        :required="true"
        :items="$professionals ?? collect()"
        empty-type="professional"
        :create-route="route('professionals.create')"
        :create-text="__('app.add_professional')"
        :selected="old('professional_id')" />

      <!-- Room Selection -->
      <x-smart-select 
        name="room_id"
        :label="__('app.room')"
        :required="true"
        :items="$rooms ?? collect()"
        empty-type="room"
        :create-route="route('rooms.create')"
        :create-text="__('app.add_room')"
        :selected="old('room_id')" />

      <!-- Date and Time -->
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
          <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.date') }} *</label>
          <div class="mt-1">
            <input type="date" name="start_date" id="start_date" 
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('start_date') border-red-300 dark:border-red-500 @enderror" 
                   value="{{ old('start_date') }}" 
                   required>
          </div>
          @error('start_date')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.start_time') }} *</label>
          <div class="mt-1">
            <input type="time" name="start_time" id="start_time" 
                   class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('start_time') border-red-300 dark:border-red-500 @enderror" 
                   value="{{ old('start_time') }}" 
                   required>
          </div>
          @error('start_time')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Duration -->
      <div>
        <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.duration_minutes') }}</label>
        <div class="mt-1">
          <input type="number" name="duration" id="duration" min="15" step="15" 
                 class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration') border-red-300 dark:border-red-500 @enderror" 
                 value="{{ old('duration', 60) }}" 
                 placeholder="60">
        </div>
        @error('duration')
          <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
      </div>

      <!-- Price -->
      <div>
        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.price') }}</label>
        <div class="mt-1 relative rounded-md shadow-sm">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">R$</span>
          </div>
          <input type="number" name="price" id="price" min="0" step="0.01"
                 class="block w-full pl-8 pr-12 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price') border-red-300 dark:border-red-500 @enderror" 
                 value="{{ old('price') }}"
                 placeholder="0,00">
        </div>
        @error('price')
          <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
      </div>

      <!-- Observation -->
      <div>
        <label for="observation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.notes') }}</label>
        <div class="mt-1">
          <textarea name="observation" id="observation" rows="3" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('observation') border-red-300 dark:border-red-500 @enderror" 
                    placeholder="{{ __('app.notes_extra_placeholder') }}">{{ old('observation') }}</textarea>
        </div>
        @error('observation')
          <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
        <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
          {{ __('app.cancel') }}
        </a>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          {{ __('app.add_extra_class') }}
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
