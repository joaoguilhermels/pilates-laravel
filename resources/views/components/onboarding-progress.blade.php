@props(['user'])

@php
    // Simulate the onboarding steps logic here for the component
    $steps = [
        [
            'id' => 'profile',
            'title' => 'Complete seu Perfil',
            'completed' => !empty($user->name) && !empty($user->email) && !empty($user->studio_name) && !empty($user->phone)
        ],
        [
            'id' => 'rooms',
            'title' => 'Configure Salas',
            'completed' => $user->rooms()->count() > 0
        ],
        [
            'id' => 'class_types',
            'title' => 'Tipos de Aula',
            'completed' => $user->classTypes()->count() > 0
        ],
        [
            'id' => 'plans',
            'title' => 'Criar Planos',
            'completed' => $user->plans()->count() > 0
        ]
    ];
    
    if ($user->isStudioOwner()) {
        array_splice($steps, 3, 0, [[
            'id' => 'professionals',
            'title' => 'Adicionar Profissionais',
            'completed' => $user->professionals()->count() > 0
        ]]);
    }
    
    $completedSteps = collect($steps)->filter(fn($step) => $step['completed'])->count();
    $totalSteps = count($steps);
    $progress = $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
    $isComplete = $progress === 100;
@endphp

@if(!$user->onboarding_completed && !$user->onboarding_skipped)
<div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-6 mb-6">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <div class="flex items-center mb-2">
                <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Configuração Inicial
                </h3>
            </div>
            
            <p class="text-gray-600 dark:text-gray-300 mb-4">
                @if($isComplete)
                    🎉 Parabéns! Você completou todos os passos básicos. Finalize a configuração para começar a usar o sistema.
                @else
                    Complete a configuração inicial para aproveitar ao máximo o PilatesFlow. {{ $completedSteps }} de {{ $totalSteps }} passos concluídos.
                @endif
            </p>
            
            <!-- Progress Bar -->
            <div class="mb-4">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progresso</span>
                    <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $progress }}%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                </div>
            </div>
            
            <!-- Steps Summary -->
            <div class="grid grid-cols-2 md:grid-cols-{{ min(4, count($steps)) }} gap-2 mb-4">
                @foreach($steps as $step)
                    <div class="flex items-center text-sm">
                        @if($step['completed'])
                            <svg class="w-4 h-4 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-green-700 dark:text-green-300">{{ $step['title'] }}</span>
                        @else
                            <svg class="w-4 h-4 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-500 dark:text-gray-400">{{ $step['title'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex flex-col space-y-2 ml-4">
            @if($isComplete)
                <a href="{{ route('onboarding.wizard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-lg transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    Finalizar
                </a>
            @else
                <a href="{{ route('onboarding.wizard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                    Continuar
                </a>
            @endif
            
            <button onclick="skipOnboarding()" 
                    class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition-colors duration-200 text-sm">
                Pular por Agora
            </button>
        </div>
    </div>
</div>

<script>
async function skipOnboarding() {
    if (!confirm('Tem certeza que deseja pular a configuração inicial? Você pode completá-la depois.')) {
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
            alert(result.message || 'Erro ao pular configuração');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Erro ao pular configuração');
    }
}
</script>
@endif
