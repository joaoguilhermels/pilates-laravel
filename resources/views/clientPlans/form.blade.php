<!-- Start Date -->
<div>
  <label for="start_at" class="block text-sm font-medium text-gray-700">Plan Start Date *</label>
  <div class="mt-1">
    <input type="date" name="start_at" id="start_at" 
           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('start_at') border-red-300 @enderror" 
           value="{{ old('start_at', \Carbon\Carbon::now()->format('Y-m-d')) }}" 
           required>
  </div>
  @error('start_at')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Plan Selection -->
<div>
  <label for="plan_id" class="block text-sm font-medium text-gray-700">Select Plan *</label>
  <div class="mt-1">
    <select name="plan_id" id="plan_id" 
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('plan_id') border-red-300 @enderror" 
            required onchange="updatePlanDetails()">
      <option value="">Choose a membership plan...</option>
      @if(isset($classTypePlans))
        @foreach($classTypePlans as $classType)
          <optgroup label="{{ $classType->name }}">
            @foreach($classType->plans as $plan)
              <option value="{{ $plan->id }}" 
                      data-class-type="{{ $classType->name }}"
                      data-plan-name="{{ $plan->name }}"
                      data-times="{{ $plan->times }}"
                      data-times-type="{{ $plan->times_type }}"
                      data-duration="{{ $plan->duration }}"
                      data-duration-type="{{ $plan->duration_type }}"
                      data-price="{{ $plan->price }}"
                      data-price-type="{{ $plan->price_type }}"
                      {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                {{ $plan->name }} - ${{ number_format($plan->price, 2) }} per {{ $plan->price_type }}
              </option>
            @endforeach
          </optgroup>
        @endforeach
      @endif
    </select>
  </div>
  @error('plan_id')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
  @enderror
</div>

<!-- Plan Details Preview -->
<div id="plan-details" class="hidden bg-blue-50 rounded-lg p-4">
  <h3 class="text-lg font-medium text-blue-900 mb-2">Plan Details</h3>
  <div id="plan-summary" class="text-sm text-blue-700">
    <!-- Plan details will be populated by JavaScript -->
  </div>
</div>

<!-- Schedule Configuration -->
<div id="schedule-config" class="hidden space-y-4">
  <h3 class="text-lg font-medium text-gray-900">Schedule Configuration</h3>
  <p class="text-sm text-gray-600">Configure when the client will attend classes for this plan.</p>
  
  <div id="schedule-slots">
    <!-- Schedule slots will be added dynamically -->
  </div>
  
  <button type="button" onclick="addScheduleSlot()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
    <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
    </svg>
    Add Schedule Slot
  </button>
</div>

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
  <a href="{{ route('clients.show', $client ?? '') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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
let scheduleSlotCount = 0;
const professionalsData = @json($professionals ?? []);
const roomsData = @json($rooms ?? []);

function updatePlanDetails() {
  const select = document.getElementById('plan_id');
  const selectedOption = select.options[select.selectedIndex];
  const planDetails = document.getElementById('plan-details');
  const scheduleConfig = document.getElementById('schedule-config');
  
  if (selectedOption.value) {
    const classType = selectedOption.dataset.classType;
    const planName = selectedOption.dataset.planName;
    const times = selectedOption.dataset.times;
    const timesType = selectedOption.dataset.timesType;
    const duration = selectedOption.dataset.duration;
    const durationType = selectedOption.dataset.durationType;
    const price = selectedOption.dataset.price;
    const priceType = selectedOption.dataset.priceType;
    
    document.getElementById('plan-summary').innerHTML = `
      <p><strong>${classType} - ${planName}</strong></p>
      <p>• ${times} sessions per ${timesType}</p>
      <p>• Plan duration: ${duration} ${durationType}(s)</p>
      <p>• Price: $${parseFloat(price).toFixed(2)} per ${priceType}</p>
    `;
    
    planDetails.classList.remove('hidden');
    scheduleConfig.classList.remove('hidden');
    
    // Clear existing schedule slots and add initial slot
    document.getElementById('schedule-slots').innerHTML = '';
    scheduleSlotCount = 0;
    
    // Add initial schedule slots based on plan frequency
    const slotsNeeded = timesType === 'week' ? parseInt(times) : 1;
    for (let i = 0; i < slotsNeeded; i++) {
      addScheduleSlot();
    }
  } else {
    planDetails.classList.add('hidden');
    scheduleConfig.classList.add('hidden');
  }
}

function addScheduleSlot() {
  scheduleSlotCount++;
  const slotsContainer = document.getElementById('schedule-slots');
  
  // Build professionals options
  let professionalsOptions = '<option value="">Select professional...</option>';
  professionalsData.forEach(professional => {
    professionalsOptions += `<option value="${professional.id}">${professional.name}</option>`;
  });
  
  // Build rooms options
  let roomsOptions = '<option value="">Select room...</option>';
  roomsData.forEach(room => {
    roomsOptions += `<option value="${room.id}">${room.name}</option>`;
  });
  
  const slotHtml = `
    <div class="schedule-slot bg-gray-50 rounded-lg p-4" id="slot-${scheduleSlotCount}">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-sm font-medium text-gray-900">Schedule Slot ${scheduleSlotCount}</h4>
        <button type="button" onclick="removeScheduleSlot(${scheduleSlotCount})" class="text-red-600 hover:text-red-500">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
      
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Day of Week</label>
          <select name="daysOfWeek[${scheduleSlotCount}][day_of_week]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            <option value="">Select day...</option>
            <option value="0">Sunday</option>
            <option value="1">Monday</option>
            <option value="2">Tuesday</option>
            <option value="3">Wednesday</option>
            <option value="4">Thursday</option>
            <option value="5">Friday</option>
            <option value="6">Saturday</option>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Time</label>
          <input type="time" name="daysOfWeek[${scheduleSlotCount}][hour]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Professional</label>
          <select name="daysOfWeek[${scheduleSlotCount}][professional_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            ${professionalsOptions}
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700">Room</label>
          <select name="daysOfWeek[${scheduleSlotCount}][room_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            ${roomsOptions}
          </select>
        </div>
      </div>
    </div>
  `;
  
  slotsContainer.insertAdjacentHTML('beforeend', slotHtml);
}

function removeScheduleSlot(slotId) {
  const slot = document.getElementById(`slot-${slotId}`);
  if (slot) {
    slot.remove();
  }
}

// Initialize form
document.addEventListener('DOMContentLoaded', function() {
  updatePlanDetails();
});
</script>
@endpush
