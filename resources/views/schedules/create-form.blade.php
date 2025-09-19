<!-- Client Selection -->
<div>
  <label for="client_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client *</label>
  <div class="mt-1">
    <select name="client_id" id="client_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('client_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      <option value="">Select a client...</option>
      @if(isset($clients))
        @foreach($clients as $client)
          <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
            {{ $client->name }}
          </option>
        @endforeach
      @endif
    </select>
  </div>
  @error('client_id')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Class Type Selection -->
<div>
  <label for="class_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class Type *</label>
  <div class="mt-1">
    <select name="class_type_id" id="class_type_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('class_type_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      <option value="">Select a class type...</option>
      @if(isset($classTypes))
        @foreach($classTypes as $classType)
          <option value="{{ $classType->id }}" {{ old('class_type_id') == $classType->id ? 'selected' : '' }}>
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

<!-- Professional Selection -->
<div>
  <label for="professional_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional *</label>
  <div class="mt-1">
    <select name="professional_id" id="professional_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('professional_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      <option value="">Select a professional...</option>
      @if(isset($professionals))
        @foreach($professionals as $professional)
          <option value="{{ $professional->id }}" {{ old('professional_id') == $professional->id ? 'selected' : '' }}>
            {{ $professional->name }}
          </option>
        @endforeach
      @endif
    </select>
  </div>
  @error('professional_id')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Room Selection -->
<div>
  <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room *</label>
  <div class="mt-1">
    <select name="room_id" id="room_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('room_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      <option value="">Select a room...</option>
      @if(isset($rooms))
        @foreach($rooms as $room)
          <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
            {{ $room->name }}
          </option>
        @endforeach
      @endif
    </select>
  </div>
  @error('room_id')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Date and Time -->
<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
  <div>
    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date *</label>
    <div class="mt-1">
      <input type="date" name="start_date" id="start_date" 
             class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('start_date') border-red-300 dark:border-red-500 @enderror" 
             value="{{ old('start_date', request('date')) }}" 
             required>
    </div>
    @error('start_date')
      <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
  </div>

  <div>
    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Start Time *</label>
    <div class="mt-1">
      <input type="time" name="start_time" id="start_time" 
             class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('start_time') border-red-300 dark:border-red-500 @enderror" 
             value="{{ old('start_time', request('start_time')) }}" 
             required>
    </div>
    @error('start_time')
      <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
  </div>
</div>

<!-- Duration -->
<div>
  <label for="duration" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Duration (minutes)</label>
  <div class="mt-1">
    <input type="number" name="duration" id="duration" min="15" step="15" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('duration') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('duration', 60) }}" 
           placeholder="60">
  </div>
  @error('duration')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Price -->
<div>
  <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
  <div class="mt-1 relative rounded-md shadow-sm">
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
      <span class="text-gray-500 dark:text-gray-400 sm:text-sm">$</span>
    </div>
    <input type="number" name="price" id="price" min="0" step="0.01"
           class="block w-full pl-7 pr-12 rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('price') border-red-300 dark:border-red-500 @enderror" 
           value="{{ old('price') }}"
           placeholder="0.00">
  </div>
  @error('price')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Observation -->
<div>
  <label for="observation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
  <div class="mt-1">
    <textarea name="observation" id="observation" rows="3" 
              class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('observation') border-red-300 dark:border-red-500 @enderror" 
              placeholder="Any additional notes for this session...">{{ old('observation') }}</textarea>
  </div>
  @error('observation')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
  <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    Cancel
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>