<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Pilates') }}</title>
  
  <!-- Dark theme detection script - MUST run before CSS loads -->
  <script>
    (function() {
      const theme = localStorage.getItem('theme') || 
                   (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
      if (theme === 'dark') {
        document.documentElement.classList.add('dark');
      }
    })();
  </script>
  
  @vite(['resources/css/app.css','resources/js/app.js'])
  
  <!-- Alpine.js cloak style to prevent flash -->
  <style>
    [x-cloak] { display: none !important; }
  </style>
  
  <!-- Alpine.js for theme toggle functionality -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 antialiased transition-colors duration-200">
  <header class="border-b border-gray-200/80 dark:border-gray-700/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex h-16 items-center justify-between">
        <a href="{{ url('/') }}" class="font-semibold text-xl tracking-tight text-gray-900 dark:text-white">{{ config('app.name', 'Pilates') }}</a>
        <nav class="flex items-center gap-6 text-sm">
          <!-- Theme Toggle -->
          @include('components.theme-toggle')
          
          @guest
            <a href="{{ route('login') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Login</a>
            <a href="{{ route('register') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-white hover:bg-indigo-500 transition-colors duration-200">Register</a>
          @else
            <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">Logout</button>
            </form>
          @endguest
        </nav>
      </div>
    </div>
  </header>

  <main>
    @yield('content')
  </main>

  <footer class="mt-24 border-t border-gray-200/80 dark:border-gray-700/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm text-gray-500 dark:text-gray-400">
      <p>&copy; {{ date('Y') }} {{ config('app.name', 'Pilates') }}. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
