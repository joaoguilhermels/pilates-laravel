@props(['type' => 'skeleton', 'rows' => 3, 'size' => 'md'])

@if($type === 'skeleton')
    <!-- Skeleton Loading -->
    <div class="animate-pulse space-y-4">
        @for($i = 0; $i < $rows; $i++)
            <div class="flex items-center space-x-4">
                <div class="rounded-full bg-gray-300 dark:bg-gray-600 h-10 w-10"></div>
                <div class="flex-1 space-y-2">
                    <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-3/4"></div>
                    <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-1/2"></div>
                </div>
            </div>
        @endfor
    </div>

@elseif($type === 'spinner')
    <!-- Spinner Loading -->
    <div class="flex items-center justify-center p-8">
        <div class="relative">
            <div class="w-12 h-12 rounded-full border-4 border-gray-200 dark:border-gray-600"></div>
            <div class="w-12 h-12 rounded-full border-4 border-indigo-500 border-t-transparent animate-spin absolute top-0 left-0"></div>
        </div>
        <span class="ml-3 text-gray-600 dark:text-gray-400">Carregando...</span>
    </div>

@elseif($type === 'dots')
    <!-- Dots Loading -->
    <div class="flex items-center justify-center space-x-2 p-8">
        <div class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce"></div>
        <div class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
        <div class="w-3 h-3 bg-indigo-500 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
    </div>

@elseif($type === 'progress')
    <!-- Progress Bar -->
    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
        <div 
            class="bg-indigo-500 h-2 rounded-full transition-all duration-300 ease-out"
            style="width: 0%"
            x-data="{ progress: 0 }"
            x-init="
                let interval = setInterval(() => {
                    progress += Math.random() * 30;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(interval);
                    }
                    $el.style.width = progress + '%';
                }, 200);
            "
        ></div>
    </div>

@elseif($type === 'table')
    <!-- Table Skeleton -->
    <div class="animate-pulse">
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <div class="border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-1/4"></div>
            </div>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @for($i = 0; $i < $rows; $i++)
                    <li class="px-4 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="rounded-full bg-gray-300 dark:bg-gray-600 h-8 w-8"></div>
                                <div class="space-y-1">
                                    <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-32"></div>
                                    <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-24"></div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <div class="h-6 bg-gray-300 dark:bg-gray-600 rounded w-16"></div>
                                <div class="h-6 bg-gray-300 dark:bg-gray-600 rounded w-16"></div>
                            </div>
                        </div>
                    </li>
                @endfor
            </ul>
        </div>
    </div>

@elseif($type === 'card')
    <!-- Card Skeleton -->
    <div class="animate-pulse">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="flex items-center space-x-4 mb-4">
                <div class="rounded-full bg-gray-300 dark:bg-gray-600 h-12 w-12"></div>
                <div class="space-y-2">
                    <div class="h-4 bg-gray-300 dark:bg-gray-600 rounded w-32"></div>
                    <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-24"></div>
                </div>
            </div>
            <div class="space-y-3">
                <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded"></div>
                <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-5/6"></div>
                <div class="h-3 bg-gray-300 dark:bg-gray-600 rounded w-4/6"></div>
            </div>
        </div>
    </div>

@endif
