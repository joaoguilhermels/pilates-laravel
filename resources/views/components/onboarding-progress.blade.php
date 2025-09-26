@props(['user'])

@php
    // Get counts for onboarding steps - these are global counts, not user-specific
    $roomsCount = \App\Models\Room::count();
    $classTypesCount = \App\Models\ClassType::count();
    $plansCount = \App\Models\Plan::count();
    $professionalsCount = \App\Models\Professional::count();
    
    // Define onboarding steps with better descriptions and priorities
    $steps = [
        [
            'id' => 'profile',
            'title' => __('app.complete_your_profile'),
            'description' => __('app.add_basic_information'),
            'icon' => 'user',
            'route' => 'profile.edit',
            'priority' => 1,
            'completed' => !empty($user->name) && !empty($user->email) && !empty($user->studio_name)
        ],
        [
            'id' => 'rooms',
            'title' => __('app.set_up_studio_rooms'),
            'description' => __('app.define_spaces_classes_held'),
            'icon' => 'building',
            'route' => 'rooms.create',
            'priority' => 2,
            'completed' => $roomsCount > 0
        ],
        [
            'id' => 'class_types',
            'title' => __('app.create_class_types'),
            'description' => __('app.define_types_classes_offer'),
            'icon' => 'academic-cap',
            'route' => 'classes.create',
            'priority' => 3,
            'completed' => $classTypesCount > 0
        ],
        [
            'id' => 'plans',
            'title' => __('app.set_up_pricing_plans'),
            'description' => __('app.create_subscription_plans_clients'),
            'icon' => 'document-text',
            'route' => 'plans.create',
            'priority' => 4,
            'completed' => $plansCount > 0
        ]
    ];
    
    // Add professionals step for studio owners
    if (method_exists($user, 'hasRole') && $user->hasRole('studio_owner')) {
        array_splice($steps, 2, 0, [[
            'id' => 'professionals',
            'title' => __('app.add_your_first_instructor'),
            'description' => __('app.add_professionals_teach_classes'),
            'icon' => 'users',
            'route' => 'professionals.create',
            'priority' => 3,
            'completed' => $professionalsCount > 0
        ]]);
        
        // Reorder priorities after insertion
        foreach ($steps as $index => &$step) {
            if ($step['id'] === 'class_types') $step['priority'] = 4;
            if ($step['id'] === 'plans') $step['priority'] = 5;
        }
    }
    
    $completedSteps = collect($steps)->filter(fn($step) => $step['completed'])->count();
    $totalSteps = count($steps);
    $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
    $isComplete = $progress === 100;
    
    // Find next step to focus on
    $nextStep = collect($steps)->first(fn($step) => !$step['completed']);
@endphp

@if(!$user->onboarding_completed && !$user->onboarding_skipped)
<!-- Simplified Progress Bar -->
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-6">
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center">
            <div class="w-6 h-6 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mr-2">
                <svg class="w-3 h-3 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('app.initial_setup') }}</span>
        </div>
        <div class="flex items-center space-x-3">
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $completedSteps }}/{{ $totalSteps }}</span>
            <button onclick="skipOnboarding()" 
                    class="text-xs text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                {{ __('app.skip') }}
            </button>
        </div>
    </div>
    
    <!-- Compact Progress Bar -->
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 mb-3">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-1.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
    </div>
    
    @if($isComplete)
        <!-- Completion State -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm text-green-700 dark:text-green-300 font-medium">{{ __('app.setup_complete') }}</span>
            </div>
            <a href="{{ route('onboarding.wizard') }}" 
               class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                {{ __('app.finish') }}
            </a>
        </div>
    @elseif($nextStep)
        <!-- Next Step Focus -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                @php
                    $iconMap = [
                        'user' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                        'building' => 'M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 6a2 2 0 104 0 2 2 0 00-4 0zm8 0a2 2 0 104 0 2 2 0 00-4 0z',
                        'users' => 'M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z',
                        'academic-cap' => 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z',
                        'document-text' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'
                    ];
                    $iconPath = $iconMap[$nextStep['icon']] ?? $iconMap['user'];
                @endphp
                <div class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-2">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                    </svg>
                </div>
                <div>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $nextStep['title'] }}</span>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $nextStep['description'] }}</p>
                </div>
            </div>
            <a href="{{ route($nextStep['route']) }}" 
               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-md transition-colors duration-200">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
                {{ __('app.start') }}
            </a>
        </div>
    @endif
</div>

@if($nextStep && $completedSteps > 0)
<!-- Quick Setup Grid - Only show after first step -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('app.quick_setup') }}</h3>
        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('app.optional') }}</span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($steps as $step)
            @if(!$step['completed'])
                <a href="{{ route($step['route']) }}" 
                   class="group p-4 border border-gray-200 dark:border-gray-600 rounded-lg hover:border-indigo-300 dark:hover:border-indigo-500 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-start">
                        <div class="w-8 h-8 bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/20 rounded-lg flex items-center justify-center mr-3 transition-colors">
                            @php $iconPath = $iconMap[$step['icon']] ?? $iconMap['user']; @endphp
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $step['title'] }}
                            </h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $step['description'] }}</p>
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>
@endif

<script>
async function skipOnboarding() {
    if (!confirm('{{ __('app.confirm_skip_setup') }}')) {
        return;
    }
    
    try {
        const response = await fetch('{{ route("onboarding.skip") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert(result.message || '{{ __('app.error_skipping_setup') }}');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('{{ __('app.error_skipping_setup') }}');
    }
}
</script>
@endif
