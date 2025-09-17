<!-- Class Name -->
<div>
  <label for="name" class="block text-sm font-medium text-gray-700">Class Name *</label>
  <div class="mt-1">
    <input type="text" name="name" id="name" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror" 
           value="{{ old('name', $classType->name ?? '') }}" 
           required>
  </div>
  @error('name')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Description -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
  <div class="mt-1">
    <textarea name="description" id="description" rows="3" 
              class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 @enderror" 
              placeholder="Class description, benefits, requirements...">{{ old('description', $classType->description ?? '') }}</textarea>
  </div>
  @error('description')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Class Details Grid -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
  <!-- Max Clients -->
  <div>
    <label for="max_number_of_clients" class="block text-sm font-medium text-gray-700">Max Number of Clients</label>
    <div class="mt-1">
      <input type="number" name="max_number_of_clients" id="max_number_of_clients" min="1" max="100" 
             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('max_number_of_clients') border-red-300 @enderror" 
             value="{{ old('max_number_of_clients', $classType->max_number_of_clients ?? '') }}">
    </div>
    @error('max_number_of_clients')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>

  <!-- Duration -->
  <div>
    <label for="duration" class="block text-sm font-medium text-gray-700">Duration (Minutes)</label>
    <div class="mt-1">
      <input type="number" name="duration" id="duration" min="15" max="180" step="15" 
             class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration') border-red-300 @enderror" 
             value="{{ old('duration', $classType->duration ?? '') }}">
    </div>
    @error('duration')
      <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
  </div>
</div>

<!-- Extra Class Price -->
<div>
  <label for="extra_class_price" class="block text-sm font-medium text-gray-700">Extra Class Price</label>
  <div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <span class="text-gray-500 sm:text-sm">$</span>
    </div>
    <input type="number" name="extra_class_price" id="extra_class_price" min="0" step="0.01"
           class="block w-full pl-7 pr-12 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('extra_class_price') border-red-300 @enderror" 
           value="{{ old('extra_class_price', $classType->extra_class_price ?? '') }}"
           placeholder="0.00">
  </div>
  @error('extra_class_price')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Trial Offer -->
<div>
  <label for="trial" class="block text-sm font-medium text-gray-700">Free Trial Available</label>
  <div class="mt-1">
    <select name="trial" id="trial" 
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('trial') border-red-300 @enderror">
      <option value="1" {{ old('trial', $classType->trial ?? 0) == 1 ? 'selected' : '' }}>Yes</option>
      <option value="0" {{ old('trial', $classType->trial ?? 0) == 0 ? 'selected' : '' }}>No</option>
    </select>
  </div>
  @error('trial')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Class Statuses -->
@if(isset($classType) && $classType->statuses && count($classType->statuses) > 0)
<div>
  <label class="block text-sm font-medium text-gray-700 mb-3">Class Statuses</label>
  <div class="bg-gray-50 rounded-lg p-4">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Charge Client</th>
            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pay Professional</th>
            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          @foreach($classType->statuses as $key => $status)
            <tr>
              <td class="px-3 py-2 text-sm text-gray-900">
                <input type="hidden" name="status[{{ $key }}][id]" value="{{ $status->id }}">
                <input type="hidden" name="status[{{ $key }}][name]" value="{{ $status->name }}">
                {{ $status->name }}
              </td>
              <td class="px-3 py-2">
                <input type="hidden" name="status[{{ $key }}][charge_client]" value="0">
                <input type="checkbox" name="status[{{ $key }}][charge_client]" value="1" 
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                       {{ $status->charge_client ? 'checked' : '' }}>
              </td>
              <td class="px-3 py-2">
                <input type="hidden" name="status[{{ $key }}][pay_professional]" value="0">
                <input type="checkbox" name="status[{{ $key }}][pay_professional]" value="1" 
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                       {{ $status->pay_professional ? 'checked' : '' }}>
              </td>
              <td class="px-3 py-2">
                <input type="color" name="status[{{ $key }}][color]" value="{{ $status->color }}" 
                       class="h-8 w-16 rounded border border-gray-300">
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endif

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
  <a href="{{ route('classes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    Cancel
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>
