<!-- Plan Name -->
<div>
  <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.plan_name') }} *</label>
  <div class="mt-1">
    <input type="text" name="name" id="name" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('name', $plan->name ?? '') }}" 
           required>
  </div>
  @error('name')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Class Type -->
<div>
  <label for="class_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.related_class_type') }}</label>
  <div class="mt-1">
    <select name="class_type_id" id="class_type_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('class_type_id') border-red-300 dark:border-red-500 @enderror">
      <option value="">{{ __('app.select_class_type_optional') }}</option>
      @if(isset($classTypes))
        @foreach($classTypes as $classType)
          <option value="{{ $classType->id }}" {{ old('class_type_id', isset($plan->classType->id) ? $plan->classType->id : '') == $classType->id ? 'selected' : '' }}>
            {{ $classType->name }}
          </option>
        @endforeach
      @endif
    </select>
  </div>
  @error('class_type_id')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Description -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.description') }}</label>
  <div class="mt-1">
    <textarea name="description" id="description" rows="3" 
              class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 dark:border-red-500 @enderror" 
              placeholder="{{ __('app.plan_description_placeholder') }}">{{ old('description', $plan->description ?? '') }}</textarea>
  </div>
  @error('description')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Frequency and Duration -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
  <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('app.plan_structure') }}</h3>
  
  <!-- Sessions per Period -->
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <label for="times" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('app.session_frequency') }} *
        <span class="ml-1 text-xs text-gray-500 dark:text-gray-400 cursor-help" title="{{ __('app.how_often_classes') }}">
          <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
        </span>
      </label>
      <div class="mt-1">
        <input type="number" name="times" id="times" min="1" 
               class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('times') border-red-300 dark:border-red-500 @enderror" 
               value="{{ old('times', $plan->times ?? '') }}" 
               required>
      </div>
      @error('times')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="times_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Período *
        <span class="ml-1 text-xs text-gray-500 dark:text-gray-400 cursor-help" title="Frequência das aulas">
          <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
        </span>
      </label>
      <div class="mt-1">
        <select name="times_type" id="times_type" 
                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('times_type') border-red-300 dark:border-red-500 @enderror" 
                required>
          <option value="week" {{ old('times_type', $plan->times_type ?? 'month') == 'week' ? 'selected' : '' }}>{{ __('app.week') }}</option>
          <option value="month" {{ old('times_type', $plan->times_type ?? 'month') == 'month' ? 'selected' : '' }}>{{ __('app.month') }}</option>
        </select>
      </div>
      @error('times_type')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <!-- Plan Duration -->
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">
    <div>
      <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('app.plan_total_duration') }} *
        <span class="ml-1 text-xs text-gray-500 dark:text-gray-400 cursor-help" title="{{ __('app.how_long_plan_lasts') }}">
          <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
        </span>
      </label>
      <div class="mt-1">
        <input type="number" name="duration" id="duration" min="1" 
               class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration') border-red-300 dark:border-red-500 @enderror" 
               value="{{ old('duration', $plan->duration ?? '') }}" 
               required>
      </div>
      @error('duration')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="duration_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        Unidade *
        <span class="ml-1 text-xs text-gray-500 dark:text-gray-400 cursor-help" title="Unidade de tempo para a duração">
          <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
        </span>
      </label>
      <div class="mt-1">
        <select name="duration_type" id="duration_type" 
                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration_type') border-red-300 dark:border-red-500 @enderror" 
                required>
          <option value="month" {{ old('duration_type', $plan->duration_type ?? 'month') == 'month' ? 'selected' : '' }}>{{ __('app.months') }}</option>
          <option value="week" {{ old('duration_type', $plan->duration_type ?? 'month') == 'week' ? 'selected' : '' }}>{{ __('app.weeks') }}</option>
        </select>
      </div>
      @error('duration_type')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>

