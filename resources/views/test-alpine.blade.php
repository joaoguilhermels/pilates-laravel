@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Alpine.js Test</h1>
        <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Testing Alpine.js functionality</p>
    </div>

    <!-- Simple Alpine.js Test -->
    <div x-data="{ message: 'Alpine.js is working!', count: 0 }" class="mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Basic Alpine.js Test</h2>
            <p x-text="message" class="text-gray-700 dark:text-gray-300 mb-4"></p>
            <p class="text-gray-700 dark:text-gray-300 mb-4">Count: <span x-text="count"></span></p>
            <button @click="count++" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Increment
            </button>
        </div>
    </div>

    <!-- Onboarding Component Test -->
    <div x-data="onboardingWizard(true)" class="mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Onboarding Component Test</h2>
            <p class="text-gray-700 dark:text-gray-300 mb-4">Show Wizard: <span x-text="showWizard"></span></p>
            <p class="text-gray-700 dark:text-gray-300 mb-4">Current Step: <span x-text="currentStep"></span></p>
            
            <div class="space-x-4">
                <button @click="startOnboarding()" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Test Start Onboarding
                </button>
                <button @click="skipOnboarding()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
                    Test Skip Onboarding
                </button>
                <button @click="showWizard = !showWizard" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">
                    Toggle Wizard
                </button>
            </div>
        </div>
    </div>

    <!-- Debug Info -->
    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
        <h2 class="text-lg font-medium text-yellow-800 dark:text-yellow-200 mb-4">Debug Information</h2>
        <div class="text-sm text-yellow-700 dark:text-yellow-300 space-y-2">
            <p>Check the browser console for any JavaScript errors.</p>
            <p>If the increment button works, Alpine.js is loaded correctly.</p>
            <p>If the onboarding buttons work, the component is registered properly.</p>
        </div>
    </div>

    <div id="setup-steps" class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
        <h3 class="text-lg font-medium text-blue-800 dark:text-blue-200">Setup Steps Section</h3>
        <p class="text-blue-700 dark:text-blue-300">This is the target for the scroll functionality.</p>
    </div>
</div>
@endsection
