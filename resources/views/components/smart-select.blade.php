@props([
    'name',
    'label',
    'required' => false,
    'items' => collect(),
    'emptyType' => null,
    'createRoute' => null,
    'createText' => null,
    'placeholder' => null,
    'valueField' => 'id',
    'textField' => 'name',
    'selected' => null,
    'disabled' => false
])

@php
    $hasItems = $items && $items->count() > 0;
    $isEmpty = !$hasItems;
    $fieldId = $name . '_' . uniqid();
    $emptyKey = $emptyType ? "empty_select_{$emptyType}" : 'no_items_available';
    $placeholderText = $placeholder ?? __("app.select_{$emptyType}");
@endphp

<div class="space-y-3">
    <!-- Label -->
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
        {{ $label }}
        @if($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if($isEmpty)
        <!-- Empty State Inline -->
        <div class="relative">
            <!-- Disabled Select -->
            <select 
                name="{{ $name }}" 
                id="{{ $fieldId }}"
                disabled
                class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 shadow-sm sm:text-sm cursor-not-allowed">
                <option value="">{{ __("app.{$emptyKey}") }}</option>
            </select>
            
            <!-- Empty State Overlay -->
            <div class="absolute inset-0 flex items-center justify-between px-3 pointer-events-none">
                <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                    <svg class="w-4 h-4 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                    {{ __("app.{$emptyKey}") }}
                </span>
            </div>
        </div>

        <!-- Action Button -->
        @if($createRoute && $createText)
            <div class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            {{ __("app.need_to_create_{$emptyType}") }}
                        </p>
                        <p class="text-xs text-blue-600 dark:text-blue-300">
                            {{ __("app.create_{$emptyType}_description") }}
                        </p>
                    </div>
                </div>
                <a href="{{ $createRoute }}" 
                   class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ $createText }}
                </a>
            </div>
        @endif
    @else
        <!-- Normal Select with Items -->
        <select 
            name="{{ $name }}" 
            id="{{ $fieldId }}"
            {{ $disabled ? 'disabled' : '' }}
            {{ $required ? 'required' : '' }}
            class="block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error($name) border-red-300 dark:border-red-500 @enderror {{ $disabled ? 'bg-gray-100 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed' : '' }}">
            
            <option value="">{{ $placeholderText }}</option>
            
            @foreach($items as $item)
                @php
                    $value = is_array($item) ? $item[$valueField] : $item->{$valueField};
                    $text = is_array($item) ? $item[$textField] : $item->{$textField};
                    $isSelected = $selected == $value || old($name) == $value;
                @endphp
                <option value="{{ $value }}" {{ $isSelected ? 'selected' : '' }}>
                    {{ $text }}
                </option>
            @endforeach
        </select>

        <!-- Items Count Info -->
        <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span>{{ $items->count() }} {{ __("app.{$emptyType}_available") }}</span>
            @if($createRoute)
                <a href="{{ $createRoute }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 font-medium">
                    + {{ __("app.add_another_{$emptyType}") }}
                </a>
            @endif
        </div>
    @endif

    <!-- Error Message -->
    @error($name)
        <p class="mt-1 text-sm text-red-600 dark:text-red-400 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>