<!-- Pricing -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
  <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('app.pricing') }}</h3>
  
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.price') }} *</label>
      <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <span class="text-gray-500 dark:text-gray-400 sm:text-sm">R$</span>
        </div>
        <input type="number" name="price" id="price" min="0" step="0.01"
               class="block w-full pl-7 pr-12 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price') border-red-300 dark:border-red-500 @enderror" 
               value="{{ old('price', $plan->price ?? '') }}"
               placeholder="0.00"
               required>
      </div>
      @error('price')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="price_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ __('app.pricing_model') }} *
        <span class="ml-1 text-xs text-gray-500 dark:text-gray-400 cursor-help" title="{{ __('app.how_charge_client') }}">
          <svg class="inline w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
          </svg>
        </span>
      </label>
      <div class="mt-1">
        <select name="price_type" id="price_type" 
                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_type') border-red-300 dark:border-red-500 @enderror" 
                required>
          <option value="class" {{ old('price_type', $plan->price_type ?? 'month') == 'class' ? 'selected' : '' }}>{{ __('app.per_class') }}</option>
          <option value="month" {{ old('price_type', $plan->price_type ?? 'month') == 'month' ? 'selected' : '' }}>{{ __('app.per_month') }}</option>
        </select>
      </div>
      @error('price_type')
        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>

