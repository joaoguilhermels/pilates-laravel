<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use App\Models\Client;
use App\Models\Room;
use App\Models\ClassType;
use App\Models\Plan;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DependencyController extends Controller
{
    /**
     * Check dependencies before deletion
     */
    public function checkDependencies(string $entityType, int $entityId): JsonResponse
    {
        try {
            $result = match ($entityType) {
                'professional' => $this->checkProfessionalDependencies($entityId),
                'client' => $this->checkClientDependencies($entityId),
                'room' => $this->checkRoomDependencies($entityId),
                'class-type' => $this->checkClassTypeDependencies($entityId),
                'plan' => $this->checkPlanDependencies($entityId),
                default => ['canDelete' => true, 'dependencies' => [], 'warnings' => [], 'alternativeActions' => []]
            };

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to check dependencies',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Check schedule conflicts
     */
    public function checkScheduleConflicts(Request $request): JsonResponse
    {
        $data = $request->validate([
            'professional_id' => 'required|exists:professionals,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'integer|min:15|max:300'
        ]);

        $conflicts = [];
        $startDateTime = $data['start_date'] . ' ' . $data['start_time'];
        $duration = $data['duration'] ?? 60;
        $endDateTime = date('Y-m-d H:i:s', strtotime($startDateTime . ' +' . $duration . ' minutes'));

        // Check professional conflicts
        $professionalConflicts = Schedule::where('professional_id', $data['professional_id'])
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_at', [$startDateTime, $endDateTime])
                    ->orWhereBetween('end_at', [$startDateTime, $endDateTime])
                    ->orWhere(function ($subQuery) use ($startDateTime, $endDateTime) {
                        $subQuery->where('start_at', '<=', $startDateTime)
                                ->where('end_at', '>=', $endDateTime);
                    });
            })
            ->with(['client', 'classType'])
            ->get();

        foreach ($professionalConflicts as $conflict) {
            $conflicts[] = "Professional has another class: {$conflict->classType->name} with {$conflict->client->name} at " . 
                          $conflict->start_at->format('H:i');
        }

        // Check room conflicts
        $roomConflicts = Schedule::where('room_id', $data['room_id'])
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_at', [$startDateTime, $endDateTime])
                    ->orWhereBetween('end_at', [$startDateTime, $endDateTime])
                    ->orWhere(function ($subQuery) use ($startDateTime, $endDateTime) {
                        $subQuery->where('start_at', '<=', $startDateTime)
                                ->where('end_at', '>=', $endDateTime);
                    });
            })
            ->with(['client', 'professional', 'classType'])
            ->get();

        foreach ($roomConflicts as $conflict) {
            $conflicts[] = "Room is occupied: {$conflict->classType->name} with {$conflict->professional->name} and {$conflict->client->name} at " . 
                          $conflict->start_at->format('H:i');
        }

        return response()->json($conflicts);
    }

    private function checkProfessionalDependencies(int $professionalId): array
    {
        $professional = Professional::findOrFail($professionalId);
        $dependencies = [];
        $warnings = [];
        $alternativeActions = [];

        // Check active schedules
        $activeSchedules = Schedule::where('professional_id', $professionalId)
            ->where('start_at', '>=', now())
            ->count();

        if ($activeSchedules > 0) {
            $dependencies[] = "{$activeSchedules} upcoming scheduled classes";
            $warnings[] = "Deleting this professional will cancel all their upcoming classes and may affect client bookings.";
        }

        // Check historical schedules
        $historicalSchedules = Schedule::where('professional_id', $professionalId)
            ->where('start_at', '<', now())
            ->count();

        if ($historicalSchedules > 0) {
            $dependencies[] = "{$historicalSchedules} completed classes in history";
            $warnings[] = "Historical class records and payment data will be affected.";
        }

        // Check financial transactions
        $financialTransactions = $professional->financialTransactions()->count();
        if ($financialTransactions > 0) {
            $dependencies[] = "{$financialTransactions} financial transactions";
            $warnings[] = "Payment history and financial records will be affected.";
        }

        // Alternative actions
        if ($activeSchedules > 0) {
            $alternativeActions[] = [
                'label' => 'Reassign upcoming classes to another professional',
                'url' => route('professionals.reassign', $professionalId)
            ];
        }

        $alternativeActions[] = [
            'label' => 'Deactivate instead of deleting',
            'url' => route('professionals.deactivate', $professionalId)
        ];

        return [
            'canDelete' => $activeSchedules === 0, // Can only delete if no active schedules
            'dependencies' => $dependencies,
            'warnings' => $warnings,
            'alternativeActions' => $alternativeActions
        ];
    }

    private function checkClientDependencies(int $clientId): array
    {
        $client = Client::findOrFail($clientId);
        $dependencies = [];
        $warnings = [];
        $alternativeActions = [];

        // Check active plans
        $activePlans = $client->clientPlans()
            ->where('end_date', '>=', now())
            ->orWhereNull('end_date')
            ->count();

        if ($activePlans > 0) {
            $dependencies[] = "{$activePlans} active subscription plans";
            $warnings[] = "Client has active subscriptions that will be cancelled.";
        }

        // Check upcoming schedules
        $upcomingSchedules = Schedule::where('client_id', $clientId)
            ->where('start_at', '>=', now())
            ->count();

        if ($upcomingSchedules > 0) {
            $dependencies[] = "{$upcomingSchedules} upcoming scheduled classes";
            $warnings[] = "Client has upcoming classes that will be cancelled.";
        }

        // Check payment history
        $paymentHistory = Schedule::where('client_id', $clientId)
            ->whereHas('financialTransactions')
            ->count();

        if ($paymentHistory > 0) {
            $dependencies[] = "{$paymentHistory} classes with payment records";
            $warnings[] = "Financial history and payment records will be affected.";
        }

        // Check outstanding balances
        $outstandingBalance = $client->clientPlans()
            ->where('balance', '>', 0)
            ->sum('balance');

        if ($outstandingBalance > 0) {
            $dependencies[] = "Outstanding balance: $" . number_format($outstandingBalance, 2);
            $warnings[] = "Client has an outstanding balance that needs to be resolved.";
        }

        // Alternative actions
        if ($upcomingSchedules > 0) {
            $alternativeActions[] = [
                'label' => 'Cancel upcoming classes first',
                'url' => route('clients.cancel-schedules', $clientId)
            ];
        }

        if ($activePlans > 0) {
            $alternativeActions[] = [
                'label' => 'End active subscriptions first',
                'url' => route('clients.end-plans', $clientId)
            ];
        }

        $alternativeActions[] = [
            'label' => 'Archive client instead of deleting',
            'url' => route('clients.archive', $clientId)
        ];

        return [
            'canDelete' => $upcomingSchedules === 0 && $activePlans === 0 && $outstandingBalance <= 0,
            'dependencies' => $dependencies,
            'warnings' => $warnings,
            'alternativeActions' => $alternativeActions
        ];
    }

    private function checkRoomDependencies(int $roomId): array
    {
        $room = Room::findOrFail($roomId);
        $dependencies = [];
        $warnings = [];
        $alternativeActions = [];

        // Check upcoming schedules
        $upcomingSchedules = Schedule::where('room_id', $roomId)
            ->where('start_at', '>=', now())
            ->count();

        if ($upcomingSchedules > 0) {
            $dependencies[] = "{$upcomingSchedules} upcoming scheduled classes";
            $warnings[] = "Room has upcoming classes that will need to be moved to another room.";
        }

        // Check historical usage
        $historicalUsage = Schedule::where('room_id', $roomId)
            ->where('start_at', '<', now())
            ->count();

        if ($historicalUsage > 0) {
            $dependencies[] = "{$historicalUsage} historical class records";
            $warnings[] = "Historical class records will reference a deleted room.";
        }

        // Alternative actions
        if ($upcomingSchedules > 0) {
            $alternativeActions[] = [
                'label' => 'Move upcoming classes to another room',
                'url' => route('rooms.move-schedules', $roomId)
            ];
        }

        $alternativeActions[] = [
            'label' => 'Deactivate room instead of deleting',
            'url' => route('rooms.deactivate', $roomId)
        ];

        return [
            'canDelete' => $upcomingSchedules === 0,
            'dependencies' => $dependencies,
            'warnings' => $warnings,
            'alternativeActions' => $alternativeActions
        ];
    }

    private function checkClassTypeDependencies(int $classTypeId): array
    {
        $classType = ClassType::findOrFail($classTypeId);
        $dependencies = [];
        $warnings = [];
        $alternativeActions = [];

        // Check active schedules
        $activeSchedules = Schedule::where('class_type_id', $classTypeId)
            ->where('start_at', '>=', now())
            ->count();

        if ($activeSchedules > 0) {
            $dependencies[] = "{$activeSchedules} upcoming scheduled classes";
            $warnings[] = "Deleting this class type will affect upcoming classes.";
        }

        // Check associated plans
        $associatedPlans = Plan::whereHas('classTypes', function ($query) use ($classTypeId) {
            $query->where('class_type_id', $classTypeId);
        })->count();

        if ($associatedPlans > 0) {
            $dependencies[] = "{$associatedPlans} subscription plans";
            $warnings[] = "This class type is included in existing subscription plans.";
        }

        // Check professional associations
        $professionalCount = $classType->professionals()->count();
        if ($professionalCount > 0) {
            $dependencies[] = "{$professionalCount} professionals certified to teach this class";
        }

        // Alternative actions
        $alternativeActions[] = [
            'label' => 'Deactivate class type instead of deleting',
            'url' => route('class-types.deactivate', $classTypeId)
        ];

        if ($activeSchedules > 0) {
            $alternativeActions[] = [
                'label' => 'Convert upcoming classes to another type',
                'url' => route('class-types.convert-schedules', $classTypeId)
            ];
        }

        return [
            'canDelete' => $activeSchedules === 0 && $associatedPlans === 0,
            'dependencies' => $dependencies,
            'warnings' => $warnings,
            'alternativeActions' => $alternativeActions
        ];
    }

    private function checkPlanDependencies(int $planId): array
    {
        $plan = Plan::findOrFail($planId);
        $dependencies = [];
        $warnings = [];
        $alternativeActions = [];

        // Check active client subscriptions
        $activeSubscriptions = $plan->clientPlans()
            ->where('end_date', '>=', now())
            ->orWhereNull('end_date')
            ->count();

        if ($activeSubscriptions > 0) {
            $dependencies[] = "{$activeSubscriptions} active client subscriptions";
            $warnings[] = "Clients are currently subscribed to this plan.";
        }

        // Check historical subscriptions
        $historicalSubscriptions = $plan->clientPlans()->count();
        if ($historicalSubscriptions > 0) {
            $dependencies[] = "{$historicalSubscriptions} total historical subscriptions";
            $warnings[] = "Historical subscription data will be affected.";
        }

        // Alternative actions
        if ($activeSubscriptions > 0) {
            $alternativeActions[] = [
                'label' => 'Migrate active subscriptions to another plan',
                'url' => route('plans.migrate-subscriptions', $planId)
            ];
        }

        $alternativeActions[] = [
            'label' => 'Deactivate plan instead of deleting',
            'url' => route('plans.deactivate', $planId)
        ];

        return [
            'canDelete' => $activeSubscriptions === 0,
            'dependencies' => $dependencies,
            'warnings' => $warnings,
            'alternativeActions' => $alternativeActions
        ];
    }
}
