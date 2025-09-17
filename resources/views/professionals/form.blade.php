<!-- Name Field -->
<div>
  <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
  <div class="mt-1">
    <input type="text" name="name" id="name" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror" 
           value="{{ old('name', $professional->name ?? '') }}" 
           required>
  </div>
  @error('name')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Phone Field -->
<div>
  <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
  <div class="mt-1">
    <input type="tel" name="phone" id="phone" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-300 @enderror" 
           value="{{ old('phone', $professional->phone ?? '') }}">
  </div>
  @error('phone')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Email Field -->
<div>
  <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
  <div class="mt-1">
    <input type="email" name="email" id="email" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-300 @enderror" 
           value="{{ old('email', $professional->email ?? '') }}" 
           required>
  </div>
  @error('email')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Salary Field -->
<div>
  <label for="salary" class="block text-sm font-medium text-gray-700">Fixed Salary</label>
  <div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <span class="text-gray-500 sm:text-sm">$</span>
    </div>
    <input type="number" name="salary" id="salary" min="0" step="0.01"
           class="block w-full pl-7 pr-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('salary') border-red-300 @enderror" 
           value="{{ old('salary', $professional->salary ?? '') }}"
           placeholder="0.00">
  </div>
  @error('salary')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Description Field -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
  <div class="mt-1">
    <textarea name="description" id="description" rows="4" 
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 @enderror" 
              placeholder="Professional background, specialties, certifications...">{{ old('description', $professional->description ?? '') }}</textarea>
  </div>
  @error('description')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Class Types Section -->
@if(isset($classTypes) && count($classTypes) > 0)
<div>
  <label class="block text-sm font-medium text-gray-700 mb-3">Class Types & Commission Rates</label>
  <div class="bg-gray-50 rounded-lg p-4 space-y-3">
    @foreach($classTypes as $classType)
      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input type="checkbox" name="class_types[]" value="{{ $classType->id }}" 
                 class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                 {{ in_array($classType->id, old('class_types', $professionalClassTypes ?? [])) ? 'checked' : '' }}>
          <label class="ml-2 text-sm text-gray-700">{{ $classType->name }}</label>
        </div>
        <div class="flex items-center space-x-2">
          <input type="number" name="commission_rates[{{ $classType->id }}]" 
                 class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                 min="0" max="100" step="0.01" placeholder="0.00"
                 value="{{ old('commission_rates.'.$classType->id, $professionalClassTypes[$classType->id]['percentage'] ?? '') }}">
          <span class="text-sm text-gray-500">%</span>
        </div>
      </div>
    @endforeach
  </div>
  <p class="mt-2 text-sm text-gray-500">Select the class types this professional can teach and set their commission rates.</p>
</div>
@endif

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
  <a href="{{ route('professionals.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    Cancel
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>