<!-- Plan Summary - Always Visible -->
<div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
  <div class="flex items-center mb-3">
    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
    </svg>
    <h3 class="text-lg font-medium text-blue-900 dark:text-blue-100">{{ __('app.plan_preview') }}</h3>
  </div>
  
  <div id="plan-summary" class="space-y-3">
    <!-- Plan Name Preview -->
    <div class="flex justify-between items-center">
      <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Nome:</span>
      <span id="summary-name" class="text-sm text-blue-700 dark:text-blue-300">-</span>
    </div>
    
    <!-- Frequency Preview -->
    <div class="flex justify-between items-center">
      <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Frequência:</span>
      <span id="summary-frequency" class="text-sm text-blue-700 dark:text-blue-300">-</span>
    </div>
    
    <!-- Duration Preview -->
    <div class="flex justify-between items-center">
      <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Duração:</span>
      <span id="summary-duration" class="text-sm text-blue-700 dark:text-blue-300">-</span>
    </div>
    
    <!-- Sessions Included -->
    <div class="flex justify-between items-center">
      <span class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('app.sessions_included') }}:</span>
      <span id="summary-sessions" class="text-sm font-semibold text-blue-700 dark:text-blue-300">-</span>
    </div>
    
    <!-- Pricing Model -->
    <div class="flex justify-between items-center">
      <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Cobrança:</span>
      <span id="summary-pricing" class="text-sm text-blue-700 dark:text-blue-300">-</span>
    </div>
    
    <!-- Cost per Session -->
    <div class="flex justify-between items-center">
      <span class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ __('app.cost_per_session') }}:</span>
      <span id="summary-cost-per-session" class="text-sm text-blue-700 dark:text-blue-300">-</span>
    </div>
    
    <!-- Total Revenue -->
    <div class="border-t border-blue-200 dark:border-blue-700 pt-3 mt-3">
      <div class="flex justify-between items-center">
        <span class="text-base font-semibold text-blue-900 dark:text-blue-100">{{ __('app.estimated_revenue') }}:</span>
        <span id="summary-total" class="text-lg font-bold text-blue-900 dark:text-blue-100">R$ 0,00</span>
      </div>
    </div>
    
    <!-- Smart Suggestions -->
    <div id="smart-suggestions" class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-md border border-yellow-200 dark:border-yellow-800 hidden">
      <div class="flex items-start">
        <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <div>
          <p class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Sugestão:</p>
          <p id="suggestion-text" class="text-sm text-yellow-700 dark:text-yellow-300 mt-1"></p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
  <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    {{ __('app.cancel') }}
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updateSmartSummary() {
        const name = document.getElementById('name').value || 'Novo Plano';
        const times = parseInt(document.getElementById('times').value) || 0;
        const timesType = document.getElementById('times_type').value;
        const duration = parseInt(document.getElementById('duration').value) || 0;
        const durationType = document.getElementById('duration_type').value;
        const price = parseFloat(document.getElementById('price').value) || 0;
        const priceType = document.getElementById('price_type').value;
        
        // Update individual elements
        document.getElementById('summary-name').textContent = name;
        
        // Frequency
        if (times && timesType) {
            document.getElementById('summary-frequency').textContent = 
                `${times}x por ${timesType === 'week' ? 'semana' : 'mês'}`;
        } else {
            document.getElementById('summary-frequency').textContent = '-';
        }
        
        // Duration
        if (duration && durationType) {
            const unit = durationType === 'month' ? 
                (duration > 1 ? 'meses' : 'mês') : 
                (duration > 1 ? 'semanas' : 'semana');
            document.getElementById('summary-duration').textContent = `${duration} ${unit}`;
        } else {
            document.getElementById('summary-duration').textContent = '-';
        }
        
        // Calculate total sessions
        let totalSessions = 0;
        if (times && duration) {
            if (timesType === 'week') {
                totalSessions = times * duration * (durationType === 'month' ? 4.33 : 1);
            } else {
                totalSessions = times * duration * (durationType === 'week' ? 0.23 : 1);
            }
        }
        
        document.getElementById('summary-sessions').textContent = 
            totalSessions > 0 ? `~${Math.round(totalSessions)} sessões` : '-';
        
        // Pricing model
        if (price && priceType) {
            document.getElementById('summary-pricing').textContent = 
                `R$ ${price.toFixed(2)} por ${priceType === 'class' ? 'aula' : 'mês'}`;
        } else {
            document.getElementById('summary-pricing').textContent = '-';
        }
        
        // Cost per session
        let costPerSession = 0;
        let totalRevenue = 0;
        
        if (price && totalSessions > 0) {
            if (priceType === 'class') {
                costPerSession = price;
                totalRevenue = price * totalSessions;
            } else {
                const totalMonths = durationType === 'month' ? duration : duration / 4.33;
                totalRevenue = price * totalMonths;
                costPerSession = totalRevenue / totalSessions;
            }
        }
        
        document.getElementById('summary-cost-per-session').textContent = 
            costPerSession > 0 ? `R$ ${costPerSession.toFixed(2)}` : '-';
        
        document.getElementById('summary-total').textContent = 
            `R$ ${totalRevenue.toFixed(2)}`;
        
        // Smart suggestions
        showSmartSuggestions(times, timesType, duration, durationType, price, priceType, costPerSession);
    }
    
    function showSmartSuggestions(times, timesType, duration, durationType, price, priceType, costPerSession) {
        const suggestionsEl = document.getElementById('smart-suggestions');
        const suggestionText = document.getElementById('suggestion-text');
        let suggestion = '';
        
        // Price analysis
        if (costPerSession > 0) {
            if (costPerSession < 30) {
                suggestion = 'O preço por sessão está muito baixo. Considere aumentar para pelo menos R$ 30-50 por sessão.';
            } else if (costPerSession > 100) {
                suggestion = 'O preço por sessão está alto. Verifique se está alinhado com o mercado local.';
            }
        }
        
        // Frequency analysis
        if (times && timesType === 'week') {
            if (times === 1) {
                suggestion = 'Para melhores resultados, considere recomendar pelo menos 2 sessões por semana.';
            } else if (times > 5) {
                suggestion = 'Mais de 5 sessões por semana pode ser excessivo para a maioria dos clientes.';
            }
        }
        
        // Duration analysis
        if (duration && durationType === 'month') {
            if (duration === 1) {
                suggestion = 'Planos de 1 mês têm baixa retenção. Considere oferecer desconto para planos de 3+ meses.';
            } else if (duration >= 6) {
                suggestion = 'Ótimo! Planos longos aumentam a retenção de clientes e garantem receita recorrente.';
            }
        }
        
        if (suggestion) {
            suggestionText.textContent = suggestion;
            suggestionsEl.classList.remove('hidden');
        } else {
            suggestionsEl.classList.add('hidden');
        }
    }
    
    // Add event listeners to update summary in real-time
    ['times', 'times_type', 'duration', 'duration_type', 'price', 'price_type', 'name'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updateSmartSummary);
            element.addEventListener('change', updateSmartSummary);
        }
    });
    
    // Make function globally available for templates
    window.updatePlanSummary = updateSmartSummary;
    
    // Initial summary update
    updateSmartSummary();
});
</script>
@endpush
