@extends('layouts.dashboard')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Schedule Trial Class</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">Create a trial class for a new client.</p>
      </div>
      <a href="{{ route('calendar') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Back to Calendar
      </a>
    </div>
  </div>

  @if($classTypes->count() == 0)
    <!-- No Trial Classes Available -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
      <div class="flex">
        <div class="flex-shrink-0">
          <svg class="h-5 w-5 text-yellow-400 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
          </svg>
        </div>
        <div class="ml-3">
          <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">No Trial Classes Available</h3>
          <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
            <p>No class types are configured to allow trial classes. Please configure at least one class type to enable trials before scheduling trial classes.</p>
          </div>
          <div class="mt-4">
            <a href="{{ route('classes.index') }}" class="text-sm font-medium text-yellow-800 dark:text-yellow-200 hover:text-yellow-600 dark:hover:text-yellow-100">
              Configure Class Types →
            </a>
          </div>
        </div>
      </div>
    </div>
  @else
    <!-- Form -->
    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
      <form action="{{ route('schedules.trial.store') }}" method="POST" class="space-y-6 p-6">
        @csrf
        
        <!-- Client Information -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-4 border border-yellow-200 dark:border-yellow-800">
          <h3 class="text-lg font-medium text-yellow-900 dark:text-yellow-200 mb-4">New Client Information</h3>
          <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name *</label>
              <div class="mt-1">
                <input type="text" name="name" id="name" 
                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('name') border-red-300 dark:border-red-500 @enderror" 
                       value="{{ old('name') }}" 
                       required>
              </div>
              @error('name')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
              <div class="mt-1">
                <input type="tel" name="phone" id="phone" 
                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('phone') border-red-300 dark:border-red-500 @enderror" 
                       value="{{ old('phone') }}">
              </div>
              @error('phone')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>

            <div class="sm:col-span-2">
              <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
              <div class="mt-1">
                <input type="email" name="email" id="email" 
                       class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('email') border-red-300 dark:border-red-500 @enderror" 
                       value="{{ old('email') }}">
              </div>
              @error('email')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Class Selection -->
        <div>
          <label for="class_type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Trial Class Type *</label>
          <div class="mt-1">
            <select name="class_type_id" id="class_type_id" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('class_type_id') border-red-300 dark:border-red-500 @enderror" 
                    required onchange="updateClassDetails()">
              <option value="">Select a trial class type...</option>
              @foreach($classTypes as $classType)
                <option value="{{ $classType->id }}" 
                        data-duration="{{ $classType->duration }}"
                        data-price="{{ $classType->trial_class_price }}"
                        {{ old('class_type_id') == $classType->id ? 'selected' : '' }}>
                  {{ $classType->name }} - ${{ number_format($classType->trial_class_price, 2) }} ({{ $classType->duration }} min)
                </option>
              @endforeach
            </select>
          </div>
          @error('class_type_id')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Professional Selection -->
        <div id="professional-section" class="hidden">
          <label for="professional_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instructor *</label>
          <div class="mt-1">
            <select name="professional_id" id="professional_id" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('professional_id') border-red-300 dark:border-red-500 @enderror">
              <option value="">Select an instructor...</option>
            </select>
          </div>
          @error('professional_id')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Room Selection -->
        <div id="room-section" class="hidden">
          <label for="room_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Room *</label>
          <div class="mt-1">
            <select name="room_id" id="room_id" 
                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('room_id') border-red-300 dark:border-red-500 @enderror">
              <option value="">Select a room...</option>
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
                     value="{{ old('start_date', request('date', \Carbon\Carbon::now()->format('Y-m-d'))) }}" 
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
                     value="{{ old('start_time', request('start_time', '09:00')) }}" 
                     required>
            </div>
            @error('start_time')
              <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <!-- Notes -->
        <div>
          <label for="observation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes</label>
          <div class="mt-1">
            <textarea name="observation" id="observation" rows="3" 
                      class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('observation') border-red-300 dark:border-red-500 @enderror" 
                      placeholder="Any special notes or requirements for this trial class...">{{ old('observation', 'New client. Scheduled a trial class.') }}</textarea>
          </div>
          @error('observation')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-700">
          <a href="{{ route('calendar') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
            Cancel
          </a>
          <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-900 transition-colors duration-200">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Schedule Trial Class
          </button>
        </div>
      </form>
    </div>
  @endif
</div>

@push('scripts')
<script>
const classTypesData = @json($classTypes);

function updateClassDetails() {
  const classTypeSelect = document.getElementById('class_type_id');
  const selectedClassTypeId = classTypeSelect.value;
  const professionalSection = document.getElementById('professional-section');
  const roomSection = document.getElementById('room-section');
  const professionalSelect = document.getElementById('professional_id');
  const roomSelect = document.getElementById('room_id');
  
  if (selectedClassTypeId) {
    const selectedClassType = classTypesData.find(ct => ct.id == selectedClassTypeId);
    
    if (selectedClassType) {
      // Show sections
      professionalSection.classList.remove('hidden');
      roomSection.classList.remove('hidden');
      
      // Populate professionals
      professionalSelect.innerHTML = '<option value="">Select an instructor...</option>';
      if (selectedClassType.professionals) {
        selectedClassType.professionals.forEach(professional => {
          const option = document.createElement('option');
          option.value = professional.id;
          option.textContent = professional.name;
          professionalSelect.appendChild(option);
        });
      }
      
      // Populate rooms
      roomSelect.innerHTML = '<option value="">Select a room...</option>';
      if (selectedClassType.rooms) {
        selectedClassType.rooms.forEach(room => {
          const option = document.createElement('option');
          option.value = room.id;
          option.textContent = room.name;
          roomSelect.appendChild(option);
        });
      }
    }
  } else {
    professionalSection.classList.add('hidden');
    roomSection.classList.add('hidden');
  }
}

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
  updateClassDetails();
});
</script>
@endpush
@endsection