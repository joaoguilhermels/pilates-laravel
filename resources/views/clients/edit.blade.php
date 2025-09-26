@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Smart Breadcrumbs -->
  <x-smart-breadcrumbs :items="[
    ['title' => __('app.clients'), 'url' => route('clients.index')],
    ['title' => $client->name, 'url' => route('clients.show', $client)],
    ['title' => __('app.edit'), 'url' => '']
  ]" />
  
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('app.edit_client') }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('app.update_client_info', ['name' => $client->name]) }}</p>
      </div>
      <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ __('app.back_to_clients') }}
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
    <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-6 p-6">
      @csrf
      @method('PATCH')
      @include('clients.form', ['submitButtonText' => __('app.update_client')])
    </form>
  </div>
</div>
@endsection
