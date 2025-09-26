@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Smart Breadcrumbs -->
  <x-smart-breadcrumbs :items="[
    ['title' => __('app.schedules'), 'url' => route('schedules.index')],
    ['title' => __('app.create'), 'url' => '']
  ]" />
  
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('app.create_new_schedule') }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('app.schedule_new_class') }}</p>
      </div>
      <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ __('app.back_to_schedules') }}
      </a>
    </div>
  </div>

  @php
    $hasClients = isset($clients) && $clients->count() > 0;
    $hasProfessionals = isset($professionals) && $professionals->count() > 0;
    $hasRooms = isset($rooms) && $rooms->count() > 0;
    $hasClassTypes = isset($classTypes) && $classTypes->count() > 0;
    $canCreateSchedule = $hasClients && $hasProfessionals && $hasRooms && $hasClassTypes;
  @endphp

  @if(!$canCreateSchedule)
    <!-- Empty States -->
    @if(!$hasClients && !$hasProfessionals && !$hasRooms && !$hasClassTypes)
      <x-schedule-empty-state 
        type="comprehensive" 
        :create-route="route('home')" 
        :create-text="__('app.setup_guide')" />
    @else
      @if(!$hasClients)
        <x-schedule-empty-state 
          type="clients" 
          :create-route="route('clients.create')" 
          :create-text="__('app.add_client')" />
      @endif
      
      @if(!$hasProfessionals)
        <x-schedule-empty-state 
          type="professionals" 
          :create-route="route('professionals.create')" 
          :create-text="__('app.add_professional')" />
      @endif
      
      @if(!$hasRooms)
        <x-schedule-empty-state 
          type="rooms" 
          :create-route="route('rooms.create')" 
          :create-text="__('app.add_room')" />
      @endif
      
      @if(!$hasClassTypes)
        <x-schedule-empty-state 
          type="class_types" 
          :create-route="route('classes.create')" 
          :create-text="__('app.add_class_type')" />
      @endif
    @endif
  @endif

  <!-- Form -->
  <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 {{ !$canCreateSchedule ? 'opacity-50 pointer-events-none' : '' }}">
    <form action="{{ route('schedules.store') }}" method="POST" class="space-y-6 p-6">
      @csrf
      @include('schedules.create-form', ['submitButtonText' => __('app.create_schedule')])
    </form>
  </div>
</div>
@endsection
