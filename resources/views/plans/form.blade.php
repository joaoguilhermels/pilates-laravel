<!-- Plan Name -->
<div>
  <label for="name" class="block text-sm font-medium text-gray-700">Plan Name *</label>
  <div class="mt-1">
    <input type="text" name="name" id="name" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror" 
           value="{{ old('name', $plan->name ?? '') }}" 
           required>
  </div>
  @error('name')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Class Type -->
<div>
  <label for="class_type_id" class="block text-sm font-medium text-gray-700">Related Class Type</label>
  <div class="mt-1">
    <select name="class_type_id" id="class_type_id" 
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('class_type_id') border-red-300 @enderror">
      <option value="">Select a class type (optional)</option>
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
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Description -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
  <div class="mt-1">
    <textarea name="description" id="description" rows="3" 
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 @enderror" 
              placeholder="Plan description, benefits, terms...">{{ old('description', $plan->description ?? '') }}</textarea>
  </div>
  @error('description')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Frequency and Duration -->
<div class="bg-gray-50 rounded-lg p-4">
  <h3 class="text-lg font-medium text-gray-900 mb-4">Plan Structure</h3>
  
  <!-- Sessions per Period -->
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <label for="times" class="block text-sm font-medium text-gray-700">Number of Sessions *</label>
      <div class="mt-1">
        <input type="number" name="times" id="times" min="1" 
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('times') border-red-300 @enderror" 
               value="{{ old('times', $plan->times ?? '') }}" 
               required>
      </div>
      @error('times')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="times_type" class="block text-sm font-medium text-gray-700">Per *</label>
      <div class="mt-1">
        <select name="times_type" id="times_type" 
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('times_type') border-red-300 @enderror" 
                required>
          <option value="week" {{ old('times_type', $plan->times_type ?? 'month') == 'week' ? 'selected' : '' }}>Week</option>
          <option value="month" {{ old('times_type', $plan->times_type ?? 'month') == 'month' ? 'selected' : '' }}>Month</option>
        </select>
      </div>
      @error('times_type')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>

  <!-- Plan Duration -->
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">
    <div>
      <label for="duration" class="block text-sm font-medium text-gray-700">Plan Duration *</label>
      <div class="mt-1">
        <input type="number" name="duration" id="duration" min="1" 
               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration') border-red-300 @enderror" 
               value="{{ old('duration', $plan->duration ?? '') }}" 
               required>
      </div>
      @error('duration')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="duration_type" class="block text-sm font-medium text-gray-700">Duration Unit *</label>
      <div class="mt-1">
        <select name="duration_type" id="duration_type" 
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration_type') border-red-300 @enderror" 
                required>
          <option value="month" {{ old('duration_type', $plan->duration_type ?? 'month') == 'month' ? 'selected' : '' }}>Month(s)</option>
          <option value="week" {{ old('duration_type', $plan->duration_type ?? 'month') == 'week' ? 'selected' : '' }}>Week(s)</option>
        </select>
      </div>
      @error('duration_type')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>

<!-- Pricing -->
<div class="bg-gray-50 rounded-lg p-4">
  <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing</h3>
  
  <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div>
      <label for="price" class="block text-sm font-medium text-gray-700">Price *</label>
      <div class="mt-1 relative rounded-md shadow-sm">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
          <span class="text-gray-500 sm:text-sm">$</span>
        </div>
        <input type="number" name="price" id="price" min="0" step="0.01"
               class="block w-full pl-7 pr-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price') border-red-300 @enderror" 
               value="{{ old('price', $plan->price ?? '') }}"
               placeholder="0.00"
               required>
      </div>
      @error('price')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>

    <div>
      <label for="price_type" class="block text-sm font-medium text-gray-700">Price Per *</label>
      <div class="mt-1">
        <select name="price_type" id="price_type" 
                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price_type') border-red-300 @enderror" 
                required>
          <option value="class" {{ old('price_type', $plan->price_type ?? 'month') == 'class' ? 'selected' : '' }}>Class</option>
          <option value="month" {{ old('price_type', $plan->price_type ?? 'month') == 'month' ? 'selected' : '' }}>Month</option>
        </select>
      </div>
      @error('price_type')
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
      @enderror
    </div>
  </div>
</div>

<!-- Plan Summary -->
<div class="bg-blue-50 rounded-lg p-4">
  <h3 class="text-lg font-medium text-blue-900 mb-2">Plan Summary</h3>
  <div id="plan-summary" class="text-sm text-blue-700">
    <p>Configure the plan details above to see a summary.</p>
  </div>
</div>

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
  <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    Cancel
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    function updatePlanSummary() {
        const times = document.getElementById('times').value;
        const timesType = document.getElementById('times_type').value;
        const duration = document.getElementById('duration').value;
        const durationType = document.getElementById('duration_type').value;
        const price = document.getElementById('price').value;
        const priceType = document.getElementById('price_type').value;
        const name = document.getElementById('name').value;
        
        const summaryEl = document.getElementById('plan-summary');
        
        if (times && duration && price && name) {
            const totalSessions = timesType === 'week' ? 
                (times * duration * (durationType === 'month' ? 4 : 1)) : 
                (times * duration * (durationType === 'week' ? 0.25 : 1));
            
            const totalPrice = priceType === 'class' ? 
                (price * totalSessions) : 
                (price * duration * (durationType === 'month' ? 1 : 0.25));
            
            summaryEl.innerHTML = `
                <p><strong>${name}</strong></p>
                <p>• ${times} sessions per ${timesType}</p>
                <p>• Plan duration: ${duration} ${durationType}(s)</p>
                <p>• Total sessions: ~${Math.round(totalSessions)}</p>
                <p>• Price: $${price} per ${priceType}</p>
                <p>• <strong>Total cost: $${totalPrice.toFixed(2)}</strong></p>
            `;
        } else {
            summaryEl.innerHTML = '<p>Configure the plan details above to see a summary.</p>';
        }
    }
    
    // Add event listeners to update summary
    ['times', 'times_type', 'duration', 'duration_type', 'price', 'price_type', 'name'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('input', updatePlanSummary);
            element.addEventListener('change', updatePlanSummary);
        }
    });
    
    // Initial summary update
    updatePlanSummary();
});
</script>
@endpush
