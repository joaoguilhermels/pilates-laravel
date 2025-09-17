{{-- Theme Toggle Component --}}
<div x-data="themeToggle()" x-cloak class="relative">
  <button 
    @click="toggleTheme()"
    class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 transition-colors duration-200"
    :title="isDark ? '{{ __('app.switch_to_light_mode') }}' : '{{ __('app.switch_to_dark_mode') }}'"
  >
    <!-- Sun Icon (Light Mode) -->
    <svg 
      x-show="!isDark" 
      x-transition:enter="transition ease-in-out duration-200"
      x-transition:enter-start="opacity-0 rotate-90 scale-75"
      x-transition:enter-end="opacity-100 rotate-0 scale-100"
      x-transition:leave="transition ease-in-out duration-200"
      x-transition:leave-start="opacity-100 rotate-0 scale-100"
      x-transition:leave-end="opacity-0 rotate-90 scale-75"
      class="w-5 h-5 text-yellow-500" 
      fill="currentColor" 
      viewBox="0 0 20 20"
    >
      <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" clip-rule="evenodd" />
    </svg>
    
    <!-- Moon Icon (Dark Mode) -->
    <svg 
      x-show="isDark" 
      x-transition:enter="transition ease-in-out duration-200"
      x-transition:enter-start="opacity-0 -rotate-90 scale-75"
      x-transition:enter-end="opacity-100 rotate-0 scale-100"
      x-transition:leave="transition ease-in-out duration-200"
      x-transition:leave-start="opacity-100 rotate-0 scale-100"
      x-transition:leave-end="opacity-0 -rotate-90 scale-75"
      class="w-5 h-5 text-blue-400" 
      fill="currentColor" 
      viewBox="0 0 20 20"
    >
      <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
    </svg>
  </button>
</div>

<script>
function themeToggle() {
  return {
    // Initialize isDark based on current DOM state to prevent flash
    isDark: document.documentElement.classList.contains('dark'),
    
    init() {
      // Double-check theme state and ensure it's correct
      const savedTheme = localStorage.getItem('theme');
      const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
      const shouldBeDark = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
      
      // Only update if there's a mismatch
      if (this.isDark !== shouldBeDark) {
        this.isDark = shouldBeDark;
        this.updateTheme();
      }
      
      // Listen for system theme changes
      window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
          this.isDark = e.matches;
          this.updateTheme();
        }
      });
    },
    
    toggleTheme() {
      this.isDark = !this.isDark;
      this.updateTheme();
      localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
    },
    
    updateTheme() {
      if (this.isDark) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
  }
}
</script>
