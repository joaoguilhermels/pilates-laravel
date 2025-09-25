<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Schedule;
use App\Models\Professional;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $results = collect();

        // Search Clients
        $clients = Client::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($client) {
                return [
                    'id' => "client_{$client->id}",
                    'type' => 'clients',
                    'title' => $client->name,
                    'subtitle' => $client->email ?: $client->phone,
                    'url' => route('clients.show', $client),
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                    'iconColor' => 'bg-blue-500',
                    'badge' => $this->getClientStatus($client),
                    'badgeColor' => $this->getClientBadgeColor($client),
                ];
            });

        // Search Schedules
        $schedules = Schedule::with(['client', 'professional', 'classType'])
            ->whereHas('client', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('professional', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('classType', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orderBy('start_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => "schedule_{$schedule->id}",
                    'type' => 'schedules',
                    'title' => ($schedule->classType->name ?? 'Aula') . ' - ' . ($schedule->client->name ?? 'Cliente'),
                    'subtitle' => $schedule->start_at->format('d/m/Y H:i') . ' • ' . ($schedule->professional->name ?? 'Instrutor'),
                    'url' => route('schedules.show', $schedule),
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'iconColor' => 'bg-green-500',
                    'badge' => $this->getScheduleStatus($schedule),
                    'badgeColor' => $this->getScheduleBadgeColor($schedule),
                ];
            });

        // Search Professionals
        $professionals = Professional::where('name', 'LIKE', "%{$query}%")
            ->orWhere('email', 'LIKE', "%{$query}%")
            ->orWhere('specialty', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function ($professional) {
                return [
                    'id' => "professional_{$professional->id}",
                    'type' => 'professionals',
                    'title' => $professional->name,
                    'subtitle' => $professional->specialty ?: $professional->email,
                    'url' => route('professionals.show', $professional),
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>',
                    'iconColor' => 'bg-purple-500',
                    'badge' => 'Ativo',
                    'badgeColor' => 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400',
                ];
            });

        // Search Plans
        $plans = Plan::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->limit(3)
            ->get()
            ->map(function ($plan) {
                return [
                    'id' => "plan_{$plan->id}",
                    'type' => 'plans',
                    'title' => $plan->name,
                    'subtitle' => 'R$ ' . number_format($plan->price, 2, ',', '.') . ' • ' . $plan->frequency,
                    'url' => route('plans.show', $plan),
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>',
                    'iconColor' => 'bg-indigo-500',
                    'badge' => $plan->duration,
                    'badgeColor' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400',
                ];
            });

        // Combine and prioritize results
        $results = $results
            ->concat($clients)
            ->concat($schedules)
            ->concat($professionals)
            ->concat($plans)
            ->take(15);

        return response()->json([
            'results' => $results->values()->all(),
            'total' => $results->count(),
            'query' => $query
        ]);
    }

    private function getClientStatus($client)
    {
        $activeSchedules = $client->schedules()
            ->where('start_at', '>=', now())
            ->count();
            
        if ($activeSchedules > 0) {
            return 'Ativo';
        }
        
        return 'Inativo';
    }

    private function getClientBadgeColor($client)
    {
        $activeSchedules = $client->schedules()
            ->where('start_at', '>=', now())
            ->count();
            
        if ($activeSchedules > 0) {
            return 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400';
        }
        
        return 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400';
    }

    private function getScheduleStatus($schedule)
    {
        if ($schedule->start_at->isFuture()) {
            return 'Agendada';
        } elseif ($schedule->start_at->isToday()) {
            return 'Hoje';
        } else {
            return 'Realizada';
        }
    }

    private function getScheduleBadgeColor($schedule)
    {
        if ($schedule->start_at->isFuture()) {
            return 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400';
        } elseif ($schedule->start_at->isToday()) {
            return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400';
        } else {
            return 'bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-400';
        }
    }
}
