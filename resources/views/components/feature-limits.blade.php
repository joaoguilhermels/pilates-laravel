@props(['user'])

@php
    $usage = $user->getResourceUsageSummary();
    $hasLimits = collect($usage)->filter(fn($data) => !$data['unlimited'])->isNotEmpty();
@endphp

@if($hasLimits)
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            📊 Uso do Plano {{ $user->getPlanName() }}
        </h3>
        @if($user->needsUpgrade())
            <a href="{{ route('upgrade') }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200 hover:bg-yellow-200 dark:hover:bg-yellow-900/40 transition-colors">
                ⚡ Upgrade
            </a>
        @endif
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($usage as $resource => $data)
            @if(!$data['unlimited'])
                <div class="text-center">
                    <div class="relative w-16 h-16 mx-auto mb-2">
                        <svg class="w-16 h-16 transform -rotate-90" viewBox="0 0 36 36">
                            <path
                                class="text-gray-300 dark:text-gray-600"
                                stroke="currentColor"
                                stroke-width="3"
                                fill="none"
                                d="M18 2.0845
                                   a 15.9155 15.9155 0 0 1 0 31.831
                                   a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                            <path
                                class="{{ $data['at_limit'] ? 'text-red-500' : ($data['near_limit'] ? 'text-yellow-500' : 'text-green-500') }}"
                                stroke="currentColor"
                                stroke-width="3"
                                stroke-linecap="round"
                                fill="none"
                                stroke-dasharray="{{ $data['percentage'] ?? 0 }}, 100"
                                d="M18 2.0845
                                   a 15.9155 15.9155 0 0 1 0 31.831
                                   a 15.9155 15.9155 0 0 1 0 -31.831"
                            />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xs font-semibold text-gray-900 dark:text-white">
                                {{ round($data['percentage'] ?? 0) }}%
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $data['current'] }} / {{ $data['limit'] }}
                    </div>
                    <div class="text-xs text-gray-600 dark:text-gray-400 capitalize">
                        {{ $resource }}
                    </div>
                    
                    @if($data['at_limit'])
                        <div class="text-xs text-red-600 dark:text-red-400 font-medium mt-1">
                            Limite atingido
                        </div>
                    @elseif($data['near_limit'])
                        <div class="text-xs text-yellow-600 dark:text-yellow-400 font-medium mt-1">
                            Próximo do limite
                        </div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    @if($user->needsUpgrade())
        <div class="mt-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        Você atingiu alguns limites do seu plano. 
                        <a href="{{ route('upgrade') }}" class="font-medium underline hover:no-underline">
                            Faça upgrade para continuar crescendo!
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endif
