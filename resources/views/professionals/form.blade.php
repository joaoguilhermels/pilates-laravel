<!-- Name Field -->
<div>
  <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name *</label>
  <div class="mt-1">
    <input type="text" name="name" id="name" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('name', $professional->name ?? '') }}" 
           required>
  </div>
  @error('name')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Phone Field -->
<div>
  <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone</label>
  <div class="mt-1">
    <input type="tel" name="phone" id="phone" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('phone', $professional->phone ?? '') }}">
  </div>
  @error('phone')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Email Field -->
<div>
  <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email *</label>
  <div class="mt-1">
    <input type="email" name="email" id="email" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('email', $professional->email ?? '') }}" 
           required>
  </div>
  @error('email')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Compensation Model Section -->
<div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
  <div class="flex items-start">
    <div class="flex-shrink-0">
      <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <div class="ml-3 flex-1">
      <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Compensation Model</h3>
      <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">
        Choose how this professional will be compensated. This affects payroll calculations and financial reporting.
      </p>
    </div>
  </div>
  
  <div class="mt-4 space-y-4">
    <!-- Fixed Salary Option -->
    <label class="relative flex cursor-pointer rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none hover:bg-gray-50 dark:hover:bg-gray-700">
      <input type="radio" name="compensation_model" value="fixed_salary" 
             class="sr-only" 
             {{ old('compensation_model', $professional->compensation_model ?? 'commission_only') == 'fixed_salary' ? 'checked' : '' }}
             onchange="toggleCompensationFields()">
      <span class="flex flex-1">
        <span class="flex flex-col">
          <span class="block text-sm font-medium text-gray-900 dark:text-white">
            Fixed monthly salary
          </span>
          <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
            Professional receives a consistent monthly payment regardless of classes taught
          </span>
        </span>
      </span>
      <span class="radio-indicator h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center">
        <span class="h-2 w-2 rounded-full bg-indigo-600 opacity-0"></span>
      </span>
    </label>

    <!-- Commission Only Option -->
    <label class="relative flex cursor-pointer rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none hover:bg-gray-50 dark:hover:bg-gray-700">
      <input type="radio" name="compensation_model" value="commission_only" 
             class="sr-only"
             {{ old('compensation_model', $professional->compensation_model ?? 'commission_only') == 'commission_only' ? 'checked' : '' }}
             onchange="toggleCompensationFields()">
      <span class="flex flex-1">
        <span class="flex flex-col">
          <span class="block text-sm font-medium text-gray-900 dark:text-white">
            Commission Percentage only
          </span>
          <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
            Professional earns commission based on class types taught (rates set below in "Class Types & Commission Rates")
          </span>
        </span>
      </span>
      <span class="radio-indicator h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center">
        <span class="h-2 w-2 rounded-full bg-indigo-600 opacity-0"></span>
      </span>
    </label>

    <!-- Combined Option -->
    <label class="relative flex cursor-pointer rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 p-4 shadow-sm focus:outline-none hover:bg-gray-50 dark:hover:bg-gray-700">
      <input type="radio" name="compensation_model" value="salary_plus_commission" 
             class="sr-only"
             {{ old('compensation_model', $professional->compensation_model ?? 'commission_only') == 'salary_plus_commission' ? 'checked' : '' }}
             onchange="toggleCompensationFields()">
      <span class="flex flex-1">
        <span class="flex flex-col">
          <span class="block text-sm font-medium text-gray-900 dark:text-white">
            Combined salary + commission
          </span>
          <span class="mt-1 flex items-center text-sm text-gray-500 dark:text-gray-400">
            Professional receives both a base salary and commission on classes (commission rates set below)
          </span>
        </span>
      </span>
      <span class="radio-indicator h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600 flex items-center justify-center">
        <span class="h-2 w-2 rounded-full bg-indigo-600 opacity-0"></span>
      </span>
    </label>
  </div>

  @error('compensation_model')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Fixed Salary Field -->
<div id="fixed_salary_field" class="compensation-field" style="display: none;">
  <label for="fixed_salary" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
    Fixed Salary
    <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">(monthly amount)</span>
  </label>
  <div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
    </div>
    <input type="number" name="fixed_salary" id="fixed_salary" min="0" step="0.01"
           class="block w-full pl-7 pr-12 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('fixed_salary') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('fixed_salary', $professional->fixed_salary ?? '') }}"
           placeholder="3000.00">
  </div>
  <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 help-text">
    Monthly salary paid regardless of classes taught. This will be included in monthly payroll.
  </p>
  @error('fixed_salary')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>


