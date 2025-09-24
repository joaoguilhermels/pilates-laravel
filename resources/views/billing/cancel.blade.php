@extends('layouts.dashboard')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <!-- Cancel Icon -->
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-yellow-100 dark:bg-yellow-900/20 mb-6">
                <svg class="h-8 w-8 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
            </div>

            <!-- Cancel Message -->
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                Checkout Cancelado
            </h1>
            
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-8">
                Não se preocupe! Você cancelou o processo de pagamento. 
                Seus dados estão seguros e nada foi cobrado.
            </p>

            <!-- What Happened -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6 mb-8 text-left">
                <h3 class="text-lg font-semibold text-yellow-900 dark:text-yellow-200 mb-3">
                    O que aconteceu?
                </h3>
                <div class="text-yellow-800 dark:text-yellow-300 space-y-2">
                    <p>• O processo de pagamento foi interrompido</p>
                    <p>• Nenhuma cobrança foi realizada</p>
                    <p>• Sua conta permanece no estado anterior</p>
                    <p>• Você pode tentar novamente a qualquer momento</p>
                </div>
            </div>

            <!-- Current Status -->
            @if(Auth::user()->isOnTrial())
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200 mb-3">
                    Seu Status Atual
                </h3>
                <p class="text-blue-800 dark:text-blue-300">
                    Você ainda está no período de teste gratuito até 
                    <strong>{{ Auth::user()->trial_ends_at->format('d/m/Y') }}</strong>. 
                    Continue aproveitando todos os recursos do PilatesFlow!
                </p>
            </div>
            @elseif(!Auth::user()->hasActiveSubscription())
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-red-900 dark:text-red-200 mb-3">
                    Acesso Limitado
                </h3>
                <p class="text-red-800 dark:text-red-300">
                    Sua conta não possui uma assinatura ativa. 
                    Para continuar usando o PilatesFlow, você precisa escolher um plano.
                </p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                <a href="{{ route('billing.plans') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Ver Planos Novamente
                </a>
                
                <a href="{{ route('home') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Voltar ao Dashboard
                </a>
                
                <a href="{{ route('billing.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-lg font-medium transition-colors">
                    Ver Cobrança
                </a>
            </div>

            <!-- Why Choose Us -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 text-left">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 text-center">
                    Por que escolher o PilatesFlow?
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">14 dias de teste gratuito</span>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Cancele a qualquer momento</span>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Suporte especializado</span>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Pagamento 100% seguro</span>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Recursos completos</span>
                    </div>
                    
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Atualizações constantes</span>
                    </div>
                </div>
            </div>

            <!-- Support -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Tem dúvidas sobre nossos planos? Entre em contato conosco através do 
                    <a href="mailto:suporte@pilatesflow.com.br" class="text-indigo-600 hover:text-indigo-700 font-medium">
                        suporte@pilatesflow.com.br
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
