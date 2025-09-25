@props(['insights' => []])

@php
    // Generate smart insights based on data patterns
    $defaultInsights = [
        [
            'type' => 'trend',
            'title' => 'Tendência de Agendamentos',
            'description' => 'Seus agendamentos aumentaram 15% esta semana',
            'action' => 'Ver detalhes',
            'actionUrl' => route('schedules.index'),
            'icon' => 'trending-up',
            'color' => 'green'
        ],
        [
            'type' => 'opportunity',
            'title' => 'Horários Disponíveis',
            'description' => 'Você tem 8 horários livres amanhã que podem ser preenchidos',
            'action' => 'Agendar aulas',
            'actionUrl' => route('schedules.create'),
            'icon' => 'clock',
            'color' => 'blue'
        ],
        [
            'type' => 'alert',
            'title' => 'Clientes Inativos',
            'description' => '3 clientes não agendam há mais de 2 semanas',
            'action' => 'Entrar em contato',
            'actionUrl' => route('clients.index', ['filter' => 'inactive']),
            'icon' => 'user-group',
            'color' => 'yellow'
        ]
    ];
    
    $allInsights = array_merge($defaultInsights, $insights);
@endphp

@if(count($allInsights) > 0)
<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            Insights Inteligentes
        </h3>
        <button class="text-sm text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
            Ver todos
        </button>
    </div>

    <div class="space-y-4">
        @foreach($allInsights as $insight)
            <div class="flex items-start space-x-3 p-3 rounded-lg border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center
                        @if($insight['color'] === 'green') bg-green-100 dark:bg-green-900/20
                        @elseif($insight['color'] === 'blue') bg-blue-100 dark:bg-blue-900/20
                        @elseif($insight['color'] === 'yellow') bg-yellow-100 dark:bg-yellow-900/20
                        @elseif($insight['color'] === 'red') bg-red-100 dark:bg-red-900/20
                        @else bg-gray-100 dark:bg-gray-900/20
                        @endif
                    ">
                        @if($insight['icon'] === 'trending-up')
                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        @elseif($insight['icon'] === 'clock')
                            <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @elseif($insight['icon'] === 'user-group')
                            <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        @endif
                    </div>
                </div>
                
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $insight['title'] }}
                        </h4>
                        @if($insight['type'] === 'trend')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-400">
                                Tendência
                            </span>
                        @elseif($insight['type'] === 'opportunity')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-400">
                                Oportunidade
                            </span>
                        @elseif($insight['type'] === 'alert')
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-400">
                                Atenção
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        {{ $insight['description'] }}
                    </p>
                    @if(isset($insight['action']) && isset($insight['actionUrl']))
                        <a href="{{ $insight['actionUrl'] }}" class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 mt-2 transition-colors duration-200">
                            {{ $insight['action'] }}
                            <svg class="ml-1 w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
