<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Pilates') }} - Dashboard</title>
  
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
  
  <!-- Alpine.js for dropdown functionality -->
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
  <!-- Navigation -->
  <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 transition-colors duration-200" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="font-semibold text-xl tracking-tight text-gray-900 dark:text-white">
            {{ config('app.name', 'Pilates') }}
          </a>
          <!-- Desktop Navigation -->
          <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.dashboard') }}
            </a>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.clients') }}
            </a>
            <a href="{{ route('schedules.index') }}" class="{{ request()->routeIs('schedules.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.schedules') }}
            </a>
            <a href="{{ route('professionals.index') }}" class="{{ request()->routeIs('professionals.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.professionals') }}
            </a>
            <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.rooms') }}
            </a>
            <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.classes') }}
            </a>
            <a href="{{ route('calendar') }}" class="{{ request()->routeIs('calendar*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.calendar') }}
            </a>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <!-- Mobile menu button -->
          <div class="sm:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200" aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen">
              <span class="sr-only">Open main menu</span>
              <!-- Hamburger icon when menu is closed -->
              <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!-- X icon when menu is open -->
              <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <!-- Theme Toggle -->
          @include('components.theme-toggle')
          
          <!-- User Dropdown -->
          <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="sr-only">Open user menu</span>
              <div class="flex items-center space-x-3">
                <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                  <span class="text-sm font-medium text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
                <div class="hidden md:block">
                  <div class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                </div>
                <svg class="h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>
            </button>

            <!-- Dropdown menu -->
            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-gray-600 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
              <div class="py-1" role="none">
                <!-- User Info Header -->
                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                  <p class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                  <p class="text-sm text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                  @if(Auth::user()->roles->isNotEmpty())
                    <div class="mt-1">
                      @foreach(Auth::user()->roles as $role)
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200">
                          @switch($role->name)
                            @case('system_admin')
                              {{ __('app.system_admin') }}
                              @break
                            @case('studio_owner')
                              {{ __('app.studio_owner') }}
                              @break
                            @case('studio_professional')
                              {{ __('app.studio_professional') }}
                              @break
                            @case('studio_client')
                              {{ __('app.studio_client') }}
                              @break
                            @default
                              {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                          @endswitch
                        </span>
                      @endforeach
                    </div>
                  @endif
                </div>
                
                <!-- Profile Links -->
                <a href="{{ route('profile.show') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200" role="menuitem">
                  <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  {{ __('app.your_profile') }}
                </a>
                
                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200" role="menuitem">
                  <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                  {{ __('app.edit_profile') }}
                </a>
                
                <a href="{{ route('profile.password.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200" role="menuitem">
                  <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                  </svg>
                  {{ __('app.change_password') }}
                </a>
                
                <a href="{{ route('settings') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200" role="menuitem">
                  <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  {{ __('app.settings') }}
                </a>
                
                <!-- Divider -->
                <div class="border-t border-gray-100 dark:border-gray-700"></div>
                
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200" role="menuitem">
                    <svg class="mr-3 h-5 w-5 text-gray-400 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    {{ __('auth.sign_out') }}
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Mobile menu -->
      <div x-show="mobileMenuOpen" 
           @click.away="mobileMenuOpen = false"
           x-transition:enter="transition ease-out duration-200"
           x-transition:enter-start="opacity-0 scale-95"
           x-transition:enter-end="opacity-100 scale-100"
           x-transition:leave="transition ease-in duration-150"
           x-transition:leave-start="opacity-100 scale-100"
           x-transition:leave-end="opacity-0 scale-95"
           class="sm:hidden" 
           id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
          <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('home') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.dashboard') }}
          </a>
          <a href="{{ route('clients.index') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('clients.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.clients') }}
          </a>
          <a href="{{ route('schedules.index') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('schedules.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.schedules') }}
          </a>
          <a href="{{ route('professionals.index') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('professionals.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.professionals') }}
          </a>
          <a href="{{ route('rooms.index') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('rooms.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.rooms') }}
          </a>
          <a href="{{ route('classes.index') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('classes.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.classes') }}
          </a>
          <a href="{{ route('calendar') }}" @click="mobileMenuOpen = false" class="{{ request()->routeIs('calendar*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.calendar') }}
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <main class="py-6">
    @yield('content')
  </main>
  
  @stack('scripts')
</body>
</html>
