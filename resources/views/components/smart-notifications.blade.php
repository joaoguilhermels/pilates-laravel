@props(['type' => 'info', 'title' => '', 'message' => '', 'actions' => [], 'dismissible' => true, 'autoHide' => true])

<div 
    x-data="smartNotification({{ json_encode(['autoHide' => $autoHide, 'dismissible' => $dismissible]) }})"
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 dark:ring-gray-600 overflow-hidden"
>
    <div class="p-4">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                @if($type === 'success')
                    <svg class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @elseif($type === 'error')
                    <svg class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                @elseif($type === 'warning')
                    <svg class="h-6 w-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                @else
                    <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @endif
            </div>
            <div class="ml-3 w-0 flex-1 pt-0.5">
                @if($title)
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $title }}</p>
                @endif
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $message }}</p>
                
                @if(count($actions) > 0)
                    <div class="mt-3 flex space-x-3">
                        @foreach($actions as $action)
                            <button 
                                @if(isset($action['onclick'])) @click="{{ $action['onclick'] }}" @endif
                                class="bg-white dark:bg-gray-700 rounded-md text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200"
                            >
                                {{ $action['text'] }}
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
            @if($dismissible)
                <div class="ml-4 flex-shrink-0 flex">
                    <button 
                        @click="dismiss()"
                        class="bg-white dark:bg-gray-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200"
                    >
                        <span class="sr-only">Fechar</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Progress Bar for Auto-hide -->
    <div x-show="autoHide && show" class="bg-gray-200 dark:bg-gray-700 h-1">
        <div 
            class="h-1 bg-indigo-500 transition-all duration-100 ease-linear"
            :style="`width: ${progress}%`"
        ></div>
    </div>
</div>

<script>
function smartNotification(config) {
    return {
        show: true,
        progress: 100,
        autoHide: config.autoHide,
        dismissible: config.dismissible,
        
        init() {
            if (this.autoHide) {
                this.startAutoHide();
            }
        },
        
        startAutoHide() {
            const duration = 5000; // 5 seconds
            const interval = 50; // Update every 50ms
            const steps = duration / interval;
            const decrement = 100 / steps;
            
            const timer = setInterval(() => {
                this.progress -= decrement;
                
                if (this.progress <= 0) {
                    clearInterval(timer);
                    this.dismiss();
                }
            }, interval);
        },
        
        dismiss() {
            this.show = false;
            // Remove from DOM after animation
            setTimeout(() => {
                this.$el.remove();
            }, 300);
        }
    }
}
</script>
