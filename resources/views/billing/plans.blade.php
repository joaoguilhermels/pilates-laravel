@extends('layouts.dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Escolha o Plano Ideal
            </h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                Selecione o plano que melhor atende às suas necessidades. 
                Todos os planos incluem 14 dias de teste gratuito.
            </p>
        </div>

        <!-- Billing Toggle -->
        <div class="flex justify-center mb-8" x-data="{ billingCycle: 'monthly' }">
            <div class="bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
                <button 
                    @click="billingCycle = 'monthly'"
                    :class="billingCycle === 'monthly' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow' : 'text-gray-600 dark:text-gray-400'"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all"
                >
                    Mensal
                </button>
                <button 
                    @click="billingCycle = 'yearly'"
                    :class="billingCycle === 'yearly' ? 'bg-white dark:bg-gray-600 text-gray-900 dark:text-white shadow' : 'text-gray-600 dark:text-gray-400'"
                    class="px-4 py-2 rounded-md text-sm font-medium transition-all"
                >
                    Anual
                    <span class="ml-1 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full">-20%</span>
                </button>
            </div>
        </div>

        <!-- Plans Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto" x-data="{ billingCycle: 'monthly' }">
            @foreach($plans as $plan)
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-lg border {{ $plan->is_popular ? 'border-indigo-500 ring-2 ring-indigo-500' : 'border-gray-200 dark:border-gray-700' }} overflow-hidden">
                @if($plan->is_popular)
                    <div class="absolute top-0 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                        <span class="bg-indigo-500 text-white px-4 py-1 rounded-full text-sm font-medium">
                            Mais Popular
                        </span>
                    </div>
                @endif

                <div class="p-8">
                    <!-- Plan Header -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $plan->name }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-6">
                            {{ $plan->description }}
                        </p>
                        
                        <!-- Pricing -->
                        <div class="mb-6">
                            <div x-show="billingCycle === 'monthly'">
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    R$ {{ number_format($plan->monthly_price, 0, ',', '.') }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-400">/mês</span>
                            </div>
                            <div x-show="billingCycle === 'yearly'" x-cloak>
                                <span class="text-4xl font-bold text-gray-900 dark:text-white">
                                    R$ {{ number_format($plan->yearly_price, 0, ',', '.') }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-400">/ano</span>
                                <div class="text-sm text-green-600 dark:text-green-400 mt-1">
                                    Economize R$ {{ number_format(($plan->monthly_price * 12) - $plan->yearly_price, 0, ',', '.') }} por ano
                                </div>
                            </div>
                        </div>

                        <!-- CTA Button -->
                        @if($currentPlan && $currentPlan->id === $plan->id)
                            <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-medium cursor-not-allowed">
                                Plano Atual
                            </button>
                        @else
                            <form action="{{ route('billing.checkout') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                <input type="hidden" name="billing_cycle" x-model="billingCycle">
                                <button type="submit" class="w-full {{ $plan->is_popular ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-gray-900 hover:bg-gray-800' }} text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                    @if($user->hasActiveSubscription())
                                        @if($currentPlan && $plan->monthly_price > $currentPlan->monthly_price)
                                            Fazer Upgrade
                                        @elseif($currentPlan && $plan->monthly_price < $currentPlan->monthly_price)
                                            Fazer Downgrade
                                        @else
                                            Alterar Plano
                                        @endif
                                    @else
                                        Começar Teste Gratuito
                                    @endif
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Features List -->
                    <div class="space-y-4">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3">
                            Recursos inclusos:
                        </h4>
                        @php
                            $features = json_decode($plan->features, true) ?? [];
                        @endphp
                        @foreach($features as $feature)
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Limits -->
                    @if($plan->limits)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-semibold text-gray-900 dark:text-white mb-3">
                                Limites:
                            </h4>
                            @php
                                $limits = json_decode($plan->limits, true) ?? [];
                            @endphp
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                @foreach($limits as $key => $value)
                                    <div class="text-center">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $value === -1 ? 'Ilimitado' : number_format($value, 0, ',', '.') }}
                                        </div>
                                        <div class="text-gray-600 dark:text-gray-400">
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- FAQ Section -->
        <div class="mt-16 max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center mb-8">
                Perguntas Frequentes
            </h2>
            <div class="space-y-6" x-data="{ openFaq: null }">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <button 
                        @click="openFaq = openFaq === 1 ? null : 1"
                        class="w-full px-6 py-4 text-left flex justify-between items-center"
                    >
                        <span class="font-medium text-gray-900 dark:text-white">
                            Posso cancelar a qualquer momento?
                        </span>
                        <svg 
                            :class="openFaq === 1 ? 'rotate-180' : ''"
                            class="w-5 h-5 text-gray-500 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Sim! Você pode cancelar sua assinatura a qualquer momento. O cancelamento será efetivo no final do período de cobrança atual, e você continuará tendo acesso a todos os recursos até lá.
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <button 
                        @click="openFaq = openFaq === 2 ? null : 2"
                        class="w-full px-6 py-4 text-left flex justify-between items-center"
                    >
                        <span class="font-medium text-gray-900 dark:text-white">
                            Como funciona o teste gratuito?
                        </span>
                        <svg 
                            :class="openFaq === 2 ? 'rotate-180' : ''"
                            class="w-5 h-5 text-gray-500 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Todos os planos incluem 14 dias de teste gratuito com acesso completo a todos os recursos. Você só será cobrado após o período de teste, e pode cancelar a qualquer momento durante o teste sem nenhum custo.
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <button 
                        @click="openFaq = openFaq === 3 ? null : 3"
                        class="w-full px-6 py-4 text-left flex justify-between items-center"
                    >
                        <span class="font-medium text-gray-900 dark:text-white">
                            Posso alterar meu plano depois?
                        </span>
                        <svg 
                            :class="openFaq === 3 ? 'rotate-180' : ''"
                            class="w-5 h-5 text-gray-500 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Claro! Você pode fazer upgrade ou downgrade do seu plano a qualquer momento. As alterações são aplicadas imediatamente, e o valor é ajustado proporcionalmente no próximo ciclo de cobrança.
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <button 
                        @click="openFaq = openFaq === 4 ? null : 4"
                        class="w-full px-6 py-4 text-left flex justify-between items-center"
                    >
                        <span class="font-medium text-gray-900 dark:text-white">
                            Quais formas de pagamento são aceitas?
                        </span>
                        <svg 
                            :class="openFaq === 4 ? 'rotate-180' : ''"
                            class="w-5 h-5 text-gray-500 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 4" x-collapse class="px-6 pb-4">
                        <p class="text-gray-600 dark:text-gray-400">
                            Aceitamos cartões de crédito (Visa, Mastercard, American Express), PIX e boleto bancário. Todos os pagamentos são processados de forma segura através do Stripe.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="text-center mt-12">
            <a href="{{ route('billing.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                ← Voltar para Cobrança
            </a>
        </div>
    </div>
</div>
@endsection
