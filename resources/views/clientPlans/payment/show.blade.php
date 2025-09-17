@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Payment Details</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">View payment information</p>
      </div>
      <div class="flex space-x-3">
        <a href="{{ route('clients.show', $financialTransaction->financiable->client) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Back to Client
        </a>
        <a href="{{ route('payment.edit', $financialTransaction) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
          </svg>
          Edit Payment
        </a>
      </div>
    </div>
  </div>

  <!-- Payment Information -->
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Payment Information</h3>
      
      @if($financialTransaction->financiable)
        <!-- Plan Details -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
          <h4 class="text-md font-medium text-gray-900 dark:text-white mb-3">Plan Details</h4>
          <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Client</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialTransaction->financiable->client->name }}</dd>
            </div>
            <div>
              <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plan</dt>
              <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialTransaction->financiable->plan->name }}</dd>
            </div>
          </dl>
        </div>
      @endif

      <!-- Payment Details -->
      <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
        <div>
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Payment Name</dt>
          <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialTransaction->name }}</dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount</dt>
          <dd class="mt-1 text-sm text-gray-900 dark:text-white">R$ {{ number_format($financialTransaction->total_amount, 2, ',', '.') }}</dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Number of Payments</dt>
          <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialTransaction->total_number_of_payments }}</dd>
        </div>
        <div>
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
          <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialTransaction->created_at->format('F j, Y g:i A') }}</dd>
        </div>
        @if($financialTransaction->observation)
        <div class="sm:col-span-2">
          <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Observation</dt>
          <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $financialTransaction->observation }}</dd>
        </div>
        @endif
      </dl>

      <!-- Payment Details -->
      @if($financialTransaction->financialTransactionDetails->count() > 0)
        <div class="mt-8">
          <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4">Payment Installments</h4>
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Payment #</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                  <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                </tr>
              </thead>
              <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                @foreach($financialTransaction->financialTransactionDetails as $detail)
                  <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $detail->payment_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($detail->date)->format('M j, Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">R$ {{ number_format($detail->amount, 2, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $detail->type === 'received' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($detail->type) }}
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection