@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Client</h1>
        <p class="mt-1 text-sm text-gray-600">Update {{ $client->name }}'s information.</p>
      </div>
      <a href="{{ route('clients.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Clients
      </a>
    </div>
  </div>

  <!-- Form -->
  <div class="bg-white shadow rounded-lg">
    <form action="{{ route('clients.update', $client) }}" method="POST" class="space-y-6 p-6">
      @csrf
      @method('PATCH')
      @include('clients.form', ['submitButtonText' => 'Update Client'])
    </form>
  </div>
</div>
@endsection
