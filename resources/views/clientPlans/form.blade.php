<!-- Start Date -->
<div>
  <label for="start_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.plan_start_date') }} *</label>
  <div class="mt-1">
    <input type="date" name="start_at" id="start_at" 
           class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('start_at') border-red-300 @enderror" 
           value="{{ old('start_at', \Carbon\Carbon::now()->format('Y-m-d')) }}" 
           required>
  </div>
  @error('start_at')
    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
  @enderror
</div>

<!-- Plan Selection -->
@php
  $hasPlans = isset($classTypePlans) && $classTypePlans->isNotEmpty() && $classTypePlans->some(fn($classType) => $classType->plans->isNotEmpty());
@endphp

@if($hasPlans)
  <div>
    <label for="plan_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.select_plan') }} *</label>
    <div class="mt-1">
      <select name="plan_id" id="plan_id" 
              class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('plan_id') border-red-300 @enderror" 
              required onchange="updatePlanDetails()">
        <option value="">{{ __('app.choose_membership_plan') }}</option>
        @foreach($classTypePlans as $classType)
          @if($classType->plans->isNotEmpty())
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
                  {{ $plan->name }} - R$ {{ number_format($plan->price, 2, ',', '.') }} por {{ $plan->price_type }}
                </option>
              @endforeach
            </optgroup>
          @endif
        @endforeach
      </select>
    </div>
    @error('plan_id')
      <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
  </div>
@else
  <!-- Empty State for No Plans -->
  <div class="text-center py-12 bg-gray-50 dark:bg-gray-800 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600">
    <svg class="mx-auto h-16 w-16 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">{{ __('app.no_plans_available') }}</h3>
    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto">
      {{ __('app.no_plans_description') }}
    </p>
    <div class="mt-6 flex flex-col sm:flex-row gap-3 justify-center">
      <a href="{{ route('plans.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        {{ __('app.create_first_plan') }}
      </a>
      <a href="{{ route('plans.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ __('app.manage_plans') }}
      </a>
    </div>
    <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
      <p class="text-sm text-blue-700 dark:text-blue-300">
        <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ __('app.plans_required_message') }}
      </p>
    </div>
  </div>
@endif

@if($hasPlans)
  <!-- Plan Details Preview -->
  <div id="plan-details" class="hidden bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
    <h3 class="text-lg font-medium text-blue-900 dark:text-blue-200 mb-2">{{ __('app.plan_details') }}</h3>
    <div id="plan-summary" class="text-sm text-blue-700 dark:text-blue-300">
      <!-- Plan details will be populated by JavaScript -->
    </div>
  </div>

  <!-- Schedule Configuration -->
  <div id="schedule-config" class="hidden space-y-4">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('app.schedule_configuration') }}</h3>
    <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('app.configure_client_schedule') }}</p>
    
    <div id="schedule-slots">
      <!-- Schedule slots will be added dynamically -->
    </div>
    
    <button type="button" onclick="addScheduleSlot()" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
      <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      {{ __('app.add_schedule_slot') }}
    </button>
  </div>
@endif

<!-- Submit Button -->
<div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 dark:border-gray-600">
  <a href="{{ route('clients.show', $client->id ?? '') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
    {{ __('app.cancel') }}
  </a>
  @if($hasPlans)
    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
      <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      {{ $submitButtonText }}
    </button>
  @endif
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
      <p>• ${times} sessões por ${timesType}</p>
      <p>• Duração do plano: ${duration} ${durationType}(s)</p>
      <p>• Preço: R$ ${parseFloat(price).toFixed(2).replace('.', ',')} por ${priceType}</p>
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
  let professionalsOptions = '<option value="">{{ __('app.select_professional_slot') }}</option>';
  professionalsData.forEach(professional => {
    professionalsOptions += `<option value="${professional.id}">${professional.name}</option>`;
  });
  
  // Build rooms options
  let roomsOptions = '<option value="">{{ __('app.select_room_slot') }}</option>';
  roomsData.forEach(room => {
    roomsOptions += `<option value="${room.id}">${room.name}</option>`;
  });
  
  const slotHtml = `
    <div class="schedule-slot bg-gray-50 dark:bg-gray-700 rounded-lg p-4" id="slot-${scheduleSlotCount}">
      <div class="flex items-center justify-between mb-3">
        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.schedule_slot') }} ${scheduleSlotCount}</h4>
        <button type="button" onclick="removeScheduleSlot(${scheduleSlotCount})" class="text-red-600 dark:text-red-400 hover:text-red-500 dark:hover:text-red-300">
          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </button>
      </div>
      
      <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.day_of_week') }}</label>
          <select name="daysOfWeek[${scheduleSlotCount}][day_of_week]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            <option value="">{{ __('app.select_day') }}</option>
            <option value="0">{{ __('app.sunday') }}</option>
            <option value="1">{{ __('app.monday') }}</option>
            <option value="2">{{ __('app.tuesday') }}</option>
            <option value="3">{{ __('app.wednesday') }}</option>
            <option value="4">{{ __('app.thursday') }}</option>
            <option value="5">{{ __('app.friday') }}</option>
            <option value="6">{{ __('app.saturday') }}</option>
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.time') }}</label>
          <input type="time" name="daysOfWeek[${scheduleSlotCount}][hour]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.professional') }}</label>
          <select name="daysOfWeek[${scheduleSlotCount}][professional_id]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            ${professionalsOptions}
          </select>
        </div>
        
        <div>
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.room') }}</label>
          <select name="daysOfWeek[${scheduleSlotCount}][room_id]" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
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
