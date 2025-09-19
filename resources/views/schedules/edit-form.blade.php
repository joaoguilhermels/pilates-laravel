<!-- Client Information -->
<div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 border border-gray-200 dark:border-gray-600">
  <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-3">Schedule Information</h3>
  
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Client</label>
      <div class="mt-1 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md">
        <span class="text-sm text-gray-900 dark:text-white">{{ $schedule->client->name }}</span>
      </div>
      <input type="hidden" name="client_id" value="{{ $schedule->client_id }}">
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class Type</label>
      <div class="mt-1 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md">
        <span class="text-sm text-gray-900 dark:text-white">{{ $schedule->classType->name }}</span>
      </div>
      <input type="hidden" name="class_type_id" value="{{ $schedule->class_type_id }}">
    </div>
  </div>

  @if(isset($plan) && $plan)
  <div class="mt-4">
    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plan</label>
    <div class="mt-1 p-3 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-md">
      <span class="text-sm text-gray-900 dark:text-white">{{ $plan }}</span>
    </div>
    <input type="hidden" name="plan_id" value="{{ $schedule->clientPlanDetail->clientPlan->plan->id }}">
  </div>
  @endif
</div>

<!-- Status -->
<div>
  <label for="class_type_status_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status *</label>
  <div class="mt-1">
    <select name="class_type_status_id" id="class_type_status_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('class_type_status_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      @if(isset($classTypeStatuses))
        @foreach($classTypeStatuses as $classTypeStatus)
          <option value="{{ $classTypeStatus->id }}" {{ $classTypeStatus->id == $schedule->class_type_status_id ? 'selected' : '' }}>
            {{ $classTypeStatus->name }}
          </option>
        @endforeach
      @endif
    </select>
  </div>
  @error('class_type_status_id')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Professional -->
<div>
  <label for="professional_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Professional *</label>
  <div class="mt-1">
    <select name="professional_id" id="professional_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('professional_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      @if(isset($professionals))
        @foreach($professionals as $professional)
          <option value="{{ $professional->id }}" {{ $professional->id == $schedule->professional_id ? 'selected' : '' }}>
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

<!-- Room -->
<div>
  <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room *</label>
  <div class="mt-1">
    <select name="room_id" id="room_id" 
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('room_id') border-red-300 dark:border-red-500 @enderror" 
            required>
      @if(isset($rooms))
        @foreach($rooms as $room)
          <option value="{{ $room->id }}" {{ $room->id == $schedule->room_id ? 'selected' : '' }}>
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
             value="{{ old('start_date', $schedule->start_at->toDateString()) }}" 
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
             value="{{ old('start_time', $schedule->start_at->format('H:i')) }}" 
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
           value="{{ old('duration', $schedule->start_at->diffInMinutes($schedule->end_at)) }}" 
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
           value="{{ old('price', $schedule->price) }}"
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
              placeholder="Any additional notes for this session...">{{ old('observation', $schedule->observation) }}</textarea>
  </div>
  @error('observation')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
  <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    Cancel
  </a>
  <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    {{ $submitButtonText }}
  </button>
</div>
