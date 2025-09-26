@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
  <!-- Smart Breadcrumbs -->
  <x-smart-breadcrumbs :items="[
    ['title' => __('app.calendar'), 'url' => '']
  ]" />
  
  <!-- Page Header -->
  <div class="mb-8">
    <div class="sm:flex sm:items-center sm:justify-between">
      <div>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ __('app.calendar') }}</h1>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">{{ __('app.view_manage_schedule') }}</p>
      </div>
      <div class="mt-4 sm:mt-0 sm:flex sm:space-x-3">
        <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
          </svg>
          {{ __('app.new_session') }}
        </a>
        @if($has_available_trial_class)
        <a href="{{ route('schedules.trial.create') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
          </svg>
          {{ __('app.trial_class') }}
        </a>
        @endif
      </div>
    </div>
  </div>

  <!-- Calendar Container -->
  <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
    <div class="p-6">
      <div id="calendar" class="min-h-96"></div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="mt-8">
    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">{{ __('app.quick_actions') }}</h3>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
      <a href="{{ route('schedules.create') }}" class="relative rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-500 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 transition-colors duration-200">
        <div class="flex-shrink-0">
          <div class="h-10 w-10 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
            <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
            </svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <span class="absolute inset-0" aria-hidden="true"></span>
          <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.schedule_session') }}</p>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.book_regular_class') }}</p>
        </div>
      </a>

      @if($has_available_trial_class)
      <a href="{{ route('schedules.trial.create') }}" class="relative rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-500 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 transition-colors duration-200">
        <div class="flex-shrink-0">
          <div class="h-10 w-10 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center">
            <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <span class="absolute inset-0" aria-hidden="true"></span>
          <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.trial_class') }}</p>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.free_trial_session') }}</p>
        </div>
      </a>
      @endif

      <a href="{{ route('schedules.reposition.create') }}" class="relative rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-500 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 transition-colors duration-200">
        <div class="flex-shrink-0">
          <div class="h-10 w-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
            <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
            </svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <span class="absolute inset-0" aria-hidden="true"></span>
          <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.makeup_class') }}</p>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.reschedule_session') }}</p>
        </div>
      </a>

      <a href="{{ route('schedules.extra.create') }}" class="relative rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 dark:hover:border-gray-500 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 transition-colors duration-200">
        <div class="flex-shrink-0">
          <div class="h-10 w-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
            <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
          </div>
        </div>
        <div class="flex-1 min-w-0">
          <span class="absolute inset-0" aria-hidden="true"></span>
          <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('app.extra_class') }}</p>
          <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('app.additional_session') }}</p>
        </div>
      </a>
    </div>
  </div>
</div>

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css' rel='stylesheet' />
<style>
.fc-event {
    border-radius: 4px;
    border: none;
    padding: 2px 4px;
    font-size: 12px;
    font-weight: 500;
}
.fc-daygrid-event {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.fc-toolbar-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
}

/* Dark theme support for FullCalendar */
.dark .fc-toolbar-title {
    color: #f9fafb;
}

.dark .fc-col-header-cell {
    background-color: #374151;
    border-color: #4b5563;
}

.dark .fc-col-header-cell-cushion {
    color: #f9fafb;
}

.dark .fc-daygrid-day {
    background-color: #1f2937;
    border-color: #4b5563;
}

.dark .fc-daygrid-day-number {
    color: #f9fafb;
}

.dark .fc-day-today {
    background-color: #1e3a8a !important;
}

.dark .fc-button-primary {
    background-color: #4f46e5;
    border-color: #4f46e5;
    color: #ffffff;
}

.dark .fc-button-primary:hover {
    background-color: #4338ca;
    border-color: #4338ca;
}

.dark .fc-button-primary:not(:disabled):active {
    background-color: #3730a3;
    border-color: #3730a3;
}

.dark .fc-button-primary:disabled {
    background-color: #6b7280;
    border-color: #6b7280;
}

.dark .fc-scrollgrid {
    border-color: #4b5563;
}

.dark .fc-scrollgrid-section > * {
    border-color: #4b5563;
}
.fc-button-primary {
    background-color: #4f46e5;
    border-color: #4f46e5;
}
.fc-button-primary:hover {
    background-color: #4338ca;
    border-color: #4338ca;
}
.fc-button-primary:focus {
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}

/* Custom tooltip styles */
.custom-calendar-tooltip {
    pointer-events: none;
    position: fixed !important;
    z-index: 10000 !important;
    max-width: 300px;
}

