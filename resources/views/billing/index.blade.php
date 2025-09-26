@extends('layouts.dashboard')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Smart Breadcrumbs -->
        <x-smart-breadcrumbs :items="[
          ['title' => 'Cobrança', 'url' => '']
        ]" />
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">💳 Cobrança e Assinatura</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">
                Gerencie sua assinatura, métodos de pagamento e histórico de cobrança
            </p>
        </div>

        <!-- Current Subscription Status -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Status da Assinatura</h2>
            </div>
            <div class="p-6">
                @if($user->hasActiveStripeSubscription())
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $currentPlan->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    @if($subscriptionInfo)
                                        Próximo pagamento: {{ \Carbon\Carbon::createFromTimestamp($subscriptionInfo['next_payment_date'])->format('d/m/Y') }}
                                        • {{ $subscriptionInfo['currency'] }} {{ number_format($subscriptionInfo['amount'], 2, ',', '.') }}/{{ $subscriptionInfo['interval'] === 'month' ? 'mês' : 'ano' }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            @if($user->stripe_subscription_cancel_at_period_end)
                                <form action="{{ route('billing.resume-subscription') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                        Reativar Assinatura
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('billing.plans') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Alterar Plano
                                </a>
                            @endif
                            <a href="{{ route('billing.portal') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Portal de Cobrança
                            </a>
                        </div>
                    </div>

                    @if($user->stripe_subscription_cancel_at_period_end)
                        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                            <div class="flex">
                                <svg class="w-5 h-5 text-yellow-400 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                        Assinatura será cancelada
                                    </h4>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300 mt-1">
                                        Sua assinatura será cancelada em {{ $user->stripe_subscription_current_period_end->format('d/m/Y') }}. 
                                        Você pode reativar a qualquer momento antes desta data.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                @elseif($user->isOnTrial())
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mr-3"></div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    Período de Teste - {{ $currentPlan->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Teste gratuito até {{ $user->trial_ends_at->format('d/m/Y') }}
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('billing.plans') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Assinar Agora
                            </a>
                        </div>
                    </div>
                @else
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-red-500 rounded-full mr-3"></div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    Nenhuma assinatura ativa
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Escolha um plano para continuar usando o PilatesFlow
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('billing.plans') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                Ver Planos
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Billing Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações de Cobrança</h2>
            </div>
            <div class="p-6">
                @if($user->needsBillingInfo())
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                            Complete suas informações de cobrança
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            Adicione seu CPF/CNPJ e endereço para emissão de notas fiscais
                        </p>
                        <a href="{{ route('billing.info') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Adicionar Informações
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Documento</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ strtoupper($user->tax_id_type) }}: {{ $user->getFormattedTaxId() }}
                            </p>
                            @if($user->company_name)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $user->company_name }}
                                </p>
                            @endif
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Endereço</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{ $user->address_line1 }}
                                @if($user->address_line2), {{ $user->address_line2 }}@endif<br>
                                {{ $user->address_city }}, {{ $user->address_state }} {{ $user->address_postal_code }}
                            </p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('billing.info') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                            Editar informações →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 00-2-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Ver Planos</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Compare e altere seu plano</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('billing.plans') }}" class="text-indigo-600 hover:text-indigo-700 text-sm font-medium">
                        Ver todos os planos →
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Portal Stripe</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Gerencie pagamentos e faturas</p>
                    </div>
                </div>
                <div class="mt-4">
                    @if($user->stripe_customer_id)
                        <a href="{{ route('billing.portal') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                            Abrir portal →
                        </a>
                    @else
                        <span class="text-gray-400 text-sm">Disponível após primeira assinatura</span>
                    @endif
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Cancelar</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Cancelar assinatura atual</p>
                    </div>
                </div>
                <div class="mt-4">
                    @if($user->stripe_subscription_id && !$user->stripe_subscription_cancel_at_period_end)
                        <button onclick="confirmCancellation()" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Cancelar assinatura →
                        </button>
                    @else
                        <span class="text-gray-400 text-sm">Nenhuma assinatura ativa</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($user->stripe_subscription_id && !$user->stripe_subscription_cancel_at_period_end)
<!-- Cancellation Modal -->
<div id="cancellationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-md mx-4">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Cancelar Assinatura</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            Tem certeza que deseja cancelar sua assinatura? Você continuará tendo acesso até o final do período atual.
        </p>
        <div class="flex space-x-3">
            <form action="{{ route('billing.cancel-subscription') }}" method="POST" class="flex-1">
                @csrf
                <input type="hidden" name="at_period_end" value="1">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Sim, Cancelar
                </button>
            </form>
            <button onclick="closeCancellationModal()" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                Não, Manter
            </button>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
function confirmCancellation() {
    document.getElementById('cancellationModal').classList.remove('hidden');
    document.getElementById('cancellationModal').classList.add('flex');
}

function closeCancellationModal() {
    document.getElementById('cancellationModal').classList.add('hidden');
    document.getElementById('cancellationModal').classList.remove('flex');
}
</script>
@endpush
@endsection
