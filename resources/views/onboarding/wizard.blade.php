@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
  <div class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Smart Breadcrumbs -->
      <x-smart-breadcrumbs :items="[
        ['title' => 'Configuração Inicial', 'url' => '']
      ]" />
      
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
          🚀 Configuração Inicial
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
          Vamos configurar seu {{ $user->getPlanName() }} em poucos passos simples
        </p>
      </div>

      <!-- Progress Bar -->
      <div class="mb-8">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progresso</span>
          <span class="text-sm font-medium text-indigo-600 dark:text-indigo-400">{{ $progress }}%</span>
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
          <div class="bg-gradient-to-r from-indigo-600 to-purple-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
        </div>
      </div>

      <!-- Steps -->
      <div class="space-y-6" x-data="onboardingWizard({{ json_encode(['steps' => $steps, 'currentStep' => $currentStep, 'progress' => $progress]) }})">
        @foreach($steps as $index => $step)
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border {{ $step['completed'] ? 'border-green-200 dark:border-green-800' : ($index === $currentStep ? 'border-indigo-200 dark:border-indigo-800' : (!$step['available'] ? 'border-gray-100 dark:border-gray-800' : 'border-gray-200 dark:border-gray-700')) }} overflow-hidden {{ !$step['available'] && !$step['completed'] ? 'opacity-60' : '' }}">
            <div class="p-6">
              <div class="flex items-start space-x-4">
                <!-- Step Icon -->
                <div class="flex-shrink-0">
                  @if($step['completed'])
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
                      <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                  @elseif($index === $currentStep && $step['available'])
                    <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/20 rounded-full flex items-center justify-center">
                      <span class="text-indigo-600 dark:text-indigo-400 font-semibold">{{ $index + 1 }}</span>
                    </div>
                  @elseif(!$step['available'])
                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                      <svg class="w-6 h-6 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                      </svg>
                    </div>
                  @else
                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                      <span class="text-gray-500 dark:text-gray-400 font-semibold">{{ $index + 1 }}</span>
                    </div>
                  @endif
                </div>

                <!-- Step Content -->
                <div class="flex-1 min-w-0">
                  <div class="flex items-center justify-between">
                    <div>
                      <h3 class="text-lg font-semibold {{ !$step['available'] && !$step['completed'] ? 'text-gray-500 dark:text-gray-400' : 'text-gray-900 dark:text-white' }} flex items-center">
                        {{ $step['title'] }}
                        @if($step['required'])
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200">
                            Obrigatório
                          </span>
                        @endif
                        @if(!$step['available'] && !$step['completed'])
                          <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                            🔒 Bloqueado
                          </span>
                        @endif
                      </h3>
                      <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $step['description'] }}</p>
                      
                      @if(isset($step['help_text']))
                        <p class="text-sm text-blue-600 dark:text-blue-400 mt-2 italic">
                          💡 {{ $step['help_text'] }}
                        </p>
                      @endif
                      
                      @if(isset($step['dependency_message']))
                        <div class="mt-2 p-2 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-md">
                          <p class="text-sm text-amber-800 dark:text-amber-200 flex items-center">
                            <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $step['dependency_message'] }}
                          </p>
                        </div>
                      @endif
                    </div>
                    
                    @if($step['completed'])
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200">
                        ✅ Concluído
                      </span>
                    @elseif($index === $currentStep)
                      <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 dark:bg-indigo-900/20 text-indigo-800 dark:text-indigo-200">
                        🔄 Atual
                      </span>
                    @endif
                  </div>

                  <!-- Action Button -->
                  @if(!$step['completed'] && $step['id'] !== 'complete')
                    <div class="mt-4">
                      @if(isset($step['route']))
                        @if($step['available'])
                          <a href="{{ route($step['route'], $step['params'] ?? []) }}" 
                             class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors duration-200">
                        @else
                          <button disabled 
                                  class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-medium rounded-lg cursor-not-allowed">
                        @endif
                          @if($step['id'] === 'profile')
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                          @elseif($step['id'] === 'rooms')
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                            </svg>
                          @elseif($step['id'] === 'class_types')
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                              <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                          @elseif($step['id'] === 'professionals')
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                              <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                            </svg>
                          @elseif($step['id'] === 'plans')
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                              <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            </svg>
                          @endif
                          {{ $step['id'] === 'profile' ? 'Completar Perfil' : 'Configurar' }}
                        @if($step['available'])
                          </a>
                        @else
                          </button>
                        @endif
                      @endif
                    </div>
                  @elseif($step['id'] === 'complete' && $index === $currentStep)
                    <div class="mt-4">
                      <button @click="completeOnboarding()" 
                              class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg transition-all duration-200 shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Finalizar Configuração
                      </button>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach

        <!-- Action Buttons -->
        <div class="flex justify-between items-center pt-6">
          <button @click="skipOnboarding()" 
                  class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium rounded-lg transition-colors duration-200">
            Pular por Agora
          </button>
          
          <div class="text-sm text-gray-500 dark:text-gray-400">
            {{ $progress }}% concluído • {{ count(array_filter($steps, fn($s) => $s['completed'])) }} de {{ count($steps) }} passos
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
  Alpine.data('onboardingWizard', (data) => ({
    steps: data.steps,
    currentStep: data.currentStep,
    progress: data.progress,
    
    async skipOnboarding() {
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
          window.location.href = result.redirect;
        } else {
          alert(result.message || 'Erro ao pular configuração');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Erro ao pular configuração');
      }
    },
    
    async completeOnboarding() {
      try {
        const response = await fetch('{{ route("onboarding.complete") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          }
        });
        
        const result = await response.json();
        
        if (result.success) {
          alert(result.message);
          window.location.href = result.redirect;
        } else {
          alert(result.message || 'Complete todos os passos obrigatórios primeiro');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Erro ao finalizar configuração');
      }
    }
  }));
});
</script>
@endpush
@endsection
