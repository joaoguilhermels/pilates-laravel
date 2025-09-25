@extends('layouts.salient')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-cyan-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-12">

  <div class="flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
      <!-- Email Icon -->
      <div class="text-center">
        <div class="mx-auto w-16 h-16 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-full flex items-center justify-center mb-4">
          <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
          </svg>
        </div>
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
          📧 Verifique seu Email
        </h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">
          Estamos quase lá! Só falta um passo.
        </p>
      </div>
      
      <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm shadow-xl rounded-xl p-8 border border-gray-200/50 dark:border-gray-700/50">
        @if (session('resent'))
          <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                  ✅ Email de verificação reenviado com sucesso!
                </p>
              </div>
            </div>
          </div>
        @endif

        <div class="text-center mb-6">
          <p class="text-gray-700 dark:text-gray-300 mb-4">
            Enviamos um email de confirmação para:
          </p>
          <p class="font-semibold text-indigo-600 dark:text-indigo-400 text-lg">
            {{ auth()->user()->email }}
          </p>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 mb-6">
          <h3 class="font-semibold text-gray-900 dark:text-white mb-2">📋 O que fazer:</h3>
          <ol class="text-sm text-gray-600 dark:text-gray-300 space-y-1">
            <li>1. Abra seu email</li>
            <li>2. Procure por "PilatesFlow" na caixa de entrada</li>
            <li>3. Clique no botão "Confirmar Email"</li>
            <li>4. Volte aqui para começar!</li>
          </ol>
        </div>

        <div class="text-center">
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
            Não recebeu o email? Verifique sua caixa de spam ou
          </p>
          
          <form method="POST" action="{{ route('verification.resend') }}" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-lg hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
              <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"/>
              </svg>
              Reenviar Email
            </button>
          </form>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-600 text-center">
          <p class="text-xs text-gray-500 dark:text-gray-400">
            🔒 Link válido por 24 horas • Suporte: suporte@pilatesflow.com
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
