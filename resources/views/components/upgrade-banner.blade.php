@props(['feature' => null, 'resource' => null, 'message' => null])

@php
    $user = auth()->user();
    $displayMessage = $message;
    
    if (!$displayMessage && $feature) {
        $displayMessage = $user->getUpgradeMessage($feature);
    }
    
    if (!$displayMessage && $resource) {
        $limit = $user->getLimit("max_{$resource}");
        $displayMessage = "Você atingiu o limite de {$limit} {$resource} do seu plano.";
    }
    
    $displayMessage = $displayMessage ?? 'Esta funcionalidade requer upgrade do seu plano.';
@endphp

<div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 mb-6">
    <div class="flex items-start">
        <div class="flex-shrink-0">
            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200">
                🚀 Upgrade Necessário
            </h3>
            <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">
                {{ $displayMessage }}
            </p>
            <div class="mt-3 flex items-center space-x-3">
                <a href="{{ route('upgrade') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd"/>
                    </svg>
                    Fazer Upgrade
                </a>
                <a href="{{ route('home') }}" class="text-sm text-yellow-700 dark:text-yellow-300 hover:text-yellow-600 dark:hover:text-yellow-200 font-medium">
                    Voltar ao Dashboard
                </a>
            </div>
        </div>
        <div class="ml-3 flex-shrink-0">
            <button type="button" class="bg-yellow-50 dark:bg-yellow-900/20 rounded-md p-1.5 text-yellow-400 hover:bg-yellow-100 dark:hover:bg-yellow-900/40 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-900" onclick="this.parentElement.parentElement.parentElement.style.display='none'">
                <span class="sr-only">Fechar</span>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
</div>
