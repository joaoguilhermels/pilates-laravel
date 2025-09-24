<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\ClassType;
use App\Models\Professional;

class OnboardingController extends Controller
{
    /**
     * Show the onboarding wizard
     */
    public function index()
    {
        $user = Auth::user();
        
        // Check if user has already completed onboarding
        if ($user->onboarding_completed) {
            return redirect()->route('home')->with('info', 'Você já completou o processo de configuração inicial.');
        }

        $steps = $this->getOnboardingSteps($user);
        $currentStep = $this->getCurrentStep($user);
        $progress = $this->calculateProgress($user, $steps);

        return view('onboarding.wizard', compact('user', 'steps', 'currentStep', 'progress'));
    }

    /**
     * Get onboarding steps based on user's plan
     */
    private function getOnboardingSteps(User $user): array
    {
        $baseSteps = [
            [
                'id' => 'profile',
                'title' => 'Complete seu Perfil',
                'description' => 'Adicione informações básicas do seu negócio',
                'icon' => 'user',
                'required' => true,
                'completed' => $this->isProfileComplete($user),
                'route' => 'profile.edit',
                'fields' => ['name', 'email', 'phone', 'studio_name']
            ],
            [
                'id' => 'rooms',
                'title' => 'Configure Salas',
                'description' => 'Adicione as salas onde as aulas acontecem',
                'icon' => 'building',
                'required' => true,
                'completed' => $user->rooms()->count() > 0,
                'route' => 'rooms.create',
                'params' => ['onboarding' => 1],
                'min_count' => 1
            ],
            [
                'id' => 'class_types',
                'title' => 'Tipos de Aula',
                'description' => 'Defina os tipos de aulas que você oferece',
                'icon' => 'academic-cap',
                'required' => true,
                'completed' => $user->classTypes()->count() > 0,
                'route' => 'classes.create',
                'params' => ['onboarding' => 1],
                'min_count' => 1
            ]
        ];

        // Add plan-specific steps
        if ($user->isStudioOwner()) {
            $baseSteps[] = [
                'id' => 'professionals',
                'title' => 'Adicionar Profissionais',
                'description' => 'Cadastre os profissionais da sua equipe',
                'icon' => 'users',
                'required' => false,
                'completed' => $user->professionals()->count() > 0,
                'route' => 'professionals.create',
                'params' => ['onboarding' => 1],
                'min_count' => 0
            ];
        }

        $baseSteps[] = [
            'id' => 'plans',
            'title' => 'Criar Planos',
            'description' => 'Configure os planos de mensalidade',
            'icon' => 'clipboard-list',
            'required' => true,
            'completed' => $user->plans()->count() > 0,
            'route' => 'plans.create',
            'params' => ['onboarding' => 1],
            'min_count' => 1
        ];

        $baseSteps[] = [
            'id' => 'complete',
            'title' => 'Finalizar',
            'description' => 'Revisar configurações e começar a usar',
            'icon' => 'check-circle',
            'required' => true,
            'completed' => false,
            'route' => 'onboarding.complete'
        ];

        return $baseSteps;
    }

    /**
     * Get current step based on completion status
     */
    private function getCurrentStep(User $user): int
    {
        $steps = $this->getOnboardingSteps($user);
        
        foreach ($steps as $index => $step) {
            if (!$step['completed']) {
                return $index;
            }
        }
        
        return count($steps) - 1; // Last step
    }

    /**
     * Calculate onboarding progress percentage
     */
    private function calculateProgress(User $user, array $steps): int
    {
        $totalSteps = count($steps);
        $completedSteps = 0;

        foreach ($steps as $step) {
            if ($step['completed']) {
                $completedSteps++;
            }
        }

        return $totalSteps > 0 ? round(($completedSteps / $totalSteps) * 100) : 0;
    }

    /**
     * Check if user profile is complete
     */
    private function isProfileComplete(User $user): bool
    {
        return !empty($user->name) && 
               !empty($user->email) && 
               !empty($user->studio_name) &&
               !empty($user->phone);
    }

    /**
     * Skip onboarding (mark as completed but incomplete)
     */
    public function skip(Request $request)
    {
        $user = Auth::user();
        
        $user->update([
            'onboarding_completed' => true,
            'onboarding_skipped' => true,
            'onboarding_completed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Configuração inicial foi pulada. Você pode completá-la depois nas configurações.',
            'redirect' => route('home')
        ]);
    }

    /**
     * Complete onboarding
     */
    public function complete(Request $request)
    {
        $user = Auth::user();
        $steps = $this->getOnboardingSteps($user);
        
        // Check if all required steps are completed
        $incompleteSteps = [];
        foreach ($steps as $step) {
            if ($step['required'] && !$step['completed']) {
                $incompleteSteps[] = $step['title'];
            }
        }

        if (!empty($incompleteSteps)) {
            return response()->json([
                'success' => false,
                'message' => 'Complete os passos obrigatórios: ' . implode(', ', $incompleteSteps),
                'incomplete_steps' => $incompleteSteps
            ], 422);
        }

        $user->update([
            'onboarding_completed' => true,
            'onboarding_skipped' => false,
            'onboarding_completed_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => '🎉 Parabéns! Configuração inicial concluída com sucesso!',
            'redirect' => route('home')
        ]);
    }

    /**
     * Get onboarding status for API
     */
    public function status()
    {
        $user = Auth::user();
        $steps = $this->getOnboardingSteps($user);
        $progress = $this->calculateProgress($user, $steps);
        $currentStep = $this->getCurrentStep($user);

        return response()->json([
            'completed' => $user->onboarding_completed,
            'skipped' => $user->onboarding_skipped ?? false,
            'progress' => $progress,
            'current_step' => $currentStep,
            'steps' => $steps,
            'total_steps' => count($steps)
        ]);
    }

    /**
     * Mark a specific step as completed
     */
    public function markStepCompleted(Request $request, $stepId)
    {
        $user = Auth::user();
        $steps = $this->getOnboardingSteps($user);
        
        // Find the step
        $stepFound = false;
        foreach ($steps as $step) {
            if ($step['id'] === $stepId) {
                $stepFound = true;
                break;
            }
        }

        if (!$stepFound) {
            return response()->json(['success' => false, 'message' => 'Passo não encontrado'], 404);
        }

        // Update progress
        $progress = $this->calculateProgress($user, $this->getOnboardingSteps($user));
        $currentStep = $this->getCurrentStep($user);

        return response()->json([
            'success' => true,
            'progress' => $progress,
            'current_step' => $currentStep,
            'message' => 'Passo marcado como concluído!'
        ]);
    }
}
