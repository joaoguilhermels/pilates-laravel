{{-- Improved SaaS Registration Form Component --}}
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">

  <!-- Progress Indicator -->
  <div class="bg-white/50 dark:bg-gray-800/50 border-b border-gray-200/50 dark:border-gray-700/50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <div class="flex items-center justify-center space-x-8">
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-indigo-600 rounded-full flex items-center justify-center">
            <span class="text-white text-sm font-medium">1</span>
          </div>
          <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">Escolher Plano</span>
        </div>
        <div class="w-16 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
            <span class="text-gray-500 text-sm font-medium">2</span>
          </div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Criar Conta</span>
        </div>
        <div class="w-16 h-0.5 bg-gray-300 dark:bg-gray-600"></div>
        <div class="flex items-center space-x-2">
          <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
            <span class="text-gray-500 text-sm font-medium">3</span>
          </div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Começar</span>
        </div>
      </div>
    </div>
  </div>

  <div class="py-8 lg:py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Hero Section -->
      <div class="text-center mb-8 lg:mb-12">
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 mb-4">
          <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
          </svg>
          <span class="text-sm font-medium text-indigo-700 dark:text-indigo-300">{{ __('auth.plan_free_trial') }}</span>
        </div>
        
        <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-4">
          {{ __('auth.register_title') }}
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 max-w-2xl mx-auto">
          {{ __('auth.register_subtitle') }}
        </p>
        
        <!-- Trust Indicators -->
        <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
          <div class="flex items-center space-x-1">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>{{ __('auth.plan_no_credit_card') }}</span>
          </div>
          <div class="flex items-center space-x-1">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>Cancele a qualquer momento</span>
          </div>
          <div class="flex items-center space-x-1">
            <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span>Suporte em português</span>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Plan Selection -->
        <div id="plan-selection">
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
            {{ __('auth.plan_selection_title') }}
          </h3>
          <p class="text-gray-600 dark:text-gray-300 mb-8">
            {{ __('auth.plan_selection_subtitle') }}
          </p>

          <!-- Billing Toggle -->
          <div class="flex items-center justify-center mb-8">
            <span class="text-sm font-medium text-gray-900 dark:text-white mr-3">{{ __('auth.plan_monthly') }}</span>
            <button type="button" id="billing-toggle" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-gray-200 dark:bg-gray-700 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900" role="switch" aria-checked="false">
              <span class="sr-only">Use yearly billing</span>
              <span id="toggle-thumb" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out translate-x-0"></span>
            </button>
            <span class="text-sm font-medium text-gray-900 dark:text-white ml-3">
              {{ __('auth.plan_yearly') }}
              <span class="text-green-600 dark:text-green-400 text-xs ml-1">({{ __('auth.plan_save_percent', ['percent' => '10']) }})</span>
            </span>
          </div>

          <!-- Enhanced Plans Grid -->
          <div class="space-y-4" id="plans-container">
            @if(isset($plans) && $plans->count() > 0)
              @foreach($plans as $plan)
                <div class="plan-card group relative rounded-xl border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 cursor-pointer hover:border-indigo-500 dark:hover:border-indigo-400 hover:shadow-lg transition-all duration-300 {{ $plan->is_popular ? 'border-indigo-500 dark:border-indigo-400 ring-2 ring-indigo-100 dark:ring-indigo-900/50 shadow-lg' : '' }}" 
                     data-plan-id="{{ $plan->id }}" 
                     data-monthly-price="{{ $plan->monthly_price }}" 
                     data-yearly-price="{{ $plan->yearly_price }}">
                  
                  @if($plan->is_popular)
                    <div class="absolute -top-3 left-6">
                      <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg">
                        ⭐ {{ __('auth.plan_popular') }}
                      </span>
                    </div>
                  @endif

                  <!-- Plan Header -->
                  <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                      <div class="flex items-center space-x-2 mb-2">
                        @if($plan->slug === 'profissional')
                          <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                              <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                          </div>
                        @else
                          <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 104 0 2 2 0 00-4 0zm8 0a2 2 0 104 0 2 2 0 00-4 0z"/>
                            </svg>
                          </div>
                        @endif
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $plan->name }}</h4>
                      </div>
                      <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $plan->description }}</p>
                    </div>
                    
                    <!-- Price Display -->
                    <div class="text-right ml-4">
                      <div class="plan-price">
                        <div class="monthly-price">
                          <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $plan->formatted_monthly_price }}</span>
                          <span class="text-sm text-gray-500 dark:text-gray-400">/mês</span>
                        </div>
                        <div class="yearly-price hidden">
                          <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $plan->formatted_yearly_price }}</span>
                          <span class="text-sm text-gray-500 dark:text-gray-400">/ano</span>
                        </div>
                      </div>
                      @if($plan->slug === 'profissional')
                        <p class="text-xs text-green-600 dark:text-green-400 mt-1">Ideal para começar</p>
                      @else
                        <p class="text-xs text-purple-600 dark:text-purple-400 mt-1">Mais completo</p>
                      @endif
                    </div>
                  </div>

                  <!-- Key Features (Top 3) -->
                  <div class="mb-4">
                    <div class="grid grid-cols-1 gap-2">
                      @foreach(array_slice($plan->features, 0, 3) as $feature)
                        <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                          <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                          </svg>
                          <span>{{ $feature }}</span>
                        </div>
                      @endforeach
                      @if(count($plan->features) > 3)
                        <button type="button" class="text-left text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium" onclick="toggleFeatures(this)">
                          + Ver mais {{ count($plan->features) - 3 }} recursos
                        </button>
                        <div class="hidden extra-features space-y-2 mt-2">
                          @foreach(array_slice($plan->features, 3) as $feature)
                            <div class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                              <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                              </svg>
                              <span>{{ $feature }}</span>
                            </div>
                          @endforeach
                        </div>
                      @endif
                    </div>
                  </div>

                  <!-- Selection Indicator -->
                  <div class="plan-selected-indicator hidden absolute top-4 right-4">
                    <div class="w-8 h-8 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                      <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                  </div>

                  <!-- Hover Effect -->
                  <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-indigo-500/5 to-purple-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
                </div>
              @endforeach
            @else
              <!-- No Plans Available Message -->
              <div class="text-center py-12">
                <div class="mx-auto w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                  <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum plano disponível</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                  Não há planos de assinatura disponíveis no momento.
                </p>
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 dark:text-indigo-400 bg-indigo-100 dark:bg-indigo-900/20 hover:bg-indigo-200 dark:hover:bg-indigo-900/40">
                  Voltar ao Login
                </a>
              </div>
            @endif
          </div>
        </div>

        <!-- Registration Form -->
        <div>
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">
            Informações da Conta
          </h3>
          <form class="space-y-6" action="{{ route('register') }}" method="POST" id="registration-form">
            @csrf
            
            <!-- Hidden fields for plan selection -->
            <input type="hidden" name="saas_plan_id" id="selected_plan_id" value="{{ old('saas_plan_id') }}">
            <input type="hidden" name="billing_cycle" id="selected_billing_cycle" value="{{ old('billing_cycle', 'monthly') }}">
            
            <div class="space-y-4">
              <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth.register_full_name') }}</label>
                <input id="name" name="name" type="text" autocomplete="name" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('name') border-red-300 dark:border-red-500 @enderror" 
                       placeholder="{{ __('auth.register_full_name_placeholder') }}" value="{{ old('name') }}">
                @error('name')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="studio_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth.register_studio_name') }}</label>
                <input id="studio_name" name="studio_name" type="text" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('studio_name') border-red-300 dark:border-red-500 @enderror" 
                       placeholder="{{ __('auth.register_studio_name_placeholder') }}" value="{{ old('studio_name') }}">
                @error('studio_name')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>
              
              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth.register_email') }}</label>
                <input id="email" name="email" type="email" autocomplete="email" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-300 dark:border-red-500 @enderror" 
                       placeholder="{{ __('auth.register_email_placeholder') }}" value="{{ old('email') }}">
                @error('email')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth.register_phone') }}</label>
                <input id="phone" name="phone" type="tel" 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('phone') border-red-300 dark:border-red-500 @enderror" 
                       placeholder="{{ __('auth.register_phone_placeholder') }}" value="{{ old('phone') }}">
                @error('phone')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>
              
              <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth.register_password') }}</label>
                <input id="password" name="password" type="password" autocomplete="new-password" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-300 dark:border-red-500 @enderror" 
                       placeholder="{{ __('auth.register_password_placeholder') }}">
                @error('password')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
              </div>
              
              <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth.register_password_confirmation') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                       class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                       placeholder="{{ __('auth.register_password_confirmation_placeholder') }}">
              </div>
            </div>

            <!-- Terms and Privacy -->
            <div class="text-sm text-gray-600 dark:text-gray-400">
              {{ __('auth.register_terms') }}
              <a href="#" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">{{ __('auth.register_terms_link') }}</a>
              {{ __('auth.register_and') }}
              <a href="#" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">{{ __('auth.register_privacy_link') }}</a>.
            </div>

            <div>
              <button type="submit" id="submit-btn" disabled
                      class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-400 cursor-not-allowed transition-colors duration-200">
                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                  <svg class="h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
                  </svg>
                </span>
                <span id="submit-text">Selecione um plano para continuar</span>
              </button>
            </div>

            @if ($errors->any())
              <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                <div class="flex">
                  <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                  </div>
                  <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                      {{ __('auth.register_errors_title') }}
                    </h3>
                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                      <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            @endif
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Toggle features functionality
function toggleFeatures(button) {
    const extraFeatures = button.nextElementSibling;
    const isHidden = extraFeatures.classList.contains('hidden');
    
    if (isHidden) {
        extraFeatures.classList.remove('hidden');
        button.textContent = '- Ver menos recursos';
    } else {
        extraFeatures.classList.add('hidden');
        const featureCount = extraFeatures.children.length;
        button.textContent = `+ Ver mais ${featureCount} recursos`;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const billingToggle = document.getElementById('billing-toggle');
    const toggleThumb = document.getElementById('toggle-thumb');
    const planCards = document.querySelectorAll('.plan-card');
    const submitBtn = document.getElementById('submit-btn');
    const submitText = document.getElementById('submit-text');
    const selectedPlanId = document.getElementById('selected_plan_id');
    const selectedBillingCycle = document.getElementById('selected_billing_cycle');
    
    let isYearly = false;
    let selectedPlan = null;

    // Billing toggle functionality
    billingToggle.addEventListener('click', function() {
        isYearly = !isYearly;
        
        if (isYearly) {
            billingToggle.classList.add('bg-indigo-600');
            billingToggle.classList.remove('bg-gray-200', 'dark:bg-gray-700');
            toggleThumb.classList.add('translate-x-5');
            toggleThumb.classList.remove('translate-x-0');
            billingToggle.setAttribute('aria-checked', 'true');
            selectedBillingCycle.value = 'yearly';
        } else {
            billingToggle.classList.remove('bg-indigo-600');
            billingToggle.classList.add('bg-gray-200', 'dark:bg-gray-700');
            toggleThumb.classList.remove('translate-x-5');
            toggleThumb.classList.add('translate-x-0');
            billingToggle.setAttribute('aria-checked', 'false');
            selectedBillingCycle.value = 'monthly';
        }

        // Update price displays
        planCards.forEach(card => {
            const monthlyPrice = card.querySelector('.monthly-price');
            const yearlyPrice = card.querySelector('.yearly-price');

            if (isYearly) {
                if (monthlyPrice) monthlyPrice.classList.add('hidden');
                if (yearlyPrice) yearlyPrice.classList.remove('hidden');
            } else {
                if (monthlyPrice) monthlyPrice.classList.remove('hidden');
                if (yearlyPrice) yearlyPrice.classList.add('hidden');
            }
        });
    });

    // Plan selection functionality
    planCards.forEach(card => {
        card.addEventListener('click', function() {
            // Remove selection from all cards
            planCards.forEach(c => {
                c.classList.remove('border-indigo-500', 'dark:border-indigo-400', 'ring-2', 'ring-indigo-200', 'dark:ring-indigo-800');
                c.querySelector('.plan-selected-indicator').classList.add('hidden');
            });

            // Add selection to clicked card
            this.classList.add('border-indigo-500', 'dark:border-indigo-400', 'ring-2', 'ring-indigo-200', 'dark:ring-indigo-800');
            this.querySelector('.plan-selected-indicator').classList.remove('hidden');

            // Update selected plan
            selectedPlan = this.dataset.planId;
            selectedPlanId.value = selectedPlan;

            // Update submit button
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'focus:outline-none', 'focus:ring-2', 'focus:ring-offset-2', 'focus:ring-indigo-500', 'dark:focus:ring-offset-gray-900');
            
            const planName = this.querySelector('h4').textContent;
            submitText.textContent = `{{ __('auth.register_create_account') }} - ${planName}`;
        });
    });

    // Pre-select popular plan if no errors
    @if(!$errors->any() && isset($plans) && $plans->count() > 0)
        @php
            $popularPlan = $plans->where('is_popular', true)->first();
            $defaultPlan = $popularPlan ?: $plans->first();
        @endphp
        @if($defaultPlan)
            const popularPlan = document.querySelector('.plan-card[data-plan-id="{{ $defaultPlan->id }}"]');
            if (popularPlan) {
                popularPlan.click();
            }
        @endif
    @endif
});
</script>
