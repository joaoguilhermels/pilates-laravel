<!-- Room Name -->
<div>
  <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room Name *</label>
  <div class="mt-1">
    <input type="text" name="name" id="name" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 @enderror" 
           value="{{ old('name', $room->name ?? '') }}" 
           required>
  </div>
  @error('name')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Description -->
<div>
  <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
  <div class="mt-1">
    <textarea name="description" id="description" rows="3" 
              class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('description') border-red-300 @enderror" 
              placeholder="Room description, capacity, equipment...">{{ old('description', $room->description ?? '') }}</textarea>
  </div>
  @error('description')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Capacity -->
<div>
  <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Capacity</label>
  <div class="mt-1">
    <input type="number" name="capacity" id="capacity" min="1" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('capacity') border-red-300 @enderror" 
           value="{{ old('capacity', $room->capacity ?? '') }}" 
           placeholder="Maximum number of people">
  </div>
  @error('capacity')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Class Types -->
@if(isset($classTypes) && count($classTypes) > 0)
<div>
  <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Available Class Types</label>
  <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 space-y-2">
    @foreach($classTypes as $classType)
      <div class="flex items-center">
        <input type="checkbox" name="class_type_list[]" value="{{ $classType->id }}" 
               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded"
               {{ (isset($room) && $room->classTypes && $room->classTypes->contains($classType->id)) || in_array($classType->id, old('class_type_list', [])) ? 'checked' : '' }}>
        <label class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $classType->name }}</label>
      </div>
    @endforeach
  </div>
  <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Select which types of classes can be held in this room.</p>
</div>
@endif

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
  <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
    Cancel
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>
