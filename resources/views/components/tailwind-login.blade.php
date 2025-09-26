{{-- Modern Tailwind CSS Login Form Component --}}
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-4xl w-full space-y-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- Login Form -->
      <div class="space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
        {{ __('auth.sign_in') }}
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-400">
        {{ __('auth.register_or') }}
        <a href="{{ route('register') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
          {{ __('auth.create_new_account') }}
        </a>
      </p>
    </div>
    <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
      @csrf
      <input type="hidden" name="remember" value="true">
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="email-address" class="sr-only">{{ __('auth.email_address') }}</label>
          <input id="email-address" name="email" type="email" autocomplete="email" required 
                 class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-colors duration-200" 
                 placeholder="{{ __('auth.email_address') }}" value="{{ old('email') }}">
        </div>
        <div>
          <label for="password" class="sr-only">{{ __('auth.password_field') }}</label>
          <input id="password" name="password" type="password" autocomplete="current-password" required 
                 class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm transition-colors duration-200" 
                 placeholder="{{ __('auth.password_field') }}">
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="flex items-center">
          <input id="remember-me" name="remember" type="checkbox" 
                 class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 rounded transition-colors duration-200">
          <label for="remember-me" class="ml-2 block text-sm text-gray-900 dark:text-gray-200">
            {{ __('auth.remember_me') }}
          </label>
        </div>

        <div class="text-sm">
          <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 transition-colors duration-200">
            {{ __('auth.forgot_password') }}
          </a>
        </div>
      </div>

      <div>
        <button type="submit" 
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
          </span>
          {{ __('auth.sign_in_button') }}
        </button>
      </div>

      @if ($errors->any())
        <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-5 w-5 text-red-400 dark:text-red-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
              </svg>
            </div>
            <div class="ml-3">
              <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                {{ __('auth.login_errors_title') }}
              </h3>
              <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                <ul class="list-disc pl-5 space-y-1">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </div>
      @endif
    </form>
      </div>

      <!-- Demo Accounts Section -->
      <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-6">
          <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            {{ __('auth.demo_accounts_title') }}
          </h3>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ __('auth.demo_accounts_subtitle') }}
          </p>
        </div>

        <div class="space-y-4">
          <!-- System Admin -->
          <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-medium text-red-800 dark:text-red-200">
                {{ __('auth.system_admin_role') }}
              </h4>
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 dark:bg-red-800/30 text-red-800 dark:text-red-200">
                {{ __('auth.full_access') }}
              </span>
            </div>
            <div class="text-sm text-red-700 dark:text-red-300 space-y-1">
              <p><strong>{{ __('auth.email') }}:</strong> admin@pilatesflow.com</p>
              <p><strong>{{ __('auth.password') }}:</strong> admin123</p>
            </div>
            <button onclick="fillLogin('admin@pilatesflow.com', 'admin123')" 
                    class="mt-2 w-full inline-flex justify-center items-center px-3 py-1.5 border border-red-300 dark:border-red-600 text-xs font-medium rounded text-red-700 dark:text-red-300 bg-white dark:bg-gray-800 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors duration-200">
              <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              {{ __('auth.use_credentials') }}
            </button>
          </div>

          <!-- Studio Owner -->
          <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-medium text-blue-800 dark:text-blue-200">
                {{ __('auth.studio_owner_role') }}
              </h4>
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-800/30 text-blue-800 dark:text-blue-200">
                {{ __('auth.management_access') }}
              </span>
            </div>
            <div class="text-sm text-blue-700 dark:text-blue-300 space-y-1">
              <p><strong>{{ __('auth.email') }}:</strong> dono@estudio.com</p>
              <p><strong>{{ __('auth.password') }}:</strong> dono123</p>
            </div>
            <button onclick="fillLogin('dono@estudio.com', 'dono123')" 
                    class="mt-2 w-full inline-flex justify-center items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 text-xs font-medium rounded text-blue-700 dark:text-blue-300 bg-white dark:bg-gray-800 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors duration-200">
              <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              {{ __('auth.use_credentials') }}
            </button>
          </div>

          <!-- Studio Professional -->
          <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-medium text-green-800 dark:text-green-200">
                {{ __('auth.studio_professional_role') }}
              </h4>
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 dark:bg-green-800/30 text-green-800 dark:text-green-200">
                {{ __('auth.limited_access') }}
              </span>
            </div>
            <div class="text-sm text-green-700 dark:text-green-300 space-y-1">
              <p><strong>{{ __('auth.email') }}:</strong> instrutora@estudio.com</p>
              <p><strong>{{ __('auth.password') }}:</strong> instrutora123</p>
            </div>
            <button onclick="fillLogin('instrutora@estudio.com', 'instrutora123')" 
                    class="mt-2 w-full inline-flex justify-center items-center px-3 py-1.5 border border-green-300 dark:border-green-600 text-xs font-medium rounded text-green-700 dark:text-green-300 bg-white dark:bg-gray-800 hover:bg-green-50 dark:hover:bg-green-900/30 transition-colors duration-200">
              <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              {{ __('auth.use_credentials') }}
            </button>
          </div>

          <!-- Studio Client -->
          <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
            <div class="flex items-center justify-between mb-2">
              <h4 class="font-medium text-purple-800 dark:text-purple-200">
                {{ __('auth.studio_client_role') }}
              </h4>
              <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-800/30 text-purple-800 dark:text-purple-200">
                {{ __('auth.client_access') }}
              </span>
            </div>
            <div class="text-sm text-purple-700 dark:text-purple-300 space-y-1">
              <p><strong>{{ __('auth.email') }}:</strong> cliente@email.com</p>
              <p><strong>{{ __('auth.password') }}:</strong> cliente123</p>
            </div>
            <button onclick="fillLogin('cliente@email.com', 'cliente123')" 
                    class="mt-2 w-full inline-flex justify-center items-center px-3 py-1.5 border border-purple-300 dark:border-purple-600 text-xs font-medium rounded text-purple-700 dark:text-purple-300 bg-white dark:bg-gray-800 hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors duration-200">
              <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
              </svg>
              {{ __('auth.use_credentials') }}
            </button>
          </div>
        </div>

        <div class="mt-6 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
          <div class="flex items-start">
            <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z" />
            </svg>
            <div class="text-sm text-yellow-800 dark:text-yellow-200">
              <p class="font-medium">{{ __('auth.demo_warning_title') }}</p>
              <p class="mt-1">{{ __('auth.demo_warning_text') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    function fillLogin(email, password) {
      document.getElementById('email-address').value = email;
      document.getElementById('password').value = password;
      
      // Add visual feedback
      const emailField = document.getElementById('email-address');
      const passwordField = document.getElementById('password');
      
      emailField.classList.add('ring-2', 'ring-indigo-500', 'border-indigo-500');
      passwordField.classList.add('ring-2', 'ring-indigo-500', 'border-indigo-500');
      
      setTimeout(() => {
        emailField.classList.remove('ring-2', 'ring-indigo-500', 'border-indigo-500');
        passwordField.classList.remove('ring-2', 'ring-indigo-500', 'border-indigo-500');
      }, 1000);
    }
  </script>
</div>