<!-- Compensation Notes -->
<div>
  <label for="compensation_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
    Compensation Notes
    <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">(optional)</span>
  </label>
  <div class="mt-1">
    <textarea name="compensation_notes" id="compensation_notes" rows="2" 
              class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('compensation_notes') border-red-300 dark:border-red-500 @enderror" 
              placeholder="Special arrangements, bonus structure, review dates...">{{ old('compensation_notes', $professional->compensation_notes ?? '') }}</textarea>
  </div>
  <p class="mt-1 text-sm text-gray-500 dark:text-gray-400 help-text">
    Additional compensation details, bonus structures, or special arrangements.
  </p>
  @error('compensation_notes')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Description Field -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
  <div class="mt-1">
    <textarea name="description" id="description" rows="4" 
              class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 dark:border-red-500 @enderror" 
              placeholder="Professional background, specialties, certifications...">{{ old('description', $professional->description ?? '') }}</textarea>
  </div>
  @error('description')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Class Types Section -->
@if(isset($classTypes) && count($classTypes) > 0)
<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Class Types & Commission Rates</label>
  <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-3 border border-gray-200 dark:border-gray-600">
    @foreach($classTypes as $classType)
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input type="checkbox" name="class_types[]" value="{{ $classType->id }}" 
                 class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-700"
                 {{ in_array($classType->id, old('class_types', collect($professionalClassTypes ?? [])->pluck('id')->toArray())) ? 'checked' : '' }}>
          <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $classType->name }}</label>
        </div>
        <div class="flex items-center space-x-2">
          <input type="number" name="commission_rates[{{ $classType->id }}]" 
                 class="w-20 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                 min="0" max="100" step="0.01" placeholder="0.00"
                 value="{{ old('commission_rates.'.$classType->id, collect($professionalClassTypes ?? [])->where('id', $classType->id)->first()->pivot->percentage ?? '') }}">
          <span class="text-sm text-gray-500 dark:text-gray-400">%</span>
        </div>
      </div>
    @endforeach
  </div>
  <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Select the class types this professional can teach and set their commission rates.</p>
</div>
@endif

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
  <a href="{{ route('professionals.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    Cancel
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
(function() {
    'use strict';
    
    function initializeProfessionalForm() {
        // Only run if we have compensation model inputs
        if (!document.querySelector('input[name="compensation_model"]')) {
            return;
        }
        
        function toggleCompensationFields() {
            const selectedRadio = document.querySelector('input[name="compensation_model"]:checked');
            if (!selectedRadio) return;
            
            const selectedModel = selectedRadio.value;
            const fixedSalaryField = document.getElementById('fixed_salary_field');
            
            // Update radio button visual indicators
            document.querySelectorAll('input[name="compensation_model"]').forEach(function(radio) {
                const indicator = radio.parentElement.querySelector('.radio-indicator span');
                if (indicator) {
                    if (radio.checked) {
                        indicator.style.opacity = '1';
                        radio.parentElement.classList.add('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                        radio.parentElement.classList.remove('border-gray-300', 'dark:border-gray-600');
                    } else {
                        indicator.style.opacity = '0';
                        radio.parentElement.classList.remove('border-indigo-500', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                        radio.parentElement.classList.add('border-gray-300', 'dark:border-gray-600');
                    }
                }
            });
            
            // Show/hide relevant fields
            if (fixedSalaryField) {
                const fixedSalaryInput = document.getElementById('fixed_salary');
                
                switch(selectedModel) {
                    case 'fixed_salary':
                    case 'salary_plus_commission':
                        fixedSalaryField.style.display = 'block';
                        if (fixedSalaryInput) fixedSalaryInput.required = true;
                        break;
                    case 'commission_only':
                        fixedSalaryField.style.display = 'none';
                        if (fixedSalaryInput) fixedSalaryInput.required = false;
                        break;
                }
            }
        }
        
        // Initialize on page load
        toggleCompensationFields();
        
        // Add event listeners
        document.querySelectorAll('input[name="compensation_model"]').forEach(function(radio) {
            radio.addEventListener('change', toggleCompensationFields);
        });
        
        // Add tooltip functionality
        document.querySelectorAll('.help-text').forEach(function(helpText) {
            helpText.classList.add('tooltip');
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeProfessionalForm);
    } else {
        initializeProfessionalForm();
    }
})();
</script>
@endpush

<style>
.tooltip {
    position: relative;
}

.compensation-field {
    transition: all 0.3s ease;
}

.radio-indicator span {
    transition: opacity 0.2s ease;
}

input[type="radio"]:checked + span .radio-indicator {
    border-color: #4F46E5;
}

input[type="radio"]:checked + span .radio-indicator span {
    opacity: 1 !important;
}
</style>
