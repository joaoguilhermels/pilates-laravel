@props(['placeholder' => 'Buscar clientes, aulas, profissionais...'])

<div x-data="globalSearch()" x-cloak class="relative" @click.away="closeResults()">
    <!-- Search Input -->
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <input 
            x-model="query" 
            @input.debounce.300ms="search()"
            @focus="showResults = true"
            @keydown.escape="closeResults()"
            @keydown.arrow-down.prevent="navigateDown()"
            @keydown.arrow-up.prevent="navigateUp()"
            @keydown.enter.prevent="selectResult()"
            type="text" 
            class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-white focus:outline-none focus:placeholder-gray-400 dark:focus:placeholder-gray-300 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors duration-200" 
            :placeholder="placeholder"
            autocomplete="off"
        >
        
        <!-- Loading Spinner -->
        <div x-show="loading" x-cloak class="absolute inset-y-0 right-0 pr-3 flex items-center">
            <svg class="animate-spin h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>

    <!-- Search Results -->
    <div 
        x-show="showResults && (results.length > 0 || query.length > 0)" 
        x-cloak
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute z-50 mt-1 w-full bg-white dark:bg-gray-800 shadow-lg rounded-md border border-gray-200 dark:border-gray-600 max-h-96 overflow-auto"
        style="display: none;"
    >
        <!-- Quick Filters -->
        <div x-show="query.length === 0" x-cloak class="p-3 border-b border-gray-200 dark:border-gray-600">
            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-2">Busca Rápida</p>
            <div class="flex flex-wrap gap-2">
                <button @click="quickSearch('clients')" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 dark:text-indigo-300 bg-indigo-100 dark:bg-indigo-900/20 hover:bg-indigo-200 dark:hover:bg-indigo-900/40 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Clientes
                </button>
                <button @click="quickSearch('schedules')" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-green-700 dark:text-green-300 bg-green-100 dark:bg-green-900/20 hover:bg-green-200 dark:hover:bg-green-900/40 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Aulas
                </button>
                <button @click="quickSearch('professionals')" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-purple-700 dark:text-purple-300 bg-purple-100 dark:bg-purple-900/20 hover:bg-purple-200 dark:hover:bg-purple-900/40 transition-colors duration-200">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Profissionais
                </button>
            </div>
        </div>

        <!-- Results -->
        <div x-show="results.length > 0" x-cloak>
            <template x-for="(group, groupIndex) in groupedResults" :key="groupIndex">
                <div>
                    <div class="px-3 py-2 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide bg-gray-50 dark:bg-gray-700/50" x-text="group.title"></div>
                    <template x-for="(result, resultIndex) in group.items" :key="result.id">
                        <a 
                            :href="result.url"
                            @click="selectResult(result)"
                            :class="selectedIndex === (groupIndex * 10 + resultIndex) ? 'bg-indigo-50 dark:bg-indigo-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-700'"
                            class="block px-3 py-2 text-sm text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 last:border-b-0 transition-colors duration-200"
                        >
                            <div class="flex items-center">
                                <div class="flex-shrink-0 mr-3">
                                    <div :class="result.iconColor" class="w-8 h-8 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-html="result.icon"></svg>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium truncate" x-text="result.title"></p>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs truncate" x-text="result.subtitle"></p>
                                </div>
                                <div class="flex-shrink-0 ml-2">
                                    <span :class="result.badgeColor" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium" x-text="result.badge"></span>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
            </template>
        </div>

        <!-- No Results -->
        <div x-show="query.length > 0 && results.length === 0 && !loading" x-cloak class="px-3 py-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Nenhum resultado encontrado</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tente buscar com termos diferentes.</p>
        </div>
    </div>
</div>

<script>
function globalSearch() {
    return {
        query: '',
        results: [],
        groupedResults: [],
        showResults: false,
        loading: false,
        selectedIndex: -1,
        placeholder: 'Buscar clientes, aulas, profissionais...',
        
        init() {
            // Initialize with proper state to prevent flashing
            this.showResults = false;
            this.loading = false;
        },

        async search() {
            if (this.query.length < 2) {
                this.results = [];
                this.groupedResults = [];
                this.showResults = this.query.length > 0; // Show empty state if typing
                return;
            }

            this.loading = true;
            this.showResults = true;
            
            try {
                const response = await fetch(`/api/search?q=${encodeURIComponent(this.query)}`);
                const data = await response.json();
                this.results = data.results || [];
                this.groupedResults = this.groupResults(this.results);
            } catch (error) {
                console.error('Search error:', error);
                this.results = [];
                this.groupedResults = [];
            } finally {
                this.loading = false;
            }
        },

        quickSearch(type) {
            const routes = {
                'clients': '/clients',
                'schedules': '/schedules',
                'professionals': '/professionals'
            };
            
            if (routes[type]) {
                window.location.href = routes[type];
            }
        },

        groupResults(results) {
            const groups = {};
            
            results.forEach(result => {
                if (!groups[result.type]) {
                    groups[result.type] = {
                        title: this.getTypeTitle(result.type),
                        items: []
                    };
                }
                groups[result.type].items.push(result);
            });

            return Object.values(groups);
        },

        getTypeTitle(type) {
            const titles = {
                'clients': 'Clientes',
                'schedules': 'Aulas',
                'professionals': 'Profissionais',
                'plans': 'Planos'
            };
            return titles[type] || type;
        },

        navigateDown() {
            if (this.selectedIndex < this.results.length - 1) {
                this.selectedIndex++;
            }
        },

        navigateUp() {
            if (this.selectedIndex > 0) {
                this.selectedIndex--;
            }
        },

        selectResult(result = null) {
            if (result) {
                window.location.href = result.url;
            } else if (this.selectedIndex >= 0 && this.results[this.selectedIndex]) {
                window.location.href = this.results[this.selectedIndex].url;
            }
        },

        closeResults() {
            // Use setTimeout to prevent flashing when clicking away
            setTimeout(() => {
                this.showResults = false;
                this.selectedIndex = -1;
            }, 150);
        }
    }
}
</script>
