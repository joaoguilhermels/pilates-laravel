@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Edit Profile</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Update your account information.</p>
      </div>
      <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Profile
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white shadow rounded-lg">
    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6 p-6">
      @csrf
      @method('PATCH')
      
      <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
          <label for="name" class="block text-sm font-medium text-gray-700">Full Name *</label>
          <div class="mt-1">
            <input type="text" name="name" id="name" 
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror" 
                   value="{{ old('name', $user->name) }}" 
                   required>
          </div>
          @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="sm:col-span-2">
          <label for="email" class="block text-sm font-medium text-gray-700">Email Address *</label>
          <div class="mt-1">
            <input type="email" name="email" id="email" 
                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-300 @enderror" 
                   value="{{ old('email', $user->email) }}" 
                   required>
          </div>
          @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Account Information (Read-only) -->
      <div class="border-t border-gray-200 pt-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Account Information</h3>
        
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
          <div>
            <label class="block text-sm font-medium text-gray-500">Member Since</label>
            <div class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</div>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-500">Last Updated</label>
            <div class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('F j, Y \a\t g:i A') }}</div>
          </div>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
        <a href="{{ route('profile.show') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Cancel
        </a>
        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Update Profile
        </button>
      </div>
    </form>
  </div>
</div>
@endsection
