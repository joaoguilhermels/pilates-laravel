@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Class Type</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Update {{ $classType->name }}'s information.</p>
      </div>
      <a href="{{ route('classes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Classes
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
    <form action="{{ route('classes.update', $classType) }}" method="POST" class="space-y-6 p-6">
      @csrf
      @method('PATCH')
      @include('classes.form', ['submitButtonText' => 'Update Class Type'])
    </form>
  </div>
</div>
@endsection
