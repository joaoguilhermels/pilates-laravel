@extends('layouts.dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Success Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/20 mb-6">
                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                🎉 Assinatura Confirmada!
            </h1>
            
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                Parabéns! Sua assinatura foi processada com sucesso. 
                Você já pode aproveitar todos os recursos do PilatesFlow.
            </p>

            <!-- Subscription Details -->
            @if(isset($subscription))
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 mb-8 text-left">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">
                    Detalhes da Assinatura
                </h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Plano:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $subscription['plan_name'] }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Valor:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ $subscription['currency'] }} {{ number_format($subscription['amount'], 2, ',', '.') }}/{{ $subscription['interval'] === 'month' ? 'mês' : 'ano' }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                            {{ $subscription['status'] === 'trialing' ? 'Período de Teste' : 'Ativa' }}
                        </span>
                    </div>
                    
                    @if($subscription['trial_end'])
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Teste até:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::createFromTimestamp($subscription['trial_end'])->format('d/m/Y') }}
                        </span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600 dark:text-gray-400">Próximo pagamento:</span>
                        <span class="font-medium text-gray-900 dark:text-white">
                            {{ \Carbon\Carbon::createFromTimestamp($subscription['next_payment_date'])->format('d/m/Y') }}
                        </span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Next Steps -->
            <div class="bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-indigo-900 dark:text-indigo-200 mb-3">
                    Próximos Passos
                </h3>
                <div class="text-left space-y-2 text-indigo-800 dark:text-indigo-300">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Complete o processo de onboarding para configurar seu estúdio
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Adicione seus primeiros clientes e profissionais
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Configure suas salas e horários de funcionamento
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Comece a agendar suas primeiras aulas
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('home') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Ir para o Dashboard
                </a>
                
                @if(!Auth::user()->onboarding_completed)
                <a href="{{ route('onboarding.wizard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Completar Onboarding
                </a>
                @endif
                
                <a href="{{ route('billing.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-lg font-medium transition-colors">
                    Ver Cobrança
                </a>
            </div>

            <!-- Support -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Precisa de ajuda? Entre em contato conosco através do 
                    <a href="mailto:suporte@pilatesflow.com.br" class="text-indigo-600 hover:text-indigo-700 font-medium">
                        suporte@pilatesflow.com.br
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
