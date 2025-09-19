{{-- Modern Tailwind CSS Register Form Component --}}
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
  <div class="max-w-md w-full space-y-8">
    <div>
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 dark:text-white">
        Create your account
      </h2>
      <p class="mt-2 text-center text-sm text-gray-600 dark:text-gray-300">
        Or
        <a href="{{ route('login') }}" class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">
          sign in to your existing account
        </a>
      </p>
    </div>
    <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full Name</label>
          <input id="name" name="name" type="text" autocomplete="name" required 
                 class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('name') border-red-300 dark:border-red-500 @enderror" 
                 placeholder="Enter your full name" value="{{ old('name') }}">
          @error('name')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>
        
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email Address</label>
          <input id="email" name="email" type="email" autocomplete="email" required 
                 class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('email') border-red-300 dark:border-red-500 @enderror" 
                 placeholder="Enter your email address" value="{{ old('email') }}">
          @error('email')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>
        
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
          <input id="password" name="password" type="password" autocomplete="new-password" required 
                 class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error('password') border-red-300 dark:border-red-500 @enderror" 
                 placeholder="Create a password">
          @error('password')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
          @enderror
        </div>
        
        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Confirm Password</label>
          <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                 class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white bg-white dark:bg-gray-700 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" 
                 placeholder="Confirm your password">
        </div>
      </div>

      <div>
        <button type="submit" 
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
          <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6z" />
            </svg>
          </span>
          Create Account
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
                There were errors with your submission
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
</div>
