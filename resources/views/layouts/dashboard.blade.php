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
      'use strict';
      try {
        var theme = 'light';
        try {
          theme = localStorage.getItem('theme');
        } catch (e) {
          // localStorage not available
        }
        
        if (!theme) {
          try {
            theme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
          } catch (e) {
            theme = 'light';
          }
        }
        
        if (theme === 'dark') {
          document.documentElement.classList.add('dark');
        }
        
        // Prevent flash by ensuring body is ready
        document.documentElement.style.visibility = 'visible';
      } catch (e) {
        // Fallback if everything fails
        console.warn('Theme detection failed:', e);
        document.documentElement.style.visibility = 'visible';
      }
    })();
  </script>
  
  @vite(['resources/css/app.css','resources/js/app.js'])
  
  <!-- Navigation JavaScript -->
  <style>
    /* Prevent flash during page load */
    .js-loading { opacity: 0; transition: opacity 0.2s ease-in-out; }
    .js-loaded { opacity: 1; }
    /* Reduce transition conflicts */
    .transition-colors { transition-duration: 0.15s !important; }
    /* Hide dropdowns by default */
    .dropdown-menu { display: none; }
    .dropdown-menu.show { display: block; }
    /* Alpine.js x-cloak directive - prevents flashing */
    [x-cloak] { display: none !important; }
  </style>
  
  <!-- Navigation functionality -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Mobile menu toggle
      const mobileMenuButton = document.getElementById('mobile-menu-button');
      const mobileMenu = document.getElementById('mobile-menu');
      let mobileMenuOpen = false;
      
      if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
          mobileMenuOpen = !mobileMenuOpen;
          mobileMenu.style.display = mobileMenuOpen ? 'block' : 'none';
          
          // Update button icons
          const hamburgerIcon = mobileMenuButton.querySelector('.hamburger-icon');
          const closeIcon = mobileMenuButton.querySelector('.close-icon');
          if (hamburgerIcon && closeIcon) {
            hamburgerIcon.style.display = mobileMenuOpen ? 'none' : 'block';
            closeIcon.style.display = mobileMenuOpen ? 'block' : 'none';
          }
        });
      }
      
      // Dropdown functionality
      document.querySelectorAll('[data-dropdown-toggle]').forEach(button => {
        const targetId = button.getAttribute('data-dropdown-toggle');
        const dropdown = document.getElementById(targetId);
        let isOpen = false;
        
        if (dropdown) {
          button.addEventListener('click', function(e) {
            e.preventDefault();
            isOpen = !isOpen;
            dropdown.classList.toggle('show', isOpen);
          });
          
          // Close on outside click
          document.addEventListener('click', function(e) {
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
              isOpen = false;
              dropdown.classList.remove('show');
            }
          });
        }
      });
      
      // Mark as loaded
      document.body.classList.add('js-loaded');
      document.body.classList.remove('js-loading');
    });
  </script>
  
  @stack('styles')
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
  <!-- Navigation -->
  <nav class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between h-16">
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="font-semibold text-xl tracking-tight text-gray-900 dark:text-white">
            {{ config('app.name', 'Pilates') }}
          </a>
          <!-- Global Search -->
          <div class="hidden md:block md:ml-6 md:w-96">
            <x-global-search />
          </div>
          
          <!-- Desktop Navigation -->
          <div class="hidden md:ml-6 md:flex md:space-x-6">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.dashboard') }}
            </a>
            <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.clients') }}
            </a>
            <a href="{{ route('schedules.index') }}" class="{{ request()->routeIs('schedules.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.schedules') }}
            </a>
            <a href="{{ route('calendar') }}" class="{{ request()->routeIs('calendar*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              {{ __('app.calendar') }}
            </a>
            <a href="{{ route('billing.index') }}" class="{{ request()->routeIs('billing.*') ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
              💳 Cobrança
            </a>
            
            <!-- Management Dropdown -->
            <div class="relative">
              <button data-dropdown-toggle="management-dropdown" class="{{ request()->routeIs(['professionals.*', 'rooms.*', 'classes.*']) ? 'border-indigo-500 text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-700 dark:hover:text-gray-200' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors duration-200">
                Gestão
                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </button>
              
              <div id="management-dropdown" class="dropdown-menu origin-top-left absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-gray-600 focus:outline-none z-50">
                <div class="py-1">
                  <a href="{{ route('professionals.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{ __('app.professionals') }}
                  </a>
                  <a href="{{ route('rooms.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    {{ __('app.rooms') }}
                  </a>
                  <a href="{{ route('classes.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    {{ __('app.classes') }}
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="flex items-center space-x-4">
          <!-- Mobile menu button -->
          <div class="md:hidden">
            <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-300 hover:text-gray-500 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-colors duration-200" aria-controls="mobile-menu">
              <span class="sr-only">Open main menu</span>
              <!-- Hamburger icon when menu is closed -->
              <svg class="hamburger-icon h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
              <!-- X icon when menu is open -->
              <svg class="close-icon h-6 w-6" style="display: none;" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
          <!-- Theme Toggle -->
          @include('components.theme-toggle')
          
          <!-- User Dropdown -->
          <div class="relative">
            <button data-dropdown-toggle="user-dropdown" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
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
            <div id="user-dropdown" class="dropdown-menu origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-gray-600 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
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
      <div id="mobile-menu" class="md:hidden" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
          <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.dashboard') }}
          </a>
          <a href="{{ route('clients.index') }}" class="{{ request()->routeIs('clients.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.clients') }}
          </a>
          <a href="{{ route('schedules.index') }}" class="{{ request()->routeIs('schedules.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.schedules') }}
          </a>
          <a href="{{ route('professionals.index') }}" class="{{ request()->routeIs('professionals.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.professionals') }}
          </a>
          <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.rooms') }}
          </a>
          <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.classes') }}
          </a>
          <a href="{{ route('calendar') }}" class="{{ request()->routeIs('calendar*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            {{ __('app.calendar') }}
          </a>
          <a href="{{ route('billing.index') }}" class="{{ request()->routeIs('billing.*') ? 'bg-indigo-50 dark:bg-indigo-900 border-indigo-500 text-indigo-700 dark:text-indigo-200' : 'border-transparent text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 hover:text-gray-800 dark:hover:text-gray-200' }} block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors duration-200">
            💳 Cobrança
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div>
    <main class="py-6">
      @yield('content')
    </main>
    
    <!-- Vue.js App Container (only for specific components) -->
    <div id="app" style="display: none;"></div>
  </div>
  
  @stack('scripts')
</body>
</html>
