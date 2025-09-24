@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('app.create_new_plan') }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ __('app.add_new_membership_plan') }}</p>
      </div>
      <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        {{ __('app.back_to_plans') }}
      </a>
    </div>
  </div>

  @if(request('onboarding'))
    <!-- Onboarding Context Banner -->
    <div class="mb-6 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg overflow-hidden">
      <div class="px-6 py-4">
        <div class="flex items-center">
          <div class="flex-shrink-0">
            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
          <div class="ml-4">
            <h3 class="text-lg font-semibold text-white">
              🎉 {{ __('app.creating_first_plan') }}
            </h3>
            <p class="text-indigo-100 text-sm">
              {{ __('app.popular_plans_help') }}
            </p>
          </div>
        </div>
      </div>
    </div>

    @if(count($popularPlans) > 0)
      <!-- Popular Plans Section -->
      <div class="mb-6">
        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4 flex items-center">
          <svg class="w-4 h-4 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
          {{ __('app.popular_plans_title') }}
        </h4>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
          @foreach($popularPlans as $plan)
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors cursor-pointer" onclick="usePopularPlan({{ json_encode($plan) }})">
              <div class="text-center">
                <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center mx-auto mb-3">
                  <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                  </svg>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white">{{ $plan['name'] }}</h4>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                  {{ $plan['times'] }}x por {{ $plan['times_type'] === 'week' ? 'semana' : 'mês' }} • 
                  {{ $plan['duration'] }} {{ $plan['duration_type'] === 'month' ? 'mês(es)' : 'semana(s)' }}
                </p>
                <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 mt-1">
                  R$ {{ number_format($plan['price'], 2, ',', '.') }}
                </p>
                <p class="text-xs text-green-600 dark:text-green-400 mt-2">
                  {{ __('app.used_by_clients', ['count' => $plan['usage_count']]) }}
                </p>
                <button class="mt-3 text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">
                  {{ __('app.use_as_base') }}
                </button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @else
      <!-- No Popular Plans Message -->
      <div class="mb-6 text-center py-8 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.no_popular_plans') }}</p>
      </div>
    @endif

    <!-- Create from Scratch Option -->
    <div class="mb-6 text-center">
      <button onclick="showForm()" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        {{ __('app.create_from_scratch') }}
      </button>
    </div>
  @endif

  <!-- Form -->
  <div id="plan-form" class="bg-white dark:bg-gray-800 shadow rounded-lg border border-gray-200 dark:border-gray-700 @if(request('onboarding')) hidden @endif">
    <form action="{{ route('plans.store') }}" method="POST" class="space-y-6 p-6">
      @csrf
      @include('plans.form', ['submitButtonText' => __('app.create_plan'), 'plan' => $plan, 'classTypes' => $classTypes])
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
function usePopularPlan(planData) {
    // Show form
    showForm();
    
    // Fill form with popular plan data
    setTimeout(() => {
        // Create a unique name based on the original
        document.getElementById('name').value = 'Baseado em: ' + planData.name;
        document.getElementById('times').value = planData.times;
        document.getElementById('times_type').value = planData.times_type;
        document.getElementById('duration').value = planData.duration;
        document.getElementById('duration_type').value = planData.duration_type;
        document.getElementById('price').value = planData.price;
        document.getElementById('price_type').value = planData.price_type;
        
        // Use original description as base or create a new one
        const baseDescription = planData.description || 'Plano baseado em um dos mais populares do sistema.';
        document.getElementById('description').value = baseDescription;
        
        // Trigger summary update
        if (typeof updatePlanSummary === 'function') {
            updatePlanSummary();
        }
        
        // Scroll to form
        document.getElementById('plan-form').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
        
        // Show a helpful message
        showPopularPlanMessage(planData.name, planData.usage_count);
    }, 100);
}

function showPopularPlanMessage(originalName, usageCount) {
    // Create a temporary notification
    const notification = document.createElement('div');
    notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 transition-opacity duration-300';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span>Usando "${originalName}" como base (${usageCount} cliente(s))</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

function showForm() {
    const form = document.getElementById('plan-form');
    if (form) {
        form.classList.remove('hidden');
        form.scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
        });
    }
}
</script>
@endpush
