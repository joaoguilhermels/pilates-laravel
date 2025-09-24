@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
  <div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <!-- Header -->
      <div class="text-center mb-8">
        @if($blockedFeature || $blockedResource)
          <div class="mb-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
            <div class="flex items-center justify-center">
              <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              <p class="text-yellow-800 dark:text-yellow-200 font-medium">
                @if($blockedFeature)
                  Esta funcionalidade requer upgrade do seu plano atual.
                @else
                  Você atingiu o limite do seu plano atual.
                @endif
              </p>
            </div>
          </div>
        @endif

        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
          🚀 Faça Upgrade e Desbloqueie Todo o Potencial
        </h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
          Expanda seu negócio com funcionalidades avançadas e recursos ilimitados
        </p>
      </div>

      <!-- Current Plan Status -->
      @if($currentPlan)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8">
          <div class="flex items-center justify-between">
            <div>
              <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Plano Atual: {{ $currentPlan->name }}</h3>
              <p class="text-gray-600 dark:text-gray-400">{{ $currentPlan->description }}</p>
            </div>
            <div class="text-right">
              @if($user->isOnTrial())
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200">
                  🎯 Trial: {{ $user->trial_ends_at->diffForHumans() }}
                </span>
              @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200">
                  ✅ Ativo
                </span>
              @endif
            </div>
          </div>

          <!-- Usage Summary -->
          <div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($usage as $resource => $data)
              <div class="text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">
                  {{ $data['current'] }}
                  @if(!$data['unlimited'])
                    <span class="text-sm text-gray-500">/ {{ $data['limit'] }}</span>
                  @endif
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400 capitalize">{{ $resource }}</div>
                @if($data['at_limit'])
                  <div class="text-xs text-red-600 dark:text-red-400 font-medium">Limite atingido</div>
                @elseif($data['near_limit'])
                  <div class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Próximo do limite</div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Plans Comparison -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        @foreach($availablePlans as $plan)
          <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden {{ $plan->is_popular ? 'ring-2 ring-indigo-500 dark:ring-indigo-400' : '' }}">
            @if($plan->is_popular)
              <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-center py-2 text-sm font-semibold">
                ⭐ Mais Popular
              </div>
            @endif

            <div class="p-8">
              <div class="text-center mb-6">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $plan->name }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $plan->description }}</p>
                
                <div class="mt-4">
                  <div class="text-4xl font-bold text-gray-900 dark:text-white">
                    {{ $plan->formatted_monthly_price }}
                    <span class="text-lg text-gray-600 dark:text-gray-400">/mês</span>
                  </div>
                  <div class="text-sm text-gray-500 dark:text-gray-400">
                    ou {{ $plan->formatted_yearly_price }}/ano (economize {{ $plan->yearly_savings_percent }}%)
                  </div>
                </div>
              </div>

              <!-- Features -->
              <div class="space-y-3 mb-8">
                @foreach(array_slice($plan->features, 0, 8) as $feature)
                  <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-gray-700 dark:text-gray-300">{{ $feature }}</span>
                  </div>
                @endforeach
                @if(count($plan->features) > 8)
                  <div class="text-sm text-indigo-600 dark:text-indigo-400">
                    + {{ count($plan->features) - 8 }} recursos adicionais
                  </div>
                @endif
              </div>

              <!-- Action Button -->
              @if($currentPlan && $currentPlan->id === $plan->id)
                <button disabled class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 py-3 px-6 rounded-lg font-semibold cursor-not-allowed">
                  Plano Atual
                </button>
              @else
                <form method="POST" action="{{ route('upgrade.process') }}">
                  @csrf
                  <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                  <input type="hidden" name="billing_cycle" value="monthly">
                  
                  <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white py-3 px-6 rounded-lg font-semibold transition-all duration-200 shadow-lg">
                    @if($currentPlan)
                      Fazer Upgrade
                    @else
                      Escolher Plano
                    @endif
                  </button>
                </form>
              @endif
            </div>
          </div>
        @endforeach
      </div>

      <!-- Benefits Section -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-8">
          Por que fazer upgrade?
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div class="text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Recursos Ilimitados</h4>
            <p class="text-gray-600 dark:text-gray-400">Clientes, profissionais e salas sem limitações</p>
          </div>

          <div class="text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a1 1 0 001 1h6a1 1 0 001-1V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm2.5 7a1.5 1.5 0 100-3 1.5 1.5 0 000 3zm2.45.5a2.5 2.5 0 11-4.9 0 2.5 2.5 0 014.9 0zM12 9a1 1 0 100 2h3a1 1 0 100-2h-3zm-1 4a1 1 0 011-1h2a1 1 0 110 2h-2a1 1 0 01-1-1z" clip-rule="evenodd"/>
              </svg>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Relatórios Avançados</h4>
            <p class="text-gray-600 dark:text-gray-400">Insights detalhados para tomar melhores decisões</p>
          </div>

          <div class="text-center">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
              </svg>
            </div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Suporte Prioritário</h4>
            <p class="text-gray-600 dark:text-gray-400">Atendimento especializado quando você precisar</p>
          </div>
        </div>
      </div>

      <!-- FAQ Section -->
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8">
        <h3 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-8">
          Perguntas Frequentes
        </h3>
        
        <div class="space-y-6">
          <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Posso cancelar a qualquer momento?</h4>
            <p class="text-gray-600 dark:text-gray-400">Sim! Você pode cancelar sua assinatura a qualquer momento sem taxas de cancelamento.</p>
          </div>
          
          <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">E se eu quiser fazer downgrade?</h4>
            <p class="text-gray-600 dark:text-gray-400">Você pode alterar seu plano a qualquer momento. O downgrade será aplicado no próximo ciclo de cobrança.</p>
          </div>
          
          <div>
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Meus dados ficam seguros?</h4>
            <p class="text-gray-600 dark:text-gray-400">Absolutamente! Todos os seus dados são criptografados e armazenados com segurança. Fazemos backup automático diário.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