.custom-calendar-tooltip .bg-gray-900 {
    animation: tooltipFadeIn 0.2s ease-out;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

@keyframes tooltipFadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced event hover effects */
.fc-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    transition: all 0.2s ease;
}

.fc-event {
    transition: all 0.2s ease;
    cursor: pointer;
}

/* Improve event text visibility */
.fc-event-title {
    font-weight: 500;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.10/locales/pt-br.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        height: 'auto',
        events: {
            url: '{{ route("calendar.data") }}',
            method: 'GET',
            failure: function() {
                alert('Erro ao carregar os eventos do calendário!');
            }
        },
        eventDisplay: 'block',
        dayMaxEvents: 3,
        moreLinkClick: 'popover',
        eventClick: function(info) {
            // Handle event click - could open a modal or navigate to schedule details
            var event = info.event;
            
            // Create a simple modal-like alert for now
            var eventDetails = `
Detalhes do Agendamento:
• Cliente: ${event.title}
• Horário: ${event.start.toLocaleString('pt-BR')}
• Duração: ${Math.round((event.end - event.start) / (1000 * 60))} minutos
            `;
            
            if (confirm(eventDetails + '\n\nDeseja editar este agendamento?')) {
                // Navigate to schedule edit page with error handling
                try {
                    const editUrl = `{{ url('schedules') }}/${event.id}/edit`;
                    window.location.href = editUrl;
                } catch (error) {
                    console.error('Error navigating to schedule edit:', error);
                    alert('Erro ao abrir a página de edição. Tente novamente.');
                }
            }
        },
        dateClick: function(info) {
            // Handle date click - could open schedule creation modal
            if (confirm(`Criar um novo agendamento para ${new Date(info.dateStr).toLocaleDateString('pt-BR')}?`)) {
                // Navigate to schedule creation with pre-filled date
                var createUrl = new URL('{{ route("schedules.create") }}', window.location.origin);
                createUrl.searchParams.set('date', info.dateStr);
                window.location.href = createUrl.toString();
            }
        },
        eventDidMount: function(info) {
            // Customize event appearance based on event properties
            var event = info.event;
            
            // Set background color if available
            if (event.backgroundColor) {
                info.el.style.backgroundColor = event.backgroundColor;
            }
            
            // Create detailed tooltip content
            var startTime = event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            var endTime = event.end ? event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
            var duration = event.end ? Math.round((event.end - event.start) / (1000 * 60)) : '';
            
            var tooltipContent = `📅 ${event.extendedProps.class_type_name || 'Aula'}
👤 Cliente: ${event.extendedProps.client_name || event.title}
👨‍🏫 Instrutor: ${event.extendedProps.professional_name || 'N/A'}
🏠 Sala: ${event.extendedProps.room_name || 'N/A'}
⏰ Horário: ${startTime}${endTime ? ' - ' + endTime : ''}${duration ? ' (' + duration + ' min)' : ''}`;
            
            // Add tooltip using native browser tooltip
            info.el.setAttribute('title', tooltipContent);
            
            // Enhanced hover effect with custom tooltip
            var tooltip = null;
            
            info.el.addEventListener('mouseenter', function(e) {
                // Remove any existing tooltips
                var existingTooltips = document.querySelectorAll('.custom-calendar-tooltip');
                existingTooltips.forEach(function(tip) {
                    tip.remove();
                });
                
                // Create custom tooltip
                tooltip = document.createElement('div');
                tooltip.className = 'custom-calendar-tooltip';
                tooltip.innerHTML = `
                    <div class="bg-gray-900 dark:bg-gray-800 text-white text-sm rounded-lg shadow-lg p-3 border border-gray-700">
                        <div class="flex items-center justify-between mb-2">
                            <div class="font-semibold text-indigo-200 dark:text-indigo-300">${event.extendedProps.class_type_name || 'Aula'}</div>
                            ${event.extendedProps.trial ? '<span class="px-2 py-1 bg-yellow-600 text-yellow-100 text-xs rounded-full">Experimental</span>' : ''}
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span class="text-gray-200">${event.extendedProps.client_name || event.title}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                </svg>
                                <span class="text-gray-200">${event.extendedProps.professional_name || 'N/A'}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <span class="text-gray-200">${event.extendedProps.room_name || 'N/A'}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-200">${startTime}${endTime ? ' - ' + endTime : ''}</span>
                            </div>
                            ${duration ? `<div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span class="text-gray-200">${duration} minutos</span>
                            </div>` : ''}
                            ${event.extendedProps.status_name ? `<div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-gray-200">${event.extendedProps.status_name}</span>
                            </div>` : ''}
                            ${event.extendedProps.price ? `<div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                                <span class="text-gray-200">R$ ${parseFloat(event.extendedProps.price).toFixed(2)}</span>
                            </div>` : ''}
                            ${event.extendedProps.observation ? `<div class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                <span class="text-gray-200 text-xs">${event.extendedProps.observation.length > 50 ? event.extendedProps.observation.substring(0, 50) + '...' : event.extendedProps.observation}</span>
                            </div>` : ''}
                        </div>
                        <div class="mt-2 pt-2 border-t border-gray-700 text-xs text-gray-400">
                            Clique para editar • Arraste para reagendar
                        </div>
                    </div>
                `;
                
                // Add tooltip to body first (invisible)
                tooltip.style.visibility = 'hidden';
                tooltip.style.position = 'fixed';
                tooltip.style.zIndex = '10000';
                document.body.appendChild(tooltip);
                
                // Get dimensions after adding to DOM
                var rect = e.target.getBoundingClientRect();
                var tooltipRect = tooltip.getBoundingClientRect();
                var viewportWidth = window.innerWidth;
                var viewportHeight = window.innerHeight;
                
                // Calculate optimal position
                var left = rect.left + (rect.width / 2) - (tooltipRect.width / 2);
                var top = rect.top - tooltipRect.height - 12;
                
                // Horizontal boundary checks
                var padding = 16;
                if (left < padding) {
                    left = padding;
                } else if (left + tooltipRect.width > viewportWidth - padding) {
                    left = viewportWidth - tooltipRect.width - padding;
                }
                
                // Vertical boundary checks
                if (top < padding) {
                    // Not enough space above, show below
                    top = rect.bottom + 12;
                    // If still not enough space below, center vertically
                    if (top + tooltipRect.height > viewportHeight - padding) {
                        top = Math.max(padding, (viewportHeight - tooltipRect.height) / 2);
                    }
                }
                
                // Apply position and make visible
                tooltip.style.left = left + 'px';
                tooltip.style.top = top + 'px';
                tooltip.style.visibility = 'visible';
            });
            
            info.el.addEventListener('mouseleave', function() {
                if (tooltip) {
                    tooltip.remove();
                    tooltip = null;
                }
            });
            
            // Clean up tooltip on scroll or click elsewhere
            var cleanupTooltip = function() {
                if (tooltip) {
                    tooltip.remove();
                    tooltip = null;
                }
            };
            
            // Add cleanup listeners (remove existing ones first to avoid duplicates)
            document.removeEventListener('scroll', cleanupTooltip, true);
            document.removeEventListener('click', cleanupTooltip, true);
            window.removeEventListener('resize', cleanupTooltip);
            document.addEventListener('scroll', cleanupTooltip, true);
            document.addEventListener('click', cleanupTooltip, true);
            window.addEventListener('resize', cleanupTooltip);
        },
        loading: function(bool) {
            // Show/hide loading indicator
            if (bool) {
                console.log('Calendar loading...');
            } else {
                console.log('Calendar loaded');
            }
        },
        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        slotLabelFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        },
        nowIndicator: true,
        businessHours: {
            daysOfWeek: [1, 2, 3, 4, 5, 6], // Monday - Saturday
            startTime: '06:00',
            endTime: '22:00',
        },
        locale: 'pt-br',
        firstDay: 1, // Monday
        weekNumbers: false,
        navLinks: true,
        selectable: true,
        selectMirror: true,
        select: function(info) {
            // Handle date range selection
            if (confirm(`Criar um novo agendamento de ${new Date(info.startStr).toLocaleDateString('pt-BR')} até ${new Date(info.endStr).toLocaleDateString('pt-BR')}?`)) {
                var createUrl = new URL('{{ route("schedules.create") }}', window.location.origin);
                createUrl.searchParams.set('start_date', info.startStr);
                createUrl.searchParams.set('start_time', info.start.toTimeString().slice(0, 5));
                window.location.href = createUrl.toString();
            }
            calendar.unselect();
        }
    });
    
    calendar.render();
    
    // Add refresh functionality
    window.refreshCalendar = function() {
        calendar.refetchEvents();
    };
});
</script>
@endpush
@endsection
